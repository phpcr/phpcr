<?php
namespace PHPCR\Tests;

use PHPCR\NodeInterface;
use PHPCR\PropertyInterface;
use PHPCR\PropertyType;

/**
 * @covers \PHPCR\PropertyType
 */
class PropertyTypesTest extends \PHPUnit_Framework_TestCase
{

    /** key = numeric type constant names as defined by api
     *  value = expected value of the TYPENAME_<TYPE> constants
     */
    protected static $names = array(
        'UNDEFINED'      => 'undefined',
        'STRING'         => 'String',
        'BINARY'         => 'Binary',
        'LONG'           => 'Long',
        'DOUBLE'         => 'Double',
        'DATE'           => 'Date',
        'BOOLEAN'        => 'Boolean',
        'NAME'           => 'Name',
        'PATH'           => 'Path',
        'REFERENCE'      => 'Reference',
        'WEAKREFERENCE'  => 'WeakReference',
        'URI'            => 'URI',
        'DECIMAL'        => 'Decimal'
    );

    public static function dataValueFromName()
    {
        $data = array();
        foreach (self::$names as $key => $value) {
            $data[] = array($key,$value);
        }

        return $data;
    }

    /**
     * @dataProvider dataValueFromName
     */
    public function testNameFromValue($field, $name)
    {
        $this->assertEquals($name, PropertyType::nameFromValue(constant("PHPCR\\PropertyType::$field")));
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNameFromValueInvalid()
    {
        PropertyType::nameFromValue(-1);
    }

    /**
     * @dataProvider dataValueFromName
     */
    public function testValueFromName($field, $name)
    {
        $this->assertEquals(constant("PHPCR\\PropertyType::$field"), PropertyType::valueFromName($name));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValueFromNameInvalid()
    {
        PropertyType::valueFromName('Notexisting');
    }

    public function dataValueTypes()
    {
        $property = $this->getMock('PHPCR\Tests\PropertyMock');
        $property->expects($this->once())
            ->method('getType')
            ->will($this->returnValue(PropertyType::BINARY))
        ;

        return array(
            array('test', PropertyType::STRING),
            array(fopen('php://memory', 'w+'), PropertyType::BINARY),
            array(123, PropertyType::LONG),
            array(3.14, PropertyType::DOUBLE),
            array('2010-03-17T16:05:13', PropertyType::DATE),
            array('2010-03-17T16:05:13.123', PropertyType::DATE),
            array('2010-03-17T16:05:13+02:00', PropertyType::DATE),
            array('2010-03-17T16:05:13 but this is not date', PropertyType::STRING),
            array(new \DateTime(), PropertyType::DATE),
            array(true, PropertyType::BOOLEAN),
            array(false, PropertyType::BOOLEAN),
            // NAME is never found, its just a string
            array($property, PropertyType::BINARY),
            array($this->getMock('PHPCR\Tests\NodeMock'), PropertyType::REFERENCE),
            // URI is never found, its just a string
            // DECIMAL is never found, its just a string
        );
    }

    /**
     * @dataProvider dataValueTypes
     */
    public function testDetermineType($value, $expected)
    {
        $this->assertEquals($expected, PropertyType::determineType($value));
    }

    /**
     * @expectedException \PHPCR\ValueFormatException
     */
    public function testDetermineTypeObject()
    {
        PropertyType::determineType($this);
    }

    /**
     * @expectedException \PHPCR\ValueFormatException
     */
    public function testDetermineTypeNull()
    {
        PropertyType::determineType(null);
    }
}

interface NodeMock extends \Iterator, NodeInterface
{}
interface PropertyMock extends \Iterator, PropertyInterface
{}
