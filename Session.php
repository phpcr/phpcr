<?php
// $Id: Session.interface.php 550 2005-08-26 02:44:12Z tswicegood $

/**
 * This file contains {@link Ticket} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is
 * licensed under the Apache License, Version 2.0.
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
 */

/**
 * The {@link Session} object provides read and (in level 2) write access to the content of a
 * particular workspace in the repository.
 *
 * The {@link Session} object is returned by {@link Repository::login()}.
 * It encapsulates both the authorization settings of a particular user (as specified by the
 * passed {@link Credentials})and a mapping to the workspace specified by the
 * <i>workspaceName</i> passed on <i>login</i>.
 *
 * Each {@link Session} object is associated one-to-one with a {@link Workspace} object.
 * The {@link Workspace} object represents a "view" of an actual repository workspace entity
 * as seen through the authorization settings of its associated {@link Session}.
 *
 * @package phpContentRepository
 */
interface phpCR_Session
{
	/**
	 * Returns the {@link Repository} object through which this session was
	 * acquired.
	 *
	 * @return object
	 *	A {@link Repository} object
	 */
	public function getRepository();

	/**
	 * Gets the user ID that was used to acquire this session.
	 *
	 * This method is free to return an "anonymous user id" or
	 * <i>NULL</i> if the {@link Credentials} used to acquire this
	 * session happens not to have provided a real user ID (for example, if
	 * instead of {@link SimpleCredentials} some other implementation of
	 * {@link Credentials} was used).
	 *
	 * @return string
	 */
	public function getUserID();

	/**
	 * Returns the value of the named attribute as an <i>Object</i>, or
	 * <i>NULL</i> if no attribute of the given name exists. See
	 * {@link Session::getAttributeNames()}.
	 *
	 * @param string
	 *   The name of an attribute passed in the credentials used to acquire
	 *   this session.
	 * @return object
	 */
	public function getAttribute($name);

	/**
	 * Returns the names of the attributes set in this session as a result of
	 * the {@link Credentials} that were used to acquire it.
	 *
	 * Not all {@link Credentials} implementations will contain attributes
	 * (though, for example, {@link SimpleCredentials} does allow for them).
	 * This method returns an empty array if the {@link Credentials} instance
	 * used to acquire this {@link Session} did not provide attributes.
	 *
	 * @return array
	 */
	public function getAttributeNames();

	/**
	 * Returns the {@link Workspace} attached to this {@link Session}.
	 *
	 * @return phpCR_Workspace
	 *	A {@link Workspace} object
	 */
	public function getWorkspace();

