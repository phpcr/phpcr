<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\NodeType;

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
 * @subpackage NodeType
 * @version $Id$
 */

/**
 * An iterator for NodeType objects.
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface NodeTypeIteratorInterface extends \F3\PHPCR\RangeIteratorInterface {

	/**
	 * Returns the next NodeType in the iteration.
	 *
	 * @return \F3\PHPCR\NodeTypeInterface the next NodeType in the iteration
	 * @throws OutOfBoundsException if iteration has no more NodeTypes
	 */
	public function nextNodeType();

}

?>