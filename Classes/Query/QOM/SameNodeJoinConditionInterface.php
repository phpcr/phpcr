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
 * Tests whether two nodes are "the same" according to the isSame method of
 * javax.jcr.Item.
 *
 * If selector2Path is omitted:
 *  Tests whether the selector1 node is the same as the selector2 node. A
 *  node-tuple satisfies the constraint only if:
 *   selector1Node.isSame(selector2Node)
 *  would return true, where selector1Node is the node for selector1 and
 *  selector2Node is the node for selector2.
 *
 * Otherwise, if selector2Path is specified:
 *  Tests whether the selector1 node is the same as a node identified by
 *  relative path from the selector2 node. A node-tuple satisfies the constraint
 *  only if:
 *   selector1Node.isSame(selector2Node.getNode(selector2Path))
 *  would return true, where selector1Node is the node for selector1 and
 *  selector2Node is the node for selector2.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface SameNodeJoinConditionInterface extends \F3\PHPCR\Query\QOM\JoinConditionInterface {

	/**
	 * Gets the name of the first selector.
	 *
	 * @return string the selector name; non-null
	 */
	public function getSelector1Name();

	/**
	 * Gets the name of the second selector.
	 *
	 * @return string the selector name; non-null
	 */
	public function getSelector2Name();

	/**
	 * Gets the path relative to the second selector.
	 *
	 * @return string the relative path, or null for none
	 */
	public function getSelector2Path();

}

?>