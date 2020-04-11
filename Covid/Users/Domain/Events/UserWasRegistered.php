<?php

namespace Covid\Users\Domain\Events;

use Symfony\Component\Console\Descriptor\Descriptor;
use DateTimeImmutable;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\HashedPassword;
use Covid\Users\Domain\Email;

final class UserWasRegistered
{
    private $userId;
    private $name;
    private $email;
    private $phone;
    private $hashedPassword;
    private $registeredAt;

    public function __construct(
        UserId $userId,
        Name $name,
        ?Email $email,
        ?PhoneNumber $phone,
        HashedPassword $hashedPassword,
        DateTimeImmutable $registeredAt
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->hashedPassword = $hashedPassword;
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

    public function getHashedPassword():? HashedPassword
    {
        return $this->hashedPassword;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function serialize(): string
    {
        return json_encode([
            'userId' => (string)$this->userId,
            'name' => (string)$this->name,
            'email' => $this->email ? (string)$this->email : null,
            'phone' => $this->phone ? (string)$this->phone : null,
            'hashedPassword' => (string) $this->hashedPassword,
            'registeredAt' => $this->registeredAt->format('Y-m-d H:i:s'),
        ]);
    }

    public static function deserialize(string $json): UserWasRegistered
    {
        $payload = json_decode($json);

        return new UserWasRegistered(
            new UserId($payload->userId),
            new Name($payload->name),
            $payload->email ? new Email($payload->email) : null,
            $payload->phone ? new PhoneNumber($payload->phone) : null,
            new HashedPassword($payload->hashedPassword),
            new DateTimeImmutable($payload->registeredAt)
        );
    }
}
