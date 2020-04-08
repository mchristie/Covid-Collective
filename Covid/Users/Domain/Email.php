<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\EmailWasInvalid;

final class Email
{
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailWasInvalid();
        }

        $this->email = $email;
    }
    
    public function __toString()
    {
        return $this->email;
    }

}
