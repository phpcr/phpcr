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
 * @package PHPCR
 * @version $Id$
 */

/**
 * The Session object provides read and (in level 2) write access to the
 * content of a particular workspace in the repository.
 *
 * The Session object is returned by Repository.login(). It encapsulates both
 * the authorization settings of a particular user (as specified by the passed
 * Credentials) and a binding to the workspace specified by the workspaceName
 * passed on login.
 *
 * Each Session object is associated one-to-one with a Workspace object. The
 * Workspace object represents a "view" of an actual repository workspace
 * entity as seen through the authorization settings of its associated Session.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_SessionInterface {

	/**
	 * Returns the Repository object through which this session was acquired.
	 *
	 * @return F3_PHPCR_RepositoryInterface a Repository object.
	 */
	public function getRepository();

	/**
	 * Gets the user ID associated with this Session. How the user ID is set is
	 * up to the implementation, it may be a string passed in as part of the
	 * credentials or it may be a string acquired in some other way. This method
	 * is free to return an "anonymous user ID" or null.
	 *
	 * @return string The user id associated with this Session.
	 */
	public function getUserID();

	/**
	 * Returns the names of the attributes set in this session as a result of
	 * the Credentials that were used to acquire it. Not all Credentials
	 * implementations will contain attributes (though, for example,
	 * SimpleCredentials does allow for them). This method returns an empty
	 * array if the Credentials instance did not provide attributes.
	 *
	 * @return array A string array containing the names of all attributes passed in the credentials used to acquire this session.
	 */
	public function getAttributeNames();

	/**
	 * Returns the value of the named attribute as an Object, or null if no
	 * attribute of the given name exists. See getAttributeNames().
	 *
	 * @param string $name The name of an attribute passed in the credentials used to acquire this session.
	 * @return object The value of the attribute or null if no attribute of the given name exists.
	 */
	public function getAttribute($name);

	/**
	 * Returns the Workspace attached to this Session.
	 *
	 * @return F3_PHPCR_WorkspaceInterface a Workspace object.
	 */
	public function getWorkspace();

	/**
	 * Returns the root node of the workspace, "/". This node is the main access
	 * point to the content of the workspace.
	 *
	 * @return F3_PHPCR_NodeInterface The root node of the workspace: a Node object.
	 * @throws RepositoryException if an error occurs.
	 */
	public function getRootNode();

	/**
	 * Returns the node specified by the given identifier. Applies to both referenceable
	 * and non-referenceable nodes.
	 *
	 * @param string $id An identifier.
	 * @return F3_PHPCR_NodeInterface A Node.
	 * @throws F3_PHPCR_ItemNotFoundException if the specified identifier is not found. This exception is also thrown if this Session does not have read access to the node with the specified identifier.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function getNodeByIdentifier($id);

	/**
	 * Returns the node at the specified absolute path in the workspace. If no such
	 * node exists, then it returns the property at the specified path. If no such
	 * property exists a PathNotFoundException is thrown.
	 *
	 * This method should only be used if the application does not know whether the
	 * item at the indicated path is property or node. In cases where the application
	 * has this information, either getNode(java.lang.String) or
	 * getProperty(java.lang.String) should be used, as appropriate. In many repository
	 * implementations the node and property-specific methods are likely to be more
	 * efficient than getItem.
	 *
	 * @param string $absPath An absolute path.
	 * @return F3_PHPCR_ItemInterface
	 * @throws F3_PHPCR_PathNotFoundException if the specified path cannot be found.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function getItem($absPath);

	/**
	 * Returns the node at the specified absolute path in the workspace.
	 *
	 * @param string $absPath An absolute path.
	 * @return F3_PHPCR_NodeInterface A node
	 * @throws F3_PHPCR_PathNotFoundException If no node exists.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function getNode($absPath);

	/**
	 * Returns the property at the specified absolute path in the workspace.
	 *
	 * @param string $absPath An absolute path.
	 * @return F3_PHPCR_PropertyInterface A property
	 * @throws F3_PHPCR_PathNotFoundException If no property exists.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	*/
	public function getProperty($absPath);

	/**
	 * Validates all pending changes currently recorded in this Session. If validation
	 * of all pending changes succeeds, then this change information is cleared from
	 * the Session. If the save occurs outside a transaction, the changes are persisted
	 * and thus made visible to other Sessions. If the save occurs within a transaction,
	 * the changes are not persisted until the transaction is committed.
	 *
	 * If validation fails, then no pending changes are saved and they remain recorded
	 * on the Session. There is no best-effort or partial save.
	 *
	 * The item in persistent storage to which a transient item is saved is determined
	 * by matching identifiers and paths.
	 *
	 * @return void
	 * @throws F3_PHPCR_AccessDeniedException if any of the changes to be persisted would violate the access privileges of the this Session. Also thrown if any of the changes to be persisted would cause the removal of a node that is currently referenced by a REFERENCE property that this Session does not have read access to.
	 * @throws F3_PHPCR_ItemExistsException if any of the changes to be persisted would be prevented by the presence of an already existing item in the workspace.
	 * @throws F3_PHPCR_ConstraintViolationException if any of the changes to be persisted would violate a node type or restriction. Additionally, a repository may use this exception to enforce implementation- or configuration-dependent restrictions.
	 * @throws F3_PHPCR_InvalidItemStateException if any of the changes to be persisted conflicts with a change already persisted through another session and the implementation is such that this conflict can only be detected at save-time and therefore was not detected earlier, at change-time.
	 * @throws F3_PHPCR_ReferentialIntegrityException if any of the changes to be persisted would cause the removal of a node that is currently referenced by a REFERENCE property that this Session has read access to.
	 * @throws F3_PHPCR_VersionException if the save would make a result in a change to persistent storage that would violate the read-only status of a checked-in node.
	 * @throws F3_PHPCR_LockException if the save would result in a change to persistent storage that would violate a lock.
	 * @throws F3_PHPCR_NoSuchNodeTypeException if the save would result in the addition of a node with an unrecognized node type.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function save();

	/**
	 * This method returns a ValueFactory that is used to create Value objects for use when
	 * setting repository properties.
	 *
	 * @return F3_PHPCR_ValueFactoryInterface
	 * @throws F3_PHPCR_UnsupportedRepositoryOperationException if writing to the repository is not supported.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function getValueFactory();

	/**
	 * Releases all resources associated with this Session. This method should be called when
	 * a Session is no longer needed.
	 *
	 * @return void
	 */
	public function logout();

	/**
	 * eturns true if this Session object is usable by the client. Otherwise, returns false.
	 * A usable Session is one that is neither logged-out, timed-out nor in any other way
	 * disconnected from the repository.
	 *
	 * @return boolean true if this Session is usable, false otherwise.
	 */
	public function isLive();
}

?>