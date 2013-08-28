<?php
namespace PHPCR\Tests;

use PHPCR\SimpleCredentials;

/**
 * a test for the PHPCR\PropertyType class
 */
class SimpleCredentialsTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $credentials = new SimpleCredentials('user', 'password');
        $this->assertInstanceOf('PHPCR\\CredentialsInterface', $credentials);

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
     * @expectedException \InvalidArgumentException
     * @depends testConstructor
     */
    public function testSetAttributeInvalid(SimpleCredentials $credentials)
    {
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
