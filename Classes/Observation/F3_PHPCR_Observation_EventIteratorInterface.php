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
 * Allows easy iteration through a list of Events with nextEvent as well as a
 * skip method inherited from RangeIterator.
 *
 * @package PHPCR
 * @subpackage Observation
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface EventIteratorInterface extends F3::PHPCR::RangeIteratorInterface {

	/**
	 * Returns the next Event in the iteration.
	 *
	 * @return F3::PHPCR::Observation::EventInterface the next Event in the iteration
	 * @throws OutOfBoundsException if iteration has no more Events
	 */
	public function nextEvent();

	/**
	 * Returns the date associated with this event iterator, or null.
	 * The date is required to be non-null for event iterators obtained through
	 * an EventJournal.
	 *
	 * @return DateTime the date associated with this event iterator, or null.
	 */
	public function getDate();

}

?>