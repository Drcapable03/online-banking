<?php

function csrf_token(): string
{
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function verify_csrf(): bool
{
    $token = $_POST['_csrf_token'] ?? $_REQUEST['_csrf_token'] ?? '';
    $session_token = $_SESSION['_csrf_token'] ?? '';
    return $token !== '' && $session_token !== '' && hash_equals($session_token, $token);
}

function require_csrf(): void
{
    if (!verify_csrf()) {
        http_response_code(403);
        exit('Invalid security token. Please refresh the page and try again.');
    }
}