<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to the upper-case string value (or values, if multi-valued) of
 * operand.
 *
 * If operand does not evaluate to a string value, its value is first converted
 * to a string.
 *
 * If operand evaluates to null, the UpperCase operand also evaluates to null.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface UpperCaseInterface extends DynamicOperandInterface
{
    /**
     * Gets the operand whose value is converted to a upper-case string.
     *
     * @return DynamicOperandInterface the operand
     *
     * @api
     */
    public function getOperand();
}
