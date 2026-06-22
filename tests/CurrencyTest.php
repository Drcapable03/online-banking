<?php

use PHPUnit\Framework\TestCase;

final class CurrencyTest extends TestCase
{
    public function testSystemPrimaryCurrencyDefaultsToUsd(): void
    {
        $this->assertSame('USD', system_primary_currency());
    }

    public function testCurrencySymbolForUsd(): void
    {
        $this->assertSame('$', currency_symbol('USD'));
    }

    public function testValidateCurrencyCode(): void
    {
        $this->assertTrue(validate_currency_code('USD'));
        $this->assertFalse(validate_currency_code('XYZ'));
    }

    public function testFormatMoney(): void
    {
        $this->assertSame('$ 1,234.50', format_money(1234.5, 'USD'));
    }
}