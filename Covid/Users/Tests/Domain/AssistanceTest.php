<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\SeekingAssistanceWasInvalid;
use Covid\Users\Domain\Exceptions\OfferingAssistanceWasInvalid;
use Covid\Users\Domain\Exceptions\EmailWasInvalid;

class AssistanceTest extends TestCase
{

    public function test_offering_assistance_valid()
    {
        $assistance = new OfferingAssistance('yes');
        $this->assertEquals('YES', (string) $assistance);

        $assistance = new OfferingAssistance('NO');
        $this->assertEquals('NO', (string) $assistance);
    }
    
    public function test_offering_assistance_invalid()
    {
        $this->expectException(OfferingAssistanceWasInvalid::class);

        $assistance = new OfferingAssistance('maybe?');
    }

    public function test_seeking_assistance_valid()
    {
        $assistance = new SeekingAssistance('yes');
        $this->assertEquals('YES', (string) $assistance);

        $assistance = new SeekingAssistance('NO');
        $this->assertEquals('NO', (string) $assistance);
    }
    
    public function test_seeking_assistance_invalid()
    {
        $this->expectException(SeekingAssistanceWasInvalid::class);

        $assistance = new SeekingAssistance('maybe?');
    }
}
