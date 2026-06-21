<?php

if (!isset($_SESSION['s_account_no']) || !isset($_SESSION['s_login'])) {
    header('location:' . app_url('site/dist/auth_login.php'));
    exit;
}

$Account_no = (int) $_SESSION['s_account_no'];