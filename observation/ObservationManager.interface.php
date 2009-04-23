<?php
// $Id: ObservationManager.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link ObservationManager} which is part of the PHP Content 
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
 * The ObservationManager object.
 *
 * Acquired via {@link Workspace::getObservationManager()}.
 * Allows for the registration and deregistration of observation listeners.
 *
 * @package phpContentRepository
 * @package Events
 */
interface phpCR_ObservationManager 
{
	/**
	 * Adds an event listener that listens for the specified $eventTypes (a
	 * combination of one or more event types encoded as a bit mask value).
	 *
	 * The set of events can be filtered by specifying restrictions based on 
	 * characteristics of the node associated with the event. In the case of 
	 * event types {@link Event::NODE_ADDED} and {@link Event::NODE_REMOVED},
	 * the node associated with an event is the node at (or formerly at) the 
	 * path returned by {@link Event.getPath()}.  In the case of event types 
	 * {@link Event::PROPERTY_ADDED}, {@link Event::PROPERTY_REMOVED} and
	 * {@link Event::PROPERTY_CHANGED}, the node associated with an event is 
	 * the parent node of the property at (or formerly at) the path returned by
	 * {@link Event.getPath()}:
	 * <ul>
	 *    <li>
	 *	      <i>$absPath</i>, <i>$isDeep</i>: Only events whose 
	 *        associated node is at <i>$absPath</i> (or within its 
	 *        subtree, if <i>isDeep</i> is <i>true</i>) will be
	 *        received.  It is permissible to register a listener for a path 
	 *        where no node currently exists.
	 *    </li>
	 *    <li>
	 *	      <i>$uuid</i>: Only events whose associated node has one of
	 *        the UUIDs in this list will be received.  If his parameter is
	 *        NULL then no UUID-related restriction is placed on events 
	 *        received.
	 *    </li>
	 *    <li>
	 * 	      <i>$nodeTypeName</i>: Only events whose associated node 
	 *        has one of the node types (or a subtype of one of the node types)
	 *        in this list will be received. If his parameter is NULL then no 
	 *        node type-related restriction is placed on events received.
	 *    </li>
	 * </ul>
	 *
	 * The restrictions are "ANDed" together. In other words, for a particular 
	 * node to be "listened to" it must meet all the restrictions.
	 *
	 * Additionally, if <i>$noLocal</i> is TRUE, then events generated 
	 * by the session through which the listener was registered are ignored. 
	 * Otherwise, they are not ignored.
	 *
	 * The filters of an already-registered {@link EventListener} can be
	 * changed at runtime by re-registering the same {@link EventListener}
	 * object (i.e. the same actual Java object) with a new set of filter
	 * arguments.  The implementation must ensure that no events are lost
	 * during the changeover.
	 *
	 * @param object
	 *	an {@link EventListener} object.
	 * @param int 
	 *	A combination of one or more event type constants encoded as a bitmask.
	 * @param string 
	 *	An absolute path.
	 * @param boolean
	 * @param array
	 *	Array of UUIDs.
	 * @param array
	 *	Array of node type names.
	 * @param boolean
	 *
	 * @throws {@link RepositoryException}
	 *	If an error occurs.
	 */
	public function addEventListener(
		EventListener $listener, 
		$eventTypes, 
		$absPath,
		$isDeep,
		$uuid, 
		$nodeTypeName, 
		$noLocal);	
	
	/**
	 * Deregisters an observation listener.
	 *
	 * A listener may be deregistered while it is being executed. The
	 * deregistration method will block until the listener has completed
	 * executing. An exception to this rule is a listener which deregisters
	 * itself from within the {@link Event::onEvent()} method. In this case, the
	 * deregistration method returns immediately, but deregistration will
	 * effectively be delayed until the listener completes.
	 *
	 * @param object
	 *   The {@link EventListener} to unregister.
	 *
	 * @throws {@link RepositoryException} 
	 *   If an error occurs.
	 */
	public function removeEventListener(EventListener $listener);
	
	
	/**
	 * Returns all event listeners that have been registered through this session.
	 * If no listeners have been registered, an empty iterator is returned.
	 *
	 * @return object
	 *	A {@link EventListenerIterator} object.
	 * @throws {@link RepositoryException}
	 *	If an error occurs
	 */
	public function getRegisteredEventListeners();
}

?>