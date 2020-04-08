<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\EmailWasInvalid;

class EmailTest extends TestCase
{

    public function test_email_instantiate()
    {
        $email = new Email('malcolm@christiesmedia.co.uk');

        $this->assertEquals('malcolm@christiesmedia.co.uk', (string)$email);
    }

    public function test_email_invalid()
    {
        $this->expectException(EmailWasInvalid::class);

        $email = new Email('M');
    }
}
