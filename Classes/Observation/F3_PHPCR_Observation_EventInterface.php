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
 * @version $Id:$
 */

/**
 * An event fired by the observation mechanism.
 *
 * An event may be a method event or a state-change event. If this is a method
 * event then getType() will return the constant Event.METHOD_EVENT. If this is
 * a state-change event then getType() will return one of the other int constants
 * defined in this interface.
 *
 * For each state-change event constant, the values returned by the methods
 * getPath(), getIdentifier() are explained.
 *
 * For method events further information about the particular method which
 * caused the event can be acquired through getMethod() and getMethodInfo().
 *
 * The value returned by getUserID() is always the same as that returned by
 * Session.getUserID() of the session that caused the event.
 *
 * @package PHPCR
 * @subpackage Observation
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface EventInterface {

	/**
	 * Generated on persist when a node is added.
	 *  getPath() returns the absolute path of the node that was added.
	 *  getIdentifier() returns the identifier of the node that was added.
	 *  getMethod() and getMethodInfo() both return null.
	 */
	const NODE_ADDED = 1;

	/**
	 * Generated on persist when a node is removed.
	 *  getPath() returns the absolute path of the node that was removed.
	 *  getIdentifier() returns the identifier of the node that was removed.
	 *  getMethod() and getMethodInfo() both return null.
	 */
	const NODE_REMOVED = 2;

	/**
	 * Generated on persist when a property is added.
	 *  getPath() returns the absolute path of the property that was added.
	 *  getIdentifier() returns the identifier of the parent node of the property that was added.
	 *  getMethod() and getMethodInfo() both return null.
	 */
	const PROPERTY_ADDED = 4;

	/**
	 * Generated on persist when a property is removed.
	 *  getPath() returns the absolute path of the property that was removed.
	 *  getIdentifier() returns the identifier of the parent node of the property that was removed.
	 *  getMethod() and getMethodInfo() both return null.
	 */
	const PROPERTY_REMOVED = 8;

	/**
	 * Generated on persist when a property is changed.
	 *  getPath() returns the absolute path of the property that was changed.
	 *  getIdentifier() returns the identifier of the parent node of the property that was changed.
	 *  getMethod() and getMethodInfo() both return null.
	 */
	const PROPERTY_CHANGED = 16;

	/**
	 * Indicates that this event is a method event.
	 *  getPath() If the method that caused this event belongs to an
	 *   Item then getPath returns the path of that
	 *   Item. Otherwise it returns null.
	 *  getIdentifier() If the method that caused this event belongs to a
	 *   Node then getIdentifier returns the identifier of that
	 *   Node. Otherwise it returns null.
	 *  getMethod() returns the string constant representing the method that caused this event.
	 *  getMethodInfo() returns a Map holding the parameters of the method that
	 * caused this event.
	 */
	const METHOD_EVENT = 32;

	const ADD_NODE = 'javax.jcr.observation.Event.ADD_NODE';

	const SET_PROPERTY = 'javax.jcr.observation.Event.SET_PROPERTY';

	const ORDER_BEFORE = 'javax.jcr.observation.Event.ORDER_BEFORE';

	const REMOVE_MIXINS = 'javax.jcr.observation.Event.REMOVE_MIXIN';

	const ADD_MIXIN = 'javax.jcr.observation.Event.ADD_MIXIN';

	const SET_PRIMARY_TYPE = 'javax.jcr.observation.Event.SET_PRIMARY_TYPE';

	const REMOVE = 'javax.jcr.observation.Event.REMOVE';

	const SESSION_MOVE = 'javax.jcr.observation.Event.SESSION_MOVE';

	const SESSION_IMPORT = 'javax.jcr.observation.Event.SESSION_IMPORT';

	const STORE_AS_NODE = 'javax.jcr.observation.Event.STORE_AS_NODE';

	const COPY = 'javax.jcr.observation.Event.COPY';

	const COPY_EXTERNAL = 'javax.jcr.observation.Event.COPY_EXTERNAL';

	const WORKSPACE_MOVE = 'javax.jcr.observation.Event.WORKSPACE_MOVE';

	const UPDATE = 'javax.jcr.observation.Event.UPDATE';

	const CHECKIN = 'javax.jcr.observation.Event.CHECKIN';

	const CHECKOUT = 'javax.jcr.observation.Event.CHECKOUT';

	const MERGE = 'javax.jcr.observation.Event.MERGE';

	const DONE_MERGE = 'javax.jcr.observation.Event.DONE_MERGE';

	const CANCEL_MERGE = 'javax.jcr.observation.Event.CANCEL_MERGE';

	const ADD_VERSION_LABEL = 'javax.jcr.observation.Event.ADD_VERSION_LABEL';

	const REMOVE_VERSION_LABEL = 'javax.jcr.observation.Event.REMOVE_VERSION_LABEL';

	const LOCK = 'javax.jcr.observation.Event.LOCK';

	const UNLOCK = 'javax.jcr.observation.Event.UNLOCK';

	const WORKSPACE_IMPORT = 'javax.jcr.observation.Event.WORKSPACE_IMPORT';

	const CREATE_ACTIVITY = 'javax.jcr.observation.Event.CREATE_ACTIVITY';

	const MERGE_ACTIVITY = 'javax.jcr.observation.Event.MERGE_ACTIVITY';

	const CREATE_CONFIGURATION = 'javax.jcr.observation.Event.CREATE_CONFIGURATION';

	const SET_HOLD = 'javax.jcr.observation.Event.SET_HOLD';

	const REMOVE_HOLD = 'javax.jcr.observation.Event.REMOVE_HOLD';

	const SET_RETENTION_POLICY = 'javax.jcr.observation.Event.SET_RETENTION_POLICY';

	const REMOVE_RETENTION_POLICY = 'javax.jcr.observation.Event.REMOVE_RETENTION_POLICY';

	const REMOVE_VERSION = 'javax.jcr.observation.Event.REMOVE_VERSION';

	const REGISTER_NODE_TYPE = 'javax.jcr.observation.Event.REGISTER_NODE_TYPE';

	const UNREGISTER_NODE_TYPE = 'javax.jcr.observation.Event.UNREGISTER_NODE_TYPE';

	const SET_POLICY = 'javax.jcr.observation.Event.SET_POLICY';

	const DELETE_POLICY = 'javax.jcr.observation.Event.DELETE_POLICY';

	const SET_PRIVILEGES = 'javax.jcr.observation.Event.SET_PRIVILEGES';

	const DELETE_PRIVILEGES = 'javax.jcr.observation.Event.DELETE_PRIVILEGES';

	const PERSIST = 'javax.jcr.observation.Event.PERSIST';

	/**
	 * Returns the type of this event: a constant defined by this interface.
	 * One of:
	 *  NODE_ADDED
	 *  NODE_REMOVED
	 *  PROPERTY_ADDED
	 *  PROPERTY_REMOVED
	 *  PROPERTY_CHANGED
	 *  METHOD_EVENT
	 *
	 * @return integer the type of this event.
	 */
	public function getType();

	/**
	 * Returns the absolute path associated with this event. The meaning of the
	 * associated path depends upon the type of the event.
	 *
	 * @return string the absolute path associated with this event.
	 * @throws F3::PHPCR::RepositoryException - if an error occurs.
	 */
	public function getPath();

	/**
	 * Returns the user ID connected with this event. This is the string returned
	 * by Session.getUserID() of the session that caused the event.
	 *
	 * @return string a String.
	 */
	public function getUserID();

	/**
	 * Returns the identifier associated with this event or null if this event
	 * has no associated identifier. The meaning of the associated identifier
	 * depends upon the type of the event.
	 *
	 * @return string the identifier associated with this event or null if this event has no associated identifier.
	 * @throws F3::PHPCR::RepositoryException - if an error occurs.
	 */
	public function getIdentifier();

	/**
	 * If this is a method event, returns the string constant identify the
	 * method that caused this event.
	 *
	 * @return string
	 * @throws F3::PHPCR::RepositoryException - if an error occurs.
	 */
	public function getMethod();

	/**
	 * If this Event is a state-change event, getMethodInfo returns null.
	 *
	 * If this Event is a method event, getMethodInfo returns a Map holding the
	 * parameters and return value of the method that caused the event.
	 *
	 * For each parameter, an entry is placed in the array where the key, a
	 * string, is the name of the parameter as specified in the Javadoc, and the
	 * value is as follows:
	 *
	 * If the parameter is null then the value is null.
	 * If the parameter is a PHP primitive then the value is that parameter
	 * If the parameter is a Node or Property then the value is the String form
	 *  of the absolute path of that Node or Property under the local namespace
	 *  mapping of the current Session.
	 * If the parameter is another class of object then the value is either that
	 *  object or null. An implementation should only use null in cases where
	 *  keeping the object reference in the Event is impractical for performance
	 *  or other resource-related reasons. For example, an implementation may
	 *  choose to use null for objects of type F3::PHPCR::BinaryInterface.
	 *
	 * In addition to the entries described above:
	 *
	 * For each Node parameter, a second entry is created where the key is the
	 *  name of the parameter as specified in the Javadoc, prefixed with a hash
	 *  character ('#') and the value is the identifier of the Node (a String).
	 *  For example, a Node parameter called "foo" would produce two array
	 *  entries, one with the key "foo" mapped to the path of the node and
	 *  another with the key "#foo" mapped to the identifier of the node. Note
	 *  that since no PHP identifier can begin with the hash character ('#'),
	 *  this entry will never collide with another parameter.
	 * Two entries are created for the return value using the same pattern as
	 *  for parameters, except that the keys are "return" and "#return" and:
	 *   If the method does not return anything (its return type is void) or if
	 *    this particular call returned null then the value of both entries is null.
	 *   If the object returned is not a Node then the "#return" entry is null.
	 * Note that since "return" is a PHP keyword it will never collide with a
	 * parameter name.
	 *
	 * @return array An array containing the parameters and return value of the called method.
	 * @throws F3::PHPCR::RepositoryException - if an error occurs.
	 */
	public function getMethodInfo();

	/**
	 * Returns the user data set in ObservationManager.setUserData()
	 *
	 * @return string
	 * @throws F3::PHPCR::RepositoryException - if an error occurs.
	 */
	public function getUserData();

}

?>