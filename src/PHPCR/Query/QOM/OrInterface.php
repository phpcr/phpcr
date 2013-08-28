<?php

namespace PHPCR\Query\QOM;

/**
 * Performs a logical disjunction of two other constraints.
 *
 * To satisfy the Or constraint, the node-tuple must either:
 *
 * - satisfy constraint1 but not constraint2, or
 * - satisfy constraint2 but not constraint1, or
 * - satisfy both constraint1 and constraint2.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface OrInterface extends ConstraintInterface
{
    /**
     * Gets the first constraint.
     *
     * @return ConstraintInterface the constraint
     *
     * @api
     */
    public function getConstraint1();

    /**
     * Gets the second constraint.
     *
     * @return ConstraintInterface the constraint
     *
     * @api
     */
    public function getConstraint2();
}
