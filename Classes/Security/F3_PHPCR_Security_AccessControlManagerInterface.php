<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Security;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Security
 * @version $Id$
 */

/**
 * The AccessControlManager object is accessed via
 * Session.getAccessControlManager(). It provides methods for:
 *  Access control discovery
 *  Assigning access control policies
 *
 * @package PHPCR
 * @subpackage Security
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface AccessControlManagerInterface {

	/**
	 * Returns the privileges supported for absolute path $absPath, which must
	 * be an existing node.
	 * This method does not return the privileges held by the session. Instead,
	 * it returns the privileges that the repository supports.
	 *
	 * @param string $absPath - an absolute path.
	 * @return array an array of Privileges.
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function getSupportedPrivileges($absPath);

	/**
	 * Returns the privilege with the specified privilegeName.
	 *
	 * @param string $privilegeName - the name of an existing privilege.
	 * @return \F3\PHPCR\Security\PrivilegeInterface the Privilege with the specified $privilegeName.
	 * @throws \F3\PHPCR\Security\AccessControlException - if no privilege with the specified name exists.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function privilegeFromName($privilegeName);

	/**
	 * Returns whether the session has the specified privileges for absolute
	 * path $absPath, which must be an existing node.
	 * Testing an aggregate privilege is equivalent to testing each non aggregate
	 * privilege among the set returned by calling Privilege.getAggregatePrivileges()
	 * for that privilege.
	 *
	 * The results reported by the this method reflect the net effect of the
	 * currently applied control mechanisms. It does not reflect unsaved access
	 * control policies or unsaved access control entries. Changes to access
	 * control status caused by these mechanisms only take effect on Session.save()
	 * and are only then reflected in the results of the privilege test methods.
	 *
	 * @param string $absPath - an absolute path.
	 * @para array $privileges - an array of Privileges.
	 * @return boolean true if the session has the specified privileges; false otherwise.
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function hasPrivileges($absPath, array $privileges);

	/**
	 * Returns the privileges the session has for absolute path absPath, which
	 * must be an existing node.
	 * The returned privileges are those for which hasPrivileges(java.lang.String,
	 * javax.jcr.security.Privilege[]) would return true.
	 *
	 * The results reported by the this method reflect the net effect of the
	 * currently applied control mechanisms. It does not reflect unsaved access
	 * control policies or unsaved access control entries. Changes to access
	 * control status caused by these mechanisms only take effect on Session.save()
	 * and are only then reflected in the results of the privilege test methods.
	 *
	 * @param string $absPath - an absolute path.
	 * @return array an array of Privileges.
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function getPrivileges($absPath);

	/**
	 * Returns the AccessControlPolicy objects that have been set to the node at
	 * $absPath or an empty array if no policy has been set. This method reflects
	 * the binding state, including transient policy modifications.
	 * Use getEffectivePolicies(String) in order to determine the policy that
	 * effectively applies at absPath.
	 *
	 * @param string $absPath - an absolute path.
	 * @return array an array of AccessControlPolicy objects or an empty array if no policy has been set.
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException - if the session lacks READ_ACCESS_CONTROL privilege for the absPath node.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function getPolicies($absPath);

	/**
	 * Returns the AccessControlPolicy objects that currently are in effect at
	 * the node at $absPath. This may be policies set through this API or some
	 * implementation specific (default) policies.
	 *
	 * @param string $absPath - an absolute path.
	 * @return array an array of AccessControlPolicy objects.
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException - if the session lacks READ_ACCESS_CONTROL privilege for the absPath node.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function getEffectivePolicies($absPath);

	/**
	 * Returns the access control policies that are capable of being applied to
	 * the node at absPath.
	 *
	 * @param string $absPath - an absolute path.
	 * @return \F3\PHPCR\Security\AccessControlPolicyIteratorInterface an AccessControlPolicyIterator over the applicable access control policies or an empty iterator if no policies are applicable.
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException - if the session lacks READ_ACCESS_CONTROL privilege for the absPath node.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function getApplicablePolicies($absPath);

	/**
	 * Binds the policy to the node at absPath.
	 *
	 * Only policies obtained through getApplicablePolicies($absPath) can be set.
	 * The access control policy does not take effect until a save is performed.
	 *
	 * Any implementation-specific (non-JCR) access control settings may be
	 * changed in response to a successful call to setPolicy.
	 *
	 * @param string $absPath - an absolute path.
	 * @param \F3\PHPCR\Security\AccessControlPolicyInterface $policy - the AccessControlPolicy to be applied.
	 * @return void
	 * @throws \F3\PHPCR\PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\Security\AccessControlException - if the policy is not applicable.
	 * @throws \F3\PHPCR\AccessDeniedException - if the session lacks MODIFY_ACCESS_CONTROL privilege for the absPath node.
	 * @throws \F3\PHPCR\Lock\LockException - if a lock applies at the node at absPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException - if the node at absPath is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function setPolicy($absPath, \F3\PHPCR\Security\AccessControlPolicyInterface $policy);

	/**
	 * Removes the specified AccessControlPolicy from the node at $absPath.
	 *
	 * An AccessControlPolicy can only be removed if it was bound to the specified
	 * node through this API before. The effect of the removal only takes place
	 * upon Session.save(). Note, that an implementation default or any other
	 * effective AccessControlPolicy that has not been applied to the node before
	 * may never be removed using this method.
	 *
	 * @param string $absPath - an absolute path.
	 * @param \F3\PHPCR\Security\AccessControlPolicyInterface $policy - the policy to be removed.
	 * @return void
	 * @throws PathNotFoundException - if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\Security\AccessControlException - if no policy exists.
	 * @throws \F3\PHPCR\AccessDeniedException - if the session lacks MODIFY_ACCESS_CONTROL privilege for the absPath node.
	 * @throws \F3\PHPCR\Lock\LockException - if a lock applies at the node at absPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException - if the node at absPath is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function removePolicy($absPath, \F3\PHPCR\Security\AccessControlPolicyInterface $policy);

}

?>