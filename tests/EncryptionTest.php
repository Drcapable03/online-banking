<?php

use PHPUnit\Framework\TestCase;

final class EncryptionTest extends TestCase
{
    public function testSsnRoundTrip(): void
    {
        $encrypted = encrypt_ssn('123456789');
        $this->assertTrue(is_encrypted_ssn($encrypted));
        $this->assertSame('123456789', decrypt_ssn($encrypted));
    }

    public function testMaskWorksWithEncryptedValue(): void
    {
        require_once __DIR__ . '/../includes/uploads.php';
        $encrypted = encrypt_ssn('123456789');
        $this->assertSame('***-**-6789', mask_ssn($encrypted));
    }
}