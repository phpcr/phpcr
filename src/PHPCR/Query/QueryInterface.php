<?php

namespace PHPCR\Query;

/**
 * A Query object.
 *
 * <b>PHPCR Note:</b> Instead of the dropped ValueInterface, bindValue uses native php variables
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
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
     * @param mixed  $value   value to bind
     *
     * @throws \InvalidArgumentException  if $varName is not a valid variable in this query.
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function bindValue($varName, $value);

    /**
     * Executes this query and returns a QueryResult object.
     *
     * @return QueryResultInterface a QueryResult object
     *
     * @throws InvalidQueryException      if the query contains an unbound variable.
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function execute();

    /**
     * This method is used from another thread to halt a currently executing
     * query.
     *
     * This method returns immediately with a boolean return value indicating
     * whether the query <i>will</i> or <i>will not</i> be cancelled. The
     * actual cancellation may take place after the method has returned and
     * will do so by throwing a RepositoryException on the thread where
     * $query->execute() is currently blocking.
     *
     * @return boolean true if the query was executing and will be cancelled,
     *      or false if the query cannot not be cancelled because it has either
     *      already finished executing, it has already been cancelled, or the
     *      implementation does not support canceling queries.
     *
     * @since JCR 2.1
     */
    public function cancel();

    /**
     * Returns the names of the bind variables in this query.
     *
     * If this query does not contains any bind variables then an empty array is returned.
     *
     * @return array the names of the bind variables in this query.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getBindVariableNames();

    /**
     * Sets the maximum size of the result set to limit.
     *
     * @param integer $limit The amount of result items to be fetched.
     *
     * @api
     */
    public function setLimit($limit);

    /**
     * Sets the start offset of the result set to offset.
     *
     * @param integer $offset The start point of the result set from when the item shall be fetched.
     *
     * @api
     */
    public function setOffset($offset);

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
     *
     * @api
     */
    public function getStatement();

    /**
     * Returns the language set for this query.
     *
     * This will be one of the query language constants returned by
     * QueryManagerInterface::getSupportedQueryLanguages().
     *
     * @return string The query language.
     *
     * @api
     */
    public function getLanguage();

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
     * @throws \PHPCR\RepositoryException   if another error occurs.
     *
     * @api
     */
    public function getStoredQueryPath();

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
     *
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
     * @throws \PHPCR\RepositoryException                     if another error occurs or if the absPath provided has an index on its final
     *                                    element.
     * @api
     */
    public function storeAsNode($absPath);
}
