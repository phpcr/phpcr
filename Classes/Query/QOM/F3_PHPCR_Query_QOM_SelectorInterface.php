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
 * Selects a subset of the nodes in the repository based on node type.
*
* A selector selects every node in the repository, subject to access control constraints, that satisfies at least one of the following conditions:
*
* the node's primary node type is nodeType, or
* the node's primary node type is a subtype of nodeType, or
* the node has a mixin node type that is nodeType, or
* the node has a mixin node type that is a subtype of nodeType.
*
* The query is invalid if nodeType or selectorName is not a syntactically valid JCR name.
*
* The query is invalid if selectorName is identical to the selectorName of another selector in the query.
*
* If nodeType is a valid JCR name but not the name of a node type available in the repository, the query is valid but the selector selects no nodes.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_Query_QOM_SelectorInterface extends F3_PHPCR_Query_QOM_SourceInterface {

	/**
	 * Gets the name of the required node type.
	 *
	 * @return string the node type name; non-null
	 */
	public function getNodeTypeName();

	/**
	 * Gets the selector name.
	 * A selector's name can be used elsewhere in the query to identify the selector.
	 *
	 * @return the selector name; non-null
	 */
	public function getSelectorName();

}

?>