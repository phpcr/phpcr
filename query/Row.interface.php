<?php
// $Id: Row.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link Row} which is part of the PHP Content 
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
 * A row in the query result table.
 *
 * @package phpContentRepository
 * @package Query
 */
interface phpCR_Row
{
	/**
	 * Returns an array of all the values in the same order as the column names 
	 * returned by {@link QueryResult::getColumnNames()}.
	 *
	 * @return array
	 *
	 * @throws {@link RepositoryException}
	 *   If an error occurs
	 */
	public function getValues();
	
	
	/**
	 * Returns the value of the indicated  property in this {@link Row}.
	 *
	 * @return object
	 *	A {@link Value} object
	 * @throws {@link ItemNotFoundException}
	 *    If <i>$propertyName</i> s not among the column names of the 
	 *    query result table.
	 * @throws {@link RepositoryException}
	 *   If another error occurs
	 */
	public function getValue($propertyName);
}

?>