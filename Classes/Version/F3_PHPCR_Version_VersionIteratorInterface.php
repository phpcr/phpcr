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
 * Allows easy iteration through a list of Versions objects with nextVersion
 * as well as a skip method inherited from RangeIterator.
 *
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface VersionIteratorInterface extends \F3\PHPCR\RangeIteratorInterface {

	/**
	 * Returns the next Version in the iteration.
	 *
	 * @return \F3\PHPCR\Version\VersionInterface the next Version in the iteration
	 * @throws OutOfBoundsException if iteration has no more Versions.
	 */
	public function nextVersion();

}

?>