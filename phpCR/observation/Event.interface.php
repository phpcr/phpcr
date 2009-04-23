<?php
// $Id: Event.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link Event} which is part of the PHP Content 
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
 * An event fired by the observation mechanism. 
 *
 * Also includes constants representing the  event types defined by the 
 * phpCR/JCR standard. Each constant is a power of 2 so that sets of event 
 * types can be encoded as a bitmask in a <i>int</i> value.
 *
 * @see ObservationManager
 *
 * @package phpContentRepository
 * @package Events
 */
interface phpCR_Event 
{
	/**
	 * An event of this type is generated when a node is added.
	 */
	const NODE_ADDED = 1;
	
	 
	/**
	 * An event of this type is generated when a node is removed.
	 */
	const NODE_REMOVED = 2;

	/**
	 * An event of this type is generated when a property is added.
	 */
	const PROPERTY_ADDED = 4;

	/**
	 * An event of this type is generated when a property is removed.
	 */
	const PROPERTY_REMOVED = 8;

	/**
	 * An event of this type is generated when a property is changed.
	 */
	const PROPERTY_CHANGED = 16;


	/**
	 * Returns the type of this event. One of:
	 * <ul>
	 *   <li>{@link NODE_ADDED}</li>
	 *   <li>{@link NODE_REMOVED}</li>
	 *   <li>{@link PROPERTY_ADDED}</li>
	 *   <li>{@link PROPERTY_REMOVED}</li>
	 *   <li>{@link PROPERTY_CHANGED}</li>
	 * </ul>
	 *
	 * @return int
	 */
	public function getType();
	
	
	/**
	 * Returns the absolute path of the parent node connected with this event.
	 *
	 * The interpretation given to the returned path depends upon the type of 
	 * the event:
	 * <ul>
	 *    <li>
	 *        If the event type is {@link NODE_ADDED} then this method returns
	 *        the absolute path of the {@link Node} that was added.
	 *    </li>
	 *    <li>
	 *        If the event type is {@link NODE_REMOVED} then this method returns 
	 *        the absolute path of the {@link Node} that was removed.
	 *    </li>
	 *    <li>
	 *        If the event type is {@link PROPERTY_ADDED} then this method
	 *        returns the absolute path of the {@link Property} that was added.
	 *    </li>
	 *    <li>
	 *        If the event type is {@link PROPERTY_REMOVED} then this method 
	 *        returns the absolute path of the {@link Property} that was removed.
	 *    </li>
	 *    <li>
	 *        If the event type is {@link PROPERTY_CHANGED} then this method 
	 *        returns the absolute path of the changed {@link Property}.
	 *    </li>
	 * </ul>
	 *
	 * @return string
	 * @throws {@link RepositoryException}
	 *	If an error occurs.
	 */
	public function getPath();

	/**
	 * Returns the user ID connected with this event. 
	 *
	 * This is the string returned by getUserID of the session that caused the
	 * event.
	 *
	 * @see {Session::getUserID()}
	 * @return string
	 */
	public function getUserID();
}

?>