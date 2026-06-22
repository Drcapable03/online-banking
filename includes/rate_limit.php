<?php

function login_rate_limit_dir(): string
{
    $dir = sys_get_temp_dir() . '/online-banking-login-limits';
    if (!is_dir($dir)) {
        mkdir($dir, 0700, true);
    }
    return $dir;
}

function login_rate_limit_file(string $portal, string $identifier): string
{
    $safe = hash('sha256', $portal . '|' . strtolower(trim($identifier)));
    return login_rate_limit_dir() . '/' . $safe . '.json';
}

function read_login_rate_state(string $portal, string $identifier): array
{
    $file = login_rate_limit_file($portal, $identifier);
    if (!is_file($file)) {
        return ['failures' => 0, 'locked_until' => 0];
    }

    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data)) {
        return ['failures' => 0, 'locked_until' => 0];
    }

    return [
        'failures' => (int) ($data['failures'] ?? 0),
        'locked_until' => (int) ($data['locked_until'] ?? 0),
    ];
}

function write_login_rate_state(string $portal, string $identifier, array $state): void
{
    $file = login_rate_limit_file($portal, $identifier);
    file_put_contents($file, json_encode($state), LOCK_EX);
}

function check_login_rate_limit(string $portal, string $identifier, int $max_attempts = 5, int $lockout_seconds = 900): ?int
{
    $state = read_login_rate_state($portal, $identifier);
    $now = time();

    if ($state['locked_until'] > $now) {
        return $state['locked_until'] - $now;
    }

    if ($state['locked_until'] > 0 && $state['locked_until'] <= $now) {
        write_login_rate_state($portal, $identifier, ['failures' => 0, 'locked_until' => 0]);
    }

    return null;
}

function record_login_failure(string $portal, string $identifier, int $max_attempts = 5, int $lockout_seconds = 900): void
{
    $state = read_login_rate_state($portal, $identifier);
    $state['failures'] = (int) $state['failures'] + 1;

    if ($state['failures'] >= $max_attempts) {
        $state['locked_until'] = time() + $lockout_seconds;
        $state['failures'] = 0;
    }

    write_login_rate_state($portal, $identifier, $state);
}

function clear_login_failures(string $portal, string $identifier): void
{
    $file = login_rate_limit_file($portal, $identifier);
    if (is_file($file)) {
        unlink($file);
    }
}