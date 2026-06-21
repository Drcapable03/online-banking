<?php

require_once __DIR__ . '/errors.php';
init_error_handling();

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'bank_db';
$app_base_url = getenv('APP_BASE_URL') ?: 'http://localhost:8080/online-banking';
$app_env = getenv('APP_ENV') ?: 'development';

function app_url(string $path): string
{
    global $app_base_url;
    return rtrim($app_base_url, '/') . '/' . ltrim($path, '/');
}