<?php

namespace Covid\Users\Domain\Events;

use DateTimeImmutable;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\SeekingAssistance;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\OfferingAssistance;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\HashedPassword;
use Covid\Users\Domain\Email;

final class UserWasUpdated
{
    private $userId;
    private $name;
    private $seekingAssistance;
    private $offeringAssistance;
    private $hashedPassword;
    private $updatedAt;

    public function __construct(
        UserId $userId,
        Name $name,
        SeekingAssistance $seekingAssistance,
        OfferingAssistance $offeringAssistance,
        ?HashedPassword $hashedPassword,
        DateTimeImmutable $updatedAt
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->seekingAssistance = $seekingAssistance;
        $this->offeringAssistance = $offeringAssistance;
        $this->hashedPassword = $hashedPassword;
        $this->updatedAt = $updatedAt;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getSeekingAssistance():? SeekingAssistance
    {
        return $this->seekingAssistance;
    }

    public function getOfferingAssistance():? OfferingAssistance
    {
        return $this->offeringAssistance;
    }

    public function getHashedPassword():? HashedPassword
    {
        return $this->hashedPassword;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function serialize(): string
    {
        return json_encode([
            'userId' => (string) $this->userId,
            'name' => (string) $this->name,
            'seekingAssistance' => (string) $this->seekingAssistance,
            'offeringAssistance' => (string) $this->offeringAssistance,
            'hashedPassword' => $this->hashedPassword ? (string) $this->hashedPassword : null,
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ]);
    }

    public static function deserialize(string $json): UserWasUpdated
    {
        $payload = json_decode($json);

        return new UserWasUpdated(
            new UserId($payload->userId),
            new Name($payload->name),
            new SeekingAssistance($payload->seekingAssistance),
            new OfferingAssistance($payload->offeringAssistance),
            $payload->hashedPassword ? new HashedPassword($payload->hashedPassword) : $payload->hashedPassword,
            new DateTimeImmutable($payload->updatedAt)
        );
    }
}
