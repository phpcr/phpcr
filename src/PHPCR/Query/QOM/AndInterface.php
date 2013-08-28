<?php

namespace PHPCR\Query\QOM;

/**
 * Performs a logical conjunction of two other constraints.
 *
 * To satisfy the And constraint, a node-tuple must satisfy both constraint1 and
 * constraint2.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface AndInterface extends ConstraintInterface
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
