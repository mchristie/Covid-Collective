<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\NameWasInvalid;

class NameTest extends TestCase
{

    public function test_name_instantiate()
    {
        $name = new Name('Malcolm');

        $this->assertEquals('Malcolm', (string)$name);
    }

    public function test_name_invalid()
    {
        $this->expectException(NameWasInvalid::class);

        $name = new Name('M');
    }
}
