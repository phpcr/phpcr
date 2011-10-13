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
    const JCR_JOIN_TYPE_INNER = 'jcr.join.type.inner';

    /**
     * A left-outer join.
     * @api
    */
    const JCR_JOIN_TYPE_LEFT_OUTER = 'jcr.join.type.left.outer';

    /**
     * A right-outer join.
     * @api
    */
    const JCR_JOIN_TYPE_RIGHT_OUTER = 'jcr.join.type.right.outer';

    /**
     * The '=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_EQUAL_TO = 'jcr.operator.equal.to';

    /**
     * The '!=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_NOT_EQUAL_TO = 'jcr.operator.not.equal.to';

    /**
     * The '<' comparison operator.
     * @api
    */
    const JCR_OPERATOR_LESS_THAN = 'jcr.operator.less.than';

    /**
     * The '<=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_LESS_THAN_OR_EQUAL_TO = 'jcr.operator.less.than.or.equal.to';

    /**
     * The '>' comparison operator.
     * @api
    */
    const JCR_OPERATOR_GREATER_THAN = 'jcr.operator.greater.than';

    /**
     * The '>=' comparison operator.
     * @api
    */
    const JCR_OPERATOR_GREATER_THAN_OR_EQUAL_TO = 'jcr.operator.greater.than.or.equal.to';

    /**
     * The 'like' comparison operator.
     * @api
    */
    const JCR_OPERATOR_LIKE = 'jcr.operator.like';

    /**
     * Ascending order.
     * @api
    */
    const JCR_ORDER_ASCENDING = 'jcr.order.ascending';

    /**
     * Descending order.
     * @api
    */
    const JCR_ORDER_DESCENDING = 'jcr.order.descending';

    /**#@-*/
}
