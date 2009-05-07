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
 *  fullTextSearchExpression ::= [-]term {whitespace [OR] whitespace [-]term}
 *  term ::= word | '"' word {whitespace word} '"'
 *  word ::= (A string containing no whitespace)
 *  whitespace ::= (A string of only whitespace)

 * A query satisfies a FullTextSearch constraint if the value (or values) of the
 * full-text indexed properties within the full-text search scope satisfy the
 * specified fullTextSearchExpression, evaluated as follows:
 *
 *  A term not preceded with "-" (minus sign) is satisfied only if the value contains that term.
 *  A term preceded with "-" (minus sign) is satisfied only if the value does not contain that term.
 *  Terms separated by whitespace are implicitly "ANDed".
 *  Terms separated by "OR" are "ORed".
 *  "AND" has higher precedence than "OR".
 *  Within a term, each double quote ("), "-" (minus sign), and "\" (backslash) must be escaped by a preceding "\" (backslash).
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface FullTextSearchInterface extends \F3\PHPCR\Query\QOM\ConstraintInterface {

	/**
	 * Gets the name of the selector against which to apply this constraint.
	 *
	 * @return string the selector name; non-null
	 */
	public function getSelectorName();

	/**
	 * Gets the name of the property.
	 *
	 * @return string the property name if the full-text search scope is a property, otherwise null if the full-text search scope is the node (or node subgraph, in some implementations).
	 */
	public function getPropertyName();

	/**
	 * Gets the full-text search expression.
	 *
	 * @return \F3\PHPCR\Query\QOM\StaticOperandInterface the full-text search expression; non-null
	 */
	public function getFullTextSearchExpression();

}

?>