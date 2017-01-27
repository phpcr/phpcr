<?php

namespace PHPCR\Tests;

use DateTime;
use InvalidArgumentException;
use PHPCR\PropertyType;
use PHPCR\ValueFormatException;
use PHPUnit_Framework_TestCase;

/**
 * @covers \PHPCR\PropertyType
 */
class PropertyTypesTest extends PHPUnit_Framework_TestCase
{
    /** key = numeric type constant names as defined by api
     *  value = expected value of the TYPENAME_<TYPE> constants
     */
    protected static $names = [
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
    ];

    public static function dataValueFromName()
    {
        $data = [];

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

    public function testNameFromValueInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        PropertyType::nameFromValue(-1);
    }

    /**
     * @dataProvider dataValueFromName
     */
    public function testValueFromName($field, $name)
    {
        $this->assertEquals(constant("PHPCR\\PropertyType::$field"), PropertyType::valueFromName($name));
    }

    public function testValueFromNameInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        PropertyType::valueFromName('Notexisting');
    }

    public function dataValueTypes()
    {
        $property = $this->createMock(PropertyMock::class);

        $property->expects($this->once())
            ->method('getType')
            ->will($this->returnValue(PropertyType::BINARY))
        ;

        return [
            ['test', PropertyType::STRING],
            [fopen('php://memory', 'w+'), PropertyType::BINARY],
            [123, PropertyType::LONG],
            [3.14, PropertyType::DOUBLE],
            ['2010-03-17T16:05:13', PropertyType::DATE],
            ['2010-03-17T16:05:13.123', PropertyType::DATE],
            ['2010-03-17T16:05:13+02:00', PropertyType::DATE],
            ['2010-03-17T16:05:13 but this is not date', PropertyType::STRING],
            [new DateTime(), PropertyType::DATE],
            [true, PropertyType::BOOLEAN],
            [false, PropertyType::BOOLEAN],
            // NAME is never found, its just a string
            [$property, PropertyType::BINARY],
            [$this->createMock(NodeMock::class), PropertyType::REFERENCE],
            // URI is never found, its just a string
            // DECIMAL is never found, its just a string
        ];
    }

    /**
     * @dataProvider dataValueTypes
     */
    public function testDetermineType($value, $expected)
    {
        $this->assertEquals($expected, PropertyType::determineType($value));
    }

    public function testDetermineTypeObject()
    {
        $this->expectException(ValueFormatException::class);

        PropertyType::determineType($this);
    }

    public function testDetermineTypeNull()
    {
        $this->expectException(ValueFormatException::class);

        PropertyType::determineType(null);
    }
}
