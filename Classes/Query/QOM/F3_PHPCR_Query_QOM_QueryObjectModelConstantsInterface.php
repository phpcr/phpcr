<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Query\QOM;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 */

/**
 * Defines constants used in the query object model.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface QueryObjectModelConstantsInterface {

	/**
	 * Join types
	 */
	const JOIN_TYPE_INNER = 101;
	const JOIN_TYPE_LEFT_OUTER = 102;
	const JOIN_TYPE_RIGHT_OUTER = 103;

	/**
	 * Operators
	 */
	const OPERATOR_EQUAL_TO = 201;
	const OPERATOR_GREATER_THAN = 205;
	const OPERATOR_GREATER_THAN_OR_EQUAL_TO = 206;
	const OPERATOR_LESS_THAN = 203;
	const OPERATOR_LESS_THAN_OR_EQUAL_TO = 204;
	const OPERATOR_LIKE = 207;
	const OPERATOR_NOT_EQUAL_TO = 202;

	/**
	 * Ordering
	 */
	const ORDER_ASCENDING = 301;
	const ORDER_DESCENDING = 302;

}

?>