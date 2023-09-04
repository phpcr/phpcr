<?php

namespace PHPCR\Query;

use Iterator;
use PHPCR\NodeInterface;
use PHPCR\RepositoryException;
use Traversable;

/**
 * A QueryResult object. Returned by Query->execute().
 *
 * The Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. QueryResults have to implement either \RecursiveIterator or
 * \Iterator.
 * The iterator is equivalent to <b>getRows()</b> returning a list of the rows.
 * The iterator keys have no significant meaning.
 * Note: We use getRows and not getNodes as this is more generic. If you have a
 * single selector, you can either do foreach on getNodes or call getNode on the
 * rows.
 *
 * @extends Traversable<RowInterface>
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface QueryResultInterface extends \Traversable
{
    /**
     * Returns an array of all the column names in the table view of this result set.
     *
     * @return string[]
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function getColumnNames();

    /**
     * Returns an iterator over the Rows of the result table.
     *
     * The rows are returned according to the ordering specified in the query.
     *
     * @return \Iterator<RowInterface> implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                                 Keys are the row position in this result set
     *
     * @throws RepositoryException if this call is the second time either getRows() or getNodes()
     *                             has been called on the same QueryResult object or if another error occurs
     *
     * @api
     */
    public function getRows();

    /**
     * Returns an iterator over all nodes that match the query.
     *
     * The nodes are returned according to the ordering specified in the query.
     *
     * @param bool|int $prefetch Whether to prefetch or not. int < 0/true means all,
     *                           0/false means none, int > 0 means the prefetch chunk size or none
     *
     * @return \Iterator<string, NodeInterface> implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                                          Keys are the paths.
     *
     * @throws RepositoryException if the query contains more than one selector, if this call is
     *                             the second time either getRows() or getNodes() has been called on the
     *                             same QueryResult object or if another error occurs
     *
     * @api
     */
    public function getNodes($prefetch = false);

    /**
     * Returns an array of all the selector names that were used in the query
     * that created this result.
     *
     * If the query did not have a selector name then an empty array is returned.
     *
     * @return string[]
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function getSelectorNames();
}
