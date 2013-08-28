<?php

namespace PHPCR\Query\QOM;

/**
 * Tests whether the descendantSelector node is a descendant of the
 * ancestorSelector node. A node-tuple satisfies the constraint only if:
 *
 *   <code>$descendantSelectorNode->getAncestor($n)->isSame($ancestorSelectorNode) && $descendantSelectorNode->getDepth() > $n</code>
 *
 * would return true some some non-negative integer $n, where
 * $descendantSelectorNode is the node for descendantSelector and
 * $ancestorSelectorNode is the node for ancestorSelector.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface DescendantNodeJoinConditionInterface extends JoinConditionInterface
{
    /**
     * Gets the name of the descendant selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getDescendantSelectorName();

    /**
     * Gets the name of the ancestor selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getAncestorSelectorName();
}
