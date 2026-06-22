<?php

putenv('APP_PRIMARY_CURRENCY=USD');
putenv('SSN_ENCRYPTION_KEY=test-secret-key-for-unit-tests-only');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/currency.php';
require_once __DIR__ . '/../includes/encryption.php';