	/**
	 * Returns a new session in accordance with the specified (new) Credentials.
	 *
	 * Allows the current user to "impersonate" another using incomplete
	 * credentials (perhaps including a user name but no password, for example),
	 * assuming that their original session gives them that permission.
	 *
	 * The new {@link Session} is tied to a new {@link Workspace} instance.
	 * In other words, {@link Workspace} instances are not re-used. However,
	 * the {@link Workspace} instance returned represents the same actual
	 * persistent workspace entity in the repository as is represented by the
	 * {@link Workspace} object tied to this {@link Session}.
	 *
	 * @param object
	 *	A {@link Credentials} object
	 * @return object
	 *	A {@link Session} object
	 *
	 * @throws {@link LoginException}
	 *    If the current session does not have sufficient rights.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function impersonate(phpCR_Credentials $credentials);

	/**
	 * Returns the root node of the workspace.
	 *
	 * The root node, "/", is the main access point to the content of the
	 * workspace.
	 *
	 * @return The root node of the workspace: a {@link Node} object.
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getRootNode();

	/**
	 * Returns the node specifed by the given UUID.
	 *
	 * Only applies to nodes that expose a UUID, in other words, those of
	 * mixin node type <i>mix:referenceable</i>
	 *
	 * @param string
	 * @return object
	 *	A {@link Node} object
	 *
	 * @throws {@link ItemNotFoundException}
	 *    If the specified UUID is not found.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getNodeByUUID($uuid);

	/**
	 * Returns the item at the specified absolute path in the workspace.
	 *
	 * @param string
	 * @return phpCR_Item
	 *	A {@link Item} object
	 *
	 * @throws {@link PathNotFoundException}
	 *    If the specified path cannot be found.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getItem($absPath);

	/**
	 * Returns <i>true</i> if an item exists at <i>absPath</i>;
	 * otherwise returns <i>false</i>.
	 *
	 * Also returns <i>false</i> if the specified <i>absPath</i> is
	 * malformed.
	 *
	 * @param string
	 * @return boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function itemExists($absPath);

	/**
	 * Moves the node at <i>srcAbsPath</i> (and its entire subtree) to
	 * the new location at <i>destAbsPath</i>.
	 *
	 * In order to persist the change, a {@link save()} must be called on
	 * either the session or a common ancestor to both the source and
	 * destination locations.
	 *
	 * Note that this behaviour differs from that of
	 * {@link Workspace::move()}, which operates directly in the persistent
	 * workspace and does not require a {@link save()}.
	 *
	 * The <i>destAbsPath</i> provided must not
	 * have an index on its final element. If it does then a {@link RepositoryException}
	 * is thrown. Strictly speaking, the <i>destAbsPath</i> parameter is actually an <i>absolute path</i>
	 * to the parent node of the new location, appended with the new <i>name</i> desired for the
	 * moved node. It does not specify a position within the child node
	 * ordering (if such ordering is supported). If ordering is supported by the node type of
	 * the parent node of the new location, then the newly moved node is appended to the end of the
	 * child node list.
	 *
	 * This method cannot be used to move just an individual property by itself.
	 * It moves an entire node and its subtree (including, of course, any properties
	 * contained therein).
	 *
	 * @param string
	 * @param string
	 *
	 * @throws {@link ItemExistsException}
	 *    If a property already exists at <i>destAbsPath</i> or a node
	 *    already exist there, and same name siblings are not allowed and this
	 *    implementation performs this validation immediately instead of
	 *    waiting until {@link save()}.
	 * @throws {@link PathNotFoundException}
	 *    If either <i>srcAbsPath</i> or <i>destAbsPath</i> cannot
	 *    be found and this implementation performs this validation immediately
	 *    instead of waiting until {@link save()}.
	 * @throws {@link VersionException}
	 *    If the parent node of <i>destAbsPath</i> or the parent node of
	 *    <i>srcAbsPath</i> is versionable and checked-in, or or is
	 *    non-verionable and its nearest versionable ancestor is checked-in and
	 *    this implementation performs this validation immediately instead of
	 *    waiting until {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If a node-type or other constraint violation is detected immediately
	 *    and this implementation performs this validation immediately instead
	 *    of waiting until {@link save()}.
	 * @throws {@link LockException}
	 *    If the move operation would violate a lock and this implementation
	 *    performs this validation immediately instead of waiting until
	 *    {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If the last element of <i>destAbsPath</i> has an index or
	 *    if another error occurs.
	 */
	public function move($srcAbsPath, $destAbsPath);

