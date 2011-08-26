<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

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
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface ComparisonInterface extends ConstraintInterface
{
    /**
     *
     * Gets the first operand.
     *
     * @return \PHPCR\Query\QOM\DynamicOperandInterface the operand; non-null
     *
     * @api
     */
    function getOperand1();

    /**
     * Gets the operator.
     *
     * @return string one of
     *      \PHPCR\Query\QOM\QueryObjectModelConstantsInterface.JCR_OPERATOR_*
     *
     * @api
     */
    function getOperator();

    /**
     * Gets the second operand.
     *
     * @return \PHPCR\Query\QOM\StaticOperandInterface the operand; non-null
     *
     * @api
     */
    function getOperand2();
}
