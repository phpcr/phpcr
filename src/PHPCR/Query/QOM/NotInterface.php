<?php

namespace PHPCR\Query\QOM;

/**
 * Performs a logical negation of another constraint.
 *
 * To satisfy the Not constraint, the node-tuple must not satisfy constraint.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NotInterface extends ConstraintInterface
{
    /**
     * Gets the constraint negated by this Not constraint.
     *
     * @return ConstraintInterface the constraint
     *
     * @api
     */
    public function getConstraint();
}
