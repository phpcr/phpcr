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

namespace PHPCR\Retention;

/**
 * The RetentionManager object is accessed via SessionInterface::getRetentionManager().
 *
 * @package phpcr
 * @subpackage interfaces
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
     * @param string $absPath The absolute path to a node.
     *
     * @return array All hold objects that have been added to the existing node
     *      at absPath through this API or an empty array if no hold has been
     *      set.
     *
     * @throws \PHPCR\PathNotFoundException if no node at absPath exists or the
     *      session does not have sufficient access to retrieve the node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to retrieve the holds.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getHolds($absPath);

    /**
     * Places a hold on the existing node at $absPath.
     *
     * If $isDeep is true the hold applies to this node and its subgraph. The
     * hold does not take effect until a save is performed. A node may have
     * more than one hold. The format and interpretation of the name are not
     * specified. They are application-dependent.
     *
     * @param string $absPath The absolute path to a node.
     * @param string $name An application-dependent string.
     * @param boolean $isDeep A boolean indicating if the hold applies to the
     *      subgraph.
     *
     * @return \PHPCR\Retention\HoldInterface The Hold applied.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve the node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to perform the operation.
     * @throws \PHPCR\Lock\LockException if a lock applies at the node at
     *      $absPath and this implementation performs this validation
     *      immediately.
     * @throws \PHPCR\Version\VersionException if the node at $absPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function addHold($absPath, $name, $isDeep);

    /**
     * Removes the specified hold from the node at $absPath.
     *
     * The removal does not take effect until a save is performed.
     *
     * @param string $absPath an absolute path.
     * @param \PHPCR\Retention\HoldInterface $hold the hold to be removed.
     *
     * @return void
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve the node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to perform the operation.
     * @throws \PHPCR\Lock\LockException if a lock applies at the node at
     *      $absPath and this implementation performs this validation
     *      immediately.
     * @throws \PHPCR\Version\VersionException if the node at $absPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function removeHold($absPath, \PHPCR\Retention\HoldInterface $hold);

    /**
     * Gets the retention poilcy of a node identified by its path.
     *
     * Returns the retention policy that has been set using
     * setRetentionPolicy() on the node at $absPath or null if no policy has
     * been set.
     *
     * @param string $absPath an absolute path to an existing node.
     *
     * @return \PHPCR\Retention\RetentionPolicyInterface The retention policy
     *      that applies to the existing node at $absPath or null if no policy
     *      applies.
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve the node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to retrieve the policy.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getRetentionPolicy($absPath);

    /**
     * Sets a retention policy of a node identified by the given path.
     *
     * Sets the retention policy of the node at $absPath to that defined in the
     * specified policy node. Interpretation and enforcement of this policy is
     * an implementation issue. In any case the policy does does not take
     * effect until a save is performed.
     *
     * @param string $absPath an absolute path to an existing node.
     * @param \PHPCR\Retention\RetentionPolicyInterface $retentionPolicy a
     *      retention policy.
     *
     * @return void
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve the node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to perform the operation.
     * @throws \PHPCR\Lock\LockException if a lock applies at the node at
     *      $absPath and this implementation performs this validation
     *      immediately.
     * @throws \PHPCR\Version\VersionException if the node at $absPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function setRetentionPolicy($absPath, RetentionPolicyInterface $retentionPolicy);

    /**
     * Removes a previously set retention policy.
     *
     * Causes the current retention policy on the node at $absPath to no longer
     * apply. The removal does not take effect until a save is performed.
     *
     * @param string $absPath an absolute path to an existing node.
     *
     * @return void
     *
     * @throws \PHPCR\PathNotFoundException if no node at $absPath exists or
     *      the session does not have sufficient access to retrieve the node.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to perform the operation.
     * @throws \PHPCR\Lock\LockException if a lock applies at the node at
     *      $absPath and this implementation performs this validation
     *      immediately.
     * @throws \PHPCR\Version\VersionException if the node at $absPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function removeRetentionPolicy($absPath);
}
