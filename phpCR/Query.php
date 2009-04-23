<?php
// $Id: Query.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link Query} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170, and is
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *    Version 2.0
 * @package phpContentRepository
 * @package Query
 */

/**
 * A {@link Query} object.
 *
 * @package phpContentRepository
 * @package Query
 */
interface phpCR_Query
{
	/**
	 * A String constant representing the XPath query language applied to the
	 * <i>document view</i> XML mapping of the workspace.
	 *
	 * This language must be supported in level 1 repositories.
	 *
	 * Used when defining a query using {@link QueryManager::createQuery()}.
	 * Also among the strings returned by
	 * {@link QueryManager::getSupportedQueryLanguages()}.
	 *
	 * @var string
	 */
	const XPATH = "xpath";

	/**
	 * A String constant representing the SQL query language applied to the
	 * <i>database view</i> of the workspace.
	 *
	 * This language is optional.
	 *
	 * Used when defining a query using {@link QueryManager::createQuery()}.
	 * Also among the strings returned by
	 * {@link QueryManager::getSupportedQueryLanguages()}.
	 *
	 * @var string
	 */
	const SQL = "sql";


	/**
	 * Executes this query and returns a {@link QueryResult}.
	 *
	 * @return phpCR_QueryResult
	 *	A {@link QueryResult} object
	 * @throws {@link RepositoryException}
	 *	If an error occurs
	 */
	public function execute();


	/**
	 * Returns the statement set for this query.
	 *
	 * @return string
	 */
	public function getStatement();


	/**
	 * Returns the language set for this query.
	 *
	 * This will be one of the query language constants returned by
	 * {@link QueryManager::getSupportedQueryLanguages()}.
	 *
	 * @see QueryLanguage
	 * @return int
	 */
	public function getLanguage();


	/**
	 * Returns the node path of this query if it has been stored as a node via
	 * {@link storeAsNode()}.
	 *
	 * If this is a {@link Query} object that has been stored using
	 * {@link Query::storeAsNode()} (regardless of whether it has been
	 * {@link Item::save()}d yet) or retrieved using
	 * {@link QueryManager::getQuery()}), then this method returns the path of
	 * the <i>nt:query</i> {@link Node} that stores the query.
	 *
	 * If this is a transient query (that is, a {@link Query} object created
	 * with {@link QueryManager::createQuery()} but not yet stored) then this
	 * method throws an {@link ItemNotFoundException}.
	 *
	 * @return string
	 *	Path of the {@link Node} representing this query.
	 *
	 * @throws {@link ItemNotFoundException}
	 *	If this query is not a stored query.
	 * @throws {@link RepositoryException}
	 *	If another error occurs.
	 */
	public function getStoredQueryPath();


	/**
	 * Creates a node representing this {@link Query} in content.
	 *
	 * In a level 1 repository this method throws an
	 * {@link UnsupportedRepositoryOperationException}.
	 *
	 * In a level 2 repository it creates a {@link Node} of type
	 * <i>nt:query</i> at <i>$absPath</i> and returns that
	 * {@link Node}.
	 *
	 * In order to persist the newly created node, a {@link Item::save()} must be
	 * performed that includes <i>the parent</i> of this new node within its
	 * scope. In other words, either a {@link Session::save()} or an
	 * {@link Item::save()} on the parent or higher-degree ancestor of
	 * <i>$absPath</i> must be performed.
	 *
	 * @param string
	 *    The absolute path to store this at
	 * @return object
	 *	A {@link Node} object
	 *
	 * @throws {@link ItemExistsException}
	 *    If an item at the specified path already exists, same-name siblings
	 *    are not allowed and this implementation performs this validation
	 *    immediately instead of waiting until {@link Item::save()}.
	 * @throws {@link PathNotFoundException}
	 *    If the specified path implies intermediary {@link Node}s that do not
	 *    exist or the last element of <i>$relPath</i> has an index, and
	 *    this implementation performs this validation immediately instead of
	 *    waiting until {@link Item::save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If a node type or implementation-specific constraint is violated or
	 *    if an attempt is made to add a node as the child of a property and
	 *    this implementation performs this validation immediately instead of
	 *    waiting until {@link Item::save()}.
	 * @throws {@link VersionException}
	 *    If the node to which the new child is being added is versionable and
	 *    checked-in or is non-versionable but its nearest versionable ancestor
	 *    is checked-in and this implementation performs this validation
	 *    immediately instead of waiting until {@link Item::save()}.
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the node and this implementation
	 *    performs this validation immediately instead of waiting until
	 *    {@link Item::save()}.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    In a level 1 implementation.
	 * @throws {@link RepositoryException}
	 *    If another error occurs or if the <i>$relPath</i> provided has
	 *    an index on its final element.
	 */
	public function storeAsNode($absPath);

}

?>