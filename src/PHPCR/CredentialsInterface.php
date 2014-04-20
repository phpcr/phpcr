<?php

namespace PHPCR;

/**
 * Interface for all credentials that may be passed to the Repository::login()
 * method.
 *
 * Serves as a marker interface that all repositories must implement when
 * providing a credentials class. See {@link SimpleCredentials} and
 * {@link GuestCredentials} for examples of such a class.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface CredentialsInterface
{

    /**
     * Returns the user password.
     *
     * @return string the password
     *
     * @api
     */
    public function getPassword();

    /**
     * Returns the user ID.
     *
     * @return string the user ID.
     *
     * @api
     */
    public function getUserID();

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
    public function setAttribute($name, $value);

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
    public function getAttribute($name);

    /**
     * Removes an attribute from this credentials instance.
     *
     * @param string $name the name of the attribute to remove
     *
     * @api
     */
    public function removeAttribute($name);

    /**
     * Returns the names of the attributes available to this
     * credentials instance. This method returns an empty array
     * if the credentials instance has no attributes available to it.
     *
     * @return array a string array containing the names of the stored attributes
     *
     * @api
     */
    public function getAttributeNames();
}
