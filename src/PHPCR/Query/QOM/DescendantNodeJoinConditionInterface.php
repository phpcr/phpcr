<?php
/**
 * Interface to describe the contract to implement a comparison class.
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
namespace PHPCR\Query\QOM;

/**
 * Tests whether the descendantSelector node is a descendant of the
 * ancestorSelector node. A node-tuple satisfies the constraint only if:
 *
 *   descendantSelectorNode.getAncestor(n).isSame(ancestorSelectorNode) && descendantSelectorNode.getDepth() > n
 *
 * would return true some some non-negative integer n, where descendantSelectorNode
 * is the node for descendantSelector and ancestorSelectorNode is the node for
 * ancestorSelector.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface DescendantNodeJoinConditionInterface extends \PHPCR\Query\QOM\JoinConditionInterface {

    /**
     * Gets the name of the descendant selector.
     *
     * @return string the selector name; non-null
     * @api
     */
    public function getDescendantSelectorName();

    /**
     * Gets the name of the ancestor selector.
     *
     * @return string the selector name; non-null
     * @api
     */
    public function getAncestorSelectorName();

}
