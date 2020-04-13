<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\SeekingAssistanceWasInvalid;

final class SeekingAssistance
{
    private $value;

    const YES = 'YES';
    const NO = 'NO';
    const OPTIONS = ['YES', 'NO'];

    public function __construct(string $value)
    {
        $value = $this->tidy($value);

        $this->validate($value);

        $this->value = $value;
    }
    
    public function __toString()
    {
        return $this->value;
    }

    private function validate(string $value): void
    {
        if (!in_array($value, self::OPTIONS)) {
            throw new SeekingAssistanceWasInvalid();
        }
    }

    private function tidy(string $value): string
    {
        return strtoupper(trim($value));
    }

}
