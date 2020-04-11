<?php

namespace Covid\Shared;

use ReflectionClass;
use Exception;

class BaseException extends Exception
{
    public function getName(): string
    {
        $reflect = new ReflectionClass($this);
        return trim(preg_replace('/(?=[A-Z])/', ' ', $reflect->getShortName()));
    }
}
