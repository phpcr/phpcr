<?php

namespace PHPCR\Lock;

/**
 * A storage object for lock configuration. A blank
 * <code>LockInfoInterface</code> is acquired through
 * {@link LockManagerInterface::createLockInfo()}.
 * <p/>
 * The parameters of the LockInfo object can then be set by chaining the set
 * methods, since each method returns the same <code>LockInfoInterface</code>
 * with the indicated parameter set.
 * <p/>
 * Once the object is configured, it is passed (along with the path of the node
 * to be locked) to {@link LockManagerInterface::lock}.
 * <p/>
 * The lock characteristics are defined according to the following parameters:
 * <ul>
 * <li>
 * <code>isDeep</code>: If <code>true</code> then the lock applies to the
 * specified node and all its descendant nodes; if <code>false</code>, the lock
 * applies only to the specified node. On a successful lock, the
 * <code>jcr:lockIsDeep</code> property of the locked node is set to this
 * value.
 * </li>
 * <li>
 * <code>isSessionScoped</code>: If <code>true</code> then the lock will
 * expire upon the expiration of the current session (either through an
 * automatic or explicit <code>Session.logout</code>); if false, the lock
 * does not expire until it is explicitly unlocked, it times out, or it is
 * automatically unlocked due to a implementation-specific limitation.
 * <p/>
 * <code>timeoutHint</code>: Specifies the number of seconds until the lock
 * times out (if it is not refreshed with <code>Lock.refresh</code> in the
 * meantime). An implementation may use this information as a hint or ignore
 * it altogether. Clients can discover the actual timeout by inspecting the
 * returned <code>Lock</code> object.
 * </li>
 * <li>
 * <code>ownerInfo</code>:This parameter can be used to pass a string holding
 * owner information relevant to the client. An implementation may either
 * use or ignore this parameter. If it uses the parameter it must set the
 * <code>jcr:lockOwner</code> property of the locked node to this value
 * and return this value on <code>Lock.getLockOwner</code>.
 * If it ignores this parameter the
 * <code>jcr:lockOwner</code> property (and the value returned by
 * <code>Lock.getLockOwner</code>) is set to either the value returned by
 * <code>Session.getUserID</code> of the owning session or an
 * implementation-specific string identifying the owner.
 * </li>
 * </ul>
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface LockInfoInterface
{

    /**
     * Sets the <code>isDeep</code> parameter of the <code>LockInfo</code>
     * object. If left unset, this parameter defaults to <code>true</code>.
     *
     * @param boolean $isDeep
     *
     * @return LockInfoInterface this object with the <code>isDeep</code>
     *      parameter set.
     */
    public function setIsDeep($isDeep);

    /**
     * Returns the <code>isDeep</code> parameter of the <code>LockInfo</code>
     * object.
     *
     * @return boolean
     */
    public function getIsDeep();

    /**
     * Sets the <code>isSessionScoped</code> parameter of the
     * <code>LockInfo</code> object. If left unset, this parameter defaults to
     * <code>false</code>.
     *
     * @param boolean $isSessionScoped
     *
     * @return LockInfoInterface this object with the
     *      <code>isSessionScoped</code> parameter set.
     */
    public function setIsSessionScoped($isSessionScoped);

    /**
     * Returns the <code>isSessionScoped</code> parameter of the
     * <code>LockInfo</code> object.
     *
     * @return boolean
     */
    public function getIsSessionScoped();

    /**
     * Sets the <code>timeoutHint</code> parameter of the <code>LockInfo</code>
     * object. If left unset, this parameter defaults to <code>-1</code>,
     * meaning no timeout is specified.
     *
     * @param int $timeoutHint
     *
     * @return LockInfoInterface this code> object with the
     *      <code>timeoutHint</code> parameter set.
     */
    public function setTimeoutHint($timeoutHint);

    /**
     * Returns the <code>timeoutHint</code> parameter of the
     * <code>LockInfo</code> object.
     *
     * @return int
     */
    public function getTimeoutHint();

    /**
     * Sets the <code>ownerInfo</code> parameter of the <code>LockInfo</code>
     * object. If left unset, this parameter defaults to <code>null</code>,
     * meaning no owner information is provided.
     *
     * @param string $ownerInfo
     *
     * @return LockInfoInterface this object with the <code>ownerInfo</code>
     *      parameter set.
     */
    public function setOwnerInfo($ownerInfo);

    /**
     * Returns the <code>ownerInfo</code> parameter of the <code>LockInfo</code>
     * object.
     *
     * @return string
     */
    public function getOwnerInfo();
}
