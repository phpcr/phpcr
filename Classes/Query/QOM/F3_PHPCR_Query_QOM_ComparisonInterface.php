<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Query\QOM;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 */

/**
 * Filters node-tuples based on the outcome of a binary operation.
 *
 * For any comparison, operand2 always evaluates to a scalar value. In contrast,
 * operand1 may evaluate to an array of values (for example, the value of a multi-valued
 * property), in which case the comparison is separately performed for each element
 * of the array, and the Comparison constraint is satisfied as a whole if the
 * comparison against any element of the array is satisfied.
 *
 * If operand1 and operand2 evaluate to values of different property types, the
 * value of operand2 is converted to the property type of the value of operand1.
 * If the type conversion fails, the query is invalid.
 *
 * Certain operators may only be applied to values of certain property types. The
 * following describes required operator support for each property type:
 *
 * STRING
 * EqualTo, NotEqualTo, LessThan, LessThanOrEqualTo, GreaterThan, GreaterThanOrEqualTo, Like
 * BINARY
 * None
 * DATE, LONG, DOUBLE, DECIMAL
 * EqualTo, NotEqualTo, LessThan, LessThanOrEqualTo, GreaterThan, GreaterThanOrEqualTo
 * BOOLEAN, NAME, PATH, REFERENCE, WEAKREFERENCE, URI
 * EqualTo, NotEqualTo
 *
 * If operator is not supported for the property type of operand1, the query is invalid.
 *
 * If operand1 evaluates to null (for example, if the operand evaluates the value
 * of a property which does not exist), the constraint is not satisfied.
 *
 * The EqualTo operator is satisfied only if the value of operand1 equals the value
 * of operand2.
 *
 * The NotEqualTo operator is satisfied unless the value of operand1 equals the
 * value of operand2.
 *
 * The LessThan operator is satisfied only if the value of operand1 is ordered before
 * the value of operand2.
 *
 * The LessThanOrEqualTo operator is satisfied unless the value of operand1 is
 * ordered after the value of operand2.
 *
 * The GreaterThan operator is satisfied only if the value of operand1 is ordered
 * after the value of operand2.
 *
 * The GreaterThanOrEqualTo operator is satisfied unless the value of operand1 is
 * ordered before the value of operand2.
 *
 * The Like operator is satisfied only if the value of operand1 matches the pattern
 * specified by the value of operand2, where in the pattern:
 *
 * the character "%" matches zero or more characters, and
 * the character "_" (underscore) matches exactly one character, and
 * the string "\x" matches the character "x", and
 * all other characters match themselves.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface ComparisonInterface extends \F3\PHPCR\Query\QOM\ConstraintInterface {

	/**
	 *
	 * Gets the first operand.
	 *
	 * @return \F3\PHPCR\Query\QOM\DynamicOperandInterface the operand; non-null
	 */
	public function getOperand1();

	/**
	 * Gets the operator.
	 *
	 * @return integer one of \F3\PHPCR\Query\QOM\QueryObjectModelConstantsInterface.OPERATOR_*
	 */
	public function getOperator();

	/**
	 * Gets the second operand.
	 *
	 * @return \F3\PHPCR\Query\QOM\StaticOperandInterface the operand; non-null
	 */
	public function getOperand2();

}

?>