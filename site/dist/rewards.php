<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Rewards & Deals';
$page_heading = 'Rewards & Deals';
$stub_message = 'Browse rewards, offers, and partner deals available to DR BANK customers.';
$stub_phase = 'Phase 4';
$customer_nav_section = 'accounts';
$customer_nav_page = 'rewards';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';