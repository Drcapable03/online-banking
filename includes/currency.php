<?php

const SUPPORTED_CURRENCIES = [
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
    'INR' => '₹',
];

function system_primary_currency(): string
{
    global $app_primary_currency;
    $code = strtoupper($app_primary_currency ?? 'USD');
    return isset(SUPPORTED_CURRENCIES[$code]) ? $code : 'USD';
}

function validate_currency_code(string $code): bool
{
    return isset(SUPPORTED_CURRENCIES[strtoupper($code)]);
}

function currency_symbol(?string $code = null): string
{
    $code = strtoupper($code ?? system_primary_currency());
    return SUPPORTED_CURRENCIES[$code] ?? SUPPORTED_CURRENCIES['USD'];
}

function format_money(float|int $amount, ?string $code = null): string
{
    return currency_symbol($code) . ' ' . number_format((float) $amount, 2);
}

function get_customer_currency(mysqli $con, int $account_no): string
{
    $stmt = $con->prepare('SELECT primary_currency FROM tbl_customer WHERE account_no = ?');
    $stmt->bind_param('i', $account_no);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row || empty($row['primary_currency'])) {
        return system_primary_currency();
    }

    $code = strtoupper($row['primary_currency']);
    return validate_currency_code($code) ? $code : system_primary_currency();
}

function supported_currency_options(): array
{
    return SUPPORTED_CURRENCIES;
}