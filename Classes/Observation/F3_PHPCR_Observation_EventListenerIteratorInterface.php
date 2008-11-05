<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR::Observation;

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
 * @subpackage Observation
 * @version $Id$
 */

/**
 * Allows easy iteration through a list of EventListeners with nextEventListener
 * as well as a skip method inherited from RangeIterator.
 *
 * @package PHPCR
 * @subpackage Observation
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface EventListenerIteratorInterface extends F3::PHPCR::RangeIteratorInterface {

	/**
	 * Returns the next EventListener in the iteration.
	 *
	 * @return F3::PHPCR::Observation::EventListenerInterface the next EventListener in the iteration
	 * @throws OutOfBoundsException if iteration has no more EventListeners
	 */
	public function nextEventListener();

}

?>