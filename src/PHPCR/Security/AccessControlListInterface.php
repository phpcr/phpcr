<?php

namespace PHPCR\Security;

/**
 * The AccessControlListInterface is an AccessControlPolicyInterface
 * representing a list of access control entries.
 *
 * It is mutable before being set to the AccessControlManagerInterface and
 * consequently defines methods to read and mutate the list i.e. to get, add or
 * remove individual AccessControlEntryInterface instances.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. AccessControlList has to implement either \RecursiveIterator
 * or \Iterator.
 * The iterator is equivalent to <b>getAccessControlEntries()</b> returning
 * AccessControlEntryInterface instances. The iterator keys have no significant
 * meaning.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface AccessControlListInterface extends AccessControlPolicyInterface, \Traversable
{
    /**
     * Returns all access control entries present with this policy.
     *
     * This method is only guaranteed to return an access control entry object
     * if that access control entry object has been assigned through this API.
     *
     * @return AccessControlEntryInterface[] an array of all
     *      AccessControlEntries present with this policy.
     *
     * @throws \PHPCR\RepositoryException - if an error occurs.
     *
     * @api
     */
    public function getAccessControlEntries();

    /**
     * Registers an access control entry object to the registry.
     *
     * Adds an access control entry to this policy consisting of the specified
     * principal and the specified privileges.
     * This method returns true if this policy was modified, false otherwise.
     *
     * How the entries are grouped within the list is an implementation detail.
     * An implementation may e.g. combine the specified privileges with those
     * added by a previous call to addAccessControlEntry for the same
     * Principal. However, a call to addAccessControlEntry for a given
     * Principal can never remove a Privilege added by a previous call.
     *
     * The modification does not take effect until this policy has been set to
     * a node by calling AccessControlManagerInterface::setPolicy() and
     * Session::save is performed.
     *
     * @param PrincipalInterface $principal the entity that should have this
     *      privilege
     * @param array $privileges - an array of Privileges.
     *
     * @return boolean true if this policy was modify; false otherwise.
     *
     * @throws AccessControlException if the specified principal or any of the
     *      privileges does not exist or if some other access control related
     *      exception occurs.
     * @throws \PHPCR\RepositoryException - if another error occurs.
     *
     * @api
     */
    public function addAccessControlEntry(PrincipalInterface $principal, array $privileges);

    /**
     * Removes the specified access control entry object from this policy.
     *
     * Only exactly those entries obtained through getAccessControlEntries can
     * be removed. This method does not take effect until this policy has been
     * re-assigned to a node by calling AccessControlManagerInterface::setPolicy()
     * and save is performed.
     *
     * @param AccessControlEntryInterface $ace the access control entry to be
     *      removed.
     *
     * @throws AccessControlException if the specified entry is not present on
     *      the specified node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function removeAccessControlEntry(AccessControlEntryInterface $ace);
}
