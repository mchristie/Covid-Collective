<?php
namespace Covid\Users\Application\Commands;

use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UserRepository;
use Covid\Users\Domain\User;
use Covid\Users\Domain\PasswordHelper;
use Covid\Users\Application\Commands\UpdateUser;
use Covid\Users\Application\Commands\RegisterUser;
use Broadway\CommandHandling\SimpleCommandHandler;

class UsersCommandHandler extends SimpleCommandHandler
{

    private $users;
    private $usersQuery;
    private $PasswordHelper;

    public function __construct(UserRepository $users, UsersQuery $usersQuery, PasswordHelper $PasswordHelper)
    {
        $this->users  = $users;
        $this->usersQuery  = $usersQuery;
        $this->PasswordHelper  = $PasswordHelper;
    }

    public function handleRegisterUser(RegisterUser $command)
    {
        $user = User::register(
            $command->getUserId(),
            $command->getName(),
            $command->getEmail(),
            $command->getPhoneNumber(),
            $command->getPassword(),
            $command->getRegisteredAt(),
            $this->usersQuery,
            $this->PasswordHelper
        );

        $this->users->save($user);
    }

    public function handleUpdateUser(UpdateUser $command)
    {
        $user = $this->users->find($command->getUserId());
        
        $user->update(
            $command->getUserId(),
            $command->getName(),
            $command->getSeekingAssistance(),
            $command->getOfferingAssistance(),
            $command->getPassword(),
            $command->getUpdatedAt(),
            $this->PasswordHelper
        );

        $this->users->save($user);
    }
}
