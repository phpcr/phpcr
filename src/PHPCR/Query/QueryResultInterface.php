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

namespace PHPCR\Query;

/**
 * A QueryResult object. Returned by Query->execute().
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. QueryResults have to implement either \RecursiveIterator or
 * \Iterator.
 * The iterator is equivalent to <b>getRows()</b> returning a list of the rows.
 * The iterator keys have no significant meaning.
 * Note: We use getRows and not getNodes as this is more generic. If you have a
 * single selector, you can either do foreach on getNodes or call getNode on the
 * rows.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface QueryResultInterface extends \Traversable
{
    /**
     * Returns an array of all the column names in the table view of this result set.
     *
     * @return array A list holding the column names.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    function getColumnNames();

    /**
     * Returns an iterator over the Rows of the result table.
     *
     * The rows are returned according to the ordering specified in the query.
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Keys are the row position in this result set, Values are the RowInterface instances.
     * @throws \PHPCR\RepositoryException if this call is the second time either getRows() or getNodes()
     *                                    has been called on the same QueryResult object or if another error occurs.
     * @api
    */
    function getRows();

    /**
     * Returns an iterator over all nodes that match the query.
     *
     * The nodes are returned according to the ordering specified in the query.
     *
     * @param  bool|int $prefetch If to prefetch or not
     *                              int < 0/true means all, 0/false means none, int > 0 means the prefetch chunk size or none
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Keys are the paths, Values the given Node instances.
     *
     * @throws \PHPCR\RepositoryException if the query contains more than one selector, if this call is
     *                                    the second time either getRows() or getNodes() has been called on the
     *                                    same QueryResult object or if another error occurs.
     * @api
     */
    function getNodes($prefetch = false);

    /**
     * Returns an array of all the selector names that were used in the query
     * that created this result.
     *
     * If the query did not have a selector name then an empty array is returned.
     *
     * @return array A String array holding the selector names.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    function getSelectorNames();
}
