<?php
/**
 * Interface description of an implementation of a version class.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */

declare(ENCODING = 'utf-8');
namespace PHPCR\Version;

/**
 * A Version object wraps an nt:version node. It provides convenient access to
 * version information.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface VersionInterface extends \PHPCR\NodeInterface {

    /**
     * Returns the VersionHistory that contains this Version
     *
     * @return \PHPCR\Version\VersionHistoryInterface the VersionHistory that contains this Version
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    public function getContainingHistory();

    /**
     * Returns the date this version was created. This corresponds to the
     * value of the jcr:created property in the nt:version node that represents
     * this version.
     *
     * @return \DateTime a \DateTime object
     * @throws \PHPCR\RepositoryException - if an error occurs
     * @api
     */
    public function getCreated();

    /**
     * Assuming that this Version object was acquired through a Workspace W and
     * is within the VersionHistory H, this method returns the successor of this
     * version along the same line of descent as is returned by
     * H.getAllLinearVersions() where H was also acquired through W.
     *
     * Note that under simple versioning the behavior of this method is equivalent
     * to getting the unique successor (if any) of this version.
     *
     * @return \PHPCR\VersionInterface a Version or null if no linear successor exists.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @see VersionHistory::getAllLinearVersions()
     * @api
     */
    public function getLinearSuccessor();

    /**
     * Returns the successor versions of this version. This corresponds to
     * returning all the nt:version nodes referenced by the jcr:successors
     * multi-value property in the nt:version node that represents this version.
     *
     * @return array of \PHPCR\Version\VersionInterface
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    public function getSuccessors();

    /**
     * Assuming that this Version object was acquired through a Workspace W and
     * is within the VersionHistory H, this method returns the predecessor of
     * this version along the same line of descent as is returned by
     * H.getAllLinearVersions() where H was also acquired through W.
     *
     * Note that under simple versioning the behavior of this method is equivalent
     * to getting the unique predecessor (if any) of this version.
     *
     * @return \PHPCR\Version\VersionInterface a Version or null if no linear predecessor exists.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @see VersionHistory::getAllLinearVersions()
     * @api
     */
    public function getLinearPredecessor();

    /**
     * In both simple and full versioning repositories, this method returns the
     * predecessor versions of this version. This corresponds to returning all
     * the nt:version nodes whose jcr:successors property includes a reference
     * to the nt:version node that represents this version.
     *
     * @return array of \PHPCR\Version\VersionInterface
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    public function getPredecessors();

    /**
     * Returns the frozen node of this version.
     *
     * @return \PHPCR\NodeInterface a Node object
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    public function getFrozenNode();

}
