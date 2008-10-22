<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR;

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
interface SessionInterface {

	/**
	 * A constant representing the add_node action string, used to determine if
	 * this Session has permission to add a new node.
	 */
	const ACTION_ADD_NODE = 'add_node';

	/**
	 * A constant representing the read action string, used to determine if this
	 * Session has permission to retrieve an item (and read the value, in the case
	 * of a property).
	 */
	const ACTION_READ = 'read';

	/**
	 * A constant representing the remove action string, used to determine if this
	 * Session has permission to remove an item.
	 */
	const ACTION_REMOVE = 'remove';

	/**
	 * A constant representing the set_property action string, used to determine if
	 * this Session has permission to set (add or modify) a property.
	 */
	const ACTION_SET_PROPERTY = 'set_property';

	/**
	 * Returns the Repository object through which this session was acquired.
	 *
	 * @return F3::PHPCR::RepositoryInterface a Repository object.
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
	 * Returns a javax.security.auth.Subject representing the user of this Session.
	 *
	 * @return Subject a Subject representing the user of this Session.
	 * @todo find replacement for javax.security.auth.Subject
	 */
	public function getSubject();

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
	 * @return F3::PHPCR::WorkspaceInterface a Workspace object.
	 */
	public function getWorkspace();

	/**
	 * Returns the root node of the workspace, "/". This node is the main access
	 * point to the content of the workspace.
	 *
	 * @return F3::PHPCR::NodeInterface The root node of the workspace: a Node object.
	 * @throws RepositoryException if an error occurs.
	 */
	public function getRootNode();

	/**
	 * Returns a new session in accordance with the specified (new) Credentials.
	 * Allows the current user to "impersonate" another using incomplete or relaxed
	 * credentials requirements (perhaps including a user name but no password, for
	 * example), assuming that this Session gives them that permission.
	 * The new Session is tied to a new Workspace instance. In other words, Workspace
	 * instances are not re-used. However, the Workspace instance returned represents
	 * the same actual persistent workspace entity in the repository as is represented
	 * by the Workspace object tied to this Session.
	 *
	 * @param F3::PHPCR::CredentialsInterface $credentials A Credentials object
	 * @return F3::PHPCR::SessionInterface a Session object
	 * @throws F3::PHPCR::LoginException if the current session does not have sufficient permissions to perform the operation.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function impersonate(F3::PHPCR::CredentialsInterface $credentials);

	/**
	 * Returns the node specified by the given identifier. Applies to both referenceable
	 * and non-referenceable nodes.
	 *
	 * @param string $id An identifier.
	 * @return F3::PHPCR::NodeInterface A Node.
	 * @throws F3::PHPCR::ItemNotFoundException if the specified identifier is not found. This exception is also thrown if this Session does not have read access to the node with the specified identifier.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
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
	 * @return F3::PHPCR::ItemInterface
	 * @throws F3::PHPCR::PathNotFoundException if the specified path cannot be found.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getItem($absPath);

	/**
	 * Returns the node at the specified absolute path in the workspace.
	 *
	 * @param string $absPath An absolute path.
	 * @return F3::PHPCR::NodeInterface A node
	 * @throws F3::PHPCR::PathNotFoundException If no node exists.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getNode($absPath);

	/**
	 * Returns the property at the specified absolute path in the workspace.
	 *
	 * @param string $absPath An absolute path.
	 * @return F3::PHPCR::PropertyInterface A property
	 * @throws F3::PHPCR::PathNotFoundException If no property exists.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	*/
	public function getProperty($absPath);

	/**
	 * Returns true if an item exists at absPath and this Session has read
	 * access to it; otherwise returns false.
	 *
	 * @param string $absPath An absolute path.
	 * @return boolean a boolean
	 * @throws F3::PHPCR::RepositoryException if absPath is not a well-formed absolute path.
	 */
	public function itemExists($absPath);

	/**
	 * Returns true if a node exists at absPath and this Session has read
	 * access to it; otherwise returns false.
	 *
	 * @param string $absPath An absolute path.
	 * @return boolean a boolean
	 * @throws 3_PHPCR_RepositoryException if absPath is not a well-formed absolute path.
	 */
	public function nodeExists($absPath);

