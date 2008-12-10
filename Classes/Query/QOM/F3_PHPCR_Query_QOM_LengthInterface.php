<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Query\QOM;

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
 * Evaluates to the length (or lengths, if multi-valued) of a property.
 *
 * The length should be computed as though the getLength method (or getLengths,
 * if multi-valued) of \F3\PHPCR\PropertyInterface were called.
 *
 * If propertyValue evaluates to null, the Length operand also evaluates to null.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface LengthInterface extends \F3\PHPCR\Query\QOM\DynamicOperandInterface {

	/**
	 * Gets the property value for which to compute the length.
	 *
	 * @return \F3\PHPCR\Query\QOM\PropertyValueInterface the property value; non-null
	 */
	public function getPropertyValue();

}

?>