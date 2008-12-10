<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Version;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
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
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
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