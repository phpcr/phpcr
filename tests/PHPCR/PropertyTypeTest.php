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
        fwrite($datestream, '17.12.2010  GMT');
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

        $nodemock = $this->getMock('PHPCR\\Tests\\NodeMock');
        $nodemock
            ->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue('38b7cf18-c417-477a-af0b-c1e92a290c9a'))
        ;
        $nodemock
            ->expects($this->any())
            ->method('isNodetype')
            ->with('mix:referenceable')
            ->will($this->returnValue(true))
        ;

        return array(
            // string to...
            array('test string', PropertyType::STRING, 'test string', PropertyType::STRING),
            array('test string', PropertyType::STRING, 0, PropertyType::LONG),
            array('378.37', PropertyType::STRING, 378, PropertyType::LONG),
            array('test string', PropertyType::STRING, 0.0, PropertyType::DOUBLE),
            array('249.39', PropertyType::STRING, 249.39, PropertyType::DOUBLE),
            array('test string', PropertyType::STRING, null, PropertyType::DATE),
            array('17.12.2010 GMT', PropertyType::STRING, new \DateTime('17.12.2010 GMT'), PropertyType::DATE),
            array('test string', PropertyType::STRING, true, PropertyType::BOOLEAN),
            array('false', PropertyType::STRING, true, PropertyType::BOOLEAN),
            array('', PropertyType::STRING, false, PropertyType::BOOLEAN),
            // TODO: check NAME may not have spaces array('test string', PropertyType::STRING, null, PropertyType::NAME),
            array('test', PropertyType::STRING, 'test', PropertyType::NAME),
            // TODO: check PATH may not have spaces array('test string', PropertyType::STRING, null, PropertyType::PATH),
            array('../the/node', PropertyType::STRING, '../the/node', PropertyType::PATH),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            // TODO: should we move UUIDHelper to phpcr so we can check in PropertyType? array('test string', PropertyType::STRING, null, PropertyType::REFERENCE),
            array('', PropertyType::STRING, null, PropertyType::REFERENCE),
            array('http://phpcr.github.com/', PropertyType::STRING, 'http://phpcr.github.com/', PropertyType::URI),
            array('test string', PropertyType::STRING, 'test string', PropertyType::DECIMAL), // up to the decimal functions to validate

            // stream to...
            array($stream, PropertyType::BINARY, 'test string', PropertyType::STRING),
            array($stream, PropertyType::BINARY, 0, PropertyType::LONG),
            array($numberstream, PropertyType::BINARY, 123, PropertyType::LONG),
            array($stream, PropertyType::BINARY, 0.0, PropertyType::DOUBLE),
            array($numberstream, PropertyType::BINARY, 123.456, PropertyType::DOUBLE),
            array($stream, PropertyType::BINARY, null, PropertyType::DATE),
            array($datestream, PropertyType::BINARY, new \DateTime('17.12.2010 GMT'), PropertyType::DATE),
            array($stream, PropertyType::BINARY, true, PropertyType::BOOLEAN),
            // TODO: check NAME may not have spaces array($stream, PropertyType::BINARY, null, PropertyType::NAME),
            array($namestream, PropertyType::BINARY, 'test', PropertyType::NAME),
            // TODO: check PATH may not have spaces array($stream, PropertyType::BINARY, null, PropertyType::PATH),
            // TODO: should we move UUIDHelper to phpcr so we can check in PropertyType? array($stream, PropertyType::STRING, null, PropertyType::REFERENCE),
            array($uuidstream, PropertyType::BINARY, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array($stream, PropertyType::BINARY, 'test string', PropertyType::DECIMAL), // up to the decimal functions to validate

            // invalid stream resource
            array($stream, PropertyType::DECIMAL, null, PropertyType::STRING),

            // long to...
            array(123, PropertyType::LONG, '123', PropertyType::STRING),
            array(123, PropertyType::LONG, 123, PropertyType::LONG),
            array(123, PropertyType::LONG, 123.0, PropertyType::DOUBLE),
            array(123, PropertyType::LONG, $datetimeLong, PropertyType::DATE),
            array(123, PropertyType::LONG, true, PropertyType::BOOLEAN),
            array(0, PropertyType::LONG, false, PropertyType::BOOLEAN),
            array(123, PropertyType::LONG, null, PropertyType::NAME),
            array(123, PropertyType::LONG, null, PropertyType::PATH),
            array(123, PropertyType::LONG, null, PropertyType::REFERENCE),
            array(123, PropertyType::LONG, null, PropertyType::URI),
            array(123, PropertyType::LONG, '123', PropertyType::DECIMAL),

            // double to...
            array(123.1, PropertyType::DOUBLE, '123.1', PropertyType::STRING),
            array(123.1, PropertyType::DOUBLE, 123, PropertyType::LONG),
            array(123.1, PropertyType::DOUBLE, 123.1, PropertyType::DOUBLE),
            array(123.1, PropertyType::DOUBLE, $datetimeLong, PropertyType::DATE),
            array(123.1, PropertyType::DOUBLE, true, PropertyType::BOOLEAN),
            array(0.0, PropertyType::DOUBLE, false, PropertyType::BOOLEAN),
            array(123.1, PropertyType::DOUBLE, null, PropertyType::NAME),
            array(123.1, PropertyType::DOUBLE, null, PropertyType::PATH),
            array(123.1, PropertyType::DOUBLE, null, PropertyType::REFERENCE),
            array(123.1, PropertyType::DOUBLE, null, PropertyType::URI),
            array(123.1, PropertyType::DOUBLE, '123.1', PropertyType::DECIMAL),

            // date to...
            array($datetimeLong, PropertyType::DATE, $datetimeLong->format('Y-m-d\TH:i:s.') . substr($datetimeLong->format('u'), 0, 3) . $datetimeLong->format('P'), PropertyType::STRING),
            array($datetimeLong, PropertyType::DATE, 123, PropertyType::LONG),
            array($datetimeLong, PropertyType::DATE, 123.0, PropertyType::DOUBLE),
            array($datetimeLong, PropertyType::DATE, $datetimeLong, PropertyType::DATE),
            array($datetimeLong, PropertyType::DATE, true, PropertyType::BOOLEAN),
            array($datetimeLong, PropertyType::DATE, null, PropertyType::NAME),
            array($datetimeLong, PropertyType::DATE, null, PropertyType::PATH),
            array($datetimeLong, PropertyType::DATE, null, PropertyType::REFERENCE),
            array($datetimeLong, PropertyType::DATE, null, PropertyType::URI),
            array($datetimeLong, PropertyType::DATE, '123', PropertyType::DECIMAL),

            // boolean to...
            array(true, PropertyType::BOOLEAN, '1', PropertyType::STRING),
            array(false, PropertyType::BOOLEAN, '', PropertyType::STRING),
            array(true, PropertyType::BOOLEAN, null, PropertyType::DATE),
            array(true, PropertyType::BOOLEAN, 1, PropertyType::LONG),
            array(true, PropertyType::BOOLEAN, 1.0, PropertyType::DOUBLE),
            array(true, PropertyType::BOOLEAN, true, PropertyType::BOOLEAN),
            array(true, PropertyType::BOOLEAN, null, PropertyType::NAME),
            array(true, PropertyType::BOOLEAN, null, PropertyType::PATH),
            array(true, PropertyType::BOOLEAN, null, PropertyType::REFERENCE),
            array(true, PropertyType::BOOLEAN, null, PropertyType::URI),
            array(true, PropertyType::BOOLEAN, '1', PropertyType::DECIMAL),
            array(false, PropertyType::BOOLEAN, '', PropertyType::DECIMAL),

            // name to...
            array('name', PropertyType::NAME, 'name', PropertyType::STRING),
            array('name', PropertyType::NAME, null, PropertyType::DATE),
            array('name', PropertyType::NAME, null, PropertyType::LONG),
            array('name', PropertyType::NAME, null, PropertyType::DOUBLE),
            array('name', PropertyType::NAME, null, PropertyType::BOOLEAN),
            array('name', PropertyType::NAME, 'name', PropertyType::NAME),
            array('name', PropertyType::NAME, 'name', PropertyType::PATH),
            array('name', PropertyType::NAME, null, PropertyType::REFERENCE),
            array('name', PropertyType::NAME, '../name', PropertyType::URI),
            array('näme', PropertyType::NAME, '../n%C3%A4me', PropertyType::URI),
            array('name', PropertyType::NAME, null, PropertyType::DECIMAL),

            // path to...
            array('../test/path', PropertyType::PATH, '../test/path', PropertyType::STRING),
            array('../test/path', PropertyType::PATH, null, PropertyType::DATE),
            array('../test/path', PropertyType::PATH, null, PropertyType::LONG),
            array('../test/path', PropertyType::PATH, null, PropertyType::DOUBLE),
            array('../test/path', PropertyType::PATH, null, PropertyType::BOOLEAN),
            // TODO: fix array('../test/path', PropertyType::PATH, null, PropertyType::NAME),
            // TODO: fix array('./path', PropertyType::PATH, 'path', PropertyType::NAME),
            array('../test/path', PropertyType::PATH, '../test/path', PropertyType::PATH),
            array('../test/path', PropertyType::PATH, null, PropertyType::REFERENCE),
            array('../test/path', PropertyType::PATH, '../test/path', PropertyType::URI),
            array('../test/päth', PropertyType::PATH, '../test/p%C3%A4th', PropertyType::URI),
            array('test', PropertyType::PATH, './test', PropertyType::URI),
            array('../test/path', PropertyType::PATH, null, PropertyType::DECIMAL),

            // reference to...
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING),
            array($nodemock, PropertyType::REFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array($nodemock, PropertyType::REFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::DATE),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::DATE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::LONG),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::LONG),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::DOUBLE),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::DOUBLE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::BOOLEAN),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::BOOLEAN),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::NAME),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::NAME),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::PATH),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::PATH),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::URI),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::URI),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE, null, PropertyType::DECIMAL),
            array($nodemock, PropertyType::REFERENCE, null, PropertyType::DECIMAL),

            array($this, PropertyType::REFERENCE, null, PropertyType::STRING),
            array($this, PropertyType::REFERENCE, null, PropertyType::BINARY),
            array($this, PropertyType::REFERENCE, null, PropertyType::DATE),
            array($this, PropertyType::REFERENCE, null, PropertyType::LONG),
            array($this, PropertyType::REFERENCE, null, PropertyType::DOUBLE),
            array($this, PropertyType::REFERENCE, null, PropertyType::BOOLEAN),
            array($this, PropertyType::REFERENCE, null, PropertyType::NAME),
            array($this, PropertyType::REFERENCE, null, PropertyType::PATH),
            array($this, PropertyType::REFERENCE, null, PropertyType::URI),
            array($this, PropertyType::REFERENCE, null, PropertyType::DECIMAL),

            // weak to...
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING),
            array($nodemock, PropertyType::WEAKREFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::STRING),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array($nodemock, PropertyType::WEAKREFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::DATE),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::DATE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::LONG),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::LONG),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::DOUBLE),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::DOUBLE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::BOOLEAN),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::BOOLEAN),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::NAME),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::NAME),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::PATH),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::PATH),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::URI),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::URI),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, '38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::REFERENCE),
            array('38b7cf18-c417-477a-af0b-c1e92a290c9a', PropertyType::WEAKREFERENCE, null, PropertyType::DECIMAL),
            array($nodemock, PropertyType::WEAKREFERENCE, null, PropertyType::DECIMAL),


            // uri to...
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, 'http://phpcr.githbub.com/doc/html', PropertyType::STRING),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::DATE),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::LONG),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::DOUBLE),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::BOOLEAN),
            // TODO: fix array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::NAME),
            // TODO: fix array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::PATH),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::REFERENCE),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, 'http://phpcr.githbub.com/doc/html', PropertyType::URI),
            array('http://phpcr.githbub.com/doc/html', PropertyType::URI, null, PropertyType::DECIMAL),

            // decimal to...
            array('123.4', PropertyType::DECIMAL, '123.4', PropertyType::STRING),
            array('123.4', PropertyType::DECIMAL, $datetimeLong, PropertyType::DATE),
            array('123.4', PropertyType::DECIMAL, 123, PropertyType::LONG),
            array('123.4', PropertyType::DECIMAL, 123.4, PropertyType::DOUBLE),
            array('123.4', PropertyType::DECIMAL, true, PropertyType::BOOLEAN),
            array('0', PropertyType::DECIMAL, false, PropertyType::BOOLEAN),
            array('123.4', PropertyType::DECIMAL, null, PropertyType::NAME),
            array('123.4', PropertyType::DECIMAL, null, PropertyType::PATH),
            array('123.4', PropertyType::DECIMAL, null, PropertyType::URI),
            array('123.4', PropertyType::DECIMAL, null, PropertyType::REFERENCE),
            array('123.4', PropertyType::DECIMAL, '123.4', PropertyType::DECIMAL),
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
            if ($expected instanceof \DateTime) {
                $result = PropertyType::convertType($value, $targettype, $srctype);
                $this->assertInstanceOf('DateTime', $result);
                $this->assertEquals($expected->getTimestamp(), $result->getTimestamp());
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

        $stream = PropertyType::convertType('test string', PropertyType::BINARY, PropertyType::BINARY);
        $this->assertInternalType('resource', $stream);
        $string = stream_get_contents($stream);
        $this->assertEquals('test string', $string);

        $date = new \DateTime('20.12.2012');
        $stream = PropertyType::convertType($date, PropertyType::BINARY);
        $this->assertInternalType('resource', $stream);
        $string = stream_get_contents($stream);
        $readDate = new \DateTime($string);
        $this->assertEquals($date->getTimestamp(), $readDate->getTimestamp());

        $stream = fopen('php://memory', '+rw');
        fwrite($stream, 'test string');
        rewind($stream);

        $result = PropertyType::convertType($stream, PropertyType::BINARY, PropertyType::BINARY);
        $string = stream_get_contents($result);
        $this->assertEquals('test string', $string);
        // if conversion to string works, should be fine for all others
    }

    public function testConvertTypeArray()
    {
        $result = PropertyType::convertType(array('2012-01-10', '2012-02-12'),
            PropertyType::DATE,
            PropertyType::STRING);
        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);

        $this->assertInstanceOf('DateTime', $result[0]);
        $this->assertInstanceOf('DateTime', $result[1]);

        $this->assertEquals('2012-01-10', $result[0]->format('Y-m-d'));
        $this->assertEquals('2012-02-12', $result[1]->format('Y-m-d'));

        $result = PropertyType::convertType(array(), PropertyType::STRING, PropertyType::NAME);
        $this->assertEquals(array(), $result);
    }

    public function testConvertTypeAutodetect()
    {
        $date = new \DateTime('2012-10-10');
        $result = PropertyType::convertType($date, PropertyType::STRING);
        $result = new \DateTime($result);
        $this->assertEquals($date->getTimestamp(), $result->getTimestamp());

        $result = PropertyType::convertType('2012-03-13T21:00:55.000+01:00', PropertyType::DATE);
        $this->assertInstanceOf('DateTime', $result);
        $this->assertEquals(1331668855, $result->getTimestamp());
    }

    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertTypeArrayInvalid()
    {
        PropertyType::convertType(array('a', 'b', 'c'), PropertyType::NAME, PropertyType::REFERENCE);
    }

    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertInvalidString()
    {
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

    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertNewNode()
    {
        $nodemock = $this->getMock('PHPCR\\Tests\\NodeMock');
        $nodemock
            ->expects($this->once())
            ->method('isNew')
            ->will($this->returnValue(true))
        ;
        PropertyType::convertType($nodemock, PropertyType::STRING);
    }
    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertNonrefNode()
    {
        $nodemock = $this->getMock('PHPCR\\Tests\\NodeMock');
        $nodemock
            ->expects($this->once())
            ->method('isNew')
            ->will($this->returnValue(false))
        ;
        $nodemock
            ->expects($this->once())
            ->method('isNodetype')
            ->with('mix:referenceable')
            ->will($this->returnValue(false))
        ;
        PropertyType::convertType($nodemock, PropertyType::STRING);
    }

    public function dataDateTargetType()
    {
        return array(
            array(PropertyType::STRING),
            array(PropertyType::LONG),
            array(PropertyType::DOUBLE),
        );
    }

    /**
     * Check if the util will survive a broken implementation
     * @expectedException PHPCR\RepositoryException
     * @dataProvider dataDateTargetType
     */
    public function testConvertInvalidDateValue($targettype)
    {
        PropertyType::convertType('', $targettype, PropertyType::DATE);
    }

    /**
     * @expectedException PHPCR\ValueFormatException
     */
    public function testConvertTypeInvalidTarget()
    {
        PropertyType::convertType('test', PropertyType::UNDEFINED);
    }
}

interface NodeMock extends \Iterator, \PHPCR\NodeInterface
{}