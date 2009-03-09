<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Query\QOM;

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
 * @subpackage Query
 * @version $Id$
 */

/**
 * Tests whether the selector node is a descendant of a node reachable by
 * absolute path path.
 *
 * A node-tuple satisfies the constraint only if:
 *   selectorNode.getAncestor(n).isSame(session.getNode(path)) &&
 *      selectorNode.getDepth() > n
 * would return true for some non-negative integer n, where selectorNode is the
 * node for the specified selector.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface DescendantNodeInterface extends \F3\PHPCR\Query\QOM\ConstraintInterface {

	/**
	 * Gets the name of the selector against which to apply this constraint.
	 *
	 * @return string the selector name; non-null
	 */
	public function getSelectorName();

	/**
	 * Gets the absolute path.
	 *
	 * @return string the path; non-null
	 */
	public function getAncestorPath();

}

?>