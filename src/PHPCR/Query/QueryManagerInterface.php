<?php
/**
 * Interface to describe the contract for an implementation of a query manager.
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
namespace PHPCR;

/**
 * This interface encapsulates methods for the management of search queries.
 *
 * Provides methods for the creation and retrieval of search queries.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface QueryManagerInterface {

    /**
     * Creates a new query by specifying the query statement itself and the language
     * in which the query is stated.
     *
     * The $language must be a string from among
     * those returned by QueryManager.getSupportedQueryLanguages().
     *
     * @param string $statement The query statement to be executed.
     * @param string $language The language of the query to be created.
     * @return \PHPCR\Query\QueryInterface a Query object
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query statement is syntactically invalid or the specified language is not supported
     * @throws \PHPCR\RepositoryException if another error occurs
     * @api
     */
    public function createQuery($statement, $language);

    /**
     * Returns a QueryObjectModelFactory with which a JCR-JQOM query can be built
     * programmatically.
     *
     * @return \PHPCR\Query\QOM\QueryObjectModelFactoryInterface a QueryObjectModelFactory object
     * @api
     */
    public function getQOMFactory();

    /**
     * Retrieves an existing persistent query.
     *
     * Persistent queries are created by first using QueryManager.createQuery to
     * create a Query object and then calling Query.save to persist the query to
     * a location in the workspace.
     *
     * @param \PHPCR\NodeInterface $node a persisted query (that is, a node of type nt:query).
     * @return \PHPCR\Query\QueryInterface a Query object.
     *
     * @throws \PHPCR\Query\InvalidQueryException If node is not a valid persisted query (that is, a node of type nt:query).
     * @throws \PHPCR\RepositoryException if another error occurs
     * @api
     */
    public function getQuery($node);

    /**
     * Returns an array of strings representing all query languages supported by
     * this repository.
     *
     * This set must include at least the strings represented
     * by the constants Query.JCR_SQL2 and Query.JCR_JQOM. An implementation may
     * also support other languages.
     *
     * @return array A list of supported languages by the query.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getSupportedQueryLanguages();

}
