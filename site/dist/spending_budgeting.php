<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Spending & Budgeting';
$page_heading = 'Spending & Budgeting';
$stub_message = 'Track spending trends, categories, and monthly budgets for your accounts.';
$stub_phase = 'Phase 3';
$customer_nav_section = 'accounts';
$customer_nav_page = 'spending';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';