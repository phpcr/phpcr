<?php
/**
 * Interface to describe the contract for an implementation of a query result row class.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */


declare(ENCODING = 'utf-8');
namespace PHPCR\Query;

/**
 * A row in the query result table.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. Rows have to implement either \RecursiveIterator or
 * \Iterator.
 * The iterator is similar to <b>getValues()</b> with keys being the column
 * names and the values the corresponding entry in that column for this row.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface RowInterface extends \Traversable {

    /**
     * Returns an array of all the values in the same order as the column names
     * returned by QueryResult.getColumnNames().
     *
     * @return array List of values of each column of the current result row.
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    public function getValues();

    /**
     * Returns the value of the indicated column in this Row.
     *
     * @param string $columnName name of query result table column
     * @return mixed The value of the given column of the current result row.
     *
     * @throws \PHPCR\ItemNotFoundException if columnName s not among the column names of the query result table.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function getValue($columnName);

    /**
     * Returns the Node corresponding to this Row and the specified selector, if given.
     *
     * @param string $selectorName The selector identifying a node within the current result row.
     * @return \PHPCR\NodeInterface a Node
     *
     * @throws \PHPCR\RepositoryException If selectorName is not the alias of a selector in this query or if
     *                                    another error occurs.
     * @api
     */
    public function getNode($selectorName = null);

    /**
     * Get the path of a node identified by a selector.
     *
     * Equivalent to Row.getNode(selectorName).getPath(). However, some
     * implementations may be able gain efficiency by not resolving the actual Node.
     *
     * @param string $selectorName The selector identifying a node within the current result row.
     * @return string The path representing the node identified by the given selector.
     *
     * @throws \PHPCR\RepositoryException if selectorName is not the alias of a selector in this query or
     *                                    if another error occurs.
     * @api
     */
    public function getPath($selectorName = null);

    /**
     * Returns the full text search score for this row associated with the specified
     * selector.
     *
     * This corresponds to the score of a particular node.
     * If no selectorName is given, the default selector is used.
     * If no FullTextSearchScore AQM object is associated with the selector
     * selectorName this method will still return a value. However, in that case
     * the returned value may not be meaningful or may simply reflect the minimum
     * possible relevance level (for example, in some systems this might be a s
     * core of 0).
     *
     * Note, in JCR-SQL2 a FullTextSearchScore AQM object is represented by a
     * SCORE() function. In JCR-JQOM it is represented by a Java object of type
     * \PHPCR\Query\QOM\FullTextSearchScoreInterface.
     *
     * @param string $selectorName The selector identifying a node within the current result row.
     * @return float The full text search score for this row.
     *
     * @throws \PHPCR\RepositoryException if selectorName is not the alias of a selector in this query or
     *                                    (in case of no given selectorName) if this query has more than one
     *                                    selector (and therefore, this Row corresponds to more than one Node)
     *                                    or if another error occurs.
     * @api
     */
    public function getScore($selectorName = null);

}
