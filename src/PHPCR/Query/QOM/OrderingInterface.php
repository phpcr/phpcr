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
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface OrderingInterface
{
    /**
     * The operand by which to order.
     *
     * @return \PHPCR\Query\QOM\DynamicOperandInterface the operand; non-null
     * @api
     */
    function getOperand();

    /**
     * Gets the order.
     *
     * @return string either QueryObjectModelConstants.JCR_ORDER_ASCENDING or
     *      QueryObjectModelConstants.JCR_ORDER_DESCENDING
     * @api
     */
    function getOrder();
}
