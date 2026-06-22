<?php

function http_get(string $url, string $cookie_file): array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_COOKIEJAR => $cookie_file,
        CURLOPT_COOKIEFILE => $cookie_file,
    ]);
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['status' => $status, 'body' => (string) $body];
}

function login(string $portal, string $cookie_file): bool
{
    if ($portal === 'admin') {
        $url = 'http://localhost/online-banking/admin/dist/auth-login.php';
        $get = http_get($url, $cookie_file);
        preg_match('/_csrf_token" value="([^"]+)"/', $get['body'], $m);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                '_csrf_token' => $m[1] ?? '',
                'txt_adminid' => '1000502004',
                'txt_password' => 'Password1',
                'btn_submit' => '1',
            ]),
            CURLOPT_COOKIEJAR => $cookie_file,
            CURLOPT_COOKIEFILE => $cookie_file,
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return str_contains((string) $resp, 'JavaScript">rightAuth();');
    }

    $url = 'http://localhost/online-banking/site/dist/auth_login.php';
    $get = http_get($url, $cookie_file);
    preg_match('/_csrf_token" value="([^"]+)"/', $get['body'], $m);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            '_csrf_token' => $m[1] ?? '',
            'txt_username' => 'customer1',
            'txt_password' => 'Password1',
            'btn_submit' => '1',
        ]),
        CURLOPT_COOKIEJAR => $cookie_file,
        CURLOPT_COOKIEFILE => $cookie_file,
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);
    return str_contains((string) $resp, 'JavaScript">rightAuth();');
}

$admin_pages = [
    'index.php',
    'transaction.php',
    'login_history.php',
    'manage_balance.php',
    'view_requests.php',
    'manage_feedback.php',
    'analysis.php',
    'profile_view.php?account_no=338509634',
    'view_request_read.php?request_id=1',
];

$customer_pages = [
    'index.php',
    'quick_transfer.php',
    'inbox.php',
    'profile.php',
    'cheque_book.php',
    'feedback.php',
    'FAQs.php',
    'request_money.php',
    'send_requests.php',
];

$admin_cookie = tempnam(sys_get_temp_dir(), 'audit-admin');
$customer_cookie = tempnam(sys_get_temp_dir(), 'audit-customer');

if (!login('admin', $admin_cookie)) {
    echo "Admin login failed\n";
    exit(1);
}
if (!login('customer', $customer_cookie)) {
    echo "Customer login failed\n";
    exit(1);
}

$failures = [];

foreach ($admin_pages as $page) {
    $url = 'http://localhost/online-banking/admin/dist/' . $page;
    $res = http_get($url, $admin_cookie);
    $has_session_warning = str_contains($res['body'], 'session_set_cookie_params') || str_contains($res['body'], 'headers already sent');
    $ok = $res['status'] === 200 && !$has_session_warning && !str_contains($res['body'], 'auth-login.php');
    echo ($ok ? '[OK] ' : '[FAIL] ') . 'admin/' . $page . PHP_EOL;
    if (!$ok) {
        $failures[] = 'admin/' . $page;
    }
}

foreach ($customer_pages as $page) {
    $url = 'http://localhost/online-banking/site/dist/' . $page;
    $res = http_get($url, $customer_cookie);
    $has_session_warning = str_contains($res['body'], 'session_set_cookie_params') || str_contains($res['body'], 'headers already sent');
    $ok = $res['status'] === 200 && !$has_session_warning && !str_contains($res['body'], 'auth_login.php');
    echo ($ok ? '[OK] ' : '[FAIL] ') . 'site/' . $page . PHP_EOL;
    if (!$ok) {
        $failures[] = 'site/' . $page;
    }
}

if ($failures) {
    echo PHP_EOL . 'Failures: ' . implode(', ', $failures) . PHP_EOL;
    exit(1);
}

echo PHP_EOL . 'All audited pages passed.' . PHP_EOL;