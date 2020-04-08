<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\EmailWasInvalid;

class VerificationCodesTest extends TestCase
{

    public function test_email_verification()
    {
        $code = EmailVerificationCode::new();

        $this->assertInstanceOf(EmailVerificationCode::class, $code);
        $this->assertEquals((string)$code, (string) new EmailVerificationCode((string) $code));
    }

    public function test_phone_number_verification()
    {
        $code = PhoneNumberVerificationCode::new();

        $this->assertInstanceOf(PhoneNumberVerificationCode::class, $code);
        $this->assertEquals((string)$code, (string) new PhoneNumberVerificationCode((string) $code));
    }
}
