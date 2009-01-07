<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Query;

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
 * This interface encapsulates methods for the management of search queries.
 * Provides methods for the creation and retrieval of search queries.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface QueryManagerInterface {

	/**
	 * Creates a new query by specifying the query statement itself and the language
	 * in which the query is stated.
	 *
	 * @param string $statement
	 * @param string $language
	 * @return \F3\PHPCR\Query\QueryInterface a Query object
	 * @throws \F3\PHPCR\Query\InvalidQueryException if the query statement is syntactically invalid or the specified language is not supported
	 * @throws \F3\PHPCR\RepositoryException if another error occurs
	 */
	public function createQuery($statement, $language);

	/**
	 * Creates a new prepared query by specifying the query statement itself and the language
	 * in which the query is stated.
	 *
	 * @param string $statement
	 * @param string $language
	 * @return \F3\PHPCR\Query\PreparedQueryInterface a PreparedQuery object
	 * @throws \F3\PHPCR\Query\InvalidQueryException if the query statement is syntactically invalid or the specified language is not supported
	 * @throws \F3\PHPCR\RepositoryException if another error occurs
	 */
	public function createPreparedQuery($statement, $language);

	/**
	 * Returns a QueryObjectModelFactory with which a JCR-JQOM query can be built
	 * programmatically.
	 *
	 * @return \F3\PHPCR\Query\QOM\QueryObjectModelFactoryInterface a QueryObjectModelFactory object
	 */
	public function getQOMFactory();

	/*
	 * Retrieves an existing persistent query. If node is not a valid persisted
	 * query (that is, a node of type nt:query), an InvalidQueryException is thrown.
	 * Persistent queries are created by first using QueryManager.createQuery to
	 * create a Query object and then calling Query.save to persist the query to
	 * a location in the workspace.
	 *
	 * @param \F3\PHPCR\NodeInterface $node a persisted query (that is, a node of type nt:query).
	 * @return \F3\PHPCR\Query\QueryInterface a Query object.
	 * @throws \F3\PHPCR\Query\InvalidQueryException If node is not a valid persisted query (that is, a node of type nt:query).
	 * @throws \F3\PHPCR\RepositoryException if another error occurs
	 */
	public function getQuery($node);

	/**
	 * Returns an array of strings representing all query languages supported by
	 * this repository. In level 1 this set must include the strings represented
	 * by the constants Query.JCR_SQL2 and Query.JCR_JQOM. An implementation of
	 * either level may also support other languages.
	 *
	 * @return array A string array.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
	 */
	public function getSupportedQueryLanguages();

}

?>