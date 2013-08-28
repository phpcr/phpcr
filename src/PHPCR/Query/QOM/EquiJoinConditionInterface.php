<?php

namespace PHPCR\Query\QOM;

/**
 * Tests whether the value of a property in a first selector is equal to the
 * value of a property in a second selector.
 *
 * A node-tuple satisfies the constraint only if:
 *  selector1 has a property named property1, and
 *  selector2 has a property named property2, and
 *  the value of property1 equals the value of property2
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface EquiJoinConditionInterface extends JoinConditionInterface
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
     * Gets the property name in the first selector.
     *
     * @return string the property name
     *
     * @api
     */
    public function getProperty1Name();

    /**
     * Gets the name of the second selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelector2Name();

    /**
     * Gets the property name in the second selector.
     *
     * @return string the property name
     *
     * @api
     */
    public function getProperty2Name();
}
