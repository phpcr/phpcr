<?php

namespace PHPCR\Security;

/**
 * The AccessControlManager object is accessed via
 * SessionInterface::getAccessControlManager().
 *
 *  It provides methods for:
 *
 *  - Access control discovery
 *  - Assigning access control policies
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface AccessControlManagerInterface
{
    /**
     * Gets privileges of an existing node identified by its path.
     *
     * Returns the privileges supported for absolute path $absPath, or, if
     * $absPath is null, the privileges supported by the repository that are
     * not associated with any particular node (for example, the privilege of
     * being able to administer the node type registry).
     *
     * If $absPath is neither the absolute path of an accessible node nor null,
     * then this method throws a PathNotFoundException.
     *
     * Note that this method does not return the privileges held by the current
     * session, but rather the privileges supported by the repository.
     * supports.
     *
     * @param string|null $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return PrivilegeInterface[] An array of Privileges.
     *
     * @throws \PHPCR\PathNotFoundException if $absPath is non-null and either
     *      no node exists at that path or the session does not have sufficient
     *      access to retrieve a node at that path.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function getSupportedPrivileges($absPath = null);

    /**
     * Returns the privilege with the specified privilegeName.
     *
     * @param string $privilegeName The name of an existing privilege.
     *
     * @return PrivilegeInterface the Privilege with the specified name.
     *
     * @throws AccessControlException if no privilege with the specified name
     *      exists.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function privilegeFromName($privilegeName);

    /**
     * Determines whether the session has a given set of privileges.
     *
     * Returns whether the session has the specified privileges for absolute
     * path $absPath, which must be an existing node or, if $absPath is null,
     * then whether the session has all the specified non-node-related
     * privileges (such as being able administer the node type registry, for
     * example).

     * Testing an aggregate privilege is equivalent to testing each non
     * aggregate privilege among the set returned by calling
     * PrivilegeInterface::getAggregatePrivileges() for that privilege.
     *
     * The results reported by this method reflect the net effect of the
     * currently applied control mechanisms. It does not reflect unsaved access
     * control policies or unsaved access control entries. Changes to access
     * control status caused by these mechanisms only take effect on
     * SessionInterface::save() and are only then reflected in the results of
     * the privilege test methods.
     *
     * @param string|null $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     * @param array $privileges an array of Privileges.
     *
     * @return boolean true if the session has the specified privileges; false
     *      otherwise.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve a node at
     *      that location
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function hasPrivileges($absPath, array $privileges);

    /**
     * Reads the privileges of the current session.
     *
     * Returns the privileges for the object specified by $absPath. If $absPath
     * is the absolute path of an accessible node then the specified object is
     * that node. If $absPath is null then the specified object is the
     * repository as a whole and the privileges in question are those that are
     * not associated with any particular node. This includes such privileges
     * as being able administer the node type registry, for example.
     *
     * The returned privileges are those for which
     * AccessControlManagerInterface::hasPrivileges() would return true.
     *
     * The results reported by the this method reflect the net effect of the
     * currently applied control mechanisms. It does not reflect unsaved access
     * control policies or unsaved access control entries. Changes to access
     * control status caused by these mechanisms only take effect on
     * SessionInterface::save() and are only then reflected in the results of
     * the privilege test methods.
     *
     * @param string|null $absPath The absolute path to a node the privileges shall
     *      be fetched of or null to fetch non-node privileges.
     *
     * @return PrivilegeInterface[] an array of Privileges.
     *
     * @throws \PHPCR\PathNotFoundException if $absPath is non-null and no node
     *      at $absPath exists or the session does not have sufficient access
     *      to retrieve a node at that location.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function getPrivileges($absPath = null);

    /**
     * Gets the access control policies previously set.
     *
     * Returns the AccessControlPolicy objects that have been set to the object
     * specified by $absPath. If $absPath is the absolute path of an accessible
     * node then the specified object is that node. If $absPath is null then
     * the specified object is the repository as a whole. If no policy has been
     * set for the specified object, an empty array is returned. This method
     * reflects the binding state, including transient policy modifications.
     *
     * Use {@link getEffectivePolicies()} in order to determine the policy that
     * effectively applies to $absPath.
     *
     * @param string|null $absPath The absolute path to a node the privileges shall
     *      be fetched of or null to fetch non-node privileges.
     *
     * @return AccessControlPolicyInterface[] an array of AccessControlPolicies, if
     *      no policy has been set the array is empty.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve a node at
     *      that location
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      READ_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function getPolicies($absPath);

    /**
     * Gets the access control policies currently in effect.
     *
     * Returns the AccessControlPolicy objects that currently are in effect for
     * the object specified by $absPath. If $absPath is the absolute path of an
     * accessible node then the specified object is that node. If $absPath is
     * null then the specified object is the repository as a whole.
     *
     * The policies returned by this method may include both those set through
     * this API and implementation specific policies.
     *
     * @param string|null $absPath The absolute path to the node of which privileges
     *      are requested or null for non-node privileges.
     *
     * @return AccessControlPolicyInterface[] an array of AccessControlPolices.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve a node at
     *      that location
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      READ_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function getEffectivePolicies($absPath);

    /**
     * Returns the access control policies that are capable of being applied to
     * the object specified by $absPath. If $absPath is the absolute path of an
     * accessible node then the specified object is that node. If $absPath is
     * null then the specified object is the repository as a whole.
     *
     * @param string|null $absPath The absolute path to the node of which
     *      privileges are requested or null for the repository as a whole.
     *
     * @return \Iterator over the applicable access control policies
     *      implementing <b>SeekableIterator</b> and <b>Countable</b>. Values
     *      are the AccessControlPolicyInterface instances. Keys have no
     *      meaning. Returns an empty iterator if no policies are applicable.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve a node at
     *      that location
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      READ_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function getApplicablePolicies($absPath);

    /**
     * Binds the policy to the object specified by $absPath. If $absPath is the
     * absolute path of an accessible node then the specified object is that
     * node. If $absPath is null then the specified object is the repository as
     * a whole.
     *
     * The behavior of AccessControlManagerInterface::setPolicy() differs
     * depending on how the policy object was originally acquired.
     *
     * If the policy was acquired through
     * AccessControlManagerInterface::getApplicablePolicies() then that policy
     * object is added to the object specified by $absPath.
     *
     * On the other hand, if the policy was acquired through
     * AccessControlManagerInterface::getPolicies() then that policy object
     * (usually after being altered) replaces its former version on the node at
     * $absPath.
     *
     * This is a session-write method and therefore the access control policy
     * assignment is only dispatched on Session::save() and will only take
     * effect upon persist.
     *
     * @param string|null $absPath The absolute path to the node to which
     *      privileges are to be set or null for the repository as a whole.

     * @param AccessControlPolicyInterface $policy The AccessControlPolicy to
     *      be applied.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve a node at
     *      that location
     * @throws AccessControlException       if the policy is not applicable.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      MODIFY_ACCESS_CONTROL privilege for $absPath.
     * @throws \PHPCR\Lock\LockException if a lock prevents the assignment and
     *      this implementation performs this validation immediately instead of
     *      waiting until save.
     * @throws \PHPCR\Version\VersionException if the object specified by
     *      $absPath is a node in the read-only state (due to a checked-in)
     *      node and this implementation performs this validation immediately.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function setPolicy($absPath, AccessControlPolicyInterface $policy);

    /**
     * Removes the specified AccessControlPolicy from the object specified by
     * $absPath. If $absPath is the absolute path of an accessible node then
     * the specified object is that node. If $absPath is null then the
     * specified object is the repository as a whole.
     *
     * An AccessControlPolicyInterface can only be removed if it was earlier
     * bound to the specified object through this API. The effect of the removal only
     * takes place upon SessionInterface::save(). Note, that an implementation
     * default or any other effective AccessControlPolicyInterface that has not been
     * applied through this API  may never be removed using this method.
     *
     * @param string|null $absPath The absolute path to the node from which
     *      privileges are removed or null for the repository as a whole.

     * @param AccessControlPolicyInterface $policy the policy to be removed.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve a node at
     *      that location
     * @throws AccessControlException if the policy to remove does not exist at
     *      the node at absPath.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      MODIFY_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\Lock\LockException if $absPath specifies a locked node
     *      and this implementation performs this validation immediately
     *      instead of waiting until save.
     * @throws \PHPCR\Version\VersionException if $absPath specifies a node
     *      that is read-only due to a checked-in node and this implementation
     *      performs this validation immediately instead of waiting until save.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function removePolicy($absPath, AccessControlPolicyInterface $policy);
}
