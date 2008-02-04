<?php
// $Id: EventListener.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link EventListener} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170,  
 * and is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 * @package Events
 */


/**
 * An event listener.
 *
 * An {@link EventListener} can be registered via the {@link ObservationManager}
 * object. 
 *
 * Event listeners are notified asynchronously, and see events after they occur 
 * and the transaction is committed.  An event listener only sees events for 
 * which the {@link Session} that registered it has sufficient access rights.
 *
 * @package phpContentRepository
 * @package Events
 */
interface phpCR_EventListener 
{
	/**
	 * Gets called when an event occurs.
	 *
	 * @param {@Link EventIterator}
	 */
	public function onEvent(EventIterator $events);
}

?>