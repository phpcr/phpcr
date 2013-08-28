<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to the length (or lengths, if multi-valued) of a property.
 *
 * The length should be computed as though the getLength method of
 * \PHPCR\PropertyInterface were called.
 *
 * If propertyValue evaluates to null, the Length operand also evaluates to null.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface LengthInterface extends DynamicOperandInterface
{
    /**
     * Gets the property value for which to compute the length.
     *
     * @return PropertyValueInterface the property value
     *
     * @api
     */
    public function getPropertyValue();
}
