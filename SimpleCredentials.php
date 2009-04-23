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
 * Interface for the JCR "SimpleCredentials" class, an example implementation of
 * the "Credentials" marker interface.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface phpCR_SimpleCredentials extends phpCR_Credentials {
	/**
	 * Create a new {@link SimpleCredentials} object, given a user ID
	 * and password.
	 *
	 * @param string The user ID
	 * @param string The user's password
	 * @return void
	 */
	public function __construct($userID, $password);


	/**
	 * Returns the user password.
	 *
	 * Note that this method returns a reference to the password.
	 * It is the caller's responsibility to zero out the password information
	 * after it is no longer needed.
	 *
	 * @return string
	 */
	public function getPassword();


	/**
	 * Returns the user ID.
	 *
	 * @return string
	 */
	public function getUserId();


	/**
	 * Stores an attribute in this credentials instance.
	 *
	 * If $value is set to NULL, it is considered the
	 * same as calling $simpleCredentials->removeAttribute($name).
	 *
	 * @param string	Specifies the name of the attribute
	 * @param mixed		The value to be stored
	 */
	public function setAttribute($name, $value);


	/**
	 * Returns the value of the named attribute as an {@link Object}, or
	 * NULL if no attribute of the given $name exists.
	 *
	 * @param string Specifies the name of the attribute
	 * @return mixed The value of the attribute or NULL if the attribute does not exist.
	 */
	public function getAttribute($name);


	/**
	 * Removes an attribute from this credentials instance.
	 *
	 * @param string Specifies the name of the attribute to remove
	 */
	public function removeAttribute($name);


	/**
	 * Returns the names of the attributes available to this credentials
	 * instance.
	 *
	 * This method returns an empty array if the credentials instance has no
	 * attributes available to it.
	 *
	 * @return array
	 */
	public function getAttributeNames();
}

?>