<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Security Center';
$page_heading = 'Security Center';
$stub_message = 'Review login activity, update your password, and manage account security preferences.';
$stub_phase = 'Phase 2';
$customer_nav_section = 'security';
$customer_nav_page = 'security';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';