<?php

namespace PHPCR;

/**
 * SimpleCredentials implements the Credentials interface and represents simple
 * user ID/password credentials.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @author Karsten Dambekalns <karsten@typo3.org>
 *
 * @api
 */
final class SimpleCredentials implements CredentialsInterface
{

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
     * @param string $userID   the user ID
     * @param string $password the user's password
     *
     * @api
     */
    public function __construct($userID, $password)
    {
        $this->userID = $userID;
        $this->password = $password;
    }

    /**
     * Returns the user password.
     *
     * @return string the password
     *
     * @api
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the user ID.
     *
     * @return string the user ID.
     *
     * @api
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Stores an attribute in this credentials instance.
     *
     * <b>Note:</b>
     * If no value is passed, the attribute will be removed.
     *
     * @param string $name  the name of the attribute
     * @param mixed  $value the value to be stored
     *
     * @api
     */
    public function setAttribute($name, $value)
    {
        if (null === $name) {
            throw new \InvalidArgumentException('$name cannot be null', 1212580046);
        }

        if (null === $value) {
            // null value is the same as removeAttribute()
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
     *
     * @return mixed the value of the attribute, or null if the attribute does
     *      not exist
     *
     * @api
     */
    public function getAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Removes an attribute from this credentials instance.
     *
     * @param string $name the name of the attribute to remove
     *
     * @api
     */
    public function removeAttribute($name)
    {
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
     * @api
     */
    public function getAttributeNames()
    {
        return array_keys($this->attributes);
    }
}