	/**
	 * Returns true if a property exists at absPath and this Session has read
	 * access to it; otherwise returns false.
	 *
	 * @param string $absPath An absolute path.
	 * @return boolean a boolean
	 * @throws F3::PHPCR::RepositoryException if absPath is not a well-formed absolute path.
	 */
	public function propertyExists($absPath);

	/**
	 * Moves the node at srcAbsPath (and its entire subtree) to the new location
	 * at destAbsPath.
	 * In order to persist the change, Session.save() must be called.
	 *
	 * The identifiers of referenceable nodes must not be changed by a move. The
	 * identifiers of non-referenceable nodes may change.
	 *
	 * A ConstraintViolationException is thrown either immediately or on save if
	 * performing this operation would violate a node type or implementation-specific
	 * constraint. Implementations may differ on when this validation is performed.
	 *
	 * As well, a ConstraintViolationException will be thrown on save if an attempt
	 * is made to separately save either the source or destination node.
	 *
	 * Note that this behaviour differs from that of Workspace.move($srcAbsPath,
	 * $destAbsPath), which operates directly in the persistent workspace and does
	 * not require a save.
	 *
	 * The destAbsPath provided must not have an index on its final element. If it
	 * does then a RepositoryException is thrown. Strictly speaking, the destAbsPath
	 * parameter is actually an absolute path to the parent node of the new location,
	 * appended with the new name desired for the moved node. It does not specify a
	 * position within the child node ordering (if such ordering is supported). If
	 * ordering is supported by the node type of the parent node of the new location,
	 * then the newly moved node is appended to the end of the child node list.
	 *
	 * This method cannot be used to move just an individual property by itself.
	 * It moves an entire node and its subtree (including, of course, any properties
	 * contained therein).
	 *
	 * @param string $srcAbsPath the root of the subtree to be moved.
	 * @param string $destAbsPath the location to which the subtree is to be moved.
	 * @return void
	 * @throws F3::PHPCR::ItemExistsException - if a node already exists at destAbsPath and same-name siblings are not allowed.
	 * @throws F3::PHPCR::PathNotFoundException - if either srcAbsPath or destAbsPath cannot be found and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::Version::VersionException - if the parent node of destAbsPath or the parent node of srcAbsPath is versionable and checked-in, or or is non-versionable and its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::ConstraintViolationException - if a node-type or other constraint violation is detected immediately and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::Lock::LockException - if the move operation would violate a lock and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::RepositoryException - if the last element of destAbsPath has an index or if another error occurs.
	 */
	public function move($srcAbsPath, $destAbsPath);

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
	 * @throws F3::PHPCR::AccessDeniedException if any of the changes to be persisted would violate the access privileges of the this Session. Also thrown if any of the changes to be persisted would cause the removal of a node that is currently referenced by a REFERENCE property that this Session does not have read access to.
	 * @throws F3::PHPCR::ItemExistsException if any of the changes to be persisted would be prevented by the presence of an already existing item in the workspace.
	 * @throws F3::PHPCR::ConstraintViolationException if any of the changes to be persisted would violate a node type or restriction. Additionally, a repository may use this exception to enforce implementation- or configuration-dependent restrictions.
	 * @throws F3::PHPCR::InvalidItemStateException if any of the changes to be persisted conflicts with a change already persisted through another session and the implementation is such that this conflict can only be detected at save-time and therefore was not detected earlier, at change-time.
	 * @throws F3::PHPCR::ReferentialIntegrityException if any of the changes to be persisted would cause the removal of a node that is currently referenced by a REFERENCE property that this Session has read access to.
	 * @throws F3::PHPCR::Version::VersionException if the save would make a result in a change to persistent storage that would violate the read-only status of a checked-in node.
	 * @throws F3::PHPCR::Lock::LockException if the save would result in a change to persistent storage that would violate a lock.
	 * @throws F3::PHPCR::NodeType::NoSuchNodeTypeException if the save would result in the addition of a node with an unrecognized node type.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function save();

	/**
	 * If keepChanges is false, this method discards all pending changes currently
	 * recorded in this Session and returns all items to reflect the current saved
	 * state. Outside a transaction this state is simply the current state of
	 * persistent storage. Within a transaction, this state will reflect persistent
	 * storage as modified by changes that have been saved but not yet committed.
	 * If keepChanges is true then pending change are not discarded but items that
	 * do not have changes pending have their state refreshed to reflect the current
	 * saved state, thus revealing changes made by other sessions.
	 *
	 * @param boolean $keepChanges a boolean
	 * @return void
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function refresh($keepChanges);

	/**
	 * Returns true if this session holds pending (that is, unsaved) changes;
	 * otherwise returns false.
	 *
	 * @return boolean a boolean
	 * @throws F3::PHPCR::RepositoryException if an error occurs
	 */
	public function hasPendingChanges();

