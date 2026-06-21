<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/csrf.php';

start_secure_session();

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$con) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    if ($app_env === 'production') {
        die('Service temporarily unavailable.');
    }
    die('Connection failed: ' . mysqli_connect_error());
}