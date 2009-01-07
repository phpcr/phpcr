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
 * A query in the JCR query object model.
 *
 * The JCR query object model describes the queries that can be evaluated by a JCR
 * repository independent of any particular query language, such as SQL.
 *
 * A query consists of:
 *
 * a source. When the query is evaluated, the source evaluates its selectors and
 * the joins between them to produce a (possibly empty) set of node-tuples. This
 * is a set of 1-tuples if the query has one selector (and therefore no joins), a
 * set of 2-tuples if the query has two selectors (and therefore one join), a set
 * of 3-tuples if the query has three selectors (two joins), and so forth.
 * an optional constraint. When the query is evaluated, the constraint filters the
 * set of node-tuples.
 * a list of zero or more orderings. The orderings specify the order in which the
 * node-tuples appear in the query results. The relative order of two node-tuples
 * is determined by evaluating the specified orderings, in list order, until
 * encountering an ordering for which one node-tuple precedes the other. If no
 * orderings are specified, or if for none of the specified orderings does one
 * node-tuple precede the other, then the relative order of the node-tuples is
 * implementation determined (and may be arbitrary).
 * a list of zero or more columns to include in the tabular view of the query
 * results. If no columns are specified, the columns available in the tabular view
 * are implementation determined, but minimally include, for each selector, a column
 * for each single-valued non-residual property of the selector's node type.
 *
 * The query object model representation of a query is created by factory methods in the QueryObjectModelFactory.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface QueryObjectModelInterface extends \F3\PHPCR\Query\PreparedQueryInterface {

	/**
	 * Gets the node-tuple source for this query.
	 *
	 * @return \F3\PHPCR\Query\QOM\SourceInterface the node-tuple source; non-null
	*/
	public function getSource();

	/**
	 * Gets the constraint for this query.
	 *
	 * @return \F3\PHPCR\Query\QOM\ConstraintInterface the constraint, or null if none
	*/
	public function getConstraint();

	/**
	 * Gets the orderings for this query.
	 *
	 * @return array an array of zero or more \F3\PHPCR\Query\QOM\OrderingInterface; non-null
	*/
	public function getOrderings();

	/**
	 * Gets the columns for this query.
	 *
	 * @return array an array of zero or more \F3\PHPCR\Query\QOM\ColumnInterface; non-null
	*/
	public function getColumns();

}

?>