	/**
	 * This method returns a ValueFactory that is used to create Value objects
	 * for use when setting repository properties.
	 *
	 * @return F3::PHPCR::ValueFactoryInterface
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if writing to the repository is not supported.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getValueFactory();

	/**
	 * Returns true if this Session has permission to perform the specified
	 * actions at the specified absPath and false otherwise.
	 * The actions parameter is a comma separated list of action strings.
	 * The following action strings are defined:
	 *
	 * add_node: If hasPermission(path, "add_node") returns true, then this
	 * Session has permission to add a node at path.
	 * set_property: If hasPermission(path, "set_property") returns true, then
	 * this Session has permission to set (add or change) a property at path.
	 * remove: If hasPermission(path, "remove") returns true, then this Session
	 * has permission to remove an item at path.
	 * read: If hasPermission(path, "read") returns true, then this Session has
	 * permission to retrieve (and read the value of, in the case of a property)
	 * an item at path.
	 *
	 * When more than one action is specified in the actions parameter, this method
	 * will only return true if this Session has permission to perform all of the
	 * listed actions at the specified path.
	 *
	 * The information returned through this method will only reflect the access
	 * control status (both JCR defined and implementation-specific) and not
	 * other restrictions that may exist, such as node type constraints. For
	 * example, even though hasPermission may indicate that a particular Session
	 * may add a property at /A/B/C, the node type of the node at /A/B may
	 * prevent the addition of a property called C.
	 *
	 * @param string $absPath an absolute path.
	 * @param string $actions a comma separated list of action strings.
	 * @return boolean true if this Session has permission to perform the specified actions at the specified absPath.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function hasPermission($absPath, $actions);

	/**
	 * Determines whether this Session has permission to perform the specified actions
	 * at the specified absPath. This method quietly returns if the access request is
	 * permitted, or throws a suitable java.security.AccessControlException otherwise.
	 * The actions parameter is a comma separated list of action strings. The following
	 * action strings are defined:
	 *
	 * add_node: If checkPermission(path, "add_node") returns quietly, then this Session
	 * has permission to add a node at path, otherwise permission is denied.
	 * set_property: If checkPermission(path, "set_property") returns quietly, then this
	 * Session has permission to set (add or change) a property at path, otherwise
	 * permission is denied.
	 * remove: If checkPermission(path, "remove") returns quietly, then this Session
	 * has permission to remove an item at path, otherwise permission is denied.
	 * read: If checkPermission(path, "read") returns quietly, then this Session has
	 * permission to retrieve (and read the value of, in the case of a property) an
	 * item at path, otherwise permission is denied.
	 *
	 * When more than one action is specified in the actions parameter, this method
	 * will only return true if this Session has permission to perform all of the
	 * listed actions at the specified path.
	 *
	 * The information returned through this method will only reflect the access
	 * control status (both JCR defined and implementation-specific) and not
	 * other restrictions that may exist, such as node type constraints. For
	 * example, even though hasPermission may indicate that a particular Session
	 * may add a property at /A/B/C, the node type of the node at /A/B may
	 * prevent the addition of a property called C.
	 *
	 * @param string $absPath an absolute path.
	 * @param string $actions a comma separated list of action strings.
	 * @return void
	 * @throws java.security.AccessControlException If permission is denied.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function checkPermission($absPath, $actions);

	/**
	 * Checks whether an operation can be performed given as much context as can be determined
	 * by the repsoitory, including:
	 * * Target object (reflecting the current selection in the application) and its current state
	 *   (locks etc.).
	 * * Current user (the current session).
	 * * Access control rules (permissions granted to the current user).
	 * * Repository capabilities.
	 * * Schema information (rules embodied in the node type structure or more
	 *   repository specific rules).
	 *
	 * The implementation of this method is best effort: returning false guarantees
	 * that the operation cannot be performed, but returning true does not guarantee
	 * the opposite. The repository implementation should use this to give priority to
	 * performance over completeness. An exception should be thrown only for important
	 * failures such as loss of connectivity to the back-end.
	 *
	 * The methodType parameter identifies the operation using the method event
	 * constants defined for Event::getMethod.
	 *
	 * The target parameter identifies the object on which the specified method is
	 * called. For example, for method Node.addNode, target would identify
	 * the Node object. The target is an optional parameter, but must be
	 * supplied if the specified method is defined on Item or any of its subtypes.
	 * To not supply a target, a NULL is passed as the second parameter.
	 *
	 * The arguments parameter contains method arguments as defined for
	 * Event::getMethodInfo. The arguments parameter is optional, and even when
	 * specified, not all arguments to the corresponding operation need to
	 * be specified. In such a case, the repository should check whether there exists a
	 * set of arguments for which the operation could succeed. To not supply arguments,
	 * either a NULL or an empty Map is passed as the third parameter.

	 * @param string $methodType the operation.
	 * @param object $target the target object of the operation.
	 * @param array $arguments the arguments of the operation.
	 * @return boolean FALSE if the operation cannot be performed, TRUE if the operation can be performed or if the repository cannot determine whether the operation can be performed.
	 * @throws F3::PHPCR::RepositoryException if an error occurs
	 */
	public function checkCapability($methodType, $target, array $arguments);

