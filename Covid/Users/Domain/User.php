<?php

namespace Covid\USers\Domain;

use RuntimeException;
use DateTimeImmutable;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Events\UserWasRegistered;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

final class User extends EventSourcedAggregateRoot
{

    private $userId;
    private $name;

    private $email;
    private $emailVerified = false;
    private $emailVerificationCode;

    private $phoneNumber;
    private $phoneNumberVerified = false;
    private $phoneNumberVerificationCode;

    private $registeredAt;

    /*
     * Getters
     */

    public function getAggregateRootId(): string
    {
        return $this->userId->toString();
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailVerified()
    {
        return $this->emailVerified;
    }

    public function getEmailVerificationCode()
    {
        return $this->emailVerificationCode;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getPhoneNumberVerified()
    {
        return $this->phoneNumberVerified;
    }

    public function getPhoneNumberVerificationCode()
    {
        return $this->phoneNumberVerificationCode;
    }

    /*
     * Methods
     */

    public static function register(
        UserId $userId,
        Name $name,
        ?Email $email,
        ?PhoneNumber $phoneNumber,
        DateTimeImmutable $registeredAt
    ) {
        if (!$email && !$phoneNumber) {
            throw new EmailOrPhoneIsRequired();
        }
        
        $user = new static;

        $user->apply(
            new UserWasRegistered(
                $userId,
                $name,
                $email,
                $phoneNumber,
                $registeredAt
            )
        );

        return $user;
    }

    /*
     *   Apply events
     */

    protected function applyUserWasRegistered(UserWasRegistered $event)
    {
        $this->userId = $event->getUserId();
        $this->name = $event->getName();
        $this->email = $event->getEmail();
        $this->phoneNumber = $event->getPhoneNumber();
        $this->registeredAt = $event->getRegisteredAt();
    }

}