	/**
	 * Validates all pending changes currently recorded in this {@link Session}.
	 *
	 * If validation of all pending changes succeeds, then this change
	 * information is cleared from the {@link Session}.
	 *
	 * If the {@link save()} occurs outside a transaction, the changes are
	 * persisted and thus made visible to other {@link Session}s.  If the
	 * {@link save()} occurs within a transaction, the changes are not
	 * persisted until the transaction is committed.
	 *
	 * If validation fails, then no pending changes are saved and they remain
	 * recorded on the {@link Session}.  There is no best-effort or partial
	 * save.
	 *
	 * When an item is saved the item in persistent storage to which pending
	 * changes are written is determined as follows:
	 * <ul>
	 *    <li>
	 *        If the transient item has a UUID, then the changes are written to
	 *        the persistent item with the same UUID.
	 *    </li>
	 *    <li>
	 *        If the transient item does not have a UUID then its nearest
	 *        ancestor with a UUID, or the root node (whichever occurs first)
	 *        is found, and the relative path from the node in persistent node
	 *        with that UUID is used to determine the item in persistent
	 *        storage to which the changes are to be written.
	 *    </li>
	 * </ul>
	 *
	 * As a result of these rules, a {@link save()} of an item that has a UUID
	 * will succeed even if that item has, in the meantime, been moved in
	 * persistent storage to a new location (that is, its path has changed).
	 * However, a {@link save()} of a non-UUID item will fail (throwing an
	 * {@link InvalidItemStateException}) if it has, in the meantime, been
	 * moved in persistent storage to a new location. A {@link save()} of a
	 * non-UUID item will also fail if it has, in addition to being moved,
	 * been replaced in its original position by a UUID-bearing item.
	 *
	 * Note that {@link save()} uses the same rules to match items between
	 * transient storage and persistent storage as {@link update()} does to
	 * match nodes between two workspaces.
	 *
	 * An {@link AccessDeniedException} will be thrown if any of the changes
	 * to be persisted would violate the access privileges of this
	 * {@link Session}.
	 *
	 * If any of the changes to be persisted would cause the removal of a node
	 * that is currently the target of a <i>REFERENCE</i> property then a
	 * {@link ReferentialIntegrityException} is thrown, provided that this
	 * {@link Session} has read access to that <i>REFERENCE</i> property.
	 * If, on the other hand, this {@link Session} does not have read access to
	 * the <i>REFERENCE</i> property in question, then an
	 * {@link AccessDeniedException} is thrown instead.
	 *
	 * An {@link ItemExistsException} will be thrown if any of the changes
	 * to be persisted would be prevented by the presence of an already existing
	 * item in the workspace.
	 *
	 * A {@link ConstraintViolationException} will be thrown if any of the
	 * changes to be persisted would violate a node type restriction.
	 * Additionally, a repository may use this exception to enforce
	 * implementation- or configuration-dependant restrictions.
	 *
	 * A {@link LockException} is thrown if any of the changes to be
	 * persisted would violate a lock.
	 *
	 * An {@link InvalidItemStateException} is thrown if any of the
	 * changes to be persisted conflicts with a change already persisted
	 * through another session and the implementation is such that this
	 * conflict can only be detected at save-time and therefore was not
	 * detected earlier, at change-time.
	 *
	 * A {@link VersionException} is thrown if the {@link save()} would make a
	 * result in a change to persistent storage that would violate the
	 * read-only status of a checked-in node.
	 *
	 * A {@link LockException} is thrown if the {@link save()} would result in a
	 * change to persistent storage that would violate a lock.
	 *
	 * A {@link NoSuchNodeTypeException} is thrown if the {@link save()} would
	 * result in the addition of a node with an unrecognized node type.
	 *
	 * A {@link RepositoryException} will be thrown if another error
	 * occurs.
	 *
	 * @throws {@link AccessDeniedException}
	 *    If any of the changes to be persisted would violate the access
	 *    privileges of the this {@link Session}. Also thrown if  any of the
	 *    changes to be persisted would cause the removal of a node that is
	 *    currently referenced by a <i>REFERENCE</i> property that this
	 *    Session <i>does not</i> have read access to.
	 * @throws {@link ItemExistsException}
	 *    If any of the changes to be persisted would be prevented by the
	 *    presence of an already existing item in the workspace.
	 * @throws {@link LockException}
	 *    If any of the changes to be persisted would violate a lock.
	 * @throws {@link ConstraintViolationException}
	 *    If any of the changes to be persisted would violate a node type or
	 *    restriction. Additionally, a repository may use this exception to
	 *    enforce implementation- or configuration-dependent restrictions.
	 * @throws {@link InvalidItemStateException}
	 *    If any of the changes to be persisted conflicts with a change already
	 *    persisted through another session and the implementation is such that
	 *    this conflict can only be detected at save-time and therefore was not
	 *    detected earlier, at change-time.
	 * @throws {@link ReferentialIntegrityException}
	 *    If any of the changes to be persisted would cause the removal of a
	 *    node that is currently referenced by a <i>REFERENCE</i> property
	 *    that this {@link Session} has read access to.
	 * @throws {@link VersionException}
	 *    If the {@link save()} would make a result in a change to persistent
	 *    storage that would violate the read-only status of a checked-in node.
	 * @throws {@link LockException}
	 *    If the {@link save()} would result in a change to persistent storage
	 *    that would violate a lock.
	 * @throws {@link NoSuchNodeTypeException}
	 *    If the {@link save()} would result in the addition of a node with an
	 *    unrecognized node type.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function save();

	/**
	 * Refresh this {@link Session} from the persistant storage.
	 *
	 * If <i>keepChanges</i> is <i>false</i>, this method discards
	 * all pending changes currently recorded in this {@link Session} and
	 * returns all items to reflect the current saved state. Outside a
	 * transaction this state is simply the current state of persistent storage.
	 * Within a transaction, this state will reflect persistent storage as
	 * modified by changes that have been saved but not yet committed.
	 *
	 * If <i>keepChanges</i> is true then pending change are not
	 * discarded but items that do not have changes pending have their state
	 * refreshed to reflect the current saved state, thus revealing changes
	 * made by other sessions.
	 *
	 * @param boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function refresh($keepChanges);

	/**
	 * Returns <i>true</i> if this session holds pending (that is,
	 * unsaved) changes; otherwise returns <i>false</i>.
	 *
	 * @return boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs
	 */
	public function hasPendingChanges();

