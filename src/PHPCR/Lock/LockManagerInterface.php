<?php

namespace PHPCR\Lock;

/**
 * This interface encapsulates methods for the management of locks.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. LockManager has to implement either \IteratorAggregate or
 * \Iterator.
 * The iterator is equivalent to <b>getLockTokens()</b> returning a list of all
 * locks. The iterator keys have no significant meaning.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface LockManagerInterface extends \Traversable
{
    /**
     * Adds the specified lock token to the current Session.
     *
     * Holding a lock token makes the current Session the owner of the lock
     * specified by that particular lock token.
     *
     * @param string $lockToken A lock token (a string).
     *
     * @throws LockException if the specified lock token is already held by
     *      another Session and the implementation does not support
     *      simultaneous ownership of open-scoped locks.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function addLockToken($lockToken);

    /**
     * Returns the Lock object that applies to the node at the specified
     * absPath.
     *
     * This may be either a lock on that node itself or a deep lock on a node
     * above that node.
     *
     * @param string $absPath absolute path of node for which to obtain the
     *      lock.
     *
     * @return LockInterface The applicable Lock object.
     *
     * @throws LockException                if no lock applies to this node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to get the lock.
     * @throws \PHPCR\PathNotFoundException if no node is found at $absPath
     * @throws \PHPCR\RepositoryException   if another error occurs.
     *
     * @api
     */
    public function getLock($absPath);

    /**
     * Gets the list of previously registered tokens.
     *
     * Returns an array containing all lock tokens currently held by the
     * current Session. Note that any such tokens will represent open-scoped
     * locks, since session-scoped locks do not have tokens.
     *
     * @return array an array of lock tokens (strings)
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getLockTokens();

    /**
     * Determines if the node identified by the passed path holds a lock.
     *
     * Returns true if the node at absPath holds a lock; otherwise returns
     * false. To hold a lock means that this node has actually had a lock
     * placed on it specifically, as opposed to just having a lock apply to it
     * due to a deep lock held by a node above.
     *
     * @param string $absPath The absolute path of node to be checked.
     *
     * @return boolean True, if the node identified by the given path holds a
     *      lock, else false.
     *
     * @throws \PHPCR\PathNotFoundException if no node is found at $absPath
     * @throws \PHPCR\RepositoryException   if an error occurs.
     *
     * @api
     */
    public function holdsLock($absPath);

    /**
     * Places a lock on the node at absPath.
     *
     * If successful, the node is said to hold the lock.
     *
     * If <b>isDeep</b> is true then the lock applies to the specified node and
     * all its descendant nodes; if false, the lock applies only to the
     * specified node. On a successful lock, the jcr:lockIsDeep property of the
     * locked node is set to this value.
     *
     * If <b>isSessionScoped</b> is true then this lock will expire upon the
     * expiration of the current session (either through an automatic or
     * explicit SessionInterface::logout()); if false, this lock does not
     * expire until it is explicitly unlocked, it times out, or it is
     * automatically unlocked due to a implementation-specific limitation.
     *
     * The <b>timeout</b> parameter specifies the number of seconds until the
     * lock times out (if it is not refreshed with LockInterface::refresh() in
     * the meantime). An implementation may use this information as a hint or
     * ignore it altogether. Clients can discover the actual timeout by
     * inspecting the returned Lock object.
     *
     * The <b>ownerInfo</b> parameter can be used to pass a string holding
     * owner information relevant to the client. An implementation may either
     * use or ignore this parameter. If it uses the parameter it must set the
     * jcr:lockOwner property of the locked node to this value and return this
     * value on LockInterface::getLockOwner(). If it ignores this parameter the
     * jcr:lockOwner property (and the value returned by
     * LockInterface::getLockOwner()) is set to either the value returned by
     * SessionInterface::getUserID() of the owning session or an
     * implementation-specific string identifying the owner.
     *
     * The method returns a Lock object representing the new lock. If the lock
     * is open-scoped the returned lock will include a lock token. The lock
     * token is also automatically added to the set of lock tokens held by the
     * current session.
     *
     * The addition or change of the properties jcr:lockIsDeep and
     * jcr:lockOwnerare persisted immediately; there is no need to call save.
     *
     * It is possible to lock a node even if it is checked-in.
     *
     * @param string  $absPath The absolute path of node to be locked
     * @param boolean $isDeep  If true this lock will apply to this node and all
     *      its descendants; if false, it applies only to this node.
     * @param boolean $isSessionScoped If true, this lock expires with the
     *      current session; if false it expires when explicitly or
     *      automatically unlocked for some other reason.
     * @param integer $timeoutHint Desired lock timeout in seconds (servers are
     *      free to ignore this value); specify PHP_INT_MAX for no timeout. If
     *      not specified, defaults to no timeout.
     * @param string $ownerInfo A string containing owner information supplied
     *      by the client; servers are free to ignore this value. If none is
     *      specified, the implementation chooses one (i.e. user name of
     *      current backend authentication credentials)
     *
     * @return LockInterface A Lock object containing a lock token.
     *
     * @throws LockException if this node is not mix:lockable or this node is
     *      already locked or isDeep is true and a descendant node of this node
     *      already holds a lock.
     * @throws \PHPCR\AccessDeniedException if this session does not have
     *      sufficient access to lock this node.
     * @throws \PHPCR\InvalidItemStateException if this node has pending
     *      unsaved changes.
     * @throws \PHPCR\PathNotFoundException if no node is found at $absPath
     * @throws \PHPCR\RepositoryException   if another error occurs.
     *
     * @api
     */
    public function lock($absPath, $isDeep, $isSessionScoped, $timeoutHint = PHP_INT_MAX, $ownerInfo = null);

    /**
     * Alternative method to lock with all the options in one configuration class.
     *
     * @param string            $absPath  The absolute path of node to be locked
     * @param LockInfoInterface $lockInfo configured with the desired
     *      characteristics for this lock.
     *
     * @return LockInterface A Lock object containing a lock token.
     *
     * @throws LockException if this node is not mix:lockable or this node is
     *      already locked or isDeep is true and a descendant node of this node
     *      already holds a lock.
     * @throws \PHPCR\AccessDeniedException if this session does not have
     *      sufficient access to lock this node.
     * @throws \PHPCR\InvalidItemStateException if this node has pending
     *      unsaved changes.
     * @throws \PHPCR\PathNotFoundException if no node is found at $absPath
     * @throws \PHPCR\RepositoryException   if another error occurs.
     *
     */
    public function lockWithInfo($absPath, LockInfoInterface $lockInfo);

    /**
     * Determines if the node at absPath is locked.
     *
     * Returns true if the node at absPath is locked either as a result of a
     * lock held by that node or by a deep lock on a node above that node;
     * otherwise returns false.
     *
     * @param string $absPath The absolute path of a node to be checked.
     *
     * @return boolean True, if the identified node has a lock.
     *
     * @throws \PHPCR\PathNotFoundException if no node is found at $absPath.
     * @throws \PHPCR\RepositoryException   if an error occurs.
     *
     * @api
     */
    public function isLocked($absPath);

    /**
     * Removes the specified lock token from this Session.
     *
     * @param string $lockToken - a lock token (a string)
     *
     * @throws LockException if the current Session does not hold
     *      the specified lock token.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function removeLockToken($lockToken);

    /**
     * Removes the lock on the node at absPath.
     *
     * Also removes the properties jcr:lockOwner and jcr:lockIsDeep from that
     * node. As well, the corresponding lock token is removed from the set of
     * lock tokens held by the current Session.
     *
     * If the node does not currently hold a lock or holds a lock for which
     * this Session is not the owner and is not a "lock-superuser", then a
     * \PHPCR\Lock\LockException is thrown.
     *
     * <b>Note:</b>
     * However that the system may give permission to a non-owning session
     * to unlock a lock. Typically such "lock-superuser" capability is intended
     * to facilitate administrational clean-up of orphaned open-scoped locks.
     *
     * Note that it is possible to unlock a node even if it is checked-in (the
     * lock-related properties will be changed despite the checked-in status).
     *
     * @param string $absPath The absolute path of node to be unlocked.
     *
     * @throws LockException If this node does not currently hold a
     *      lock or holds a lock for which this Session does not have the
     *      correct lock token.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have permission to unlock this node.
     * @throws \PHPCR\InvalidItemStateException if this node has pending
     *      unsaved changes.
     * @throws \PHPCR\PathNotFoundException if no node is found at $absPath
     * @throws \PHPCR\RepositoryException   if another error occurs.
     *
     * @api
     */
    public function unlock($absPath);

    /**
     * Creates a ockInfo object that can then be configured and passed to the
     * method lockWithInfo
     *
     * @return LockInfoInterface the object instance to be configured
     *
     * @api
     */
    public function createLockInfo();
}
