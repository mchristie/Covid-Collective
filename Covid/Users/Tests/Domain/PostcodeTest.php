<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\PostcodeWasInvalid;

class PostcodeTest extends TestCase
{

    public function test_postcode_instantiate()
    {
        $postcode = new Postcode('eh112jg ');

        $this->assertEquals('EH11 2JG', (string) $postcode);
    }

    public function test_postcode_invalid()
    {
        $this->expectException(PostcodeWasInvalid::class);

        $postcode = new Postcode('M');
    }
}