	/**
	 * This method returns a {@link ValueFactory} that is used to create
	 * {@link Value} objects for use when setting repository properties.
	 *
	 * If writing to the repository is not supported (because this is a
	 * level 1-only implementation, for example) an
	 * {@link UnsupportedRepositoryOperationException} will be thrown.
	 *
	 * @return object
	 *	A {@link ValueFactory} object
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If writing to the repository is not supported.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getValueFactory();

	/**
	 * Determines whether this {@link Session} has permission to perform the
	 * specified actions at the specified <i>$absPath</i>.
	 *
	 * This method quietly returns if the access request is permitted, or
	 * throws a suitable {@link AccessControlException} otherwise.
	 *
	 * The <i>actions</i> parameter is a comma separated list of action
	 * strings. The following action strings are defined:
	 * <ul>
	 *    <li>
	 *        <i>add_node</i>: If
	 *        <i>checkPermission(path, "add_node")</i> returns quietly,
	 *        then this {@link Session} has permission to add a node at
	 *        <i>path</i>, otherwise permission is denied.
	 *    </li>
	 *    <li>
	 *        <i>set_property</i>: If
	 *        <i>checkPermission(path, "set_property")</i> returns
	 *        quietly, then this {@link Session} has permission to set (add or
	 *        change) a property at <i>path</i>, otherwise permission is
	 *        denied.
	 *    </li>
	 *    <li>
	 *        <i>remove</i>: If
	 *        <i>checkPermission(path, "remove")</i> returns quietly,
	 *        then this {@link Session} has permission to remove an item at
	 *        <i>path</i>, otherwise permission is denied.
	 *    </li>
	 *    <li>
	 *        <i>read</i>: If <i>checkPermission(path, "read")</i>
	 *        returns quietly, then this {@link Session} has permission to
	 *        retrieve (and read the value of, in the case of a property) an
	 *        item at <i>path</i>, otherwise permission is denied.
	 *    </li>
	 * </ul>
	 *
	 * When more than one action is specified in the <i>actions</i>
	 * parameter, this method will only return quietly if this {@link Session}
	 * has permission to perform <i>all</i> of the listed actions at the
	 * specified path.
	 *
	 * The information returned through this method will only reflect access
	 * control policies and not other restrictions that may exist. For example,
	 * even though <i>checkPermission</i> may indicate that a particular
	 * {@link Session} may add a property at <i>/A/B/C</i>, the node type
	 * of the node at <i>/A/B</i> may prevent the addition of a property
	 * called <i>C</i>.
	 *
	 * @throws {@link AccessControlException}
	 *    If permission is denied.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function checkPermission($absPath, $actions);

	/**
	 * Returns an <i>org.xml.sax.ContentHandler</i> which can be used to
	 * push SAX events into the repository. If the incoming XML stream (in the
	 * form of SAX events) does not appear to be a JCR <i>system view</i> XML
	 * document then it is interpreted as a JCR <i>document view</i> XML
	 * document.
	 *
	 * The incoming XML is deserialized into a subtree of items immediately
	 * below the node at <i>parentAbsPath</i>.
	 *
	 * This method simply returns the <i>ContentHandler</i> without
	 * altering the state of the session; the actual deserialization to the
	 * session transient space is done through the methods of the
	 * <i>ContentHandler</i>. Invalid XML data
	 * will cause the <i>ContentHandler</i> to throw a
	 * {@link SAXException}.
	 *
	 * As SAX events are fed into the <i>ContentHandler</i>, the tree of
	 * new items is built in the transient storage of the session. In order to
	 * persist the new content, {@link save()} must be called. The advantage
	 * of this through-the-session method is that (depending on which constraint
	 * checks the implementation leaves until {@link save()}) structures that
	 * violate node type constraints can be imported, fixed and then saved. The
	 * disadvantage is that a large import will result in a large cache of
	 * pending nodes in the session. See
	 * {@link Workspace::getImportContentHandler()} for a version of this
	 * method that does not go through the session.
	 *
	 * The flag <i>uuidBehavior</i> governs how the UUIDs of incoming
	 * (deserialized) nodes are handled. There are four options:
	 * <ul>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_CREATE_NEW}: Incoming referenceable
	 * nodes are added in the same way that new node is added with
	 * <i>Node.addNode</i>. That is, they are either assigned newly
	 * created UUIDs upon addition or upon {@link save()} (depending on the
	 * implementation). In either case, UUID collisions will not occur.
	 * </li>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REMOVE_EXISTING}: If an
	 * incoming referenceable node has the same UUID as a node already existing
	 * in the workspace then the already existing node (and its subtree) is
	 * removed from wherever it may be in the workspace before the incoming node
	 * is added. Note that this can result in nodes �disappearing� from
	 * locations in the workspace that are remote from the location to which the
	 * incoming subtree is being written. Both the removal and the new addition
	 * will be persisted on {@link save()}.
	 * </li>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REPLACE_EXISTING}: If an
	 * incoming referenceable node has the same UUID as a node already existing
	 * in the workspace, then the already-existing node is replaced by the
	 * incoming node in the same position as the existing node. Note that this
	 * may result in the incoming subtree being disaggregated and �spread
	 * around� to different locations in the workspace. In the most extreme case
	 * this behavior may result in no node at all being added as child of
	 * <i>parentAbsPath</i>. This will occur if the topmost element of the
	 * incoming XML has the same UUID as an existing node elsewhere in the
	 * workspace. The change will be persisted on {@link save()}.
	 * </li>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_THROW}: If an incoming
	 * referenceable node has the same UUID as a node already existing in the
	 * workspace then a {@link SAXException} is thrown by the
	 * <i>ContentHandler</i> during deserialization.
	 * </li>
	 * </ul>
	 * Unlike <i>Workspace.getImportContentHandler</i>, this method does not necessarily
	 * enforce all node type constraints during deserialization. Those that
	 * would be immediately enforced in a normal write method (<i>Node.addNode</i>,
	 * <i>Node.setProperty</i> etc.) of this implementation cause the returned
	 * <i>ContentHandler</i> to throw an immediate {@link SAXException} during deserialization.
	 * All other constraints are checked on save, just as they are in normal
	 * write operations. However, which node type constraints are enforced depends upon whether node type
	 * information in the imported data is respected, and this is an implementation-specific issue.
	 *
	 * A {@link SAXException} will also be thrown by the returned
	 * <i>ContentHandler</i> during deserialization if <i>uuidBehavior</i> is set to
	 * <i>IMPORT_UUID_COLLISION_REMOVE_EXISTING</i> and an incoming node has the same
	 * UUID as the node at <i>parentAbsPath</i> or one of its ancestors.
	 *
	 * A {@link PathNotFoundException} is thrown either immediately or on {@link save()}
	 * if no node exists at <i>parentAbsPath</i>. Implementations may differ on when this
	 * validation is performed
	 *
	 * A {@link ConstraintViolationException} is thrown either immediately or on {@link save()}
	 * if the new subtree cannot be added to the node at parentAbsPath due to node-type or other
	 * implementation-specific constraints, and this can be determined before the first SAX event is sent.
	 * Implementations may differ on when this validation is performed.
	 *
	 * A {@link VersionException} is thrown either immediately or on {@link save()} if the node at
	 * <i>parentAbsPath</i> is versionable and checked-in, or is non-versionable but
	 * its nearest versionable ancestor is checked-in. Implementations may differ on when this validation is performed.
	 *
	 * A {@link LockException} is thrown either immediately or on {@link save()}
	 * if a lock prevents the addition of the subtree. Implementations may differ on when this validation is performed.
	 *
	 * @param parentAbsPath the absolute path of a node under which (as child) the imported subtree will be
	 * built.
	 * @param uuidBehavior a four-value flag that governs how incoming UUIDs are handled.
	 * @return an org.xml.sax.ContentHandler whose methods may be called to feed SAX events
	 * into the deserializer.
	 * @throws {@link PathNotFoundException}
	 *    If no node exists at <i>parentAbsPath</i> and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If the new subtree cannot be added to the node at
	 * <i>parentAbsPath</i> due to node-type or other implementation-specific constraints,
	 * and this implementation performs this validation immediately instead of waiting until {@link save()}.
	 * @throws {@link VersionException}
	 *    If the node at <i>parentAbsPath</i> is versionable
	 * and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}..
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the subtree and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}..
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 *
	 * @todo Determine how to handle this...
	 */
	public function getImportContentHandler($parentAbsPath, $uuidBehavior);

