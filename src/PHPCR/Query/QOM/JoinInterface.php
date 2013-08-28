<?php

namespace PHPCR\Query\QOM;

/**
 * Performs a join between two node-tuple sources.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface JoinInterface extends SourceInterface
{
    /**
     * Gets the left node-tuple source.
     *
     * @return SourceInterface the left source
     *
     * @api
     */
    public function getLeft();

    /**
     * Gets the right node-tuple source.
     *
     * @return SourceInterface the right source
     *
     * @api
     */
    public function getRight();

    /**
     * Gets the join type.
     *
     * @return string one of QueryObjectModelConstants.JCR_JOIN_TYPE_*
     *
     * @api
     */
    public function getJoinType();

    /**
     * Gets the join condition.
     *
     * @return JoinConditionInterface the join condition
     *
     * @api
     */
    public function getJoinCondition();
}
