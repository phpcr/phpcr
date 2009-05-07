<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Query\QOM;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 */

/**
 * Determines the relative order of two node-tuples by evaluating operand for
 * each.
 *
 * For a first node-tuple, nt1, for which operand evaluates to v1, and a second
 * node-tuple, nt2, for which operand evaluates to v2:
 *
 * If order is Ascending, then:
 *  if either v1 is null, v2 is null, or both v1 and v2 are null, the relative order of nt1 and nt2 is implementation determined, otherwise
 *  if v1 is a different property type than v2, the relative order of nt1 and nt2 is implementation determined, otherwise
 *  if v1 is ordered before v2, then nt1 precedes nt2, otherwise
 *  if v1 is ordered after v2, then nt2 precedes nt1, otherwise
 *  the relative order of nt1 and nt2 is implementation determined and may be arbitrary.
 *
 * Otherwise, if order is Descending, then:
 *  if either v1 is null, v2 is null, or both v1 and v2 are null, the relative order of nt1 and nt2 is implementation determined, otherwise
 *  if v1 is a different property type than v2, the relative order of nt1 and nt2 is implementation determined, otherwise
 *  if v1 is ordered before v2, then nt2 precedes nt1, otherwise
 *  if v1 is ordered after v2, then nt1 precedes nt2, otherwise
 *  the relative order of nt1 and nt2 is implementation determined and may be arbitrary.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface OrderingInterface {

	/**
	 * The operand by which to order.
	 *
	 * @return \F3\PHPCR\Query\QOM\DynamicOperandInterface the operand; non-null
	 */
	public function getOperand();

	/**
	 * Gets the order.
	 *
	 * @return string either QueryObjectModelConstants.JCR_ORDER_ASCENDING or QueryObjectModelConstants.JCR_ORDER_DESCENDING
	 */
	public function getOrder();

}

?>