	/**
	 * Deserializes an XML document and adds the resulting item subtree as a
	 * child of the node at parentAbsPath.
	 *
	 * If the incoming XML stream does not appear to be a JCR <i>system view</i>
	 * XML document then it is interpreted as a <i>document view</i> XML
	 * document.
	 *
	 * The tree of new items is built in the transient storage of the Session.
	 * In order to persist the new content, {@link save()} must be called.
	 * The advantage of this through-the-session method is that (depending on
	 * what constraint checks the implementation leaves until {@link save()})
	 * structures that violate node type constraints can be imported, fixed and
	 * then saved. The disadvantage is that a large import will result in a
	 * large cache of pending nodes in the session. See {@link
	 * Workspace#importXML} for a version of this method that does not go
	 * through the {@link Session}.
	 *
	 * The flag <i>uuidBehavior</i> governs how the UUIDs of incoming
	 * (deserialized) nodes are handled. There are four options:
	 * <ul>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_CREATE_NEW}: Incoming referenceable nodes
	 * are added in the same way that new node is added with
	 * <i>Node.addNode</i>. That is, they are either assigned newly
	 * created UUIDs upon addition or upon {@link save()} (depending on the
	 * implementation). In either case, UUID collisions will not occur.
	 * </li>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REMOVE_EXISTING}: If an incoming
	 * referenceable node has the same UUID as a node already existing in the
	 * workspace then the already existing node (and its subtree) is removed
	 * from wherever it may be in the workspace before the incoming node is
	 * added. Note that this can result in nodes �disappearing� from locations
	 * in the workspace that are remote from the location to which the incoming
	 * subtree is being written. Both the removal and the new addition will be
	 * persisted on {@link save()}.
	 * </li>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REPLACE_EXISTING}: If an incoming
	 * referenceable node has the same UUID as a node already existing in the
	 * workspace, then the already-existing node is replaced by the incoming
	 * node in the same position as the existing node. Note that this may result
	 * in the incoming subtree being disaggregated and �spread around� to
	 * different locations in the workspace. In the most extreme case this
	 * behavior may result in no node at all being added as child of
	 * <i>parentAbsPath</i>. This will occur if the topmost element of the
	 * incoming XML has the same UUID as an existing node elsewhere in the
	 * workspace. The change will only be persisted on {@link save()}.
	 * </li>
	 * <li>
	 * {@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_THROW}: If an incoming
	 * referenceable node has the same UUID as a node already existing in the
	 * workspace then an {@link ItemExistsException} is thrown.
	 * </li>
	 * </ul>
	 * Unlike {@link Workspace::importXML()}, this method does not necessarily
	 * enforce all node type constraints during deserialization. Those that
	 * would be immediately enforced in a normal write method
	 * (<i>Node.addNode</i>, <i>Node.setProperty</i> etc.) of this
	 * implementation cause an immediate
	 * {@link ConstraintViolationException} during deserialization. All
	 * other constraints are checked on {@link save()}, just as they are in
	 * normal write operations. However, which node type constraints are enforced
	 * depends upon whether node type information in the imported data is respected,
	 * and this is an implementation-specific issue.
	 *
	 * A {@link ConstraintViolationException} will also be thrown
	 * immediately if <i>uuidBehavior</i> is set to
	 * <i>IMPORT_UUID_COLLISION_REMOVE_EXISTING</i> and an incoming node
	 * has the same UUID as the node at <i>parentAbsPath</i> or one of its
	 * ancestors.
	 *
	 * A {@link PathNotFoundException} is thrown either immediately or on {@link save()}
	 * if no node exists at <i>parentAbsPath</i>. Implementations may differ on when this
	 * validation is performed
	 *
	 * A {@link ConstraintViolationException} is thrown either immediately or on {@link save()}
	 * if the new subtree cannot be added to the node at parentAbsPath due to node-type or other
	 * implementation-specific constraints, and this can be determined before the first SAX event is sent.
	 * Implementations may differ on when this validation is performed.
	 *
	 * A {@link VersionException} is thrown either immediately or on {@link save()} if the node at
	 * <i>parentAbsPath</i> is versionable and checked-in, or is non-versionable but
	 * its nearest versionable ancestor is checked-in. Implementations may differ on when this validation is performed.
	 *
	 * A {@link LockException} is thrown either immediately or on {@link save()}
	 * if a lock prevents the addition of the subtree. Implementations may differ on when this validation is performed.
	 *
	 * @param parentAbsPath the absolute path of the node below which the deserialized subtree is added.
	 * @param in The <i>Inputstream</i> from which the XML to be deserilaized is read.
	 * @param uuidBehavior a four-value flag that governs how incoming UUIDs are handled.
	 *
	 * @throws {@link java}
	 *    .io.IOException if an error during an I/O operation occurs.
	 * @throws {@link PathNotFoundException}
	 *    If no node exists at <i>parentAbsPath</i> and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}..
	 * @throws {@link ItemExistsException}
	 *    If deserialization would overwrite an existing item and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}..
	 * @throws {@link ConstraintViolationException}
	 *    If a node type or other implementation-specific
	 * constraint is violated that would be checked on a normal write method or if
	 * <i>uuidBehavior</i> is set to <i>IMPORT_UUID_COLLISION_REMOVE_EXISTING</i>
	 * and an incoming node has the same UUID as the node at <i>parentAbsPath</i> or one
	 * of its ancestors.
	 * @throws {@link VersionException}
	 *    If the node at <i>parentAbsPath</i> is versionable
	 * and checked-in, or its nearest versionable ancestor is checked-in and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}..
	 * @throws {@link InvalidSerializedDataException}
	 *    If incoming stream is not a valid XML document.
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the subtree and this
	 * implementation performs this validation immediately instead of waiting until {@link save()}..
	 * @throws {@link RepositoryException}
	 *     if another error occurs.
	 *
	 * @todo Determine how to handle this...
	 */
	public function importXML($parentAbsPath, $in, $uuidBehavior);

