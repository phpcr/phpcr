<?php
namespace PHPCR\Tests\Version;

use InvalidArgumentException;
use PHPCR\Version\OnParentVersionAction;
use PHPUnit_Framework_TestCase;

/**
 * a test for the PHPCR\PropertyType class
 */
class OnParentVersionActionTest extends PHPUnit_Framework_TestCase
{
    /**
     * key = numeric type constant names as defined by api
     * value = string for valueFromType
     */
    protected static $types = [
        'COPY'       => 1,
        'VERSION'    => 2,
        'INITIALIZE' => 3,
        'COMPUTE'    => 4,
        'IGNORE'     => 5,
        'ABORT'      => 6,
    ];

    public static function data()
    {
        $data = [];

        foreach (self::$types as $key => $value) {
            $data[] = [$key,$value];
        }

        return $data;
    }

    /**
     * @dataProvider data
     */
    public function testNameFromValue($name, $value)
    {
        $this->assertEquals($name, OnParentVersionAction::nameFromValue($value));
    }

    public function testNameFromValueInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        OnParentVersionAction::nameFromValue(-1);
    }

    /**
     * @dataProvider data
     */
    public function testValueFromName($name, $value)
    {
        $this->assertEquals($value, OnParentVersionAction::valueFromName($name));
    }

    public function testValueFromNameInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        OnParentVersionAction::valueFromName('something');
    }
}
