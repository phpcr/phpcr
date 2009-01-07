<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Observation;

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
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface EventIteratorInterface extends \F3\PHPCR\RangeIteratorInterface {

	/**
	 * Returns the next Event in the iteration.
	 *
	 * @return \F3\PHPCR\Observation\EventInterface the next Event in the iteration
	 * @throws OutOfBoundsException if iteration has no more Events
	 */
	public function nextEvent();

	/**
	 * Returns the date associated with this event iterator, or null.
	 * The date is required to be non-null for event iterators obtained through
	 * an EventJournal.
	 *
	 * @return \DateTime the date associated with this event iterator, or null.
	 */
	public function getDate();

}

?>