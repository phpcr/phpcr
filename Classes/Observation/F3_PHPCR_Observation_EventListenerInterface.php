<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Observation;

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
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
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