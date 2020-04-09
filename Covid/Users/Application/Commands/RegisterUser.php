<?php

namespace Covid\Users\Application\Commands;

use DateTimeImmutable;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\Email;

class RegisterUser {

    private $userId;
    private $name;
    private $email;
    private $phone;
    private $registeredAt;

    public function __construct(
        UserId $userId,
        Name $name,
        ?Email $email,
        ?PhoneNumber $phone,
        DateTimeImmutable $registeredAt
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->registeredAt = $registeredAt;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail():? Email
    {
        return $this->email;
    }

    public function getPhoneNumber():? PhoneNumber
    {
        return $this->phone;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }
}
