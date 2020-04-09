<?php

namespace Covid\Users\Framework;

use Illuminate\Support\ServiceProvider;
use Covid\Users\Infrastructure\UserRepository;
use Covid\Users\Domain\UsersProjector;
use Covid\Users\Domain\UserRepository as UserRepositoryInterface;
use Covid\Users\Application\UsersQuery;
use Covid\Users\Application\Commands\UsersCommandHandler;
use Covid\Shared\EventStore;
use Covid\Shared\EventBus;
use Covid\Shared\CommandBus;

class UsersServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $eventBus = $this->app->get(EventBus::class);
        /* 
        $eventBus->subscribe(
            new UsersProjector(
                $this->app->make('db')->connection(),
                $this->app->get(UserRepositoryInterface::class)
            )
        );
        */

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
            $this->app->get(UserRepositoryInterface::class)
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
        /* 
        $this->app->bind(
            UsersQuery::class,
            function () {
                return new UsersQuery(
                    $this->app->make('db')->connection()
                );
            }
        );
        */

    }

}
