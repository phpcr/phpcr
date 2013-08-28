<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to the value (or values, if multi-valued) of a property.
 *
 * If, for a node-tuple, the selector node does not have a property named
 * property, the operand evaluates to null.
 *
 * The query is invalid if:
 *
 * - selector is not the name of a selector in the query
 * - property is not a syntactically valid JCR name
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface PropertyValueInterface extends DynamicOperandInterface
{
    /**
     * Gets the name of the selector against which to evaluate this operand.
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
