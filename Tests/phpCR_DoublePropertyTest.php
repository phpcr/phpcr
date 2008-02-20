<?php
declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

require_once('phpCR_Test.php');
require_once('phpCR_PropertyUtil.php');

/**
 * Tests a double property.
 *
 * @package		phpCRJackrabbit
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_DoublePropertyTest extends phpCR_Test {

	public function setUp() {
		parent::setUp();
		$this->testProp->setValue(178.4324);
	}

    /**
     * Returns {@link PropertyType#DOUBLE}.
     *
     * @return {@link PropertyType#DOUBLE}.
     */
    protected function getPropertyType() {
        return phpCR_PropertyType::DOUBLE;
    }

    /**
     * tests that Property.getDouble() delivers the same as Value.getDouble()
     * and if in case of a multivalue property a ValueFormatException is
     * thrown.
     */
    public function testValue() {
        $d = $this->testProp->getValue()->getDouble();
        $dd = $this->testProp->getDouble();
        $this->assertTrue($d == $dd, 'Value->getDouble() and Property->getDouble() return different values.');
        throw new PHPUnit_Framework_IncompleteTestError('missing check: in case of a multivalue property a ValueFormatException is thrown');
    }

    /**
     * tests failure of conversion from Double type to Boolean type
     */
    public function testGetBoolean() {
        try {
            $val = phpCR_PropertyUtil::getValue($this->testProp);
            $val->getBoolean();
            $this->fail('Conversion from a Double value to a Boolean value should throw a ValueFormatException.');
        } catch (phpCR_ValueFormatException $e) {
            //ok
        }
    }

    /**
     * tests conversion from Double type to Date type
     */
    public function testGetDate() {
        $val = phpCR_PropertyUtil::getValue($this->testProp);
        $this->assertEquals((int)$val->getDouble(), $val->getDate(), 'Conversion from Double value to Date value is not correct.');
    }

    /**
     * tests the conversion from a Double to a Long Value
     */
    public function testGetLong() {
        $val = phpCR_PropertyUtil::getValue($this->testProp);
        $l = $val->getLong();
        $ll = (int)$val->getDouble();
        $this->assertTrue($l == $ll, 'Conversion from Double value to Long value is not correct.');
    }

    /**
     * tests conversion from Double type to Binary type
     */
    public function testGetStream() {
    	/*
        $val = phpCR_PropertyUtil::getValue($this->testProp);
        $in = new BufferedInputStream($val->getStream());
        $otherVal = phpCR_PropertyUtil::getValue($this->testProp);
        $ins = null;
        $utf8bytes = (array)$otherVal->getString()->getBytes();
        // if yet utf-8 encoded these bytes should be equal
        // to the ones received from the stream
        $i = 0;
        $b = $in->read();
        while ($b != -1) {
            $this->assertTrue($b == $utf8bytes[$i], 'Double as a Stream is not utf-8 encoded.');
            $b = $in->read();
            $i++;
        }

        try {
            $val->getDouble();
            $this->fail('Non stream method call after stream method call should throw an IllegalStateException.');
        } catch (phpCR_IllegalStateException $e) {
            //ok
        }

        try {
            $ins = $otherVal->getStream();
            fail('Stream method call after a non stream method call should throw an IllegalStateException.');
        } catch (phpCR_IllegalStateException $e) {
            // ok
        }

        if (in != null) {
        	$in->close();
        }
        if ($ins != null) {
            $ins->close();
        }
        */
		throw new PHPUnit_Framework_IncompleteTestError;
    }

    /**
     * tests the conversion from a Double to a String Value
     */
    public function testGetString() {
        $val = phpCR_PropertyUtil::getValue($this->testProp);
        $str = $val->getString();
        $otherStr = (double)$val->getDouble();
        $this->assertEquals($str, $otherStr, 'Conversion from Double value to String value is not correct.');
    }

    /**
     * Tests if Value.getType() returns the same as Property.getType() and also
     * tests that prop.getDefinition().getRequiredType() returns the same type
     * in case it is not of Undefined type.
     */
    public function testGetType() {
        $this->assertTrue(phpCR_PropertyUtil::checkGetType($this->testProp, phpCR_PropertyType::DOUBLE), 'Value->getType() returns wrong type.');
    }

    /**
     * Tests the Property.getLength() method. The length returned is either -1
     * or it is the length of the string received by conversion.
     */
    public function testGetLength() {
        $length = $this->testProp->getLength();
        if ($length > -1) {
	        $this->assertEquals($length, T3_PHP6_Functions::strlen($this->testProp->getString()), 'Property.getLength() returns wrong number of bytes.');
        }
    }
}

?>