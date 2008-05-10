<?php
declare(ENCODING = 'utf-8');

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
 * A Session interface
 *
 * @package		phpCR
 * @version 	$Id$
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_phpCR_SessionInterface {

	/**
	 * Returns the Repository object through which this session was acquired.
	 * 
	 * @return F3_phpCR_RepositoryInterface a Repository object.
	 */
	public function getRepository();

	/**
	 * Gets the user ID that was used to acquire this session. This method is free to
	 * return an "anonymous user id" or null if the Credentials used to acquire this
	 * session happens not to have provided a real user ID (for example, if instead
	 * of SimpleCredentials some other implementation of Credentials was used).
	 * 
	 * @return string The user id from the credentials used to acquire this session.
	 */
	public function getUserID();

	/**
	 * Returns the value of the named attribute as an Object, or null if no attribute
	 * of the given name exists. See getAttributeNames().
	 *
	 * @param string $name - the name of an attribute passed in the credentials used to acquire this session.
	 * @return object The value of the attribute.
	 */
	public function getAttribute($name);

	/**
	 * Returns the names of the attributes set in this session as a result of the Credentials
	 * that were used to acquire it. Not all Credentials implementations will contain attributes
	 * (though, for example, SimpleCredentials does allow for them). This method returns an
	 * empty array if the Credentials instance used to acquire this Session did not provide
	 * attributes.
	 * 
	 * @return string[] Array containing the names of all attributes passed in the credentials used to acquire this session.
	 */
	public function getAttributeNames();

	/**
	 * Returns the Workspace attached to this Session.
	 * 
	 * @return F3_phpCR_WorkspaceInterface a Workspace object.
	 */
	public function getWorkspace();

	/**
	 * Returns the root node of the workspace. The root node, "/", is the main access point
	 * to the content of the workspace.
	 * 
	 * @return F3_phpCR_NodeInterface The root node of the workspace: a Node object.
	 * @throws RepositoryException if an error occurs.
	 */
	public function getRootNode();

	/**
	 * Returns the node specifed by the given UUID. Only applies to nodes that expose a UUID,
	 * in other words, those of mixin node type mix:referenceable
	 * 
	 * @param string $uuid A universally unique identifier.
	 * @return F3_phpCR_NodeInterface A Node.
	 * @throws F3_phpCR_ItemNotFoundException if the specified UUID is not found.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getNodeByUUID($uuid);

	/**
	 * This method returns a ValueFactory that is used to create Value objects for use when
	 * setting repository properties.
	 * If writing to the repository is not supported (because this is a level 1-only
	 * implementation, for example) an UnsupportedRepositoryOperationException will be thrown.
	 * 
	 * @return F3_phpCR_ValueFactoryInterface
	 * @throws F3_phpCR_UnsupportedRepositoryOperationException if writing to the repository is not supported.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getValueFactory();

	/**Releases all resources associated with this Session. This method should be called when
	 * a Session is no longer needed.
	 * 
	 * @return void
	 */
	public function logout();

	/**
	 * Returns true if this Session object is usable by the client. Otherwise, returns false.
	 * A usable Session is one that is neither logged-out, timed-out nor in any other way
	 * disconnected from the repository.
	 * 
	 * @return boolean true if this Session is usable, false otherwise.
	 */
	public function isLive();

	/**
	 * Validates all pending changes currently recorded in this Session. If validation of all
	 * pending changes succeeds, then this change information is cleared from the Session. If
	 * the save occurs outside a transaction, the changes are persisted and thus made visible
	 * to other Sessions. If the save occurs within a transaction, the changes are not persisted
	 * until the transaction is committed.
	 * 
	 * If validation fails, then no pending changes are saved and they remain recorded on the
	 * Session. There is no best-effort or partial save.
	 * 
	 * When an item is saved the item in persistent storage to which pending changes are written
	 * is determined as follows:
	 * * If the transient item has a UUID, then the changes are written to the persistent item
	 *   with the same UUID.
	 * * If the transient item does not have a UUID then its nearest ancestor with a UUID, or
	 *   the root node (whichever occurs first) is found, and the relative path from the node
	 *   in persistent node with that UUID is used to determine the item in persistent storage
	 *   to which the changes are to be written.
	 * 
	 * As a result of these rules, a save of an item that has a UUID will succeed even if that item
	 * has, in the meantime, been moved in persistent storage to a new location (that is, its path
	 * has changed). However, a save of a non-UUID item will fail (throwing an InvalidItemStateException)
	 * if it has, in the meantime, been moved in persistent storage to a new location. A save of a
	 * non-UUID item will also fail if it has, in addition to being moved, been replaced in its
	 * original position by a UUID-bearing item.
	 * 
	 * Note that save uses the same rules to match items between transient storage and persistent
	 * storage as Node.update(java.lang.String) does to match nodes between two workspaces.
	 * 
	 * @return void
	 * @throws F3_phpCR_AccessDeniedException if any of the changes to be persisted would violate the access privileges of the this Session. Also thrown if any of the changes to be persisted would cause the removal of a node that is currently referenced by a REFERENCE property that this Session does not have read access to.
	 * @throws F3_phpCR_ItemExistsException if any of the changes to be persisted would be prevented by the presence of an already existing item in the workspace.
	 * @throws F3_phpCR_LockException if any of the changes to be persisted would violate a lock.
	 * @throws F3_phpCR_ConstraintViolationException if any of the changes to be persisted would violate a node type or restriction. Additionally, a repository may use this exception to enforce implementation- or configuration-dependent restrictions.
	 * @throws F3_phpCR_InvalidItemStateException if any of the changes to be persisted conflicts with a change already persisted through another session and the implementation is such that this conflict can only be detected at save-time and therefore was not detected earlier, at change-time.
	 * @throws F3_phpCR_ReferentialIntegrityException if any of the changes to be persisted would cause the removal of a node that is currently referenced by a REFERENCE property that this Session has read access to.
	 * @throws F3_phpCR_VersionException if the save would make a result in a change to persistent storage that would violate the read-only status of a checked-in node.
	 * @throws F3_phpCR_LockException if the save would result in a change to persistent storage that would violate a lock.
	 * @throws F3_phpCR_NoSuchNodeTypeException if the save would result in the addition of a node with an unrecognized node type.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function save();

	/**
	 * Returns the node at the specified absolute path in the workspace. If no such node exists,
	 * then it returns the property at the specified path. If no such property exisits a
	 * PathNotFoundException is thrown.
	 * 
	 * @param string $absPath An absolute path.
	 * @return F3_phpCR_ItemInterface
	 * @throws F3_phpCR_PathNotFoundException if the specified path cannot be found.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getItem($absPath);

	/**
	 * Returns the node at the specified absolute path in the workspace. If no node exists,
	 * then a PathNotFoundException is thrown.
	 * 
	 * @param string $absPath An absolute path.
	 * @return F3_phpCR_NodeInterface A node
	 * @throws F3_phpCR_PathNotFoundException If no node exists.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	 */
	public function getNode($absPath);

	/**
	 * Returns the property at the specified absolute path in the workspace. If no property
	 * exists, then a PathNotFoundException is thrown.
	 * 
	 * @param string $absPath An absolute path.
	 * @return F3_phpCR_PropertyInterface A property
	 * @throws F3_phpCR_PathNotFoundException If no property exists.
	 * @throws F3_phpCR_RepositoryException if another error occurs.
	*/
	public function getProperty($absPath);
}

?>