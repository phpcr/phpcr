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
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function getAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function removeAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeNames()
    {
        return array_keys($this->attributes);
    }
}
