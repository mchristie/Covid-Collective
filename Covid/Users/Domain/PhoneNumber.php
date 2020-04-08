<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\PhoneNumberWasInvalid;

final class PhoneNumber
{
    private $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        $phoneNumber = $this->tryToCorrect($phoneNumber);

        if (!preg_match('/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/', $phoneNumber)) {
            throw new PhoneNumberWasInvalid();
        }

        $this->phoneNumber = $phoneNumber;
    }
    
    public function __toString()
    {
        return $this->phoneNumber;
    }

    private function tryToCorrect(string $phoneNumber): string
    {
        // Replace leading 0
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = preg_replace('/^0/', '+44', $phoneNumber, 1);
        }
        // Fix dropped leading 0
        if (substr($phoneNumber, 0, 1) === '7') {
            $phoneNumber = '+44'.$phoneNumber;
        }

        return $phoneNumber;
    }

}
