<?php

namespace Covid\Users\Domain;

use Illuminate\Database\Connection;
use Covid\Users\Domain\UserRepository;
use Covid\Users\Domain\Events\UserWasUpdated;
use Covid\Users\Domain\Events\UserWasRegistered;
use Broadway\ReadModel\Projector;

class UsersProjector extends Projector
{

    private $db;

    public function __construct(Connection $db, UserRepository $users)
    {
        $this->db       = $db;
        $this->users = $users;
    }

    public function applyUserWasRegistered(UserWasRegistered $event)
    {
        $this->db->table('users')->insert(
            [
                'id'            => (string) $event->getUserId(),
                'name'          => (string) $event->getName(),
                'email'         => $event->getEmail() ? (string) $event->getEmail() : null,
                'phone'         => $event->getPhoneNumber() ? (string) $event->getPhoneNumber() : null,
                'password'      => (string) $event->getHashedPassword(),
                'emailVerified' => 0,
                'phoneVerified' => 0,
                'registeredAt'  => $event->getRegisteredAt()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function applyUserWasUpdated(UserWasUpdated $event)
    {
        $this->db->table('users')
                ->where('id', (string) $event->getUserId())
                ->limit(1)
                ->update([
                    'name'                  => (string) $event->getName(),
                    'seekingAssistance'     => (string) $event->getSeekingAssistance(),
                    'offeringAssistance'    => (string) $event->getOfferingAssistance(),
                    'updatedAt'             => $event->getUpdatedAt()->format('Y-m-d H:i:s'),
                ]);
    }


}
