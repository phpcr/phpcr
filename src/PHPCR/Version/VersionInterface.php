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

namespace PHPCR\Version;

/**
 * A Version object wraps an nt:version node. It provides convenient access to
 * version information.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface VersionInterface extends \PHPCR\NodeInterface
{
    /**
     * Returns the VersionHistory that contains this Version
     *
     * @return \PHPCR\Version\VersionHistoryInterface the VersionHistory that
     *      contains this Version
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function getContainingHistory();

    /**
     * Returns the date this version was created. This corresponds to the
     * value of the jcr:created property in the nt:version node that represents
     * this version.
     *
     * @return \DateTime the creation date
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function getCreated();

    /**
     * Get the next linear successor version of this version.
     *
     * Assuming that this Version object was acquired through a Workspace $w
     * and is within the VersionHistory $h, this method returns the successor
     * of this version along the same line of descent as is returned by
     * $h->getAllLinearVersions() where $h was also acquired through $w.
     *
     * Note that under simple versioning the behavior of this method is
     * equivalent to getting the unique successor (if any) of this version.
     *
     * @return \PHPCR\VersionInterface a Version or null if no linear successor
     *      exists.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @see VersionHistory::getAllLinearVersions()
     *
     * @api
     */
    function getLinearSuccessor();

    /**
     * Returns the successor versions of this version.
     *
     * This corresponds to returning all the nt:version nodes referenced by the
     * jcr:successors multi-value property in the nt:version node that
     * represents this version.
     *
     * @return array of \PHPCR\Version\VersionInterface
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function getSuccessors();

    /**
     * Get the next linear predecessor version of this version.
     *
     * Assuming that this Version object was acquired through a Workspace $w
     * and is within the VersionHistory $h, this method returns the predecessor
     * ofthis version along the same line of descent as is returned by
     * $h->getAllLinearVersions() where $h was also acquired through $w.
     *
     * Note that under simple versioning the behavior of this method is
     * equivalent to getting the unique predecessor (if any) of this version.
     *
     * @return \PHPCR\Version\VersionInterface a Version or null if no linear
     *      predecessor exists.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @see VersionHistory::getAllLinearVersions()
     *
     * @api
     */
    function getLinearPredecessor();

    /**
     * Returns the predecessor versions of this version.
     *
     * In both simple and full versioning repositories, this method returns the
     * predecessor versions of this version. This corresponds to returning all
     * the nt:version nodes whose jcr:successors property includes a reference
     * to the nt:version node that represents this version.
     *
     * @return array of \PHPCR\Version\VersionInterface
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function getPredecessors();

    /**
     * Returns a snapshot of the node as it was at this version.
     *
     * All properties are at under their original names except for uuid,
     * primaryType and mixinTypes. The frozen node has his own uuid, and is of
     * type nt:frozenNode. The original values at the time of the snapshots are
     * provided as jcr:frozenUuid, jcr:frozenPrimaryType, jcr:frozenMixinTypes
     *
     * @return \PHPCR\NodeInterface a Node object
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function getFrozenNode();
}
