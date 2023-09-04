<?php

namespace PHPCR\Retention;

use PHPCR\AccessDeniedException;
use PHPCR\Lock\LockException;
use PHPCR\PathNotFoundException;
use PHPCR\RepositoryException;
use PHPCR\Version\VersionException;

/**
 * The RetentionManager object is accessed via SessionInterface::getRetentionManager().
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface RetentionManagerInterface
{
    /**
     * Returns all hold objects that have been added through this API to the
     * existing node at $absPath.
     *
     * If no hold has been set before, this method returns an empty array.
     *
     * @param string $absPath the absolute path to a node
     *
     * @return HoldInterface[] All holds that have been added to the existing
     *                         node at absPath through this API. Empty array if no hold has been
     *                         set.
     *
     * @throws PathNotFoundException if no node at absPath exists or the
     *                               session does not have sufficient access to retrieve the node
     * @throws AccessDeniedException if the current session does not
     *                               have sufficient access to retrieve the holds
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function getHolds($absPath);

    /**
     * Places a hold on the existing node at $absPath.
     *
     * If $isDeep is true the hold applies to this node and its subgraph. The
     * hold does not take effect until a save is performed. A node may have
     * more than one hold. The format and interpretation of the name are not
     * specified. They are application-dependent.
     *
     * @param string $absPath the absolute path to a node
     * @param string $name    an application-dependent string
     * @param bool   $isDeep  a boolean indicating if the hold applies to the
     *                        subgraph
     *
     * @return HoldInterface the Hold applied
     *
     * @throws PathNotFoundException if no node at $absPath exists or
     *                               the session does not have sufficient access to retrieve the node
     * @throws AccessDeniedException if the current session does not
     *                               have sufficient access to perform the operation
     * @throws LockException         if a lock applies at the node at
     *                               $absPath and this implementation performs this validation
     *                               immediately
     * @throws VersionException      if the node at $absPath is
     *                               read-only due to a checked-in node and this implementation performs
     *                               this validation immediately
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function addHold($absPath, $name, $isDeep);

    /**
     * Removes the specified hold from the node at $absPath.
     *
     * The removal does not take effect until a save is performed.
     *
     * @param string        $absPath an absolute path
     * @param HoldInterface $hold    the hold to be removed
     *
     * @throws PathNotFoundException if no node at $absPath exists or
     *                               the session does not have sufficient access to retrieve the node
     * @throws AccessDeniedException if the current session does not
     *                               have sufficient access to perform the operation
     * @throws LockException         if a lock applies at the node at
     *                               $absPath and this implementation performs this validation
     *                               immediately
     * @throws VersionException      if the node at $absPath is
     *                               read-only due to a checked-in node and this implementation performs
     *                               this validation immediately
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function removeHold($absPath, HoldInterface $hold);

    /**
     * Gets the retention policy of a node identified by its path.
     *
     * Returns the retention policy that has been set using
     * setRetentionPolicy() on the node at $absPath or null if no policy has
     * been set.
     *
     * @param string $absPath an absolute path to an existing node
     *
     * @return RetentionPolicyInterface the retention policy that applies to
     *                                  the existing node at $absPath or null if no policy applies
     *
     * @throws PathNotFoundException if no node at $absPath exists or
     *                               the session does not have sufficient access to retrieve the node
     * @throws AccessDeniedException if the current session does not
     *                               have sufficient access to retrieve the policy
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function getRetentionPolicy($absPath);

    /**
     * Sets a retention policy of a node identified by the given path.
     *
     * Sets the retention policy of the node at $absPath to that defined in the
     * specified policy node. Interpretation and enforcement of this policy is
     * an implementation issue. In any case the policy does does not take
     * effect until a save is performed.
     *
     * @param string                   $absPath         an absolute path to an existing node
     * @param RetentionPolicyInterface $retentionPolicy a
     *                                                  retention policy
     *
     * @throws PathNotFoundException if no node at $absPath exists or
     *                               the session does not have sufficient access to retrieve the node
     * @throws AccessDeniedException if the current session does not
     *                               have sufficient access to perform the operation
     * @throws LockException         if a lock applies at the node at
     *                               $absPath and this implementation performs this validation
     *                               immediately
     * @throws VersionException      if the node at $absPath is
     *                               read-only due to a checked-in node and this implementation performs
     *                               this validation immediately
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function setRetentionPolicy($absPath, RetentionPolicyInterface $retentionPolicy);

    /**
     * Removes a previously set retention policy.
     *
     * Causes the current retention policy on the node at $absPath to no longer
     * apply. The removal does not take effect until a save is performed.
     *
     * @param string $absPath an absolute path to an existing node
     *
     * @throws PathNotFoundException if no node at $absPath exists or
     *                               the session does not have sufficient access to retrieve the node
     * @throws AccessDeniedException if the current session does not
     *                               have sufficient access to perform the operation
     * @throws LockException         if a lock applies at the node at
     *                               $absPath and this implementation performs this validation
     *                               immediately
     * @throws VersionException      if the node at $absPath is
     *                               read-only due to a checked-in node and this implementation performs
     *                               this validation immediately
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function removeRetentionPolicy($absPath);
}
