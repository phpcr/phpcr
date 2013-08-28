<?php

namespace PHPCR\Version;

/**
 * A Version object wraps an nt:version node. It provides convenient access to
 * version information.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface VersionInterface extends \PHPCR\NodeInterface
{
    /**
     * Returns the VersionHistory that contains this Version
     *
     * @return VersionHistoryInterface the VersionHistory that
     *      contains this Version
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function getContainingHistory();

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
    public function getCreated();

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
     * @return VersionInterface a Version or null if no linear successor
     *      exists.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @see VersionHistory::getAllLinearVersions()
     *
     * @api
     */
    public function getLinearSuccessor();

    /**
     * Returns the successor versions of this version.
     *
     * This corresponds to returning all the nt:version nodes referenced by the
     * jcr:successors multi-value property in the nt:version node that
     * represents this version.
     *
     * @return VersionInterface[] an array of Versions
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function getSuccessors();

    /**
     * Get the next linear predecessor version of this version.
     *
     * Assuming that this Version object was acquired through a Workspace $w
     * and is within the VersionHistory $h, this method returns the predecessor
     * of this version along the same line of descent as is returned by
     * $h->getAllLinearVersions() where $h was also acquired through $w.
     *
     * Note that under simple versioning the behavior of this method is
     * equivalent to getting the unique predecessor (if any) of this version.
     *
     * @return VersionInterface a Version or null if no linear
     *      predecessor exists.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @see VersionHistory::getAllLinearVersions()
     *
     * @api
     */
    public function getLinearPredecessor();

    /**
     * Returns the predecessor versions of this version.
     *
     * In both simple and full versioning repositories, this method returns the
     * predecessor versions of this version. This corresponds to returning all
     * the nt:version nodes whose jcr:successors property includes a reference
     * to the nt:version node that represents this version.
     *
     * @return VersionInterface[] an array of Versions
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function getPredecessors();

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
    public function getFrozenNode();
}
