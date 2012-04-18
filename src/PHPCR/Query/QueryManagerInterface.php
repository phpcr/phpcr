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
 * This interface encapsulates methods for the management of search queries.
 *
 * Provides methods for the creation and retrieval of search queries.
 *
 * @package phpcr
 * @subpackage interfaces
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
     * @param string $statement The query statement to be executed.
     * @param string $language The language of the query to be created.
     *
     * @return \PHPCR\Query\QueryInterface a Query object
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query statement is
     *      syntactically invalid or the specified language is not supported
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function createQuery($statement, $language);

    /**
     * Returns a QueryObjectModelFactory with which a JCR-JQOM query can be
     * built programmatically.
     *
     * @return \PHPCR\Query\QOM\QueryObjectModelFactoryInterface a
     *      QueryObjectModelFactory object
     *
     * @api
     */
    function getQOMFactory();

    /**
     * Retrieves an existing persistent query.
     *
     * Persistent queries are created by first using
     * QueryManagerInterface::createQuery() to create a Query object and then
     * calling QueryInterface::save() to persist the query to a location in the
     * workspace.
     *
     * @param \PHPCR\NodeInterface $node a persisted query (that is, a node of
     *      type nt:query).
     *
     * @return \PHPCR\Query\QueryInterface a Query object.
     *
     * @throws \PHPCR\Query\InvalidQueryException If node is not a valid
     *      persisted query (that is, a node of type nt:query).
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getQuery($node);

    /**
     * Returns an array of strings representing all query languages supported
     * by this repository.
     *
     * This set must include at least the strings represented by the constants
     * QueryInterface::JCR_SQL2 and QueryInterface::JCR_JQOM. An implementation
     * may also support other languages including the deprecated languages of
     * JCR 1.0: QueryInterface::XPATH and QueryInterface::SQL.
     *
     * @return array A list of supported languages by the query.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getSupportedQueryLanguages();
}
