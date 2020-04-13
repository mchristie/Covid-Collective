<?php

namespace Covid\Users\Domain;

use Covid\Users\Domain\Exceptions\PostcodeWasInvalid;

final class Postcode
{
    private $postcode;

    const TIDY = '/([A-Z]{2}[1-9]{1,2})\s?([1-9][A-Z]{2})/';
    const VALIDATE = '/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([AZa-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z]))))[0-9][A-Za-z]{2})$/';

    public function __construct(string $postcode)
    {
        $this->validate($postcode);

        $this->postcode = $this->tidy($postcode);
    }
    
    public function __toString()
    {
        return $this->postcode;
    }

    private function validate(string $postcode): void
    {
        $postcode = str_replace(' ', '', trim($postcode));

        if (preg_match(self::VALIDATE, $postcode) != 1) {
            throw new PostcodeWasInvalid();
        }
    }

    private function tidy(string $postcode): string
    {
        return preg_replace_callback(self::TIDY, function($data) {
            return $data[1].' '.$data[2];
        }, strtoupper(trim($postcode)));
    }

}
