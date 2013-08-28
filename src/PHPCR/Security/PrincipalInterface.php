<?php

namespace PHPCR\Security;

/**
 * As there are no ACL standard interfaces in PHP this interface provides the
 * Principal interface similar to the java.security.Principal
 *
 * The Principal is any entity that can be assigned privileges. E.g. a person,
 * a role, a computer.
 *
 * The reason to have this interface is that the PHPCR implementation needs to
 * store the principals and use them on later requests.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface PrincipalInterface
{
    /**
     * Compares this principal to the passed object. Returns true if both this
     * principal and the passed object match the same thing.
     *
     * This is necessary, as the same hashCode does not guarantee equality, and
     * the === operator is too strict, as there could be two instances of the
     * same principal.
     *
     * @param mixed $object
     *
     * @return boolean true if the principal passed to the method is the same
     *      as this object
     */
    public function equals($object);

    /**
     * The hash code must be the same for the same principal.
     *
     * However it should be unique inside your application for different
     * principals.
     *
     * @return int a hashcode for this principal.
     */
    public function hashCode();

    /**
     * Returns the name of this principal.
     *
     * @return string name of this principal
     */
    public function getName();
}
