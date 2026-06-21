<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$con) {
  echo "Connection Not Connect";
}