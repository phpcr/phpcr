<?php
/**
 * Final class implementing the CredentialsInterface.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 */

declare(ENCODING = 'utf-8');
namespace PHPCR;

/**
 * SimpleCredentials implements the Credentials interface and represents simple
 * user ID/password credentials.
 *
 * @package phpcr
 * @subpackage prototypes
 * @scope prototype
 * @api
 */
final class SimpleCredentials implements \PHPCR\CredentialsInterface {

    /**
     * Unique identifier of a user.
     * @var string
     */
    private $userID;

    /**
     * Unique string used to authenticate the user.
     * @var string
     */
    private $password;

    /**
     * Container to store properties.
     * @var array
     */
    private $attributes = array();

    /**
     * The constructor creates a new SimpleCredentials object, given a user ID
     * and password.
     *
     * @param string $userID the user ID
     * @param string $password the user's password
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
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
     * @api
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Returns the user ID.
     *
     * @return string the user ID.
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * Stores an attribute in this credentials instance.
     *
     * <b>Note:</b>
     * If no value is passed the attribute will be removed.
     *
     * @param string $name the name of the attribute
     * @param mixed $value the value to be stored
     * @return void
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
     */
    public function setAttribute($name, $value) {
        if ($name === null) {
            throw new \InvalidArgumentException('$name cannot be null', 1212580046);
        }

            // null value is the same as removeAttribute()
        if ($value === null) {
            $this->removeAttribute($name);
        } else {
            $this->attributes[$name] = $value;
        }
    }

    /**
     * Returns the value of the named attribute, or null if no attribute of the
     * given name exists.
     *
     * @param string $name the name of the attribute
     * @return mixed the value of the attribute, or null if the attribute does not exist
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
     */
    public function getAttribute($name) {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        return null;
    }

    /**
     * Removes an attribute from this credentials instance.
     *
     * @param string $name the name of the attribute to remove
     * @return void
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
     */
    public function removeAttribute($name) {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }
    }

    /**
     * Returns the names of the attributes available to this
     * credentials instance. This method returns an empty array
     * if the credentials instance has no attributes available to it.
     *
     * @return array a string array containing the names of the stored attributes
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
     */
    public function getAttributeNames() {
        return array_keys($this->attributes);
    }

}
