<?php
// $Id: Lock.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link Lock} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 * @package Locks
 */

/**
 * Represents a lock placed on an item.
 *
 * @package phpContentRepository
 * @package Locks
 */
interface phpCR_Lock 
{

	/**
	 * Returns the user ID of the user who owns this lock. This is the value of the
	 * <i>jcr:lockOwner</i> property of the lock-holding node. It is also the
	 * value returned by {@link Session::getUserID()} at the time that the lock was
	 * placed. The lock owner's identity is only provided for informational purposes.
	 * It does not govern who can perform an unlock or make changes to the locked nodes;
	 * that depends entirely upon who the token holder is.
	 *
	 * @return mixed
	 *   A user ID.
	 */
	public function getOwner();
	
	
	/**
	 * Returns <i>true</i> if this is a deep lock; <i>false</i> otherwise.
	 *
	 * @return boolean
	 */
	public function isDeep();
	

	/**
	 * Returns the lock holding node. 
	 *
	 * Note that <i>N.getLock().getNode()</i> (where <i>N</i> is a
	 * locked node) will only return <i>N</i> if <i>N</i> is the
	 * lock holder. If <i>N</i> is in the subtree of the lock holder, 
	 * <i>H</i>, then this call will return <i>H</i>.
	 *
	 * @return object
	 *	A {@link Node} object
	 */
	public function getNode();
	
	
	/**
	 * May return the lock token for this lock.
	 *
	 * If this {@link Session} holds the lock token for this lock, then this method will
	 * return that lock token. If this {@link Session} does not hold the applicable lock
	 * token then this method will return null.
	 *
	 * @return string
	 */
	public function getLockToken();
	
	
	/**
	 * Returns <i>true</i> if this {@link Lock} object represents a lock
	 * that is currently in effect.  If this lock has been unlocked either 
	 * explicitly or due to an implementation-specific limitation (like a
	 * timeout) then it returns <i>false</i>. 
	 *
	 * Note that this method is intended for those cases where one is holding a
	 * {@link Lock} object and wants to find out whether the lock (the 
	 * PHPCR-level entity that is attached to the lockable node) that this 
	 * object originally represented still exists. For example, a timeout or 
	 * explicit {@link Node::unlock()} will remove a lock from a node but 
	 * the {@link Lock} object corresponding to that lock may still exist, and
	 * in that case its {@link isLive()} method will return <i>false</i>.
	 *
	 * @return boolean
	 * @throws {@link RepositoryException}
	 *	If an error occurs.
	 */
	public function isLive();
	
	
	/**
	 * Returns <i>true</i> if this is a session-scoped lock; returns 
	 * <i>false</i> if this is an open-scoped lock.
	 *
	 * @return boolean
	 */
	public function isSessionScoped();
	
	
	/**
	 * If this lock's time-to-live is governed by a timer, this method resets 
	 * that timer so that the lock does not timeout and expire. If this lock's
	 * time-to-live is not governed by a timer, then this method has no effect.
	 *
	 * @throws {@link LockException}
	 *	If this {@link Session} does not hold the correct lock token for this 
	 *	lock.
	 * @throws {@link RepositoryException}
	 *	If another error occurs.
	 */
	public function refresh();
}

?>