	/**
	 * Returns an org.xml.sax.ContentHandler which can be used to push SAX events
	 * into the repository. If the incoming XML stream (in the form of SAX events)
	 * does not appear to be a JCR system view XML document then it is interpreted
	 * as a JCR document view XML document.
	 * The incoming XML is deserialized into a subtree of items immediately below
	 * the node at parentAbsPath.
	 *
	 * This method simply returns the ContentHandler without altering the state of
	 * the session; the actual deserialization to the session transient space is done through the methods of the ContentHandler. Invalid XML data will cause the ContentHandler to throw a SAXException.
	 *
	 * As SAX events are fed into the ContentHandler, the tree of new items is built
	 * in the transient storage of the session. In order to persist the new content, save must be called. The advantage of this through-the-session method is that (depending on which constraint checks the implementation leaves until save) structures that violate node type constraints can be imported, fixed and then saved. The disadvantage is that a large import will result in a large cache of pending nodes in the session. See Workspace.getImportContentHandler(java.lang.String, int) for a version of this method that does not go through the session.
	 *
	 * The flag uuidBehavior governs how the identifiers of incoming (deserialized)
	 * nodes are handled. There are four options:
	 *
	 * ImportUUIDBehavior.IMPORT_UUID_CREATE_NEW: Incoming identifiers nodes are added
	 * in the same way that new node is added with Node.addNode. That is, they are either
	 * assigned newly created identifiers upon addition or upon save (depending on the
	 * implementation). In either case, identifier collisions will not occur.
	 * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an incoming node has
	 * the same identifier as a node already existing in the workspace then the already
	 * existing node (and its subtree) is removed from wherever it may be in the workspace
	 * before the incoming node is added. Note that this can result in nodes "disappearing"
	 * from locations in the workspace that are remote from the location to which the
	 * incoming subtree is being written. Both the removal and the new addition will be
	 * persisted on save.
	 * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an incoming node has
	 * the same identifier as a node already existing in the workspace, then the
	 * already-existing node is replaced by the incoming node in the same position as the
	 * existing node. Note that this may result in the incoming subtree being disaggregated
	 * and "spread around" to different locations in the workspace. In the most extreme
	 * case this behavior may result in no node at all being added as child of parentAbsPath.
	 * This will occur if the topmost element of the incoming XML has the same identifier as
	 * an existing node elsewhere in the workspace. The change will be persisted on save.
	 * ImportUUIDBehavior.IMPORT_UUID_COLLISION_THROW: If an incoming node has the same
	 * identifier as a node already existing in the workspace then a SAXException is thrown
	 * by the ContentHandler during deserialization.
	 * Unlike Workspace.getImportContentHandler, this method does not necessarily enforce
	 * all node type constraints during deserialization. Those that would be immediately
	 * enforced in a normal write method (Node.addNode, Node.setProperty etc.) of this
	 * implementation cause the returned ContentHandler to throw an immediate SAXException
	 * during deserialization. All other constraints are checked on save, just as they are
	 * in normal write operations. However, which node type constraints are enforced depends
	 * upon whether node type information in the imported data is respected, and this is an
	 * implementation-specific issue.
	 * A SAXException will also be thrown by the returned ContentHandler during deserialization
	 * if uuidBehavior is set to IMPORT_UUID_COLLISION_REMOVE_EXISTING and an incoming node has
	 * the same identifier as the node at parentAbsPath or one of its ancestors.
	 *
	 * @param string $parentAbsPath the absolute path of a node under which (as child) the imported subtree will be built.
	 * @param integer $uuidBehavior a four-value flag that governs how incoming identifiers are handled.
	 * @return org.xml.sax.ContentHandler whose methods may be called to feed SAX events into the deserializer.
	 * @throws F3::PHPCR::PathNotFoundException - if no node exists at parentAbsPath and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::ConstraintViolationException - if the new subtree cannot be added to the node at parentAbsPath due to node-type or other implementation-specific constraints, and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::Version::VersionException - if the node at parentAbsPath is versionable and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save..
	 * @throws F3::PHPCR::Lock::LockException - if a lock prevents the addition of the subtree and this implementation performs this validation immediately instead of waiting until save..
	 * @throws F3::PHPCR::RepositoryException - if another error occurs.
	 */
	public function getImportContentHandler($parentAbsPath, $uuidBehavior);

