<?php
/**
 * Interface to describe the contract to implement a lowercase class.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */


declare(ENCODING = 'utf-8');
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
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface LowerCaseInterface extends DynamicOperandInterface {

    /**
     * Gets the operand whose value is converted to a lower-case string.
     *
     * @return \PHPCR\Query\QOM\DynamicOperandInterface the operand; non-null
     * @api
     */
    public function getOperand();

}
