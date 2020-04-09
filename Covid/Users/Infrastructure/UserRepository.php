<?php

namespace Covid\Users\Infrastructure;

use Covid\Users\Domain\UserRepository as UserRepositoryInterface;
use Covid\Users\Domain\User;
use Covid\Users\Domain\Exceptions\UserNotFound;
use Broadway\EventStore\EventStore;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventHandling\EventBus;
use Broadway\Domain\AggregateRoot;

class UserRepository extends EventSourcingRepository implements UserRepositoryInterface
{
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        parent::__construct($eventStore, $eventBus, User::class, new PublicConstructorAggregateFactory());
    }

    public function find($id) : User
    {
        $user = parent::load($id);

        if ($user->getPlayhead() === -1) {
            throw new UserNotFound('User '.$id.' not found');
        }

        return $user;
    }

    public function save(AggregateRoot $user) : void
    {
        parent::save($user);
    }

}
