<?php

namespace PHPCR\Query\QOM;

/**
 * Defines constants used in the query object model.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
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
