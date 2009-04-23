<?php
// $Id: PropertyType.class.php 578 2005-08-29 00:51:26Z tswicegood $
/**
 * This file contains {@link PropertyType} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170, and is
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *    Version 2.0
 * @package phpContentRepository
 */


/**
 * The property types supported by the phpCR standard.
 *
 * This interface defines following property types:
 * <ul>
 *    <li>{@link self::STRING}</li>
 *    <li>{@link self::BINARY}</li>
 *    <li>{@link self::LONG}</li>
 *    <li>{@link self::DOUBLE}</li>
 *    <li>{@link self::DATE}</li>
 *    <li>{@link self::BOOLEAN}</li>
 *    <li>{@link self::NAME}</li>
 *    <li>{@link self::PATH}</li>
 *    <li>{@link self::REFERENCE}</li>
 * </ul>
 *
 * <b>PHP Note</b>: Some of these values do not translate from Java into
 * PHP.  Example: Java long = PHP int; Java double = PHP float.  In order to
 * emulate the JCR standard, however, I have left them.
 *
 * @package phpContentRepository
 */
abstract class phpCR_PropertyType
{
	/**
	 * The supported property types.
	 */
	const STRING    = 1;
	const BINARY    = 2;
	const INT       = 3;
	const LONG      = 3; // self::INT
	const FLOAT     = 4;
	const DOUBLE    = 4; // self::FLOAT
	const DATE      = 5;
	const BOOLEAN   = 6;
	const NAME      = 7;
	const PATH      = 8;
	const REFERENCE = 9;

	/**
	 * Undefined type.
	 */
	const UNDEFINED = 0;

	/**
	 * The names of the supported property types,
	 * as used in serialization.
	 */
	const TYPENAME_STRING	    = "String";
	const TYPENAME_BINARY	    = "Binary";
	const TYPENAME_INT       = "Integer";
	const TYPENAME_LONG      = "Long";
	const TYPENAME_FLOAT     = "Float";
	const TYPENAME_DOUBLE	    = "Double";
	const TYPENAME_DATE      = "Date";
	const TYPENAME_BOOLEAN   = "Boolean";
	const TYPENAME_NAME      = "Name";
	const TYPENAME_PATH      = "Path";
	const TYPENAME_REFERENCE = "Reference";


	/**
	 * String representation of <i>undefined</i> type.
	 */
	const TYPENAME_UNDEFINED = "undefined";


	/**
	 * Returns the name of the specified type,
	 * as used in serialization.
	 * @param type the property type
	 * @return the name of the specified type
	 * @throws IllegalArgumentException if type
	 * is not a valid property type.
	 */
	static public function nameFromValue($type) {
		assert('$type == intval($type)');

		switch ($type) {
		case self::STRING :
			return self::TYPENAME_STRING;
			break;

		case self::BINARY :
			return self::TYPENAME_BINARY;
			break;

		case self::BOOLEAN :
			return self::TYPENAME_BOOLEAN;
			break;

		case self::INT  :
		case self::LONG :
			return self::TYPENAME_INT;
			break;

		case self::FLOAT  :
		case self::DOUBLE :
			return self::TYPENAME_FLOAT;
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

		case self::UNDEFINED :
			return self::TYPENAME_UNDEFINED;
			break;

		default:
			throw new IllegalArgumentException("unknown type: " + $type);
			break;
		}
	}


	/**
	 * Returns the numeric constant value of the type with the specified name.
	 *
	 * @param string
	 *   The name of the property type
	 * @return int
	 *   The numeric constant value
	 *
	 * @throws {@link IllegalArgumentException}
	 *   If $name is not a valid property type name.
	 */
	static public function valueFromName($name)
	{
		assert('is_string($name)');

		$name = ucwords(strtolower($name));
		switch ($name) {
		case self::TYPENAME_STRING :
			return self::STRING;
			break;

		case self::TYPENAME_BINARY :
			return self::BINARY;
			break;

		case self::TYPENAME_INT  :
		case self::TYPENAME_LONG :
			return self::INT;
			break;

		case self::TYPENAME_FLOAT  :
		case self::TYPENAME_DOUBLE :
			return self::FLOAT;
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

		case self::TYPENAME_UNDEFINED :
			return self::UNDEFINED;
			break;

		default :
			throw new IllegalArgumentException("unknown type : " . $name);
			break;
		}
	}
}

?>