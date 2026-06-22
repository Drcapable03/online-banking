<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Overdraft Protection';
$page_heading = 'Overdraft Protection';
$stub_message = 'Link accounts and configure overdraft protection settings.';
$stub_phase = 'Phase 4';
$customer_nav_section = 'accounts';
$customer_nav_page = 'overdraft';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';