	/**
	 * Serializes the node (and if <i>$noRecurse</i> is <i>false</i>,
	 * the whole subtree) at <i>$absPath</i> and return a
	 * {@link http://us3.php.net/manual/en/ref.dom.php DOMDocument}.
	 *
	 * The resulting XML is in the system view form. Note that <i>$absPath</i>
	 * must be the path of a node, not a property.
	 *
	 * If <i>$skipBinary</i> is true then any properties of
	 * {@link PropertyType::BINARY} will be serialized as if they are empty.
	 * That is, the existence of the property will be serialized, but its
	 * content will not appear in the serialized output (the
	 * <i>&lt;sv:value&gt;</i> element will have no content). Note that in the
	 * case of multi-value <i>BINARY</i> properties, the number of values in the
	 * property will be reflected in the serialized output, though they will all
	 * be empty. If <i>$skipBinary</i> is false then the actual value(s) of
	 * each <i>BINARY</i> property is recorded using Base64 encoding.
	 *
	 * If <i>$noRecurse</i> is true then only the node at <i>$absPath</i> and
	 * its properties, but not its child nodes, are serialized. If
	 * <i>$noRecurse</i> is <i>false</i> then the entire subtree rooted at
	 * <i>$absPath</i> is serialized.
	 *
	 * If the user lacks read access to some subsection of the specified tree,
	 * that section simply does not get serialized, since, from the user's
	 * point of view, it is not there.
	 *
	 * The serialized output will reflect the state of the current workspace as
	 * modified by the state of this {@link Session}. This means that
	 * pending changes (regardless of whether they are valid according to
	 * node type constraints) and the current session-mapping of namespaces
	 * are reflected in the output.
	 *
	 * <i>PHP Node</i>: This deviates from the JSR-170 standard as it does not
	 * seem to make sense to pass a referenced parameter in, thus I have opted
	 * to remove the <i>$out</i> parameter in favor of returning the results
	 * of this method, something that seems much more PHP-like.
	 *
	 * @param absPath The path of the root of the subtree to be serialized.
	 * This must be the path to a node, not a property
	 * @param skipBinary A <i>boolean</i> governing whether binary
	 * properties are to be serialized.
	 * @param noRecurse A <i>boolean</i> governing whether the subtree at
	 * absPath is to be recursed.
	 *
	 * @return object
	 *	A {@link http://us3.php.net/manual/en/ref.dom.php DOMDocument} object.
	 *
	 * @throws {@link PathNotFoundException}
	 *    If no node exists at <i>$absPath</i>.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function exportSystemView($absPath, $skipBinary, $noRecurse);

	/**
	 * Serializes the node (and if <i>noRecurse</i> is <i>false</i>,
	 * the whole subtree) at <i>absPath</i> as an XML stream and outputs it to
	 * the supplied <i>OutputStream</i>. The resulting XML is in the document
	 * view form. Note that <i>absPath</i> must be the path of a node, not a property.
	 *
	 * If <i>skipBinary</i> is true then any properties of <i>PropertyType.BINARY</i> will be
	 * serialized as if they are empty. That is, the existence of the property
	 * will be serialized, but its content will not appear in the serialized
	 * output (the value of the attribute will be empty). If <i>skipBinary</i> is false
	 * then the actual value(s) of each <i>BINARY</i> property is recorded using Base64
	 * encoding.
	 *
	 * If <i>noRecurse</i> is true then only the node at
	 * <i>absPath</i> and its properties, but not its child nodes, are
	 * serialized. If <i>noRecurse</i> is <i>false</i> then the entire subtree
	 * rooted at <i>absPath</i> is serialized.
	 *
	 * If the user lacks read access to some subsection of the specified tree,
	 * that section simply does not get serialized, since, from the user's
	 * point of view, it is not there.
	 *
	 * The serialized output will reflect the state of the current workspace as
	 * modified by the state of this {@link Session}. This means that
	 * pending changes (regardless of whether they are valid according to
	 * node type constraints) and the current session-mapping of namespaces
	 * are reflected in the output.
	 *
	 * A {@link PathNotFoundException} is thrown if no node exists at <i>absPath</i>.
	 *
	 * A {@link SAXException} is thrown if an error occurs while feeding events to the
	 * <i>ContentHandler</i>.
	 *
	 * @param absPath The path of the root of the subtree to be serialized.
	 * This must be the path to a node, not a property
	 * @param out The <i>OutputStream</i> to which the XML
	 * serialization of the subtree will be output.
	 * @param skipBinary A <i>boolean</i> governing whether binary
	 * properties are to be serialized.
	 * @param noRecurse A <i>boolean</i> governing whether the subtree at
	 * absPath is to be recursed.
	 *
	 * @throws {@link PathNotFoundException}
	 *    If no node exists at <i>absPath</i>.
	 * @throws {@link IOException}
	 *    If an error during an I/O operation occurs.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 *
	 * @todo Determine how to handle this
	 */
	public function exportDocumentView($absPath, $out, $skipBinary, $noRecurse);

