<?php
namespace PHPCR\Tests;

use PHPCR\CredentialsInterface;
use PHPCR\GuestCredentials;
use PHPUnit\Framework\TestCase;

class GuestCredentialsTest extends TestCase
{
    public function testGuestCredentials()
    {
        $credentials = new GuestCredentials;
        $this->assertInstanceOf(CredentialsInterface::class, $credentials);
    }
}
