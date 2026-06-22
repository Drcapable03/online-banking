<?php

require_once __DIR__ . '/errors.php';
init_error_handling();

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'bank_db';
$app_base_url = getenv('APP_BASE_URL') ?: 'http://localhost:8080/online-banking';
$app_env = getenv('APP_ENV') ?: 'development';
$app_primary_currency = getenv('APP_PRIMARY_CURRENCY') ?: 'USD';
$ssn_encryption_key = getenv('SSN_ENCRYPTION_KEY') ?: '';
$admin_registration_enabled = filter_var(getenv('ADMIN_REGISTRATION_ENABLED') ?: 'false', FILTER_VALIDATE_BOOLEAN);
$admin_pool_account = (int) (getenv('ADMIN_POOL_ACCOUNT') ?: '338509629');

function app_url(string $path): string
{
    global $app_base_url;
    return rtrim($app_base_url, '/') . '/' . ltrim($path, '/');
}