	/**
	 * Within the scope of this session, rename a persistently registered
	 * namespace URI to the new prefix.  The renaming only affects operations
	 * done through this session. To clear all renamings the client must acquire
	 * a new session.
	 *
	 * A prefix that is currently already mapped to some URI (either
	 * persistently in the repository <i>NamespaceRegistry</i> or
	 * transiently within this {@link Session}) cannot be remapped to a new
	 * URI using this method, since this would make any content stored using
	 * the old URI unreadable. An attempt to do this will throw a
	 * {@link NamespaceException}.
	 *
	 * As well, a {@link NamespaceException} will be thrown if an attempt is
	 * made to remap an existing namespace URI to a prefix beginning with the
	 * characters "<i>xml</i>" (in any combination of case).
	 *
	 * A {@link NamespaceException} will also be thrown ifthe specified uri is
	 * not among those registered in the {@link NamespaceRegistry}.
	 *
	 * @param string
	 * @param string
	 *
	 * @throws {@link NamespaceException}
	 *    If the specified uri is not registered or an attempt is made to remap
	 *    to an illegal prefix.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function setNamespacePrefix($prefix, $uri);

	/**
	 * Returns all prefixes currently set for this session. This includes all
	 * those registered in the {@link NamespaceRegistry} but <i>not
	 * over-ridden</i> by a {@link Session::setNamespacePrefix()}, plus those
	 * currently set locally by {@link Session::setNamespacePrefix()}.
	 *
	 * @return array
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs
	 */
	public function getNamespacePrefixes();

