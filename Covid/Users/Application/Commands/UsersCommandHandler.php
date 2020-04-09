<?php
namespace Covid\Users\Application\Commands;

use Covid\Users\Domain\UserRepository;
use Covid\Users\Domain\User;
use Covid\Users\Application\Commands\RegisterUser;
use Broadway\CommandHandling\SimpleCommandHandler;

class UsersCommandHandler extends SimpleCommandHandler
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users  = $users;
    }

    public function handleRegisterUser(RegisterUser $command)
    {
        $user = User::register(
            $command->getUserId(),
            $command->getName(),
            $command->getEmail(),
            $command->getPhoneNumber(),
            $command->getRegisteredAt()
        );

        $this->users->save($user);
    }
}
