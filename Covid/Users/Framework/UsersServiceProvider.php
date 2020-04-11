<?php

namespace Covid\Users\Framework;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Covid\Users\Infrastructure\UserRepository;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UsersProjector;
use Covid\Users\Domain\UserRepository as UserRepositoryInterface;
use Covid\Users\Domain\PasswordHelper;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\HashedPassword;
use Covid\Users\Application\Query\MySQLUsersQuery;
use Covid\Users\Application\Commands\UsersCommandHandler;
use Covid\USers\Domain\User;
use Covid\Shared\EventStore;
use Covid\Shared\EventBus;
use Covid\Shared\CommandBus;

class UsersServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $eventBus = $this->app->get(EventBus::class);

        $eventBus->subscribe(
            new UsersProjector(
                $this->app->make('db')->connection(),
                $this->app->get(UserRepositoryInterface::class)
            )
        );

        /* 
        $eventBus->subscribe(
            new EventHandler($this->app->make(CommandBus::class))
        );
        */

        /*
         *  Register the commands
         */
        $commandBus = $this->app->get(CommandBus::class);

        $usersCommandHandler = new UsersCommandHandler(
            $this->app->get(UserRepositoryInterface::class),
            $this->app->make(UsersQuery::class),
            $this->app->make(PasswordHelper::class),
        );

        // Create a command bus and subscribe the command handler at the command bus
        $commandBus->subscribe($usersCommandHandler);
    }

    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            function () {
                return new UserRepository(
                    $this->app->get(EventStore::class),
                    $this->app->get(EventBus::class)
                );
            }
        );

        $this->app->bind(
            UsersQuery::class,
            function () {
                return new MySQLUsersQuery(
                    $this->app->make('db')->connection()
                );
            }
        );

        $this->app->bind(PasswordHelper::class, function() {
            return new class() implements PasswordHelper {
                public function hash(Password $password): HashedPassword {
                    return new HashedPassword( Hash::make((string) $password) );
                }
                
                public function check(HashedPassword $hashedPassword, Password $password): bool {
                    return Hash::check((string) $password, (string) $hashedPassword );
                }
            };
        });

    }

}
