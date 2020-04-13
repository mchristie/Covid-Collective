<?php

namespace Covid\Users\Application\Commands;

use DateTimeImmutable;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\SeekingAssistance;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\OfferingAssistance;
use Covid\Users\Domain\Name;

class UpdateUser {

    private $userId;
    private $name;
    private $seekingAssistance;
    private $offeringAssistance;
    private $password;
    private $updatedAt;

    public function __construct(
        UserId $userId,
        Name $name,
        SeekingAssistance $seekingAssistance,
        OfferingAssistance $offeringAssistance,
        ?Password $password,
        DateTimeImmutable $updatedAt
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->seekingAssistance = $seekingAssistance;
        $this->offeringAssistance = $offeringAssistance;
        $this->password = $password;
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

    public function getSeekingAssistance(): SeekingAssistance
    {
        return $this->seekingAssistance;
    }

    public function getOfferingAssistance(): OfferingAssistance
    {
        return $this->offeringAssistance;
    }

    public function getPassword():? Password
    {
        return $this->password;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
