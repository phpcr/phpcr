<?php

namespace PHPCR\Query\QOM;

/**
 * Tests whether the childSelector node is a child of the parentSelector node.
 *
 * A node-tuple satisfies the constraint only if:
 *  <code>$childSelectorNode->getParent()->isSame($parentSelectorNode)</code>
 * would return true, where $childSelectorNode is the node for childSelector
 * and $parentSelectorNode is the node for parentSelector.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface ChildNodeJoinConditionInterface extends JoinConditionInterface
{
    /**
     * Gets the name of the child selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getChildSelectorName();

    /**
     * Gets the name of the parent selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getParentSelectorName();
}
