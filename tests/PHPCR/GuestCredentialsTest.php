<?php
namespace PHPCR\Tests;

use PHPCR\GuestCredentials;

class GuestCredentialsTest extends \PHPUnit_Framework_TestCase
{
    public function testGuestCredentials()
    {
        $credentials = new GuestCredentials;
        $this->assertInstanceOf('PHPCR\\CredentialsInterface', $credentials);
    }
}
