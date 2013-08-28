<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to a DOUBLE value equal to the full-text search score of a node.
 *
 * Full-text search score ranks a selector's nodes by their relevance to the
 * fullTextSearchExpression specified in a FullTextSearch. The values to which
 * FullTextSearchScore evaluates and the interpretation of those values are
 * implementation specific. FullTextSearchScore may evaluate to a constant value
 * in a repository that does not support full-text search scoring or has no
 * full-text indexed properties.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface FullTextSearchScoreInterface extends DynamicOperandInterface
{
    /**
     * Gets the name of the selector against which to evaluate this operand.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelectorName();
}
