<?php

namespace PHPCR\Query\QOM;

/**
 * Tests the existence of a property.
 *
 * A node-tuple satisfies the constraint if the selector node has a property
 * named property.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface PropertyExistenceInterface extends ConstraintInterface
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
     * Gets the name of the property.
     *
     * @return string the property name
     *
     * @api
     */
    public function getPropertyName();
}
