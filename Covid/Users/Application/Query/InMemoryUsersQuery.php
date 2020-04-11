<?php
namespace Covid\Users\Application\Query;

use Illuminate\Database\Connection;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\Exceptions\UserNotFound;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Email;

class InMemoryUsersQuery implements UsersQuery
{

    public function find(UserId $userId): array
    {
        // TODO

        throw new UserNotFound();
    }

    public function findByEmailOrPhoneNumber(?Email $email, ?PhoneNumber $phone): array
    {
        if ($email === null && $phone === null) {
            throw new EmailOrPhoneIsRequired();
        }
        
        // Todo

        throw new UserNotFound();
    }

}
