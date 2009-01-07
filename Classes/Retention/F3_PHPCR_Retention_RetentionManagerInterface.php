<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Retention;

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
 * @subpackage Retention
 * @version $Id$
 */

/**
 * The RetentionManager object is accessed via Session.getRetentionManager().
 *
 * @package PHPCR
 * @subpackage Retention
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface RetentionManagerInterface {

	/**
	 * Returns all hold objects that have been added through this API to the
	 * existing node at absPath. If no hold has been set before, this method
	 * returns an empty array.
	 *
	 * @param string $absPath an absolute path.
	 * @return array All hold objects that have been added to the existing node at absPath through this API or an empty array if no hold has been set.
	 * @throws \F3\PHPCR\PathNotFoundException if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to retrieve the holds.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getHolds($absPath);

	/**
	 * Places a hold on the existing node at absPath. If isDeep is true) the
	 * hold applies to this node and its subtree. The hold does not take effect
	 * until a save is performed. A node may have more than one hold.
	 * The format and interpretation of the name are not specified. They are
	 * application-dependent.
	 *
	 * @param string $absPath an absolute path.
	 * @param string $name - an application-dependent string.
	 * @param boolean $isDeep - a boolean indicating if the hold applies to the subtree.
	 * @return \F3\PHPCR\Retention\HoldInterface The Hold applied.
	 * @throws \F3\PHPCR\PathNotFoundException if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to perform the operation.
	 * @throws \F3\PHPCR\Lock\LockException if a lock applies at the node at absPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if the node at absPath is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function addHold($absPath, $name, $isDeep);

	/**
	 * Removes the specified hold from the node at absPath. The removal does not
	 * take effect until a save is performed.
	 *
	 * @param string $absPath an absolute path.
	 * @param \F3\PHPCR\Retention\HoldInterface $hold - the hold to be removed.
	 * @return void
	 * @throws \F3\PHPCR\PathNotFoundException if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to perform the operation.
	 * @throws \F3\PHPCR\Lock\LockException if a lock applies at the node at absPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if the node at absPath is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function removeHold($absPath, \F3\PHPCR\Retention\HoldInterface $hold);

	/**
	 * Returns the retention policy that has been set using setRetentionPolicy()
	 * on the node at absPath or null if no policy has been set.
	 *
	 * @param string $absPath an absolute path to an existing node.
	 * @return \F3\PHPCR\Retention\RetentionPolicyInterface The retention policy that applies to the existing node at absPath or null if no policy applies.
	 * @throws \F3\PHPCR\PathNotFoundException if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to retrieve the policy.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getRetentionPolicy($absPath);

	/**
	 * Sets the retention policy of the node at absPath to that defined in the
	 * specified policy node. Interpretation and enforcement of this policy is an
	 * implementation issue. In any case the policy does does not take effect
	 * until a save is performed.
	 *
	 * @param string $absPath an absolute path to an existing node.
	 * @param \F3\PHPCR\Retention\RetentionPolicyInterface $retentionPolicy - a retention policy.
	 * @return void
	 * @throws \F3\PHPCR\PathNotFoundException if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to perform the operation.
	 * @throws \F3\PHPCR\Lock\LockException if a lock applies at the node at absPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if the node at absPath is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function setRetentionPolicy($absPath, \F3\PHPCR\Retention\RetentionPolicyInterface $retentionPolicy);

	/**
	 * Causes the current retention policy on the node at absPath to no longer
	 * apply. The removal does not take effect until a save is performed.
	 *
	 * @param string $absPath an absolute path to an existing node.
	 * @return void
	 * @throws \F3\PHPCR\PathNotFoundException if no node at absPath exists or the session does not have privilege to retrieve the node.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to perform the operation.
	 * @throws \F3\PHPCR\Lock\LockException if a lock applies at the node at absPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if the node at absPath is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function removeRetentionPolicy($absPath);

}
?>