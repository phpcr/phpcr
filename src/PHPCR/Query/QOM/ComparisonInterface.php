<?php

namespace PHPCR\Query\QOM;

/**
 * Filters node-tuples based on the outcome of a binary operation.
 *
 * For any comparison, operand2 always evaluates to a scalar value. In
 * contrast, operand1 may evaluate to an array of values (for example, the
 * value of a multi-valued property), in which case the comparison is
 * separately performed for each element of the array, and the Comparison
 * constraint is satisfied as a whole if the comparison against any element of
 * the array is satisfied.
 *
 * If operand1 and operand2 evaluate to values of different property types, the
 * value of operand2 is converted to the property type of the value of operand1.
 * If the type conversion fails, the query is invalid.
 *
 * If operator is not supported for the property type of operand1, the query is
 * invalid.
 *
 * If operand1 evaluates to null (for example, if the operand evaluates the
 * value of a property which does not exist), the constraint is not satisfied.
 *
 * The JCR_OPERATOR_EQUAL_TO operator is satisfied only if the value of
 * operand1 equals the value of operand2.
 *
 * The JCR_OPERATOR_NOT_EQUAL_TO operator is satisfied unless the value of
 * operand1 equals the value of operand2.
 *
 * The JCR_OPERATOR_LESSS_THAN operator is satisfied only if the value of
 * operand1 is ordered before the value of operand2.
 *
 * The JCR_OPERATOR_LESS_THAN_OR_EQUAL_TO operator is satisfied unless the value
 * of operand1 is ordered after the value of operand2.
 *
 * The JCR_OPERATOR_GREATER_THAN operator is satisfied only if the value of
 * operand1 is ordered after the value of operand2.
 *
 * The JCR_OPERATOR_GREATER_THAN_OR_EQUAL_TO operator is satisfied unless the
 * value of operand1 is ordered before the value of operand2.
 *
 * The JCR_OPERATOR_LIKE operator is satisfied only if the value of operand1
 * matches the pattern specified by the value of operand2, where in the pattern:
 *
 * - the character "%" matches zero or more characters, and
 * - the character "_" (underscore) matches exactly one character, and
 * - the string "\x" matches the character "x", and
 * - all other characters match themselves.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface ComparisonInterface extends ConstraintInterface
{
    /**
     * Gets the first operand.
     *
     * @return DynamicOperandInterface the operand
     *
     * @api
     */
    public function getOperand1();

    /**
     * Gets the operator.
     *
     * @return string one of QueryObjectModelConstantsInterface.JCR_OPERATOR_*
     *
     * @api
     */
    public function getOperator();

    /**
     * Gets the second operand.
     *
     * @return StaticOperandInterface the operand
     *
     * @api
     */
    public function getOperand2();
}
