<?php

namespace PHPCR\Query\QOM;

/**
 * Tests whether two nodes are "the same" according to
 * \PHPCR\ItemInterface::isSame()
 *
 * If selector2Path is omitted:
 *  Tests whether the selector1 node is the same as the selector2 node.
 *  A node-tuple satisfies the constraint only if:
 *   <code>$selector1Node->isSame($selector2Node)</code>
 *  would return true, where $selector1Node is the node for selector1 and
 *  $selector2Node is the node for selector2.
 *
 * Otherwise, if selector2Path is specified:
 *  Tests whether the selector1 node is the same as a node identified by
 *  relative path from the selector2 node. A node-tuple satisfies the
 *  constraint only if:
 *   <code>$selector1Node->isSame($selector2Node->getNode($selector2Path))</code>
 *  would return true, where $selector1Node is the node for selector1 and
 *  $selector2Node is the node for selector2.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface SameNodeJoinConditionInterface extends JoinConditionInterface
{
    /**
     * Gets the name of the first selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelector1Name();

    /**
     * Gets the name of the second selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelector2Name();

    /**
     * Gets the path relative to the second selector.
     *
     * @return string|null the relative path, or null if no path specified
     *
     * @api
     */
    public function getSelector2Path();
}
