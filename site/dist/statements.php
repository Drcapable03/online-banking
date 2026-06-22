<?php
include('connect.php');
require_once __DIR__ . '/../../includes/customer_guard.php';
$query_customer = "SELECT * FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
$page_title = 'Statements & Documents';
$page_heading = 'Statements & Documents';
$stub_message = 'Download monthly statements, tax documents, and electronic notices from one place.';
$stub_phase = 'Phase 2';
$customer_nav_section = 'accounts';
$customer_nav_page = 'statements';
require_once __DIR__ . '/../../includes/customer_stub_shell.php';