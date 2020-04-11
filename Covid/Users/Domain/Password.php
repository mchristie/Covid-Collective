<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\PasswordNotStrongEnough;

final class Password
{
    private $password;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new PasswordNotStrongEnough();
        }

        $this->password = $password;
    }
    
    public function __toString()
    {
        return $this->password;
    }

}
