<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
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
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface ValueFactoryInterface {

	/**
	 * Returns a \F3\PHPCR\Binary object with a value consisting of the content of
	 * the specified resource handle.
	 * The passed resource handle is closed before this method returns either normally
	 * or because of an exception.
	 *
	 * @param resource $handle
	 * @return \F3\PHPCR\BinaryInterface
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
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
	 * * if the given $value is a Node object, it's Identifier is fetched for the
	 *   Value object and the type of that object will be WEAKREFERENCE if $weak
	 *   is set to TRUE
	 * * if the given $Value is a \DateTime object, the Value type will be DATE.
	 *
	 * @param mixed $value The value to use when creating the Value object
	 * @param integer $type Type request for the Value object
	 * @param boolean $weak When a Node is given as $value this can be given as TRUE to create a WEAKREFERENCE
	 * @return \F3\PHPCR\ValueInterface
	 * @throws \F3\PHPCR\ValueFormatException is thrown if the specified value cannot be converted to the specified type.
	 * @throws \F3\PHPCR\RepositoryException if the specified Node is not referenceable, the current Session is no longer active, or another error occurs.
	 */
	public function createValue($value, $type = NULL, $weak = FALSE);

}

?>