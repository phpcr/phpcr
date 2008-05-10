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

/**
 * The property type definitions
 *
 * @package		phpCR
 * @version 	$Id$
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_phpCR_PropertyType {
	/**
	 * The supported property types.
	 */
	const UNDEFINED = 0;
	const STRING    = 1;
	const BINARY    = 2;
	const LONG      = 3;
	const DOUBLE    = 4;
	const DATE      = 5;
	const BOOLEAN   = 6;
	const NAME      = 7;
	const PATH      = 8;
	const REFERENCE = 9;
	const WEAKREFERENCE = 10;
	const URI = 11;

	/**
	 * The names of the supported property types,
	 * as used in serialization.
	 */
	const TYPENAME_UNDEFINED = 'undefined';
	const TYPENAME_STRING = 'String';
	const TYPENAME_BINARY = 'Binary';
	const TYPENAME_LONG = 'Long';
	const TYPENAME_DOUBLE = 'Double';
	const TYPENAME_DATE = 'Date';
	const TYPENAME_BOOLEAN = 'Boolean';
	const TYPENAME_NAME = 'Name';
	const TYPENAME_PATH = 'Path';
	const TYPENAME_REFERENCE = 'Reference';
	const TYPENAME_WEAKREFERENCE = 'WeakReference';
	const TYPENAME_URI= 'URI';

	/**
	 * Returns the name of the specified type, as used in serialization.
	 *
	 * @param  int  $type: type the property type
	 * @return string  name of the specified type
	 * @author Travis Swicegood <development@domain51.com>
	 * @author Sebastian Kurfuerst <sebastian@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	static public function nameFromValue($type) {		
		switch (intval($type)) {
			case self::UNDEFINED :
				return self::TYPENAME_UNDEFINED;
				break;
			case self::STRING :
				return self::TYPENAME_STRING;
				break;
			case self::BINARY :
				return self::TYPENAME_BINARY;
				break;
			case self::BOOLEAN :
				return self::TYPENAME_BOOLEAN;
				break;
			case self::LONG :
				return self::TYPENAME_LONG;
				break;
			case self::DOUBLE :
				return self::TYPENAME_DOUBLE;
				break;
			case self::DATE :
				return self::TYPENAME_DATE;
				break;
			case self::NAME :
				return self::TYPENAME_NAME;
				break;
			case self::PATH :
				return self::TYPENAME_PATH;
				break;
			case self::REFERENCE :
				return self::TYPENAME_REFERENCE;
				break;
			case self::WEAKREFERENCE :
				return self::TYPENAME_WEAKREFERENCE;
				break;
			case self::URI :
				return self::TYPENAME_URI;
				break;
		}
	}
	
	
	/**
	 * Returns the numeric constant value of the type with the specified name.
	 *
	 * @param  string $name: The name of the property type
	 * @return int The numeric constant value
	 * @author Travis Swicegood <development@domain51.com>
	 * @author Sebastian Kurfuerst <sebastian@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	static public function valueFromName($name) {
		switch ($name) {
			case self::TYPENAME_UNDEFINED :
				return self::UNDEFINED;
				break;
			case self::TYPENAME_STRING :
				return self::STRING;
				break;
			case self::TYPENAME_BINARY :
				return self::BINARY;
				break;
			case self::TYPENAME_LONG :
				return self::LONG;
				break;
			case self::TYPENAME_DOUBLE :
				return self::DOUBLE;
				break;
			case self::TYPENAME_DATE :
				return self::DATE;
				break;
			case self::TYPENAME_BOOLEAN :
				return self::BOOLEAN;
				break;
			case self::TYPENAME_NAME :
				return self::NAME;
				break;
			case self::TYPENAME_PATH :
				return self::PATH;
				break;
			case self::TYPENAME_REFERENCE :
				return self::REFERENCE;
				break;
			case self::TYPENAME_WEAKREFERENCE :
				return self::WEAKREFERENCE;
				break;
			case self::TYPENAME_URI :
				return self::URI;
				break;
		}
	}
}

?>