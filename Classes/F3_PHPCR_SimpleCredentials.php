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
 * SimpleCredentials implements the Credentials interface and represents simple
 * user ID/password credentials.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
final class F3_PHPCR_SimpleCredentials implements F3_PHPCR_CredentialsInterface {

	private $userID;
	private $password;
	private $attributes = array();

	/**
	 * The constructor creates a new SimpleCredentials object, given a user ID
	 * and password.
	 *
	 * @param string $userID the user ID
	 * @param string $password the user's password
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __construct($userID, $password) {
		$this->userID = $userID;
		$this->password = $password;
	}

	/**
	 * Returns the user password.
	 *
	 * @return string the password
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Returns the user ID.
	 *
	 * @return string the user ID.
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getUserID() {
		return $this->userID;
	}

	/**
	 * Stores an attribute in this credentials instance.
	 *
	 * @param string $name the name of the attribute
	 * @param mixed $value the value to be stored
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setAttribute($name, $value) {
		if ($name === NULL) {
			throw new InvalidArgumentException('$name cannot be null', 1212580046);
		}

			// null value is the same as removeAttribute()
		if ($value === NULL) {
			$this->removeAttribute($name);
		} else {
			$this->attributes[$name] = $value;
		}
	}

	/**
	 * Returns the value of the named attribute, or NULL if no attribute of the
	 * given name exists.
	 *
	 * @param string $name the name of the attribute
	 * @return mixed the value of the attribute, or NULL if the attribute does not exist
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getAttribute($name) {
		if(isset($this->attributes[$name])) {
			return $this->attributes[$name];
		} else {
			return NULL;
		}
	}

	/**
	 * Removes an attribute from this credentials instance.
	 *
	 * @param string $name the name of the attribute to remove
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function removeAttribute($name) {
		if(isset($this->attributes[$name])) {
			unset($this->attributes[$name]);
		}
	}

	/**
	 * Returns the names of the attributes available to this
	 * credentials instance. This method returns an empty array
	 * if the credentials instance has no attributes available to it.
	 *
	 * @return array a string array containing the names of the stored attributes
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getAttributeNames() {
		return array_keys($this->attributes);
	}

}

?>