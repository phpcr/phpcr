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
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface FullTextSearchInterface extends ConstraintInterface
{
    /**
     * Gets the name of the selector against which to apply this constraint.
     *
     * @return string the selector name; non-null
     *
     * @api
     */
    function getSelectorName();

    /**
     * Gets the name of the property.
     *
     * @return string the property name if the full-text search scope is a
     *      property, otherwise null if the full-text search scope is the node
     *      (or node subgraph, in some implementations).
     *
     * @api
     */
    function getPropertyName();

    /**
     * Gets the full-text search expression.
     *
     * @return \PHPCR\Query\QOM\StaticOperandInterface the full-text search
     *      expression; non-null
     *
     * @api
     */
    function getFullTextSearchExpression();
}
