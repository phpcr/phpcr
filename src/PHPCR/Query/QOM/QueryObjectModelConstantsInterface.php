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
 * Defines constants used in the query object model.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface QueryObjectModelConstantsInterface
{
    /**#@+
     * @var string
     */

    /**
     * An inner join.
     * @api
    */
    const JCR_JOIN_TYPE_INNER = '{http://www.jcp.org/jcr/1.0}joinTypeInner';

    /**
     * A left-outer join.
     * @api
    */
    const JCR_JOIN_TYPE_LEFT_OUTER = '{http://www.jcp.org/jcr/1.0}joinTypeLeftOuter';

    /**
     * A right-outer join.
     * @api
    */
    const JCR_JOIN_TYPE_RIGHT_OUTER = '{http://www.jcp.org/jcr/1.0}joinTypeRightOuter';

    /**
     * The '=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_EQUAL_TO = '{http://www.jcp.org/jcr/1.0}operatorEqualTo';

    /**
     * The '!=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_NOT_EQUAL_TO = '{http://www.jcp.org/jcr/1.0}operatorNotEqualTo';

    /**
     * The '<' comparison operator.
     * @api
    */
    const JCR_OPERATOR_LESS_THAN = '{http://www.jcp.org/jcr/1.0}operatorLessThan';

    /**
     * The '<=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_LESS_THAN_OR_EQUAL_TO = '{http://www.jcp.org/jcr/1.0}operatorLessThanOrEqualTo';

    /**
     * The '>' comparison operator.
     * @api
    */
    const JCR_OPERATOR_GREATER_THAN = '{http://www.jcp.org/jcr/1.0}operatorGreaterThan';

    /**
     * The '>=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_GREATER_THAN_OR_EQUAL_TO = '{http://www.jcp.org/jcr/1.0}operatorGreaterThanOrEqualTo';

    /**
     * The 'like' comparison operator.
     * @api
    */
    const JCR_OPERATOR_LIKE = '{http://www.jcp.org/jcr/1.0}operatorLike';

    /**
     * Ascending order.
     * @api
    */
    const JCR_ORDER_ASCENDING = '{http://www.jcp.org/jcr/1.0}orderAscending';

    /**
     * Descending order.
     * @api
    */
    const JCR_ORDER_DESCENDING = '{http://www.jcp.org/jcr/1.0}orderDescending';

    /**#@-*/
}
