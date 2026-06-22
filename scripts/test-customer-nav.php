<?php

function http_request(string $url, string $method = 'GET', array $post = [], string $cookie_file = ''): array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_COOKIEJAR => $cookie_file,
        CURLOPT_COOKIEFILE => $cookie_file,
    ]);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }

    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['status' => $status, 'body' => (string) $body];
}

$base = getenv('APP_BASE_URL') ?: 'http://localhost/online-banking';
$cookie = tempnam(sys_get_temp_dir(), 'nav');

$login_url = $base . '/site/dist/auth_login.php';
$get = http_request($login_url, 'GET', [], $cookie);
preg_match('/_csrf_token" value="([^"]+)"/', $get['body'], $m);
$csrf = $m[1] ?? '';

if ($csrf === '') {
    echo "FAIL: could not obtain CSRF token\n";
    exit(1);
}

$post = http_request($login_url, 'POST', [
    '_csrf_token' => $csrf,
    'txt_username' => 'customer1',
    'txt_password' => 'Password1',
    'btn_submit' => '1',
], $cookie);

$login_ok = str_contains($post['body'], 'JavaScript">rightAuth();') && !str_contains($post['body'], 'JavaScript">wrongAuth();');
if (!$login_ok) {
    echo "FAIL: customer login\n";
    if (str_contains($post['body'], 'Too many attempts')) {
        echo "rate limited\n";
    }
    exit(1);
}

echo "PASS: customer login\n";

$pages = [
    'index.php' => ['customer-nav.css', 'customer-mega-menu', 'topnav-accounts'],
    'profile.php' => ['customer-nav.css', 'customer-mega-menu', 'profile.php'],
    'statements.php' => ['Coming Soon', 'Statements &amp; Documents'],
    'account_alerts.php' => ['Coming Soon', 'Account Alerts'],
    'routing_numbers.php' => ['Coming Soon', 'Routing Numbers'],
    'security_center.php' => ['Coming Soon', 'Security Center'],
    'cheque_book.php' => ['Coming Soon', 'Order Checks'],
    'FAQs.php' => ['customer-nav.css', 'customer-mega-menu', 'FAQs.php'],
    'quick_transfer.php' => ['customer-nav.css', 'customer-mega-menu', 'quick_transfer.php'],
];

$failed = 0;
foreach ($pages as $page => $needles) {
    $url = $base . '/site/dist/' . $page;
    $res = http_request($url, 'GET', [], $cookie);
    $ok = $res['status'] === 200;
    foreach ($needles as $needle) {
        if (!str_contains($res['body'], $needle)) {
            $ok = false;
            break;
        }
    }
    echo ($ok ? 'PASS' : 'FAIL') . ": $page (HTTP {$res['status']})\n";
    if (!$ok) {
        $failed++;
    }
}

exit($failed > 0 ? 1 : 0);