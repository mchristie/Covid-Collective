<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\InvalidArgumentException;
use PHPUnit\Framework\ExpectationFailedException;
use DateTimeImmutable;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\Exceptions\UserAlreadyExists;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Application\Query\InMemoryUsersQuery;
use Covid\USers\Domain\User;

class UserTest extends TestCase
{

    public function test_user_needs_name_or_email()
    {
        // Just email
        User::register(
            UserId::new(),
            new Name('Malcolm'),
            new Email('malcolm@christiesmedia.co.uk'),
            null,
            new Password('Hello world'),
            new DateTimeImmutable(),
            new InMemoryUsersQuery(),
            $this->getHasher()
        );

        // Just phone number
        User::register(
            UserId::new(),
            new Name('Malcolm'),
            null,
            new PhoneNumber('07825600704'),
            new Password('Hello world'),
            new DateTimeImmutable(),
            new InMemoryUsersQuery(),
            $this->getHasher()
        );

        // Neither causes an exception
        $this->expectException(EmailOrPhoneIsRequired::class);
        User::register(
            UserId::new(),
            new Name('Malcolm'),
            null,
            null,
            new Password('Hello world'),
            new DateTimeImmutable(),
            new InMemoryUsersQuery(),
            $this->getHasher()
        );
    }

    public function test_user_create()
    {
        $user = User::register(
            UserId::new(),
            new Name('Malcolm'),
            new Email('malcolm@christiesmedia.co.uk'),
            new PhoneNumber('07825600704'),
            new Password('Hello world'),
            new DateTimeImmutable(),
            new InMemoryUsersQuery(),
            $this->getHasher()
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('+447825600704', (string)$user->getPhoneNumber());

        return $user;
    }
    
    /**
     * @depends test_user_create
     */
    public function test_user_update(User $user)
    {
        $user->update(
            UserId::new(),
            new Name('Malcolm'),
            new SeekingAssistance('yes'),
            new OfferingAssistance('no'),
            new Password('Hello world'),
            new DateTimeImmutable(),
            $this->getHasher()
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('YES', (string) $user->getSeekingAssistance());
        $this->assertEquals('NO', (string) $user->getOfferingAssistance());

        return $user;
    }

    private function getHasher(): PasswordHelper
    {
        return new class() implements PasswordHelper {
            public function hash(Password $password): HashedPassword {
                return new HashedPassword((string) $password);
            }
            public function check(HashedPassword $hashedPassword, Password $password): Bool {
                return true;
            }
        };
    }
}
