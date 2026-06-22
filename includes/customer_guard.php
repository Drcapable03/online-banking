<?php

if (!isset($_SESSION['s_account_no']) || !isset($_SESSION['s_login'])) {
    header('location:' . app_url('site/dist/auth_login.php'));
    exit;
}

$Account_no = (int) $_SESSION['s_account_no'];

require_once __DIR__ . '/currency.php';
$Customer_currency = get_customer_currency($con, $Account_no);
$Currency_symbol = currency_symbol($Customer_currency);