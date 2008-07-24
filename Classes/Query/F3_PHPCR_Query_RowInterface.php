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
 * A row in the query result table.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_Query_RowInterface {

	/**
	 * Returns an array of all the values in the same order as the column names
	 * returned by QueryResult.getColumnNames().
	 *
	 * @return array a Value array.
	 * @throws F3_PHPCR_RepositoryException if an error occurs
	 */
	public function getValues();

	/**
	 * Returns the value of the indicated column in this Row.
	 *
	 * @param string $columnName name of query result table column
	 * @return F3_PHPCR_ValueInterface a Value
	 * @throws F3_PHPCR_ItemNotFoundException if columnName s not among the column names of the query result table.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function getValue($columnName);

	/**
	 * Returns the Node corresponding to this Row and the specified selector,
	 * if given.
	 *
	 * @param string $selectorName
	 * @return F3_PHPCR_NodeInterface a Node
	 * @throws F3_PHPCR_RepositoryException if selectorName is not the alias of a selector in this query or if another error occurs.
	 */
	public function getNode($selectorName = NULL);

	/**
	 * Equivalent to Row.getNode(selectorName).getPath(). However, some
	 * implementations may be able gain efficiency by not resolving the actual Node.
	 *
	 * @param string $selectorName
	 * @return string
	 * @throws F3_PHPCR_RepositoryException if selectorName is not the alias of a selector in this query or if another error occurs.
	 */
	public function getPath($selectorName = NULL);

	/**
	 * Returns the full text search score for this row associated with the specified
	 * selector. This corresponds to the score of a particular node.
	 * If no selectorName is given, the default selector is used.
	 * If no FullTextSearchScore AQM object is associated with the selector
	 * selectorName this method will still return a value. However, in that case
	 * the returned value may not be meaningful or may simply reflect the minimum
	 * possible relevance level (for example, in some systems this might be a s
	 * core of 0).
	 *
	 * Note, in JCR-SQL2 a FullTextSearchScore AQM object is represented by a
	 * SCORE() function. In JCR-JQOM it is represented by a Java object of type
	 * F3_PHPCR_Query_QOM_FullTextSearchScoreInterface.
	 *
	 * @param string $selectorName
	 * @return float
	 * @throws F3_PHPCR_RepositoryException if selectorName is not the alias of a selector in this query or (in case of no given selectorName) if this query has more than one selector (and therefore, this Row corresponds to more than one Node) or if another error occurs.
	 */
	public function getScore($selectorName = NULL);

}
?>