	/**
	 * Deserializes an XML document and adds the resulting item subtree as a
	 * child of the node at parentAbsPath.
	 * If the incoming XML stream does not appear to be a JCR system view XML
	 * document then it is interpreted as a document view XML document.
	 *
	 * The passed InputStream is closed before this method returns either normally
	 * or because of an exception.
	 *
	 * The tree of new items is built in the transient storage of the Session. In order
	 * to persist the new content, save must be called. The advantage of this
	 * through-the-session method is that (depending on what constraint checks the
	 * implementation leaves until save) structures that violate node type constraints
	 * can be imported, fixed and then saved. The disadvantage is that a large import
	 * will result in a large cache of pending nodes in the session. See
	 * Workspace.importXML(java.lang.String, java.io.InputStream, int) for a version
	 * of this method that does not go through the Session.
	 *
	 * The flag uuidBehavior governs how the identifiers of incoming (deserialized)
	 * nodes are handled. There are four options:
	 *
	 * ImportUUIDBehavior.IMPORT_UUID_CREATE_NEW: Incoming nodes are added in the same
	 * way that new node is added with Node.addNode. That is, they are either assigned
	 * newly created identifiers upon addition or upon save (depending on the implementation,
	 * see 4.9.1.1 When Identifiers are Assigned in the specification). In either case,
	 * identifier collisions will not occur.
	 * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an incoming node has
	 * the same identifier as a node already existing in the workspace then the already
	 * existing node (and its subtree) is removed from wherever it may be in the workspace
	 * before the incoming node is added. Note that this can result in nodes "disappearing"
	 * from locations in the workspace that are remote from the location to which the
	 * incoming subtree is being written. Both the removal and the new addition will be
	 * persisted on save.
	 * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an incoming node
	 * has the same identifier as a node already existing in the workspace, then the
	 * already-existing node is replaced by the incoming node in the same position as
	 * the existing node. Note that this may result in the incoming subtree being
	 * disaggregated and "spread around" to different locations in the workspace. In the
	 * most extreme case this behavior may result in no node at all being added as child
	 * of parentAbsPath. This will occur if the topmost element of the incoming XML has
	 * the same identifier as an existing node elsewhere in the workspace. The change
	 * will only be persisted on save.
	 * ImportUUIDBehavior.IMPORT_UUID_COLLISION_THROW: If an incoming node has the same
	 * identifier as a node already existing in the workspace then an
	 * ItemExistsException is thrown.
	 * Unlike Workspace.importXML(java.lang.String, java.io.InputStream, int), this
	 * method does not necessarily enforce all node type constraints during deserialization.
	 * Those that would be immediately enforced in a normal write method (Node.addNode,
	 * Node.setProperty etc.) of this implementation cause an immediate
	 * ConstraintViolationException during deserialization. All other constraints are
	 * checked on save, just as they are in normal write operations. However, which node
	 * type constraints are enforced depends upon whether node type information in the
	 * imported data is respected, and this is an implementation-specific issue (see
	 * 5.4.3 Respecting Property Semantics in the specification).
	 *
	 * @param string $parentAbsPath the absolute path of the node below which the deserialized subtree is added.
	 * @param resource $in The Inputstream from which the XML to be deserialized is read.
	 * @param integer $uuidBehavior a four-value flag that governs how incoming identifiers are handled.
	 * @return void
	 * @throws RuntimeException if an error during an I/O operation occurs.
	 * @throws F3::PHPCR::PathNotFoundException if no node exists at parentAbsPath and this implementation performs this validation immediately instead of waiting until save..
	 * @throws F3::PHPCR::ItemExistsException if deserialization would overwrite an existing item and this implementation performs this validation immediately instead of waiting until save..
	 * @throws F3::PHPCR::ConstraintViolationException if a node type or other implementation-specific constraint is violated that would be checked on a normal write method or if uuidBehavior is set to IMPORT_UUID_COLLISION_REMOVE_EXISTING and an incoming node has the same UUID as the node at parentAbsPath or one of its ancestors.
	 * @throws F3::PHPCR::Version::VersionException if the node at parentAbsPath is versionable and checked-in, or its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save..
	 * @throws F3::PHPCR::InvalidSerializedDataException if incoming stream is not a valid XML document.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the addition of the subtree and this implementation performs this validation immediately instead of waiting until save..
	 * @throws F3::PHPCR::RepositoryException is another error occurs.
	 */
	public function importXML($parentAbsPath, $in, $uuidBehavior);

