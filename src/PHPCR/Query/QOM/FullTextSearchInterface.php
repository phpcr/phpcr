<?php

namespace PHPCR\Query\QOM;

/**
 * Performs a full-text search.
 *
 * The full-text search expression is evaluated against the set of full-text
 * indexed properties within the full-text search scope. If property is
 * specified, the full-text search scope is the property of that name on the
 * selector node in the node-tuple; otherwise the full-text search scope is all
 * properties of the selector node (or, in some implementations, all properties
 * in the node subgraph).
 *
 * Which properties (if any) in a repository are full-text indexed is
 * implementation determined.
 *
 * It is also implementation determined whether fullTextSearchExpression is
 * independently evaluated against each full-text indexed property in the
 * full-text search scope, or collectively evaluated against the set of such
 * properties using some implementation-determined mechanism.
 *
 * Similarly, for multi-valued properties, it is implementation determined
 * whether fullTextSearchExpression is independently evaluated against each
 * element in the array of values, or collectively evaluated against the array
 * of values using some implementation-determined mechanism.
 *
 * At minimum, an implementation must support the following
 * fullTextSearchExpression grammar:
 *
 * - fullTextSearchExpression ::= [-]term {whitespace [OR] whitespace [-]term}
 * - term ::= word | '"' word {whitespace word} '"'
 * - word ::= (A string containing no whitespace)
 * - whitespace ::= (A string of only whitespace)
 *
 * A query satisfies a FullTextSearch constraint if the value (or values) of the
 * full-text indexed properties within the full-text search scope satisfy the
 * specified fullTextSearchExpression, evaluated as follows:
 *
 * - A term not preceded with "-" (minus sign) is satisfied only if the value
 *      contains that term.
 * - A term preceded with "-" (minus sign) is satisfied only if the value does
 *      not contain that term.
 * - Terms separated by whitespace are implicitly "ANDed".
 * - Terms separated by "OR" are "ORed".
 * - "AND" has higher precedence than "OR".
 * - Within a term, each double quote ("), "-" (minus sign), and "\"
 *      (backslash) must be escaped by a preceding "\" (backslash).
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface FullTextSearchInterface extends ConstraintInterface
{
    /**
     * Gets the name of the selector against which to apply this constraint.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelectorName();

    /**
     * Gets the name of the property.
     *
     * @return string|null the property name if the full-text search scope is a
     *      property, otherwise null if the full-text search scope is the node
     *      (or node subgraph, in some implementations).
     *
     * @api
     */
    public function getPropertyName();

    /**
     * Gets the full-text search expression.
     *
     * @return StaticOperandInterface the full-text search expression
     *
     * @api
     */
    public function getFullTextSearchExpression();
}
