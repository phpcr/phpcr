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
 * An event listener.
 *
 * An EventListener can be registered via the ObservationManager object. Event
 * listeners are notified asynchronously, and see events after they occur and
 * the transaction is committed. An event listener only sees events for which
 * the session that registered it has sufficient access rights.
 *
 * @package PHPCR
 * @subpackage Observation
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface EventListenerInterface {

	/**
	 * This method is called when a bundle of events is dispatched.
	 *
	 * @param \F3\PHPCR\Observation\EventIteratorInterface $events - The event set received.
	 * @return void
	 */
	public function onEvent(\F3\PHPCR\Observation\EventIteratorInterface $events);

}
?>