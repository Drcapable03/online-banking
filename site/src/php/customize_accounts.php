<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Customize My Accounts';
$page_heading = 'Customize My Accounts';
$stub_message = 'Set account nicknames and choose how accounts appear on your dashboard.';
$stub_phase = 'Phase 2';
$customer_nav_section = 'accounts';
$customer_nav_page = 'customize';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';