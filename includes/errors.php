<?php

function init_error_handling(): void
{
    $env = getenv('APP_ENV') ?: 'development';

    if ($env === 'production') {
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
    }

    set_exception_handler(function (Throwable $e) use ($env) {
        error_log($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
        http_response_code(500);
        if ($env === 'production') {
            echo 'An unexpected error occurred. Please try again later.';
        } else {
            echo 'Error: ' . htmlspecialchars($e->getMessage());
        }
        exit;
    });
}