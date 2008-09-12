<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR;

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
 * @version $Id$
 */

/**
 * Allows easy iteration through a list of Propertys with nextProperty as
 * well as a skip method.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface PropertyIteratorInterface extends F3::PHPCR::RangeIteratorInterface {

	/**
	 * Returns the next Property from the iterator.
	 *
	 * @return F3::PHPCR::PropertyInterface
	 * @throws OutOfBoundsException if the iterator contains no more elements.
	 */
	public function nextProperty();

}

?>