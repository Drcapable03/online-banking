<?php

function customer_upload_dir(int $account_no): string
{
    return __DIR__ . '/../site/dist/assets/uploads/customers/' . $account_no;
}

function customer_upload_url(int $account_no, string $filename): string
{
    return 'assets/uploads/customers/' . $account_no . '/' . $filename;
}

function save_customer_upload(int $account_no, string $field, array $file, array $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']): ?string
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return false;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowed_types, true)) {
        return false;
    }

    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    $dir = customer_upload_dir($account_no);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        return false;
    }

    $filename = $field . '.' . $extensions[$mime];
    $target = $dir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return false;
    }

    return customer_upload_url($account_no, $filename);
}

function mask_ssn(?string $ssn): string
{
    if (empty($ssn)) {
        return 'Not on file';
    }
    $digits = preg_replace('/\D/', '', $ssn);
    if (strlen($digits) < 4) {
        return '***-**-****';
    }
    return '***-**-' . substr($digits, -4);
}

function normalize_ssn(string $ssn): ?string
{
    $digits = preg_replace('/\D/', '', $ssn);
    if (strlen($digits) !== 9) {
        return null;
    }
    return $digits;
}