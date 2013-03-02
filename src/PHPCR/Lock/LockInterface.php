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

namespace PHPCR\Lock;

/**
 * Represents a lock placed on an item.
 *
 * @api
 */
interface LockInterface
{
    /**
     * Get the user ID string of the lock owner.
     *
     * Returns the value of the jcr:lockOwner property. This is either the
     * client supplied owner information (see LockManager::lock()),
     * an implementation-dependent string identifying the user who either
     * created the lock or who is bound to the session holding the lock, or
     * null if none of these are available.
     *
     * The lock owner's identity is only provided for informational purposes.
     * It does not govern who can perform an unlock or make changes to the
     * locked nodes; that depends entirely upon who the token holder is.
     *
     * @return string a user ID
     *
     * @api
     */
    public function getLockOwner();

    /**
     * Returns true if this is a deep lock; false otherwise.
     *
     * @return boolean
     *
     * @api
     */
    public function isDeep();

    /**
     * Returns the lock holding node.
     *
     * This is not necessarily the node at the path you used to get this lock
     * instance, if a parent node was deep locked. This method returns the node
     * that was originally locked.
     *
     * I.e. $lockManager->getLock($n->getPath())->getNode() (where $n is a
     * locked node) will only * return $n if $n is the lock holder. If $n is in
     * the subgraph of the lock holder, $h, then this call will return $h.
     *
     * @return \PHPCR\NodeInterface a Node
     *
     * @api
     */
    public function getNode();

    /**
     * May return the lock token for this lock.
     *
     * If this lock is open-scoped and the current session either holds the
     * lock token for this lock, or the repository chooses to expose the lock
     * token to the current session, then this method will return that lock
     * token. Otherwise this method will return null.
     *
     * @return string
     *
     * @api
     */
    public function getLockToken();

    /**
     * Returns the number of seconds remaining until this locks times out.
     *
     * If the lock has already timed out, a negative value is returned. If the
     * number of seconds remaining is infinite or unknown, PHP_INT_MAX is
     * returned.
     *
     * @return integer the number of seconds remaining until this lock times out.
     *
     * @throws \PHPCR\RepositoryException if the timeout is infinite or unknown
     *
     * @api
     */
    public function getSecondsRemaining();

    /**
     * Determines if the lock is still in effect.
     *
     * Returns true if this Lock object represents a lock that is currently in
     * effect. If this lock has been unlocked either explicitly or due to an
     * implementation-specific limitation (like a timeout) then it returns
     * false.
     *
     * Note that this method is intended for those cases where one is holding a
     * Lock object and wants to find out whether the lock (the JCR-level
     * entity that is attached to the lockable node) that this object
     * originally represented still exists. For example, a timeout or explicit
     * unlock will remove a lock from a node but the Lock object
     * corresponding to that lock may still exist, and in that case its isLive
     * method will return false.
     *
     * @return boolean True, if the lock still counts, else false.
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function isLive();

    /**
     * Determines if this lock is session-scoped.
     *
     * Returns true if this is a session-scoped lock and the scope is bound to
     * the current session. Returns false otherwise.
     *
     * @return boolean True, if the lock current session is locked, else false.
     *
     * @api
     */
    public function isSessionScoped();

    /**
     * Determines if the current session owns this lock.
     *
     * Returns true if the current session is the owner of this lock, either
     * because it is session-scoped and bound to this session or open-scoped
     * and this session currently holds the token for this lock. Returns false
     * otherwise.
     *
     * @return boolean True, if the the current session is the owner of the
     *      lock, else false.
     *
     * @api
     */
    public function isLockOwningSession();

    /**
     * If this lock's time-to-live is governed by a timer, this method resets
     * that timer so that the lock does not timeout and expire.
     *
     * If this lock's time-to-live is not governed by a timer, then this method
     * has no effect.
     *
     * @throws LockException if this Session does not hold the correct lock
     *      token for this lock.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function refresh();
}
