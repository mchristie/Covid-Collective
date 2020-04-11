<?php

namespace Covid\USers\Domain;

use RuntimeException;
use DateTimeImmutable;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\PasswordHelper;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\HashedPassword;
use Covid\Users\Domain\Exceptions\UserNotFound;
use Covid\Users\Domain\Exceptions\UserAlreadyExists;
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

    private $hashedPassword;

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
        Password $password,
        DateTimeImmutable $registeredAt,
        UsersQuery $userQuery,
        PasswordHelper $hasher
    ) {
        if (!$email && !$phoneNumber) {
            throw new EmailOrPhoneIsRequired();
        }

        try {
            $userQuery->findByEmailOrPhoneNumber($email, $phoneNumber);
            throw new UserAlreadyExists();
        } catch (UserNotFound $exception) {
            // Ideal
        }
        
        $user = new static;

        $hashedPassword = $hasher->hash($password);

        $user->apply(
            new UserWasRegistered(
                $userId,
                $name,
                $email,
                $phoneNumber,
                $hashedPassword,
                $registeredAt
            )
        );

        return $user;
    }

    public function checkPassword(Password $password, PasswordHelper $helper)
    {
        return $helper->check($this->hashedPassword, $password);
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
        $this->hashedPassword = $event->getHashedPassword();
        $this->registeredAt = $event->getRegisteredAt();
    }

}
