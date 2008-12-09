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
 * An EventJournal is an extension of EventIterator that provides the additional
 * method skipTo(::DateTime):.
 *
 * @package PHPCR
 * @subpackage Observation
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface EventJournalInterface extends F3::PHPCR::Observation::EventIteratorInterface {

	/**
	 * Skip all elements of the iterator earlier than date.
	 * If an attempt is made to skip past the last element of the iterator, no
	 * exception is thrown but the subsequent EventIterator.nextEvent() will fail.
	 *
	 * @param DateTime $date - a Calendar object
	 * @return void
	 */
	public function skipTo(::DateTime $date);

}

?>