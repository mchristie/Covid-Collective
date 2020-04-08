<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\CodeWasInvalid;

abstract class VerificationCode
{
    private $code;

    public function __construct(string $code)
    {
        if (!preg_match('/[0-9]{6}/', $code)) {
            throw new CodeWasInvalid();
        }

        $this->code = $code;
    }
    
    public function __toString()
    {
        return $this->code;
    }

    public function new()
    {
        return new static((string)rand(100000, 999999));
    }

}
