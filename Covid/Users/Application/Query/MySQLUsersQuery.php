<?php
namespace Covid\Users\Application\Query;

use Illuminate\Database\Connection;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\Exceptions\UserNotFound;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Email;

class MySQLUsersQuery implements UsersQuery
{

    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function find(UserId $userId): array
    {
        $result = $this->db->table('users')->where('id', (string) $userId)->first();

        if (!$result) {
            throw new UserNotFound();
        }

        return (array) $result;
    }

    public function findByEmailOrPhoneNumber(?Email $email, ?PhoneNumber $phone): array
    {
        if ($email === null && $phone === null) {
            throw new EmailOrPhoneIsRequired();
        }
        
        $result = $this->db->table('users')->where(function($query) use($email, $phone) {
            if ($email) {
                $query->where('email', (string) $email);
            }
            if ($phone) {
                $query->orWhere('phone', (string) $phone);
            }
        })->first();

        if (!$result) {
            throw new UserNotFound();
        }

        return (array) $result;
    }

}
