<?php
namespace PHPCR\Tests;

use PHPCR\CredentialsInterface;
use PHPCR\GuestCredentials;
use PHPUnit_Framework_TestCase;

class GuestCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testGuestCredentials()
    {
        $credentials = new GuestCredentials;
        $this->assertInstanceOf(CredentialsInterface::class, $credentials);
    }
}
