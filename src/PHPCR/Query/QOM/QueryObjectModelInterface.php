<?php

namespace PHPCR\Query\QOM;

/**
 * A query in the JCR/PHPCR query object model.
 *
 * The JCR query object model describes the queries that can be evaluated by a
 * JCR repository independent of any particular query language, such as SQL.
 *
 * A query consists of:
 *
 * - a source. When the query is evaluated, the source evaluates its selectors
 *   and the joins between them to produce a (possibly empty) set of
 *   node-tuples. This is a set of 1-tuples if the query has one selector (and
 *   therefore no joins), a set of 2-tuples if the query has two selectors (and
 *   therefore one join), a set of 3-tuples if the query has three selectors
 *   (two joins), and so forth.
 * - an optional constraint. When the query is evaluated, the constraint
 *   filters the set of node-tuples.
 * - a list of zero or more orderings. The orderings specify the order in which
 *   the node-tuples appear in the query results. The relative order of two
 *   node-tuples is determined by evaluating the specified orderings, in list
 *   order, until encountering an ordering for which one node-tuple precedes the
 *   other. If no orderings are specified, or if for none of the specified
 *   orderings does one node-tuple precede the other, then the relative order
 *   of the node-tuples is implementation determined (and may be arbitrary).
 * - a list of zero or more columns to include in the tabular view of the query
 *   results. If no columns are specified, the columns available in the tabular
 *   view are implementation determined, but minimally include, for each
 *   selector, a column for each single-valued non-residual property of the
 *   selector's node type.
 *
 * The query object model representation of a query is created by factory
 * methods in the QueryObjectModelFactory.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface QueryObjectModelInterface extends \PHPCR\Query\QueryInterface
{
    /**
     * Gets the node-tuple source for this query.
     *
     * @return SourceInterface the node-tuple source
     *
     * @api
    */
    public function getSource();

    /**
     * Gets the constraint for this query.
     *
     * @return ConstraintInterface|null the constraint, or null if there is no
     *      constraint
     *
     * @api
    */
    public function getConstraint();

    /**
     * Gets the orderings for this query.
     *
     * @return OrderingInterface[] an array of the orderings. If no orderings
     *      defined an empty array is returned.
     *
     * @api
    */
    public function getOrderings();

    /**
     * Gets the columns for this query.
     *
     * @return ColumnInterface[] an array of the columns to get. If none
     *      specified an empty array is returned.
     *
     * @api
    */
    public function getColumns();
}
