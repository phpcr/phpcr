<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Version;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 */

/**
 * A Version object wraps an nt:version node. It provides convenient access to
 * version information.
 *
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface VersionInterface extends \F3\PHPCR\NodeInterface {

	/**
	 * Returns the VersionHistory that contains this Version
	 *
	 * @return VersionHistory the VersionHistory that contains this Version
	 * throws RepositoryException if an error occurs
	 */
	public function getContainingHistory();

	/**
	 * Returns the date this version was created. This corresponds to the
	 * value of the jcr:created property in the nt:version node that represents
	 * this version.
	 *
	 * @return \DateTime a \DateTime object
	 * @throws RepositoryException - if an error occurs
	 */
	public function getCreated();

	/**
	 * Returns the successor versions of this version. This corresponds to returning all the nt:version nodes referenced by the jcr:successors multi-value property in the nt:version node that represents this version.
	 *
	 * @return array of \F3\PHPCR\Version\Version
	 * @throws RepositoryException if an error occurs
	 */
	public function getSuccessors();

	/**
	 * Returns the predecessor versions of this version. This corresponds to
	 * returning all the nt:version nodes whose jcr:successors property includes
	 * a reference to the nt:version node that represents this version.
	 *
	 * @return array of \F3\PHPCR\Version\Version
	 * @throws RepositoryException if an error occurs
	 */
	public function getPredecessors();

	/**
	 * Returns the frozen node of this version.
	 *
	 * @return \F3\PHPCR\NodeInterface a Node object
	 * @throws RepositoryException if an error occurs
	 */
	public function getFrozenNode();

}

?>