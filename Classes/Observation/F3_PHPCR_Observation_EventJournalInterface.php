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
 * An EventJournal is an extension of EventIterator that provides the additional
 * method skipTo(\DateTime):.
 *
 * @package PHPCR
 * @subpackage Observation
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface EventJournalInterface extends \F3\PHPCR\Observation\EventIteratorInterface {

	/**
	 * Skip all elements of the iterator earlier than date.
	 * If an attempt is made to skip past the last element of the iterator, no
	 * exception is thrown but the subsequent EventIterator.nextEvent() will fail.
	 *
	 * @param \DateTime $date - a Calendar object
	 * @return void
	 */
	public function skipTo(\DateTime $date);

}

?>