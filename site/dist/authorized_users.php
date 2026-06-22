<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Authorized Users';
$page_heading = 'Authorized Users';
$stub_message = 'Add or remove users authorized to access your accounts.';
$stub_phase = 'Phase 4';
$customer_nav_section = 'accounts';
$customer_nav_page = 'authorized';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';