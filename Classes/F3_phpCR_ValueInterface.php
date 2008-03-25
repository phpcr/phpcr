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
 * A Value interface
 *
 * A generic holder for the value of a property. A Value object can be used
 * without knowing the actual property type (STRING, DOUBLE, BINARY etc.).
 * 
 * Any implementation of this interface must adhere to the following behavior:
 * * A Value object can be read using type-specific get methods. These methods
 *   are divided into two groups:
 *   * The non-stream get methods getString(), getDate(), getLong(), getDouble()
 *     and getBoolean().
 *   * getStream().
 * * Once a Value object has been read once using getStream(), all subsequent
 *   calls to getStream() will return the same Stream object. This may mean,
 *   for example, that the stream returned is fully or partially consumed.
 *   In order to get a fresh stream the Value object must be reacquired via
 *   Property.getValue() or Property.getValues().
 * * Once a Value object has been read once using getStream(), any subsequent
 *   call to any of the non-stream get methods will throw an IllegalStateException.
 *   In order to successfully invoke a non-stream get method, the Value must be
 *   reacquired via Property.getValue() or Property.getValues().
 * * Once a Value object has been read once using a non-stream get method, any
 *   subsequent call to getStream() will throw an IllegalStateException. In
 *   order to successfully invoke getStream(), the Value must be reacquired via
 *   Property.getValue() or Property.getValues(). 
 * 
 * Two Value instances, v1 and v2, are considered equal if and only if:
 * * v1.getType() == v2.getType(), and,
 * * v1.getString().equals(v2.getString())
 * 
 * Actually comparing two Value instances by converting them to string form may not
 * be practical in some cases (for example, if the values are very large binaries).
 * Consequently, the above is intended as a normative definition of Value equality
 * but not as a procedural test of equality. It is assumed that implementations
 * will have efficient means of determining equality that conform with the above
 * definition. An implementation is only required to support equality comparisons on
 * Value instances that were acquired from the same Session and whose contents have
 * not been read. The equality comparison must not change the state of the Value
 * instances even though the getString() method in the above definition implies a
 * state change.
 * 
 * @package		phpCR
 * @version 	$Id$
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_phpCR_ValueInterface {

	/**
	 * Returns a string representation of this value.
	 * 
	 * @return string A String representation of the value of this property.
	 * @throws F3_phpCR_ValueFormatException if conversion to a String is not possible. 
	 * @throws BadMethodCallException if getStream has previously been called on this Value instance. 
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getString();

	/**
	 * Returns an InputStream representation of this value. Uses the standard
	 * conversion to binary (see JCR specification).
	 * It is the responsibility of the caller to close the returned InputStream.
	 * 
	 * @return InputStream An InputStream representation of this value.
	 * @throws BadMethodCallException if a non-stream get method has previously been called on this Value instance.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getStream();

	/**
	 * Returns a long representation of this value.
	 * 
	 * @return string A long representation of the value of this property.
	 * @throws F3_phpCR_ValueFormatException if conversion to a long is not possible. 
	 * @throws BadMethodCallException if getStream has previously been called on this Value instance. 
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getLong();

	/**
	 * Returns a double representation of this value.
	 * 
	 * @return string A double representation of the value of this property.
	 * @throws F3_phpCR_ValueFormatException if conversion to a double is not possible. 
	 * @throws BadMethodCallException if getStream has previously been called on this Value instance. 
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getDouble();

	/**
	 * Returns a DateTime representation of this value.
	 * 
	 * The object returned is a copy of the stored value, so changes to it are
	 * not reflected in internal storage.
	 * 
	 * @return DateTime A DateTime representation of the value of this property.
	 * @throws F3_phpCR_ValueFormatException if conversion to a DateTime is not possible. 
	 * @throws BadMethodCallException if getStream has previously been called on this Value instance. 
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getDate();

	/**
	 * Returns a boolean representation of this value.
	 * 
	 * @return string A boolean representation of the value of this property.
	 * @throws F3_phpCR_ValueFormatException if conversion to a boolean is not possible. 
	 * @throws BadMethodCallException if getStream has previously been called on this Value instance. 
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getBoolean();

	/**
	 * Returns the type of this Value. One of:
	 * * PropertyType.STRING
	 * * PropertyType.DATE
	 * * PropertyType.BINARY
	 * * PropertyType.DOUBLE
	 * * PropertyType.LONG
	 * * PropertyType.BOOLEAN
	 * * PropertyType.NAME
	 * * PropertyType.PATH
	 * * PropertyType.REFERENCE
	 * * PropertyType.WEAKREFERENCE
	 * * PropertyType.URI
	 * 
	 * The type returned is that which was set at property creation.
	 * @return integer The type of the value
	 */
	public function getType();
}

?>