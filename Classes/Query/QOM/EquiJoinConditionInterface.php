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
 * Tests whether the value of a property in a first selector is equal to the
 * value of a property in a second selector.
 *
 * A node-tuple satisfies the constraint only if:
 *  selector1 has a property named property1, and
 *  selector2 has a property named property2, and
 *  the value of property1 equals the value of property2
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface EquiJoinConditionInterface extends \F3\PHPCR\Query\QOM\JoinConditionInterface {

	/**
	 * Gets the name of the first selector.
	 *
	 * @return string the selector name; non-null
	 */
	public function getSelector1Name();

	/**
	 * Gets the property name in the first selector.
	 *
	 * @return string the property name; non-null
	 */
	public function getProperty1Name();

	/**
	 * Gets the name of the second selector.
	 *
	 * @return string the selector name; non-null
	 */
	public function getSelector2Name();

	/**
	 * Gets the property name in the second selector.
	 *
	 * @return string the property name; non-null
	 */
	public function getProperty2Name();

}

?>