<?php

function fetch(string $url, string $cookie): string
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => $cookie,
        CURLOPT_COOKIEFILE => $cookie,
    ]);
    $body = (string) curl_exec($ch);
    curl_close($ch);
    return $body;
}

function admin_login(string $cookie): void
{
    $url = 'http://localhost/online-banking/admin/dist/auth-login.php';
    $get = fetch($url, $cookie);
    preg_match('/_csrf_token" value="([^"]+)"/', $get, $m);
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
        CURLOPT_COOKIEJAR => $cookie,
        CURLOPT_COOKIEFILE => $cookie,
    ]);
    curl_exec($ch);
    curl_close($ch);
}

$cookie = tempnam(sys_get_temp_dir(), 'sess');
admin_login($cookie);

$pages = [
    'profile_view.php?account_no=338509634',
    'transaction.php',
    'view_requests.php',
];

foreach ($pages as $page) {
    $body = fetch('http://localhost/online-banking/admin/dist/' . $page, $cookie);
    $warn = str_contains($body, 'session_set_cookie_params') || str_contains($body, 'headers already sent');
    echo ($warn ? 'WARN ' : 'OK   ') . $page . PHP_EOL;
}