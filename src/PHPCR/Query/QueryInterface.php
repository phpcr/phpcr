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
 * A Query object.
 *
 * <b>PHPCR Note:</b> Instead of the dropped ValueInterface, bindValue uses native php variables
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface QueryInterface
{
    /**#@+
     * @var string
     */

    /**
     * A string constant representing the JCR-JQOM query language.
     * @api
     */
    const JCR_JQOM = 'JCR-JQOM';

    /**
     * A string constant representing the JCR-SQL2 query language.
     * @api
     */
    const JCR_SQL2 = 'JCR-SQL2';

    /**
     * A string constant representing the (deprecated in JSR-283) XPATH query language.
     * @api
     */
    const XPATH = 'xpath';

    /**
     * A string constant representing the (deprecated in JSR-283) SQL query language.
     * @api
     */
    const SQL = 'sql';
    /**#@-*/

    /**
     * Binds the given value to the variable named $varName.
     *
     * @param string $varName name of variable in query
     * @param mixed $value value to bind
     * @return void
     *
     * @throws \InvalidArgumentException if $varName is not a valid variable in this query.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    function bindValue($varName, $value);

    /**
     * Executes this query and returns a QueryResult object.
     *
     * @return \PHPCR\Query\QueryResultInterface a QueryResult object
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query contains an unbound variable.
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    function execute();

    /**
     * Returns the names of the bind variables in this query.
     *
     * If this query does not contains any bind variables then an empty array is returned.
     *
     * @return array the names of the bind variables in this query.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    function getBindVariableNames();

    /**
     * Sets the maximum size of the result set to limit.
     *
     * @param integer $limit The amount of result items to be fetched.
     * @return void
     * @api
     */
    function setLimit($limit);

    /**
     * Sets the start offset of the result set to offset.
     *
     * @param integer $offset The start point of the result set from when the item shall be fetched.
     * @return void
     * @api
     */
    function setOffset($offset);

    /**
     * Returns the statement defined for this query.
     *
     * If the language of this query is string-based (like JCR-SQL2), this method
     * will return the statement that was used to create this query.
     *
     * If the language of this query is JCR-JQOM, this method will return the
     * JCR-SQL2 equivalent of the JCR-JQOM object tree.
     *
     * This is the standard serialization of JCR-JQOM and is also the string stored
     * in the jcr:statement property if the query is persisted. See storeAsNode($absPath).
     *
     * @return string The query statement.
     * @api
     */
    function getStatement();

    /**
     * Returns the language set for this query.
     *
     * This will be one of the query language constants returned by
     * QueryManagerInterface::getSupportedQueryLanguages().
     *
     * @return string The query language.
     * @api
     */
    function getLanguage();

    /**
     * Fetches the path of the node representing this query.
     *
     * If this is a Query object that has been stored using QueryInterface::storeAsNode()
     * (regardless of whether it has been saved yet) or retrieved using
     * QueryManagerInterface::getQuery()), then this method returns the path
     * of the nt:query node that stores the query.
     *
     * @return string Path of the node representing this query.
     *
     * @throws \PHPCR\ItemNotFoundException if this query is not a stored query.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    function getStoredQueryPath();

    /**
     * Creates a node of type nt:query holding this query at $absPath and
     * returns that node.
     *
     * This is  a session-write method and therefore requires a
     * SessionInterface::save() to dispatch the change.
     *
     * The $absPath provided must not have an index on its final element. If
     * ordering is supported by the node type of the parent node then the new
     * node is appended to the end of the child node list.
     *
     * @param string $absPath absolute path the query should be stored at
     * @return \PHPCR\NodeInterface the newly created node.
     *
     * @throws \PHPCR\ItemExistsException if an item at the specified path already exists,
     *                                    same-name siblings are not allowed and this implementation performs
     *                                    this validation immediately.
     * @throws \PHPCR\PathNotFoundException if the specified path implies intermediary Nodes that do not exist
     *                                      or the last element of relPath has an index, and this implementation
     *                                      performs this validation immediately.
     * @throws \PHPCR\NodeType\ConstraintViolationException if a node type or implementation-specific constraint
     *                                                      is violated or if an attempt is made to add a node as
     *                                                      the child of a property and this implementation
     *                                                      performs this validation immediately.
     * @throws \PHPCR\Version\VersionException if the node to which the new child is being added is read-only due to
     *                                         a checked-in node and this implementation performs this validation
     *                                         immediately.
     * @throws \PHPCR\Lock\LockException if a lock prevents the addition of the node and this implementation performs
     *                                   this validation immediately instead of waiting until save.
     * @throws \PHPCR\UnsupportedRepositoryOperationException in a level 1 implementation.
     * @throws \PHPCR\RepositoryException if another error occurs or if the absPath provided has an index on its final
     *                                    element.
     * @api
     */
    function storeAsNode($absPath);
}
