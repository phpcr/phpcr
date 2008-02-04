<?php
declare(encoding = 'utf-8');

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
 * A ValueFactory interface
 *
 * The ValueFactory object provides methods for the creation Value objects that can
 * then be used to set properties.
 *
 * @package		phpCR
 * @version 	$Id: T3_phpCR_ValueInterface.php 328 2007-09-04 13:44:34Z robert $
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface T3_phpCR_ValueFactoryInterface {

	/**
	 * Returns a Value object with the specified value. If $type is given,
	 * conversion is attempted before creating the Value object.
	 * 
	 * If no type is given, the value is stored as is, i.e. it's type is
	 * preserved. Exceptions are:
	 * * if the given $value is a Node object, it's UUID is fetched for the
	 *   Value object and the type of that object will be REFERENCE
	 * * if the given $value is a file pointer, the file's content will be
	 *   fetched for the Value object. The file pointer will be closed before
	 *   returning the Value object. The Value object will be of type BINARY.
	 * * if the given $Value is a DateTime object, the Value type will be DATE.
	 * 
	 * @param mixed $value
	 * @param integer $type
	 * @return T3_phpCR_ValueInterface
	 * @throws T3_phpCR_ValueFormatException is thrown if the specified value cannot be converted to the specified type.
	 * @throws T3_phpCR_RepositoryException if the specified Node is not referenceable, the current Session is no longer active, or another error occurs.
	 */
	public function createValue($value, $type = NULL);

}

?>