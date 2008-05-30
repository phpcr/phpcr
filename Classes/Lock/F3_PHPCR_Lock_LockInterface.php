<?php
declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
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
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_Lock_LockInterface {

	/**
	 * Returns the value of the jcr:lockOwner property. This is the user ID
	 * bound to the Session that holds the lock or another implementation-
	 * dependent string identifying the user. The lock owner's identity is
	 * only provided for informational purposes. It does not govern who can
	 * perform an unlock or make changes to the locked nodes; that depends
	 * entirely upon who the token holder is.
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
	 * @return F3_PHPCR_NodeInterface a Node
	 */
	public function getNode();

	/**
	 * May return the lock token for this lock. If this lock is open-scoped and
	 * the current session holds the lock token for this lock, then this method
	 * will return that lock token. Otherwise this method will return null.
	 *
	 * @return string
	 */
	public function getLockToken();

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
	 * current session. Returns false if this is an open-scoped lock or is session-
	 * scoped but the scope is bound to another session.
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
	 * @throws F3_PHPCR_Lock_LockException if this Session does not hold the correct lock token for this lock.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function refresh();

}

?>