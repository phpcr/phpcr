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
 * @package PHPCR
 * @version $Id$
 */

/**
 * The ValueFactory object provides methods for the creation Value objects that can
 * then be used to set properties.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_ValueFactoryInterface {

	/**
	 * Returns a F3_PHPCR_Binary object with a value consisting of the content of
	 * the specified resource handle.
	 * The passed resource handle is closed before this method returns either normally
	 * or because of an exception.
	 *
	 * @param resource $handle
	 * @return F3_PHPCR_BinaryInterface
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function createBinary($handle);

	/**
	 * Returns a Value object with the specified value. If $type is given,
	 * conversion is attempted before creating the Value object.
	 *
	 * If no type is given, the value is stored as is, i.e. it's type is
	 * preserved. Exceptions are:
	 * * if the given $value is a Node object, it's Identifier is fetched for the
	 *   Value object and the type of that object will be REFERENCE
	 * * if the given $Value is a DateTime object, the Value type will be DATE.
	 *
	 * @param mixed $value
	 * @param integer $type
	 * @return F3_PHPCR_ValueInterface
	 * @throws F3_PHPCR_ValueFormatException is thrown if the specified value cannot be converted to the specified type.
	 * @throws F3_PHPCR_RepositoryException if the specified Node is not referenceable, the current Session is no longer active, or another error occurs.
	 */
	public function createValue($value, $type = NULL);
}

?>