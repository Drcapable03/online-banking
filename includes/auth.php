<?php

function hash_password(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password(string $stored, string $input): bool
{
    $info = password_get_info($stored);
    if (!empty($info['algo'])) {
        return password_verify($input, $stored);
    }
    return hash_equals($stored, $input);
}

function upgrade_account_password(mysqli $con, int $account_no, string $password): void
{
    $hash = hash_password($password);
    $stmt = $con->prepare('UPDATE tbl_account SET password = ? WHERE account_no = ?');
    $stmt->bind_param('si', $hash, $account_no);
    $stmt->execute();
    $stmt->close();
}

function upgrade_admin_password(mysqli $con, int $admin_id, string $password): void
{
    $hash = hash_password($password);
    $stmt = $con->prepare('UPDATE tbl_admin SET password = ? WHERE admin_id = ?');
    $stmt->bind_param('si', $hash, $admin_id);
    $stmt->execute();
    $stmt->close();
}