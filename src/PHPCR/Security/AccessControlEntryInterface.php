<?php

namespace PHPCR\Security;

/**
 * An AccessControlEntryInterface represents the association of one or more
 * PrivilegeInterface objects with a specific principal.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. Concrete AccessControlEntry have to implement either
 * \RecursiveIterator or \Iterator.
 * The iterator is equivalent to <b>getPrivileges()</b>, returning a list of
 * PrivilegeInterface. The iterator keys have no significant meaning.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface AccessControlEntryInterface extends \Traversable
{
    /**
     * Returns the principal associated with this access control entry.
     *
     * @return PrincipalInterface
     *
     * @api
     */
    public function getPrincipal();

    /**
     * Returns the privileges associated with this access control entry.
     *
     * @return PrivilegeInterface[] an array of Privileges.
     *
     * @api
     */
    public function getPrivileges();
}
