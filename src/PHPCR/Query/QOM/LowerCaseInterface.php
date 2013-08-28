<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to the lower-case string value (or values, if multi-valued) of
 * operand.
 *
 * If operand does not evaluate to a string value, its value is first converted
 * to a string.
 *
 * If operand evaluates to null, the LowerCase operand also evaluates to null.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface LowerCaseInterface extends DynamicOperandInterface
{
    /**
     * Gets the operand whose value is converted to a lower-case string.
     *
     * @return DynamicOperandInterface the operand
     *
     * @api
     */
    public function getOperand();
}
