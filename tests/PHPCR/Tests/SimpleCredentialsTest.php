<?php

namespace PHPCR\Tests;

use InvalidArgumentException;
use PHPCR\CredentialsInterface;
use PHPCR\SimpleCredentials;
use PHPUnit_Framework_TestCase;

/**
 * a test for the PHPCR\PropertyType class
 */
class SimpleCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $credentials = new SimpleCredentials('user', 'password');
        $this->assertInstanceOf(CredentialsInterface::class, $credentials);

        return $credentials;
    }

    /**
     * @depends testConstructor
     */
    public function testGetters(SimpleCredentials $credentials)
    {
        $this->assertEquals('user', $credentials->getUserID());
        $this->assertEquals('password', $credentials->getPassword());
    }

    /**
     * @depends testConstructor
     */
    public function testSetGetRemoveAttribute(SimpleCredentials $credentials)
    {
        $credentials->setAttribute('name', 'test');
        $this->assertSame('test', $credentials->getAttribute('name'));
        $this->assertNull($credentials->getAttribute('notexisting'));

        $credentials->removeAttribute('name');
        $this->assertNull($credentials->getAttribute('name'));

        $credentials->setAttribute('name', 'test');
        $this->assertSame('test', $credentials->getAttribute('name'));

        $credentials->setAttribute('name', null);
        $this->assertNull($credentials->getAttribute('name'));
    }

    /**
     * @depends testConstructor
     */
    public function testSetAttributeInvalid(SimpleCredentials $credentials)
    {
        $this->expectException(InvalidArgumentException::class);

        $credentials->setAttribute(null, 'test');
    }

    /**
     * @depends testConstructor
     */
    public function testGetAttributeNames(SimpleCredentials $credentials)
    {
        $credentials->setAttribute('other', 'test');
        $this->assertEquals(array('other'), $credentials->getAttributeNames());
    }
}
