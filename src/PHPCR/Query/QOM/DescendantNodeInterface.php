<?php

namespace PHPCR\Query\QOM;

/**
 * Tests whether the selector node is a descendant of a node reachable by
 * absolute path path.
 *
 * A node-tuple satisfies the constraint only if:
 *
 *   <code>$selectorNode->getAncestor($n)->isSame(session->getNode($path)) && $selectorNode->getDepth() > $n</code>
 *
 * would return true for some non-negative integer n, where selectorNode is the
 * node for the specified selector.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface DescendantNodeInterface extends ConstraintInterface
{
    /**
     * Gets the name of the selector against which to apply this constraint.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelectorName();

    /**
     * Gets the absolute path.
     *
     * @return string the path
     *
     * @api
     */
    public function getAncestorPath();
}
