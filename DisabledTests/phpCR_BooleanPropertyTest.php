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

/**
 * Tests a boolean property.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_BooleanPropertyTest extends phpCR_Test {

	public function setUp() {
		parent::setUp();
		$this->testProp->setValue(true);
	}

	/**
	 * Returns {@link PropertyType#BOOLEAN}.
	 *
	 * @return {@link PropertyType#BOOLEAN}.
	 */
	protected function getPropertyType() {
		return phpCR_PropertyType::BOOLEAN;
	}

	/**
	 * Tests that Property->getBoolean() delivers the same as Value->getBoolean()
	 * and that in case of a multivalue property Property->getBoolean() throws a
	 * ValueFormatException.
	 */
	public function testValue() {
		$bool = $this->testProp->getValue()->getBoolean();
		$otherBool = $this->testProp->getBoolean();
		$this->assertTrue($bool == $otherBool, "Value->getBoolean() and Property->getBoolean() return different values.");

	}

	/**
	 * Tests failure of conversion from Boolean type to Date type.
	 */
	public function testGetDate() {
		try {
			$val = $this->testProp->getValue();
			$val->getDate();
			$this->fail("Conversion from a Boolean value to a Date value should throw a ValueFormatException");
		} catch (phpCR_ValueFormatException $e) {
			//ok
		}
	}

	/**
	 * Tests failure from Boolean type to Double type.
	 */
	public function testGetDouble() {
		try {
			$val = $this->testProp->getValue();
			$val->getDouble();
			$this->fail("Conversion from a Boolean value to a Double value should throw a ValueFormatException");
		} catch (phpCR_ValueFormatException $e) {
			//ok
		}
	}

	/**
	 * Tests failure of conversion from Boolean type to Long type.
	 */
	public function testGetLong() {
		try {
			$val = $this->testProp->getValue();
			$val->getLong();
			$this->fail("Conversion from a Boolean value to a Long value should throw a ValueFormatException");
		} catch (phpCR_ValueFormatException $e) {
			//ok
		}
	}

	/**
	 * Tests conversion from Boolean type to Binary type.
	 */
	public function testGetStream() {
		/*
		 $val = $this->testProp->getValue();
		 $in = new BufferedInputStream($val->getStream());
		 $otherVal = $this->testProp->getValue();
		 $ins = null;
		 $utf8bytes = $otherVal->getString()->getBytes(UTF8);
		 // if yet utf-8 encoded these bytes should be equal
		 // to the ones received from the stream
		 $i = 0;
		 $b = array();
		 while ($in->read($b) != -1) {
		 $this->assertTrue($b[0] == $utf8bytes[$i], "Boolean as a Stream is not utf-8 encoded");
		 $i++;
		 }
		 try {
		 $val->getBoolean();
		 $this->fail("Non stream method call after stream method call should throw an IllegalStateException");
		 } catch (phpCR_IllegalStateException $e) {
		 //ok
		 }
		 try {
		 $ins = $otherVal->getStream();
		 $this->fail("Stream method call after a non stream method call should throw an IllegalStateException");
		 } catch (phpCR_IllegalStateException $e) {
		 // ok
		 }

		 if ($in != null) {
		 $in->close();
		 }
		 if ($ins != null) {
		 $ins->close();
		 }
		 */
		throw new PHPUnit_Framework_IncompleteTestError;
	}

	/**
	 * Tests the conversion from a Boolean to a String Value.
	 */
	public function testGetString() {
		$val = $this->testProp->getValue();
		$str = $val->getString();
		$otherStr = $val->getBoolean();
		$this->assertEquals($str, $otherStr, "Conversion from a Boolean value to a String value failed.");
	}

	/**
	 * Tests if Value->getType() returns the same as Property->getType() and also
	 * tests that prop->getDefinition()->getRequiredType() returns the same type
	 * in case it is not of Undefined type.
	 */
	public function testGetType() {
		$this->assertEquals(phpCR_PropertyType::BOOLEAN, $this->testProp->getType(), "Value->getType() returns wrong type.");
	}

	/**
	 * Tests the Property->getLength() method. The length returned is either -1
	 * or it is the length of the string received by conversion.
	 */
	public function testGetLength() {
		$length = $this->testProp->getLength();
		if ($length > -1) {
			$this->assertEquals($length, F3_PHP6_Functions::strlen($this->testProp->getString()), "Property->getLength() returns wrong number of bytes.");
		}
	}
}
?>