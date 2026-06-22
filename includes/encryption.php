<?php

function is_encrypted_ssn(string $value): bool
{
    return str_starts_with($value, 'enc:');
}

function encrypt_ssn(string $plaintext): string
{
    global $ssn_encryption_key;

    if (empty($ssn_encryption_key)) {
        return $plaintext;
    }

    $key = hash('sha256', $ssn_encryption_key, true);
    $iv = random_bytes(12);
    $tag = '';
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);

    if ($ciphertext === false) {
        throw new RuntimeException('SSN encryption failed');
    }

    return 'enc:' . base64_encode($iv . $tag . $ciphertext);
}

function decrypt_ssn(?string $stored): ?string
{
    if ($stored === null || $stored === '') {
        return null;
    }

    if (!is_encrypted_ssn($stored)) {
        return $stored;
    }

    global $ssn_encryption_key;
    if (empty($ssn_encryption_key)) {
        return null;
    }

    $payload = base64_decode(substr($stored, 4), true);
    if ($payload === false || strlen($payload) < 28) {
        return null;
    }

    $iv = substr($payload, 0, 12);
    $tag = substr($payload, 12, 16);
    $ciphertext = substr($payload, 28);
    $key = hash('sha256', $ssn_encryption_key, true);

    $plaintext = openssl_decrypt($ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);

    return $plaintext === false ? null : $plaintext;
}