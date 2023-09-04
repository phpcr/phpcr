<?php

namespace PHPCR\Query;

use PHPCR\NodeInterface;
use PHPCR\Query\QOM\QueryObjectModelFactoryInterface;
use PHPCR\RepositoryException;

/**
 * This interface encapsulates methods for the management of search queries.
 *
 * Provides methods for the creation and retrieval of search queries.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface QueryManagerInterface
{
    /**
     * Creates a new query by specifying the query statement itself and the
     * language in which the query is stated.
     *
     * The $language must be a string from among those returned by
     * QueryManagerInterface::getSupportedQueryLanguages().
     *
     * @param string $statement the query statement to be executed
     * @param string $language  the language of the query to be created
     *
     * @return QueryInterface a Query object
     *
     * @throws InvalidQueryException if the query statement is syntactically
     *                               invalid or the specified language is not supported
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function createQuery($statement, $language);

    /**
     * Returns a QueryObjectModelFactory with which a JCR-JQOM query can be
     * built programmatically.
     *
     * @return QueryObjectModelFactoryInterface a
     *                                          QueryObjectModelFactory object
     *
     * @api
     */
    public function getQOMFactory();

    /**
     * Retrieves an existing persistent query.
     *
     * Persistent queries are created by first using
     * QueryManagerInterface::createQuery() to create a Query object and then
     * calling QueryInterface::save() to persist the query to a location in the
     * workspace.
     *
     * @param NodeInterface $node a persisted query (that is, a node of
     *                            type nt:query)
     *
     * @return QueryInterface a Query object
     *
     * @throws InvalidQueryException if node is not a valid persisted query
     *                               (that is, a node of type nt:query)
     * @throws RepositoryException   if another error occurs
     *
     * @api
     */
    public function getQuery($node);

    /**
     * Returns an array of strings representing all query languages supported
     * by this repository.
     *
     * This set must include at least the strings represented by the constants
     * QueryInterface::JCR_SQL2 and QueryInterface::JCR_JQOM. An implementation
     * may also support other languages including the deprecated languages of
     * JCR 1.0: QueryInterface::XPATH and QueryInterface::SQL.
     *
     * @return string[]
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function getSupportedQueryLanguages();
}
