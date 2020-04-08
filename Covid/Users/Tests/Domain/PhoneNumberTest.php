<?php

namespace Covid\Users\Domain;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Covid\Users\Domain\Exceptions\PhoneNumberWasInvalid;

class PhoneNumberTest extends TestCase
{

    public function test_phone_number_instantiate()
    {
        $phoneNumber = new PhoneNumber('+447825600704');

        $this->assertEquals('+447825600704', (string)$phoneNumber);
    }
    
    public function test_phone_number_corrects_zero()
    {
        $phoneNumber = new PhoneNumber('07825600704');

        $this->assertEquals('+447825600704', (string)$phoneNumber);
    }
    
    public function test_phone_number_corrects_clipped_zero()
    {
        $phoneNumber = new PhoneNumber('7825600704');

        $this->assertEquals('+447825600704', (string)$phoneNumber);
    }

    public function test_phone_number_invalid()
    {
        $this->expectException(PhoneNumberWasInvalid::class);

        $phoneNumber = new PhoneNumber('01592204707');
    }
}