	/**
	 * Serializes the node (and if noRecurse is false, the whole subtree) at absPath
	 * as an XML stream and outputs it to the supplied OutputStream. It is the
	 * responsibility of the caller to close the passed OutputStream.
	 *
	 * If $out is a org.xml.sax.ContentHandler:
	 * Serializes the node (and if noRecurse is false, the whole subtree) at absPath
	 * into a series of SAX events by calling the methods of the supplied
	 * org.xml.sax.ContentHandler.
	 *
	 * The resulting XML is in the system view form. Note that absPath must be the path
	 * of a node, not a property.
	 * If skipBinary is true then any properties of PropertyType.BINARY will be serialized
	 * as if they are empty. That is, the existence of the property will be serialized,
	 * but its content will not appear in the serialized output (the <sv:value> element
	 * will have no content). Note that in the case of multi-value BINARY properties,
	 * the number of values in the property will be reflected in the serialized output,
	 * though they will all be empty. If skipBinary is false then the actual value(s)
	 * of each BINARY property is recorded using Base64 encoding.
	 *
	 * If noRecurse is true then only the node at absPath and its properties, but not
	 * its child nodes, are serialized. If noRecurse is false then the entire subtree
	 * rooted at absPath is serialized.
	 *
	 * If the user lacks read access to some subsection of the specified tree, that
	 * section simply does not get serialized, since, from the user's point of view,
	 * it is not there.
	 *
	 * The serialized output will reflect the state of the current workspace as
	 * modified by the state of this Session. This means that pending changes
	 * (regardless of whether they are valid according to node type constraints)
	 * and all namespace mappings in the namespace registry, as modified by the
	 * current session-mappings, are reflected in the output.
	 *
	 * The output XML will be encoded in UTF-8.
	 *
	 * @param string $absPath The path of the root of the subtree to be serialized. This must be the path to a node, not a property
	 * @param resource $out The OutputStream or org.xml.sax.ContentHandler to which the XML serialization of the subtree will be output.
	 * @param boolean $skipBinary A boolean governing whether binary properties are to be serialized.
	 * @param boolean $noRecurse A boolean governing whether the subtree at absPath is to be recursed.
	 * @return void
	 * @throws F3::PHPCR::PathNotFoundException if no node exists at absPath.
	 * @throws java.io.IOException if an error during an I/O operation occurs.
	 * @throws org.xml.sax.SAXException if an error occurs while feeding events to the org.xml.sax.ContentHandler.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 * @todo Decide in what to use for org.xml.sax.ContentHandler
	 */
	public function exportSystemView($absPath, $out, $skipBinary, $noRecurse);

