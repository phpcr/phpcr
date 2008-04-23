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
 * Tests a name property.
 *
 * @package		phpCRJackrabbit
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_NamePropertyTest extends phpCR_Test {

	public function setUp() {
		parent::setUp();
		$this->testProp = $this->testRootNode->setProperty('testPropName', 'test:propName', phpCR_PropertyType::NAME);
	}

    /**
     * Returns {@link PropertyType#NAME}.
     *
     * @return {@link PropertyType#NAME}.
     */
    protected function getPropertyType() {
        return phpCR_PropertyType::NAME;
    }

    /**
     * Tests conversion from Name type to String type.
     *
     * @throws RepositoryException
     */
    public function testGetString() {
        $val = phpCR_PropertyUtil::getValue($this->testProp);
        $this->assertTrue(phpCR_PropertyUtil::checkNameFormat($val->getString(), $this->session), 'Not a valid Name property: ' + $this->testProp->getName());
    }

    /**
     * Tests failure of conversion from Name type to Boolean type.
     *
     * @throws RepositoryException
     */
    public function testGetBoolean() {
        try {
        	$val = phpCR_PropertyUtil::getValue($this->testProp);
            $val->getBoolean();
            $this->fail('Conversion from a Name value to a Boolean value should throw a ValueFormatException.');
        } catch (phpCR_ValueFormatException $e) {
            //ok
        }
    }

    /**
     * Tests failure of conversion from Name type to Date type.
     *
     * @throws RepositoryException
     */
    public function testGetDate() {
        try {
        	$val = phpCR_PropertyUtil::getValue($this->testProp);
            $val->getDate();
            fail('Conversion from a Name value to a Date value should throw a ValueFormatException.');
        } catch (phpCR_ValueFormatException $e) {
            //ok
        }
    }

    /**
     * Tests failure from Name type to Double type.
     *
     * @throws RepositoryException
     */
    public function testGetDouble() {
        try {
        	$val = phpCR_PropertyUtil::getValue($this->testProp);
            $val->getDouble();
            $this->fail('Conversion from a Name value to a Double value should throw a ValueFormatException.');
        } catch (phpCR_ValueFormatException $e) {
            //ok
        }
    }

    /**
     * Tests failure of conversion from Name type to Long type.
     *
     * @throws RepositoryException
     */
    public function testGetLong() {
        try {
        	$val = phpCR_PropertyUtil::getValue($this->testProp);
            $val->getLong();
            $this->fail('Conversion from a Name value to a Long value should throw a ValueFormatException.');
        } catch (phpCR_ValueFormatException $e) {
            //ok
        }
    }

    /**
     * Tests if Value.getType() returns the same as Property.getType() and also
     * tests that prop.getDefinition().getRequiredType() returns the same type
     * in case it is not of Undefined type.
     *
     * @throws RepositoryException
     */
    public function testGetType() {
        $this->assertTrue(phpCR_PropertyUtil::checkGetType($this->testProp, phpCR_PropertyType::NAME), 'Value->getType() returns wrong type.');
    }
}

?>