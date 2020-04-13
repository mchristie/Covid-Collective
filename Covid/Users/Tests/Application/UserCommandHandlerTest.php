<?php

namespace Covid\Users\Application\Commands;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\InvalidArgumentException;
use PHPUnit\Framework\ExpectationFailedException;
use DateTimeImmutable;
use Covid\Users\Infrastructure\UserRepository;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\SeekingAssistance;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\PasswordHelper;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\OfferingAssistance;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\HashedPassword;
use Covid\Users\Domain\Exceptions\UserAlreadyExists;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Email;
use Covid\Users\Application\Query\InMemoryUsersQuery;
use Covid\Users\Application\Commands\UsersCommandHandler;
use Covid\Users\Application\Commands\RegisterUser;
use Covid\USers\Domain\User;
use Covid\EventSourcing\InMemoryEventStore;
use Broadway\EventHandling\SimpleEventBus;

class UserCommandHandlerTest extends TestCase
{
    private $userId = 'd78be3a0-0d4f-473e-b630-acc04294e049';
    private $repo;
    
    public function test_handler_instantiates()
    {
        $this->assertInstanceOf(UsersCommandHandler::class, $this->getHandler());
    }

    public function test_register_user()
    {
        $command = new RegisterUser(
            new UserId($this->userId),
            new Name('Malcolm'),
            new Email('malcolm@christiesmedia.co.uk'),
            new PhoneNumber('07825600704'),
            new Password('HelloWorld'),
            new DateTimeImmutable()
        );

        $this->getHandler()->handleRegisterUser($command);

        $user = $this->repo->find(
            new UserId($this->userId)
        );

        $this->assertInstanceOf(
            User::class,
            $user
        );

        return $user;
    }

    /**
     * @depends test_register_user
     * Totally fucked the tests up, ignore for now
     *
    public function test_update_user(User $user)
    {
        $handler = $this->getHandler();
        
        $this->repo->save($user);

        $command = new UpdateUser(
            new UserId($this->userId),
            new Name('Malcolm'),
            new SeekingAssistance('YES'),
            new OfferingAssistance('YES'),
            new Password('HelloWorld'),
            new DateTimeImmutable()
        );

        $handler->handleUpdateUser($command);
        
        $user = $this->repo->find(
            new UserId($this->userId)
        );

        $this->assertInstanceOf(
            User::class,
            $user
        );

        return $user;
    }
    */

    private function getHandler(): UsersCommandHandler
    {
        $this->repo = new UserRepository(
            new InMemoryEventStore(), new SimpleEventBus()
        );
        
        return new UsersCommandHandler(
            $this->repo,
            new InMemoryUsersQuery(),
            new class() implements PasswordHelper {
                public function hash(Password $password): HashedPassword {
                    return new HashedPassword((string) $password);
                }
                public function check(HashedPassword $hashedPassword, Password $password): Bool {
                    return true;
                }
            }
        );
    }
}
