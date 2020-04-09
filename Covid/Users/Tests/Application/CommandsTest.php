<?php

namespace Covid\Users\Application\Commands;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Infrastructure\UserRepository;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Email;
use Covid\Users\Application\Commands\UsersCommandHandler;
use Covid\Users\Application\Commands\RegisterUser;
use Covid\USers\Domain\User;
use Covid\EventSourcing\InMemoryEventStore;
use Broadway\EventHandling\SimpleEventBus;

class UserTest extends TestCase
{
    private $userId = 'd78be3a0-0d4f-473e-b630-acc04294e049';
    private $repo;
    
    public function test_handler_instantiates()
    {
        $this->assertInstanceOf(UsersCommandHandler::class, $this->getHandler());
    }

    /**
     * @depends test_handler_instantiates
     * @return void 
     */
    public function test_register_user()
    {
        $command = new RegisterUser(
            new UserId($this->userId),
            new Name('Malcolm'),
            new Email('malcolm@christiesmedia.co.uk'),
            new PhoneNumber('07825600704'),
            new DateTimeImmutable()
        );

        $this->getHandler()->handleRegisterUser($command);

        $this->assertInstanceOf(
            User::class,
            $this->repo->find(
                new UserId($this->userId)
            )
        );
    }

    private function getHandler(): UsersCommandHandler
    {
        $this->repo = new UserRepository(
            new InMemoryEventStore(), new SimpleEventBus()
        );
        
        return new UsersCommandHandler(
            $this->repo
        );
    }
}
