<?php

if (!isset($_SESSION['s_admin_id'])) {
    header('location:' . app_url('admin/dist/auth-login.php'));
    exit;
}