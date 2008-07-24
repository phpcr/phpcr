<?php
declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 */

/**
 * A QueryResult object. Returned by Query->execute().
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_Query_QueryResultInterface {

	/**
	 * Returns an array of all the column names in the table view of this result set.
	 *
	 * @return array
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function getColumnNames();

	/**
	 * Returns an iterator over the Rows of the result table. The rows are
	 * returned according to the ordering specified in the query.
	 *
	 * @return F3_PHPCR_Query_RowIteratorInterface a RowIterator
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	*/
	public function getRows();

	/**
	 * Returns an iterator over all nodes that match the query. The rows are
	 * returned according to the ordering specified in the query.
	 *
	 * @return F3_PHPCR_NodeIteratorInterface a NodeIterator
	 * @throws F3_PHPCR_RepositoryException if the query contains more than one selector or if another error occurs.
	 */
	public function getNodes();

}
?>