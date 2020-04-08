<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;

class UserTest extends TestCase
{

    public function test_user_create()
    {
        $user = User::register(
            UserId::new(),
            new Name('Malcolm'),
            new Email('malcolm@christiesmedia.co.uk'),
            new PhoneNumber('07825600704'),
            new DateTimeImmutable()
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('+447825600704', (string)$user->getPhoneNumber());
    }

    public function test_user_needs_name_or_email()
    {
        // Just email
        User::register(
            UserId::new(),
            new Name('Malcolm'),
            new Email('malcolm@christiesmedia.co.uk'),
            null,
            new DateTimeImmutable()
        );

        // Just phone number
        User::register(
            UserId::new(),
            new Name('Malcolm'),
            null,
            new PhoneNumber('07825600704'),
            new DateTimeImmutable()
        );

        // Neither causes an exception
        $this->expectException(EmailOrPhoneIsRequired::class);
        User::register(
            UserId::new(),
            new Name('Malcolm'),
            null,
            null,
            new DateTimeImmutable()
        );
    }
}
