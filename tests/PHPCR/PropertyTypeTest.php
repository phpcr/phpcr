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

        $datetimeLong = new \DateTime();
        $datetimeLong->setTimestamp(123);

        return array(
            // string to...
            array('test string', PropertyType::STRING, 0, PropertyType::LONG),
            array('378.37', PropertyType::STRING, 378, PropertyType::LONG),
            array('test string', PropertyType::STRING, 0.0, PropertyType::DOUBLE),
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

            // stream to...
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

            // long to...
            array(123, PropertyType::LONG, '123', PropertyType::STRING),
            array(123, PropertyType::LONG, 123.0, PropertyType::DOUBLE),
            array(123, PropertyType::LONG, $datetimeLong, PropertyType::DATE),
            array(123, PropertyType::LONG, null, PropertyType::BOOLEAN),
            // TODO: array(123, PropertyType::LONG, null, PropertyType::NAME),
            // TODO: array(123, PropertyType::LONG, null, PropertyType::PATH),
            array(123, PropertyType::LONG, null, PropertyType::REFERENCE),
            // TODO: array(123, PropertyType::LONG, null, PropertyType::URI),
            array(123, PropertyType::LONG, '123', PropertyType::DECIMAL),

            // double to...
            array(123.1, PropertyType::DOUBLE, '123.1', PropertyType::STRING),
            array(123.1, PropertyType::DOUBLE, 123, PropertyType::LONG),
            array(123.1, PropertyType::DOUBLE, $datetimeLong, PropertyType::DATE),
            array(123.1, PropertyType::DOUBLE, null, PropertyType::BOOLEAN),
            // TODO: array(123.1, PropertyType::DOUBLE, null, PropertyType::NAME),
            // TODO: array(123.1, PropertyType::DOUBLE, null, PropertyType::PATH),
            array(123.1, PropertyType::DOUBLE, null, PropertyType::REFERENCE),
            // TODO: array(123.1, PropertyType::DOUBLE, null, PropertyType::URI),
            array(123.1, PropertyType::DOUBLE, '123.1', PropertyType::DECIMAL),

            array($datetimeLong, PropertyType::DATE, $datetimeLong->format('Y-m-d\TH:i:s.') . substr($datetimeLong->format('u'), 0, 3) . $datetimeLong->format('P'), PropertyType::STRING),
            // TODO fix: array($datetimeLong, PropertyType::DATE, 123, PropertyType::LONG),
            // TODO fix: array($datetimeLong, PropertyType::DATE, 123.0, PropertyType::DOUBLE),
            array($datetimeLong, PropertyType::DATE, null, PropertyType::BOOLEAN),
            // TODO fix: array($datetimeLong, PropertyType::DATE, null, PropertyType::NAME),
            // TODO fix: array($datetimeLong, PropertyType::DATE, null, PropertyType::PATH),
            // TODO fix: array($datetimeLong, PropertyType::DATE, null, PropertyType::REFERENCE),
            // TODO fix: array($datetimeLong, PropertyType::DATE, null, PropertyType::URI),
            // TODO fix: array($datetimeLong, PropertyType::DATE, '123', PropertyType::DECIMAL),

            array(true, PropertyType::BOOLEAN, '1', PropertyType::STRING),
            array(false, PropertyType::BOOLEAN, '', PropertyType::STRING),
            array(true, PropertyType::BOOLEAN, null, PropertyType::DATE),
            array(true, PropertyType::BOOLEAN, null, PropertyType::LONG),
            array(true, PropertyType::BOOLEAN, null, PropertyType::DOUBLE),
            // TODO fix: array(true, PropertyType::BOOLEAN, null, PropertyType::NAME),
            // TODO fix: array(true, PropertyType::BOOLEAN, null, PropertyType::PATH),
            array(true, PropertyType::BOOLEAN, null, PropertyType::REFERENCE),
            // TODO fix: array(true, PropertyType::BOOLEAN, null, PropertyType::URI),
            array(true, PropertyType::BOOLEAN, null, PropertyType::DECIMAL),

            array('name', PropertyType::NAME, 'name', PropertyType::STRING),
            array('name', PropertyType::NAME, null, PropertyType::DATE),
            array('name', PropertyType::NAME, null, PropertyType::LONG),
            array('name', PropertyType::NAME, null, PropertyType::DOUBLE),
            array('name', PropertyType::NAME, null, PropertyType::BOOLEAN),
            array('name', PropertyType::NAME, 'name', PropertyType::PATH),
            array(true, PropertyType::BOOLEAN, null, PropertyType::REFERENCE),
            // TODO: fix array('name', PropertyType::NAME, '../name', PropertyType::URI),
            // TODO: fix array('näme', PropertyType::NAME, '../n%C4me', PropertyType::URI),
            array('name', PropertyType::NAME, null, PropertyType::DECIMAL),

            array('../test/path', PropertyType::PATH, '../test/path', PropertyType::STRING),
            array('../test/path', PropertyType::PATH, null, PropertyType::DATE),
            array('../test/path', PropertyType::PATH, null, PropertyType::LONG),
            array('../test/path', PropertyType::PATH, null, PropertyType::DOUBLE),
            array('../test/path', PropertyType::PATH, null, PropertyType::BOOLEAN),
            // TODO: fix array('../test/path', PropertyType::PATH, null, PropertyType::NAME),
            // TODO: fix array('./path', PropertyType::PATH, 'path', PropertyType::NAME),
            // TODO: fix array('../test/path', PropertyType::PATH, null, PropertyType::REFERENCE),
            array('../test/path', PropertyType::PATH, '../test/path', PropertyType::URI),
            // TODO: fix array('../test/päth', PropertyType::PATH, '../test/p%C4th', PropertyType::URI),
            // TODO: fix array('test', PropertyType::PATH, './test', PropertyType::URI),
            array('../test/path', PropertyType::PATH, null, PropertyType::DECIMAL),

            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::DATE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::LONG),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::DOUBLE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::BOOLEAN),
            // TODO: fix array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::NAME),
            // TODO: fix array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::PATH),
            // TODO: fix array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::URI),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::DECIMAL),

            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, 'http://phpcr.githbub.com/doc/html', PropertyType::STRING),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::DATE),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::LONG),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::DOUBLE),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::BOOLEAN),
            // TODO: fix array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::NAME),
            // TODO: fix array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::PATH),
            // TODO: fix array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::REFERENCE),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::DECIMAL),

            array('123.4', PropertyType::DECIMAL, '123.4', PropertyType::STRING),
            // TODO: fix array('123.4', PropertyType::DECIMAL, $datetimeLong, PropertyType::DATE),
            array('123.4', PropertyType::DECIMAL, 123, PropertyType::LONG),
            array('123.4', PropertyType::DECIMAL, 123.4, PropertyType::DOUBLE),
            array('123.4', PropertyType::DECIMAL, null, PropertyType::BOOLEAN),
            // TODO: fix array('123.4', PropertyType::DECIMAL, null, PropertyType::NAME),
            // TODO: fix array('123.4', PropertyType::DECIMAL, null, PropertyType::PATH),
            // TODO: fix array('123.4', PropertyType::DECIMAL, null, PropertyType::URI),
            // TODO: fix array('123.4', PropertyType::DECIMAL, null, PropertyType::REFERENCE),
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
            if (is_object($expected)) {
                $this->assertEquals($expected, PropertyType::convertType($value, $targettype, $srctype));
            } else {
                $this->assertSame($expected, PropertyType::convertType($value, $targettype, $srctype));
            }
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