	/**
	 * Serializes the node (and if noRecurse is false, the whole subtree) at absPath as an XML
	 * stream and outputs it to the supplied OutputStream. The resulting XML is in the document
	 * view form. Note that absPath must be the path of a node, not a property. It is the
	 * responsibility of the caller to close the passed OutputStream.
	 *
	 * If $out is a org.xml.sax.ContentHandler:
	 * Serializes the node (and if noRecurse is false, the whole subtree) at absPath into a
	 * series of SAX events by calling the methods of the supplied org.xml.sax.ContentHandler.
	 *
	 * If skipBinary is true then any properties of PropertyType.BINARY will be serialized as if
	 * they are empty. That is, the existence of the property will be serialized, but its content
	 * will not appear in the serialized output (the value of the attribute will be empty). If
	 * skipBinary is false then the actual value(s) of each BINARY property is recorded using
	 * Base64 encoding.
	 *
	 * If noRecurse is true then only the node at absPath and its properties, but not its
	 * child nodes, are serialized. If noRecurse is false then the entire subtree rooted at
	 * absPath is serialized.
	 *
	 * If the user lacks read access to some subsection of the specified tree, that section
	 * simply does not get serialized, since, from the user's point of view, it is not there.
	 *
	 * The serialized output will reflect the state of the current workspace as modified by
	 * the state of this Session. This means that pending changes (regardless of whether they
	 * are valid according to node type constraints) and all namespace mappings in the
	 * namespace registry, as modified by the current session-mappings, are reflected in
	 * the output.
	 *
	 * The output XML will be encoded in UTF-8.
	 *
	 * @param string $absPath The path of the root of the subtree to be serialized. This must be the path to a node, not a property
	 * @param resource $out The OutputStream or org.xml.sax.ContentHandler to which the XML serialization of the subtree will be output.
	 * @param boolean $skipBinary A boolean governing whether binary properties are to be serialized.
	 * @param boolean $noRecurse A boolean governing whether the subtree at absPath is to be recursed.
	 * @return void
	 * @throws F3::PHPCR::PathNotFoundException if no node exists at absPath.
	 * @throws RuntimeException if an error during an I/O operation occurs.
	 * @throws org.xml.sax.SAXException if an error occurs while feeding events to the org.xml.sax.ContentHandler.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 * @todo Decide in what to use for org.xml.sax.ContentHandler
	 */
	public function exportDocumentView($absPath, $out, $skipBinary, $noRecurse);

	/**
	 * Within the scope of this Session, this method maps uri to prefix. The
	 * remapping only affects operations done through this Session. To clear
	 * all remappings, the client must acquire a new Session.
	 * All local mappings already present in the Session that include either
	 * the specified prefix or the specified uri are removed and the new mapping
	 * is added.
	 *
	 * @param string $prefix a string
	 * @param string $uri a string
	 * @return void
	 * @throws F3::PHPCR::NamespaceException if the local mapping cannot be done.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function setNamespacePrefix($prefix, $uri);

	/**
	 * Returns all prefixes currently mapped to URIs in this Session.
	 *
	 * @return array a string array
	 * @throws F3::PHPCR::RepositoryException if an error occurs
	 */
	public function getNamespacePrefixes();

	/**
	 * Returns the URI to which the given prefix is mapped as currently set in
	 * this Session.
	 *
	 * @param string $prefix a string
	 * @return string a string
	 * @throws F3::PHPCR::NamespaceException if the specified prefix is unknown.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getNamespaceURI($prefix);

	/**
	 * Returns the prefix to which the given uri is mapped as currently set in
	 * this Session.
	 *
	 * @param string $uri a string
	 * @return string a string
	 * @throws F3::PHPCR::NamespaceException if the specified uri is unknown.
	 * @throws F3::PHPCR::RepositoryException - if another error occurs
	 */
	public function getNamespacePrefix($uri);

	/**
	 * Releases all resources associated with this Session. This method should
	 * be called when a Session is no longer needed.
	 *
	 * @return void
	 */
	public function logout();

	/**
	 * Returns true if this Session object is usable by the client. Otherwise,
	 * returns false.
	 * A usable Session is one that is neither logged-out, timed-out nor in
	 * any other way disconnected from the repository.
	 *
	 * @return boolean true if this Session is usable, false otherwise.
	 */
	public function isLive();

	/**
	 * Returns the access control manager for this Session.
	 *
	 * @return F3::PHPCR::Security::AccessControlManager the access control manager for this Session
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if access control is not supported.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getAccessControlManager();

	/**
	 * Returns the retention and hold manager for this Session.
	 *
	 * @return F3::PHPCR::Retention::RetentionManagerInterface the retention manager for this Session.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if retention and hold are not supported.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getRetentionManager();

}

?>