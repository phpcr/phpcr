<?php
// $Id: QueryManager.interface.php 412 2005-08-16 01:19:58Z tswicegood $

/**
 * This file contains {@link QueryManager} which is part of the PHP Content
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170, and
 * is licensed under the Apache License, Version 2.0.
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
 * This interface encapsulates methods for the management of search queries.
 *
 * Provides methods for the creation and retrieval of search queries.
 *
 * @package phpContentRepository
 * @package Query
 */
interface phpCR_QueryManager
{
	/**
	 * Creates a new query by specifying the query <i>$statement</i>
	 * itself and the language in which the query is stated.
	 *
	 * If the query <i>$statement</i> is syntactically invalid, given the
	 * language specified, an {@link InvalidQueryException} is thrown.
	 *
	 * <i>$language</i> must specify a query language from among those
	 * returned by {@link getSupportedQueryLanguages()}; if it does
	 * not then an {@link InvalidQueryException} is thrown.
	 *
	 * @param string
	 * @param string
	 * @return phpCR_Query
	 *   A {@link Query} object.
	 *
	 * @throws {@link InvalidQueryException}
	 *   If statement is invalid or language is unsupported.
	 * @throws {@link RepositoryException}
	 *   If another error occurs
	 */
	public function createQuery($statement, $language);


	/**
	 * Retrieves an existing persistent query from a given <i>$node</i>
	 *
	 * If <i>$node</i> is not a valid persisted query (that is, a
	 * {@link Node} of type <i>nt:query</i>), an
	 * {@link InvalidQueryException} is thrown.
	 *
	 * @see Query::storeAsNode()
	 * @param object
	 *	A {@link Node} object
	 * @return object
	 *	A {@link Query} object
	 *
	 * @throws {@link InvalidQueryException}
	 *    If <i>$node</i> is not a valid persisted query (that is, a node
	 *    of type <i>nt:query</i>)
	 * @throws {@link RepositoryException}
	 *   If another error occurs
	 */
	public function getQuery(phpCR_Node $node);


	/**
	 * Returns an array of strings representing all query languages supported
	 * by this repository.
	 *
	 * In level 1 this set must include the string represented by the
	 * constant {@link Query::XPATH}.  If SQL is supported it must additionally
	 * include the string represented by the constant {@link Query::SQL()}.
	 *
	 * An implementation may also support other languages as well.
	 *
	 * @return array
	 * @throws {@link RepositoryException}
	 *   If an error occurs
	 */
	public function getSupportedQueryLanguages();
}

?>