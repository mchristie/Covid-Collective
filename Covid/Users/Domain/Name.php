<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\NameWasInvalid;

final class Name
{
    private $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3 || strlen($name) > 100) {
            throw new NameWasInvalid();
        }

        $this->name = $name;
    }
    
    public function __toString()
    {
        return $this->name;
    }

}
