<?php

namespace PHPCR\Query;

use PHPCR\ItemNotFoundException;
use PHPCR\NodeInterface;
use PHPCR\RepositoryException;
use Traversable;

/**
 * A row in the query result table.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. Rows have to implement either \RecursiveIterator or
 * \Iterator.
 * The iterator is similar to <b>getValues()</b> with keys being the column
 * names and the values the corresponding entry in that column for this row.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface RowInterface extends Traversable
{
    /**
     * Returns an array of all the values in the same order as the column names
     * returned by QueryResultInterface::getColumnNames().
     *
     * @return array Hashmap of column name to value of each column of the
     *      current result row.
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function getValues();

    /**
     * Returns the value of the indicated column in this Row.
     *
     * @param string $columnName name of query result table column
     *
     * @return mixed The value of the given column of the current result row.
     *
     * @throws ItemNotFoundException if columnName s not among the
     *      column names of the query result table.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getValue($columnName);

    /**
     * Returns the Node corresponding to this Row and the specified selector,
     * if given.
     *
     * @param string $selectorName The selector identifying a node within the
     *      current result row.
     *
     * @return NodeInterface|null The result node or null on incomplete outer joins.
     *
     * @throws RepositoryException If selectorName is not the alias of a
     *      selector in this query or if another error occurs.
     *
     * @api
     */
    public function getNode($selectorName = null);

    /**
     * Get the path of a node identified by a selector.
     *
     * Equivalent to $row->getNode($selectorName)->getPath(). However, some
     * implementations may be able gain efficiency by not resolving the actual
     * Node.
     *
     * @param string $selectorName The selector identifying a node within the
     *      current result row.
     *
     * @return string|null The path representing the node identified by the given
     *      selector or null on incomplete outer joins.
     *
     * @throws RepositoryException if selectorName is not the alias of a
     *      selector in this query or if another error occurs.
     *
     * @api
     */
    public function getPath($selectorName = null);

    /**
     * Returns the full text search score for this row associated with the
     * specified selector.
     *
     * This corresponds to the score of a particular node.
     *
     * - If no selectorName is given, the default selector is used.
     * - If no FullTextSearchScore AQM object is associated with the selector
     *   selectorName, this method will still return a value. However, in that
     *   case the returned value may not be meaningful or may simply reflect
     *   the minimum possible relevance level (for example, in some systems
     *   this might be a score of 0).
     *
     * Note, in JCR-SQL2 a FullTextSearchScore AQM object is represented by a
     * SCORE() function. In JCR-JQOM it is represented by a PHP object of type
     * \PHPCR\Query\QOM\FullTextSearchScoreInterface.
     *
     * @param string $selectorName The selector identifying a node within the
     *      current result row.
     *
     * @return float The full text search score for this row.
     *
     * @throws RepositoryException if selectorName is not the alias of a
     *      selector in this query or (in case of no given selectorName) if
     *      this query has more than one selector (and therefore, this Row
     *      corresponds to more than one Node) or if another error occurs.
     *
     * @api
     */
    public function getScore($selectorName = null);
}
