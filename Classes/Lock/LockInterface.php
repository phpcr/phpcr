<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Lock;

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
 * @subpackage Lock
 * @version $Id$
 */

/**
 * Represents a lock placed on an item.
 *
 * @package PHPCR
 * @subpackage Lock
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface LockInterface {

	/**
	 * Returns the value of the jcr:lockOwner property. This is either the
	 * client supplied owner information (see LockManager->lock()),
	 * an implementation-dependent string identifying the user who either
	 * created the lock or who is bound to the session holding the lock, or
	 * NULL if none of these are available.
	 *
	 * The lock owner's identity is only provided for informational purposes.
	 * It does not govern who can perform an unlock or make changes to the
	 * locked nodes; that depends entirely upon who the token holder is.
	 *
	 * @return string a user ID
	 */
	public function getLockOwner();

	/**
	 * Returns true if this is a deep lock; false otherwise.
	 *
	 * @return boolean
	 */
	public function isDeep();

	/**
	 * Returns the lock holding node. Note that N.getLock().getNode() (where N
	 * is a locked node) will only return N if N is the lock holder. If N is in
	 * the subtree of the lock holder, H, then this call will return H.
	 *
	 * @return \F3\PHPCR\NodeInterface a Node
	 */
	public function getNode();

	/**
	 * May return the lock token for this lock. If this lock is open-scoped and
	 * the current session either holds the lock token for this lock, or the
	 * repository chooses to expose the lock token to the current session,
	 * then this method will return that lock token. Otherwise this method will
	 * return null.
	 *
	 * @return string
	 */
	public function getLockToken();

	/**
	 * Returns the seconds remaining until this locks times out.
	 * If the lock has already timed out, a negative value is returned.
	 *
	 * @return integer
	 * @throws \F3\PHPCR\RepositoryException if the timeout is infinite or unknown
	 */
	public function getSecondsRemaining();

	/**
	 * Returns true if this Lock object represents a lock that is currently in
	 * effect. If this lock has been unlocked either explicitly or due to an
	 * implementation-specific limitation (like a timeout) then it returns false.
	 * Note that this method is intended for those cases where one is holding a
	 * Lock Java object and wants to find out whether the lock (the JCR-level
	 * entity that is attached to the lockable node) that this object originally
	 * represented still exists. For example, a timeout or explicit unlock will
	 * remove a lock from a node but the Lock Java object corresponding to that
	 * lock may still exist, and in that case its isLive method will return false.
	 *
	 * @return boolean
	 * @throws RepositoryException if an error occurs
	 */
	public function isLive();

	/**
	 * Returns true if this is a session-scoped lock and the scope is bound to the
	 * current session. Returns false otherwise.
	 *
	 * @return boolean
	 */
	public function isSessionScoped();

	/**
	 * Returns true if the current session is the owner of this lock, either because
	 * it is session-scoped and bound to this session or open-scoped and this session
	 * currently holds the token for this lock. Returns false otherwise.
	 *
	 * @return boolean
	 */
	public function isLockOwningSession();

	/**
	 * If this lock's time-to-live is governed by a timer, this method resets that
	 * timer so that the lock does not timeout and expire. If this lock's time-to-live
	 * is not governed by a timer, then this method has no effect.
	 *
	 * @throws \F3\PHPCR\Lock\LockException if this Session does not hold the correct lock token for this lock.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function refresh();

}

?>