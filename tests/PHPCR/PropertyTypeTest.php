<?php
namespace PHPCR\Tests;

use PHPCR\PropertyType;

/**
 * a test for the PHPCR\PropertyType class
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
    /** key = numeric type constant names as defined by api
     *  value = string for valueFromType
     */
    protected static $types = array(
        'STRING'         => 'String',
        'LONG'           => 'int',
        'LONG'           => 'Integer',
        'DOUBLE'         => 'Double',
        'DOUBLE'         => 'Float',
        'DATE'           => 'Datetime',
        'BOOLEAN'        => 'Boolean',
        'BOOLEAN'        => 'Bool',
        'UNDEFINED'      => 'something',
        'UNDEFINED'      => 'undefined',
    );

    static public function dataValueFromName()
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
     * @expectedException InvalidArgumentException
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
     * @expectedException InvalidArgumentException
     */
    public function testValueFromNameInvalid()
    {
        PropertyType::valueFromName('Notexisting');
    }

    public function dataValueTypes()
    {
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
            // TODO: PATH for property
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
     * @expectedException PHPCR\ValueFormatException
     */
    public function testDetermineTypeObject()
    {
        PropertyType::determineType($this);
    }

    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testDetermineTypeNull()
    {
        PropertyType::determineType(null);
    }

    public function dataConversionMatrix()
    {
        $stream = fopen('php://memory', '+rw');
        fwrite($stream, 'test string');
        rewind($stream);

        $datestream = fopen('php://memory', '+rw');
        fwrite($datestream, '17.12.2010');
        rewind($datestream);

        $numberstream = fopen('php://memory', '+rw');
        fwrite($numberstream, '123.456');
        rewind($numberstream);

        $namestream = fopen('php://memory', '+rw');
        fwrite($namestream, 'test');
        rewind($namestream);

        $uuidstream = fopen('php://memory', '+rw');
        fwrite($uuidstream, '38b7cf18-c417-477a-af0b-c1e92a290c9a');
        rewind($uuidstream);

        return array(
            array('test string', PropertyType::STRING, 0, PropertyType::LONG),
            array('378.37', PropertyType::STRING, 378, PropertyType::LONG),
            array('test string', PropertyType::STRING, 0, PropertyType::DOUBLE),
            array('249.39', PropertyType::STRING, 249.39, PropertyType::DOUBLE),
            array('test string', PropertyType::STRING, null, PropertyType::DATE),
            array('17.12.2010', PropertyType::STRING, new \DateTime('17.12.2010'), PropertyType::DATE),
            array('test string', PropertyType::STRING, true, PropertyType::BOOLEAN),
            array('false', PropertyType::STRING, true, PropertyType::BOOLEAN),
            array('', PropertyType::STRING, false, PropertyType::BOOLEAN),
            // TODO: check NAME may not have spaces array('test string', PropertyType::STRING, null, PropertyType::NAME),
            array('test', PropertyType::STRING, 'test', PropertyType::NAME),
            // TODO: check PATH may not have spaces array('test string', PropertyType::STRING, null, PropertyType::PATH),
            array('../the/node', PropertyType::STRING, '../the/node', PropertyType::PATH),
            // TODO: should we move UUIDHelper to phpcr so we can check in PropertyType? array('test string', PropertyType::STRING, null, PropertyType::REFERENCE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array('http://phpcr.github.com/', PropertyType::STRING, 'http://phpcr.github.com/', PropertyType::URI),
            array('test string', PropertyType::STRING, 'test string', PropertyType::DECIMAL), // up to the decimal functions to validate

            // TODO: fix stream handling
            // array($stream, PropertyType::BINARY, 'test string', PropertyType::STRING),
            // array($stream, PropertyType::BINARY, 0, PropertyType::LONG),
            // array($numberstream, PropertyType::BINARY, 123, PropertyType::LONG),
            // array($stream, PropertyType::BINARY, 0, PropertyType::DOUBLE),
            // array($numberstream, PropertyType::BINARY, 123.456, PropertyType::DOUBLE),
            array($stream, PropertyType::BINARY, null, PropertyType::DATE),
            // TODO: fix this case array($datestream, PropertyType::BINARY, new \DateTime('17.12.2010'), PropertyType::DATE),
            array($stream, PropertyType::BINARY, true, PropertyType::BOOLEAN),
            // TODO: check NAME may not have spaces array($stream, PropertyType::BINARY, null, PropertyType::NAME),
            // array($namestream, PropertyType::BINARY, 'test', PropertyType::NAME),
            // TODO: check PATH may not have spaces array($stream, PropertyType::BINARY, null, PropertyType::PATH),
            // TODO: should we move UUIDHelper to phpcr so we can check in PropertyType? array($stream, PropertyType::STRING, null, PropertyType::REFERENCE),
            // array($uuidstream, PropertyType::BINARY, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            // array($stream, PropertyType::STRING, 'test string', PropertyType::DECIMAL), // up to the decimal functions to validate

/*
            TODO: provide further mappings to test them
            array(PropertyType::LONG),
            array(PropertyType::DOUBLE),
            array(PropertyType::DATE),
            array(PropertyType::BOOLEAN),
            array(PropertyType::NAME),
            array(PropertyType::PATH),
            array(PropertyType::REFERENCE),
            array(PropertyType::WEAKREFERENCE),
            array(PropertyType::URI),
            array(PropertyType::DECIMAL),
            */
        );
    }

    /**
     * Skip binary target as its a special case
     *
     * @param int $srctype PropertyType constant to convert from
     * @param $validtargets array map of target type => value | null for exception
     *
     * @dataProvider dataConversionMatrix
     */
    public function testConvertType($value, $srctype, $expected, $targettype)
    {
        if (is_null($expected)) {
            try {
                PropertyType::convertType($value, $targettype, $srctype);
                $this->fail('Excpected that this conversion would throw an exception');
            } catch(\PHPCR\ValueFormatException $e) {
                // expected
                $this->assertTrue(true); // make it assert something
            }
        } else {
            $this->assertEquals($expected, PropertyType::convertType($value, $targettype, $srctype));
        }
    }

    public function testConvertTypeToBinary()
    {
        $stream = PropertyType::convertType('test string', PropertyType::BINARY);
        $this->assertInternalType('resource', $stream);
        $string = stream_get_contents($stream);
        $this->assertEquals('test string', $string);

        $this->markTestIncomplete('TODO: fix conversion to binary');

        $stream = PropertyType::convertType(new \DateTime('20.12.2012'), PropertyType::BINARY);
        $this->assertInternalType('resource', $stream);
        $string = stream_get_contents($stream);
        $this->assertEquals('2012-12-20:00:00:00.000', $string);

        // if conversion to string works, should be fine for all others
    }

    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertInvalidString()
    {
        $this->markTestIncomplete('TODO: Fix');
        PropertyType::convertType($this, PropertyType::STRING);
    }
    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertInvalidBinary()
    {
        PropertyType::convertType($this, PropertyType::BINARY);
    }
    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertInvalidDate()
    {
        PropertyType::convertType($this, PropertyType::DATE);
    }
}

interface NodeMock extends \Iterator, \PHPCR\NodeInterface
{}