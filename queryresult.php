<?php
// $Id: QueryResult.interface.php 412 2005-08-16 01:19:58Z tswicegood $

/**
 * This file contains {@link QueryResult} which is part of the PHP Content 
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
 * A QueryResult object. Returned in an iterator by {@link Query::execute()}
 *
 * @package phpContentRepository
 * @package Query
 */
interface phpCR_QueryResult 
{
	/**
	 * Returns an array of all the property names (column names) in this 
	 * result set.
	 *
	 * @return array
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getColumnNames();
	
	
	/**
	 * Returns an iterator over the {@link Row}s of the query result table.
	 *
	 * If an <i>ORDER BY</i> clause was specified in the query, then the
	 * order of the returned properties in the iterator will reflect the order
	 * specified in that clause. If no items match, an empty iterator is 
	 * returned.
	 *
	 * @return object
	 *	A {@link RowIterator} object
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getRows();
	
	
	/**
	 * Returns an iterator over all nodes that match the query. 
	 *
	 * If an <i>ORDER BY</i> clause was specified in the query, then the
	 * order of the returned nodes in the iterator will reflect the order 
	 * specified in that clause. If no nodes match, an empty iterator is 
	 * returned.
	 *
	 * @return object
	 *	A {@link NodeIterator} object
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getNodes();
}

?>