	/**
	 * For a given prefix, returns the URI to which it is mapped as currently
	 * set in this {@link Session}. If the prefix is unknown, a {@link NamespaceException} is thrown.
	 *
	 * @param string
	 * @return string
	 *
	 * @throws {@link NamespaceException}
	 *    If the prefix is unknown.
	 * @throws {@link RepositoryException}
	 *    If another error occurs
	 */
	public function getNamespaceURI($prefix);

	/**
	 * Returns the prefix to which the given URI is mapped
	 *
	 * @param string
	 * @return string
	 *
	 * @throws {@link NamespaceException}
	 *    If the URI is unknown.
	 * @throws {@link RepositoryException}
	 *    If another error occurs
	 */
	public function getNamespacePrefix($uri);

	/**
	 * Releases all resources associated with this {@link Session}.
	 *
	 * This method should be called when a {@link Session} is no longer needed.
	 */
	public function logout();

	/**
	 * Returns <i>true</i> if this {@link Session} object is usable
	 * by the client. Otherwise, returns <i>false</i>.
	 *
	 * A usable {@link Session} is one that is neither logged-out, timed-out
	 * nor in any other way disconnected from the repository.
	 *
	 * @return boolean
	 */
	public function isLive();

	/**
	 * Adds the specified lock token to this session.
	 *
	 * Holding a lock token allows the {@link Session} object of the lock owner
	 * to alter nodes that are locked by the lock specified by that particular
	 * lock token.
	 *
	 * @param string
	 */
	public function addLockToken($lt);

	/**
	 * Returns an array containing all lock tokens currently held by this
	 * session.
	 *
	 * @return array
	 */
	public function getLockTokens();

	/**
	 * Removes the specified lock token from this session.
	 *
	 * @param string
	 */
	public function removeLockToken($lt);
}

?>