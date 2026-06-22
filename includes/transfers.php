<?php

function execute_transfer(mysqli $con, int $from_account, int $to_account, int $amount, string $purpose): array
{
    if ($amount <= 0) {
        return ['success' => false, 'error' => 'invalid_amount'];
    }

    if ($from_account === $to_account) {
        return ['success' => false, 'error' => 'same_account'];
    }

    $check_stmt = $con->prepare('SELECT account_no FROM tbl_account WHERE account_no = ?');
    $check_stmt->bind_param('i', $to_account);
    $check_stmt->execute();
    $exists = $check_stmt->get_result()->fetch_assoc();
    $check_stmt->close();

    if (!$exists) {
        return ['success' => false, 'error' => 'invalid_beneficiary'];
    }

    $trans_date = date('Y-m-d H:i:s');

    mysqli_begin_transaction($con);
    try {
        $debit_stmt = $con->prepare('UPDATE tbl_balance SET balance = balance - ? WHERE account_no = ? AND balance >= ?');
        $debit_stmt->bind_param('iii', $amount, $from_account, $amount);
        $debit_stmt->execute();
        if ($debit_stmt->affected_rows !== 1) {
            throw new RuntimeException('insufficient_balance');
        }
        $debit_stmt->close();

        $credit_stmt = $con->prepare('UPDATE tbl_balance SET balance = balance + ? WHERE account_no = ?');
        $credit_stmt->bind_param('ii', $amount, $to_account);
        $credit_stmt->execute();
        if ($credit_stmt->affected_rows !== 1) {
            throw new RuntimeException('credit_failed');
        }
        $credit_stmt->close();

        $from_bal_stmt = $con->prepare('SELECT balance FROM tbl_balance WHERE account_no = ?');
        $from_bal_stmt->bind_param('i', $from_account);
        $from_bal_stmt->execute();
        $from_bal = (int) $from_bal_stmt->get_result()->fetch_assoc()['balance'];
        $from_bal_stmt->close();

        $to_bal_stmt = $con->prepare('SELECT balance FROM tbl_balance WHERE account_no = ?');
        $to_bal_stmt->bind_param('i', $to_account);
        $to_bal_stmt->execute();
        $to_bal = (int) $to_bal_stmt->get_result()->fetch_assoc()['balance'];
        $to_bal_stmt->close();

        $debit_type = 'DEBIT';
        $debit_insert = $con->prepare('INSERT INTO tbl_transaction (trans_date, amount, trans_type, purpose, to_account, account_no, account_bal) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $debit_insert->bind_param('sissiii', $trans_date, $amount, $debit_type, $purpose, $to_account, $from_account, $from_bal);
        $debit_insert->execute();
        $debit_insert->close();

        $credit_type = 'CREDIT';
        $credit_insert = $con->prepare('INSERT INTO tbl_transaction (trans_date, amount, trans_type, purpose, to_account, account_no, account_bal) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $credit_insert->bind_param('sissiii', $trans_date, $amount, $credit_type, $purpose, $from_account, $to_account, $to_bal);
        $credit_insert->execute();
        $credit_insert->close();

        mysqli_commit($con);
        return ['success' => true, 'error' => null];
    } catch (Throwable $e) {
        mysqli_rollback($con);
        $error = $e->getMessage();
        if (!in_array($error, ['insufficient_balance', 'credit_failed'], true)) {
            $error = 'transfer_failed';
        }
        return ['success' => false, 'error' => $error];
    }
}

function fulfill_money_request(mysqli $con, int $payer_account, int $request_id, string $purpose = 'From Requests'): array
{
    $request_stmt = $con->prepare('SELECT request_id, account_no, amount, status FROM tbl_requests WHERE request_id = ?');
    $request_stmt->bind_param('i', $request_id);
    $request_stmt->execute();
    $request = $request_stmt->get_result()->fetch_assoc();
    $request_stmt->close();

    if (!$request) {
        return ['success' => false, 'error' => 'request_not_found'];
    }

    if ($request['status'] === 'sent') {
        return ['success' => false, 'error' => 'already_sent'];
    }

    $amount = (int) $request['amount'];
    $beneficiary = (int) $request['account_no'];
    $result = execute_transfer($con, $payer_account, $beneficiary, $amount, $purpose);

    if (!$result['success']) {
        return $result;
    }

    $update_stmt = $con->prepare("UPDATE tbl_requests SET status = 'sent' WHERE request_id = ?");
    $update_stmt->bind_param('i', $request_id);
    $update_stmt->execute();
    $update_stmt->close();

    return ['success' => true, 'error' => null];
}

function execute_admin_balance_op(mysqli $con, int $pool_account, int $customer_account, int $amount, string $operation, string $purpose = 'Operation made by Admin'): array
{
    if ($amount <= 0) {
        return ['success' => false, 'error' => 'invalid_amount'];
    }

    if (!in_array($operation, ['credit', 'debit'], true)) {
        return ['success' => false, 'error' => 'invalid_operation'];
    }

    $exists_stmt = $con->prepare('SELECT account_no FROM tbl_balance WHERE account_no = ?');
    $exists_stmt->bind_param('i', $customer_account);
    $exists_stmt->execute();
    $exists = $exists_stmt->get_result()->fetch_assoc();
    $exists_stmt->close();

    if (!$exists) {
        return ['success' => false, 'error' => 'invalid_account'];
    }

    $trans_date = date('Y-m-d H:i:s');

    mysqli_begin_transaction($con);
    try {
        if ($operation === 'credit') {
            $credit_stmt = $con->prepare('UPDATE tbl_balance SET balance = balance + ? WHERE account_no = ?');
            $credit_stmt->bind_param('ii', $amount, $customer_account);
            $credit_stmt->execute();
            if ($credit_stmt->affected_rows !== 1) {
                throw new RuntimeException('credit_failed');
            }
            $credit_stmt->close();

            $bal_stmt = $con->prepare('SELECT balance FROM tbl_balance WHERE account_no = ?');
            $bal_stmt->bind_param('i', $customer_account);
            $bal_stmt->execute();
            $balance = (int) $bal_stmt->get_result()->fetch_assoc()['balance'];
            $bal_stmt->close();

            $credit_type = 'CREDIT';
            $insert = $con->prepare('INSERT INTO tbl_transaction (trans_date, amount, trans_type, purpose, to_account, account_no, account_bal) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $insert->bind_param('sissiii', $trans_date, $amount, $credit_type, $purpose, $customer_account, $customer_account, $balance);
            $insert->execute();
            $insert->close();
        } else {
            $debit_stmt = $con->prepare('UPDATE tbl_balance SET balance = balance - ? WHERE account_no = ? AND balance >= ?');
            $debit_stmt->bind_param('iii', $amount, $customer_account, $amount);
            $debit_stmt->execute();
            if ($debit_stmt->affected_rows !== 1) {
                throw new RuntimeException('insufficient_balance');
            }
            $debit_stmt->close();

            $bal_stmt = $con->prepare('SELECT balance FROM tbl_balance WHERE account_no = ?');
            $bal_stmt->bind_param('i', $customer_account);
            $bal_stmt->execute();
            $balance = (int) $bal_stmt->get_result()->fetch_assoc()['balance'];
            $bal_stmt->close();

            $debit_type = 'DEBIT';
            $insert = $con->prepare('INSERT INTO tbl_transaction (trans_date, amount, trans_type, purpose, to_account, account_no, account_bal) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $insert->bind_param('sissiii', $trans_date, $amount, $debit_type, $purpose, $pool_account, $customer_account, $balance);
            $insert->execute();
            $insert->close();
        }

        mysqli_commit($con);
        return ['success' => true, 'error' => null];
    } catch (Throwable $e) {
        mysqli_rollback($con);
        $error = $e->getMessage();
        if (!in_array($error, ['insufficient_balance', 'credit_failed'], true)) {
            $error = 'transfer_failed';
        }
        return ['success' => false, 'error' => $error];
    }
}