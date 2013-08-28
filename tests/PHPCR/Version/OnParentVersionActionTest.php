<?php
namespace PHPCR\Tests\Version;

use PHPCR\Version\OnParentVersionAction;

/**
 * a test for the PHPCR\PropertyType class
 */
class OnParentVersionActionTest extends \PHPUnit_Framework_TestCase
{
    /** key = numeric type constant names as defined by api
     *  value = string for valueFromType
     */
    protected static $types = array(
        'COPY'       => 1,
        'VERSION'    => 2,
        'INITIALIZE' => 3,
        'COMPUTE'    => 4,
        'IGNORE'     => 5,
        'ABORT'      => 6,
    );

    public static function data()
    {
        $data = array();
        foreach (self::$types as $key => $value) {
            $data[] = array($key,$value);
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNameFromValueInvalid()
    {
        OnParentVersionAction::nameFromValue(-1);
    }

    /**
     * @dataProvider data
     */
    public function testValueFromName($name, $value)
    {
        $this->assertEquals($value, OnParentVersionAction::valueFromName($name));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValueFromNameInvalid()
    {
        OnParentVersionAction::valueFromName('something');
    }
}
