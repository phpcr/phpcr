<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

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
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface AccessControlManagerInterface
{
    /**
     * Gets privileges of an existing node identified by its path.
     *
     * Returns the privileges supported for absolute path $absPath, which must
     * be an existing node. This method does not return the privileges held by
     * the session. Instead, it returns the privileges that the repository
     * supports.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return array An array of Privileges.
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have privilege to retrieve the node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getSupportedPrivileges($absPath);

    /**
     * Returns the privilege with the specified privilegeName.
     *
     * @param string $privilegeName The name of an existing privilege.
     *
     * @return \PHPCR\Security\PrivilegeInterface the Privilege with the
     *      specified $privilegeName.
     *
     * @throws \PHPCR\Security\AccessControlException if no privilege with the
     *      specified name exists.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function privilegeFromName($privilegeName);

    /**
     * Determines if the node identified its path has the given set of
     * privileges.
     *
     * Returns whether the session has the specified privileges for absolute
     * path $absPath, which must be an existing node. Testing an aggregate
     * privilege is equivalent to testing each non aggregate privilege among
     * the set returned by calling PrivilegeInterface::getAggregatePrivileges()
     * for that privilege.
     *
     * The results reported by the this method reflect the net effect of the
     * currently applied control mechanisms. It does not reflect unsaved access
     * control policies or unsaved access control entries. Changes to access
     * control status caused by these mechanisms only take effect on
     * SessionInterface::save() and are only then reflected in the results of
     * the privilege test methods.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     * @param array $privileges an array of Privileges.
     *
     * @return boolean true if the session has the specified privileges; false
     *      otherwise.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficent access to retrieve a node at
     *      that location.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function hasPrivileges($absPath, array $privileges);

    /**
     * Reads the privileges of an existing node identfied by its path.
     *
     * Returns the privileges the session has for absolute path absPath, which
     * must be an existing node. The returned privileges are those for which
     * AccessControlManagerInterface::hasPrivileges() would return true.
     *
     * The results reported by the this method reflect the net effect of the
     * currently applied control mechanisms. It does not reflect unsaved access
     * control policies or unsaved access control entries. Changes to access
     * control status caused by these mechanisms only take effect on
     * SessionInterface::save() and are only then reflected in the results of
     * the privilege test methods.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return array an array of Privileges.
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficent access to retrieve a node at that
     *      location.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getPrivileges($absPath);

    /**
     * Gets the access control policies previously set to the node identified
     * by the given path.
     *
     * Returns the AccessControlPolicy objects that have been set to the node
     * at $absPath or an empty array if no policy has been set. This method
     * reflects the binding state, including transient policy modifications.
     * Use getEffectivePolicies(String) in order to determine the policy that
     * effectively applies at absPath.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return array an array of AccessControlPolicy objects or an empty array
     *      if no policy has been set.
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficent access to retrieve a node at that
     *      location.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      READ_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getPolicies($absPath);

    /**
     * Gets the access control policies currently in effect on the node
     * identified by the given path.
     *
     * Returns the AccessControlPolicy objects that currently are in effect at
     * the node at $absPath. This may be policies set through this API or some
     * implementation specific (default) policies.
     *
     * @param string $absPath The absolute path to the node of which privileges
     *      are requested.
     *
     * @return array an array of AccessControlPolicy objects.
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficent access to retrieve a node at that
     *      location.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      READ_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getEffectivePolicies($absPath);

    /**
     * Returns the access control policies that are capable of being applied to
     * the node at absPath.
     *
     * @param string $absPath The absolute path to the node of which privileges
     *      are requested.
     *
     * @return Iterator over the applicable access control policies
     *      implementing <b>SeekableIterator</b> and <b>Countable</b>. Values
     *      are the AccessControlPolicyInterface instances. Keys have no
     *      meaning. Returns an empty iterator if no policies are applicable.
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficent access to retrieve a node at that
     *      location.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      READ_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getApplicablePolicies($absPath);

    /**
     * Binds the policy to the node at absPath.
     *
     * The behavior of the call $acm->setPolicy($absPath, $policy) differs
     * depending on how the policy object was originally acquired.
     *
     * If policy was acquired through $acm->getApplicablePolicies($absPath)
     * then that policy object is added to the node at absPath.
     *
     * On the other hand, if <code>$policy</code> was acquired through
     * $acm->getPolicies(absPath) then that policy object (usually after being
     * altered) replaces its former version on the node at $absPath.
     *
     * This is session-write method and therefore the access control policy
     * is only dispatched on <code>save()</code> and will only take effect upon
     * persist.
     *
     * @param string $absPath The absolute path to the node of which privileges
     *      are requested.
     * @param \PHPCR\Security\AccessControlPolicyInterface $policy The
     *      AccessControlPolicy to be applied.
     *
     * @return void
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficent access to retrieve a node at that
     *      location.
     * @throws \PHPCR\Security\AccessControlException if the policy is not
     *      applicable.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      MODIFY_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\Lock\LockException if a lock applies at the node at
     *      absPath and this implementation performsthis validation immediately
     *      instead of waiting until save.
     * @throws \PHPCR\Version\VersionException if the node at absPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function setPolicy($absPath, \PHPCR\Security\AccessControlPolicyInterface $policy);

    /**
     * Removes the specified AccessControlPolicy from the node at $absPath.
     *
     * An AccessControlPolicy can only be removed if it was bound to the
     * specified node through this API before. The effect of the removal only
     * takes place upon SessionInterface::save(). Note, that an implementation
     * default or any other effective AccessControlPolicy that has not been
     * applied to the node before may never be removed using this method.
     *
     * @param string $absPath The absolute path to the node of which privileges
     *      are requested.
     * @param \PHPCR\Security\AccessControlPolicyInterface $policy the policy
     *      to be removed.
     *
     * @return void
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficent access to retrieve a node at that
     *      location.
     * @throws \PHPCR\Security\AccessControlException if no policy exists.
     * @throws \PHPCR\AccessDeniedException if the session lacks
     *      MODIFY_ACCESS_CONTROL privilege for the absPath node.
     * @throws \PHPCR\Lock\LockException if a lock applies at the node at
     *      absPath and this implementation performs this validation
     *      immediately instead of waiting until save.
     * @throws \PHPCR\Version\VersionException if the node at absPath is
     *      versionable and checked-in or is non-versionable but its nearest
     *      versionable ancestor is checked-in and this implementation performs
     *      this validation immediately instead of waiting until save.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function removePolicy($absPath, \PHPCR\Security\AccessControlPolicyInterface $policy);
}
