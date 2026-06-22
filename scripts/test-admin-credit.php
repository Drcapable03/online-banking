<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/transfers.php';

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$result = execute_admin_balance_op($con, 338509629, 338509634, 250, 'credit');
var_export($result);
echo PHP_EOL;

$bal = mysqli_fetch_assoc(mysqli_query($con, 'SELECT balance FROM tbl_balance WHERE account_no = 338509634'));
echo 'balance=' . $bal['balance'] . PHP_EOL;