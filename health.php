<?php
header('Content-Type: application/json');

$status = ['status' => 'ok', 'service' => 'online-banking'];

require_once __DIR__ . '/includes/config.php';

$con = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if ($con) {
    $status['database'] = 'ok';
    mysqli_close($con);
} else {
    http_response_code(503);
    $status['status'] = 'degraded';
    $status['database'] = 'unavailable';
}

echo json_encode($status);