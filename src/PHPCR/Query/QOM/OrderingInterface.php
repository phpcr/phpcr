<?php

namespace PHPCR\Query\QOM;

/**
 * Determines the relative order of two node-tuples by evaluating operand for
 * each.
 *
 * For a first node-tuple, nt1, for which operand evaluates to v1, and a second
 * node-tuple, nt2, for which operand evaluates to v2:
 *
 * If order is Ascending, then:
 *
 * - if either v1 is null, v2 is null, or both v1 and v2 are null, the relative
 *   order of nt1 and nt2 isimplementation determined, otherwise
 * - if v1 is a different property type than v2, the relative order of nt1 and
 *   nt2 is implementation determined, otherwise
 * - if v1 is ordered before v2, then nt1 precedes nt2, otherwise
 * - if v1 is ordered after v2, then nt2 precedes nt1, otherwise
 *   the relative order of nt1 and nt2 is implementation determined and may be
 *   arbitrary.
 *
 * Otherwise, if order is Descending, then:
 *
 * - if either v1 is null, v2 is null, or both v1 and v2 are null, the relative
 *   order of nt1 and nt2 is implementation determined, otherwise
 * - if v1 is a different property type than v2, the relative order of nt1 and
 *   nt2 is implementation determined, otherwise
 * - if v1 is ordered before v2, then nt2 precedes nt1, otherwise
 * - if v1 is ordered after v2, then nt1 precedes nt2, otherwise
 *   the relative order of nt1 and nt2 is implementation determined and may be
 *   arbitrary.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface OrderingInterface
{
    /**
     * The operand by which to order.
     *
     * @return DynamicOperandInterface the operand
     *
     * @api
     */
    public function getOperand();

    /**
     * Gets the order.
     *
     * @return string either QueryObjectModelConstants.JCR_ORDER_ASCENDING or
     *      QueryObjectModelConstants.JCR_ORDER_DESCENDING
     *
     * @api
     */
    public function getOrder();
}
