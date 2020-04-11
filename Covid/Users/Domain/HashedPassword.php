<?php

namespace Covid\Users\Domain;

final class HashedPassword
{
    private $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }
    
    public function __toString()
    {
        return $this->hash;
    }

}
