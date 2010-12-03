<?php
/**
 * Interface to describe the contract to implement a query class.
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
 * A Query object.
 *
 * <b>PHPCR Note:</b> Instead of the dropped ValueInterface, bindValue uses native php variables
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface QueryInterface {

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

    /**#@-*/

    /**
     * Binds the given value to the variable named $varName.
     *
     * @param string $varName name of variable in query
     * @param mixed $value value to bind
     * @return void
     *
     * @throws \InvalidArgumentException if $varName is not a valid variable in this query.
     * @throws RepositoryException if an error occurs.
     * @api
     */
    public function bindValue($varName, $value);

    /**
     * Executes this query and returns a QueryResult object.
     *
     * @return \PHPCR\Query\QueryInterface a QueryResult object
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query contains an unbound variable.
     * @throws \PHPCR\RepositoryException if an error occurs
     * @api
     */
    public function execute();

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
    public function getBindVariableNames();

    /**
     * Sets the maximum size of the result set to limit.
     *
     * @param integer $limit The amount of result items to be fetched.
     * @return void
     * @api
     */
    public function setLimit($limit);

    /**
     * Sets the start offset of the result set to offset.
     *
     * @param integer $offset The start point of the result set from when the item shall be fetched.
     * @return void
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
     * @api
     */
    public function getStatement();

    /**
     * Returns the language set for this query.
     *
     * This will be one of the query language constants returned by
     * QueryManager.getSupportedQueryLanguages().
     *
     * @return string The query language.
     * @api
     */
    public function getLanguage();

    /**
     * Fetches the path of the node representing this query.
     *
     * If this is a Query object that has been stored using storeAsNode(java.lang.String)
     * (regardless of whether it has been saved yet) or retrieved using
     * QueryManager.getQuery(javax.jcr.Node)), then this method returns the path
     * of the nt:query node that stores the query.
     *
     * @return string Path of the node representing this query.
     *
     * @throws \PHPCR\ItemNotFoundException if this query is not a stored query.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function getStoredQueryPath();

    /**
     * Creates a node of type nt:query holding this query at $absPath and
     * returns that node.
     *
     * This is  a session-write method and therefore requires a
     * Session.save() to dispatch the change.
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
    public function storeAsNode($absPath);

}
