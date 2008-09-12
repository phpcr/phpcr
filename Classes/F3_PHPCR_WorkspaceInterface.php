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
 * The Workspace object represents a "view" of an actual repository workspace
 * entity as seen through the authorization settings of its associated Session.
 * Each Workspace object is associated one-to-one with a Session object. The
 * Workspace object can be acquired by calling Session.getWorkspace() on the
 * associated Session object.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface WorkspaceInterface {

	/**
	 * Returns the Session object through which this Workspace object was acquired.
	 *
	 * @return F3::PHPCR::SessionInterface a Session object.
	 */
	public function getSession();

	/**
	 * Returns the name of the actual persistent workspace represented by this
	 * Workspace object. This the name used in Repository->login.
	 *
	 * @return string the name of this workspace.
	 */
	public function getName();

	/**
	 * This method copies the node at srcAbsPath to the new location at
	 * destAbsPath.
	 * The new copies of nodes are automatically given new identifiers and
	 * referenceable nodes in particular are always given new referenceable
	 * identifiers.
	 *
	 * If srcWorkspace is given:
	 * This method copies the subtree at srcAbsPath in srcWorkspace to
	 * destAbsPath in this workspace.
	 * Unlike clone, this method does assign new referenceable identifiers
	 * to the new copies of referenceable nodes. In the case of
	 * non-referenceable nodes, this method may assign new identifiers.
	 *
	 * This operation is performed entirely within the persistent workspace,
	 * it does not involve transient storage and therefore does not require
	 * a save.
	 *
	 * When the source subtree in a copy operation includes both a reference
	 * property (P) and the node to which it refers (N) then not only does the
	 * new copy of the referenceable node (N') get a new identifier but the new
	 * copy of the reference property (P') is changed so that it points to N',
	 * thus preserving the reference within the subtree.
	 *
	 * The destAbsPath provided must not have an index on its final element. If
	 * it does then a RepositoryException is thrown. Strictly speaking, the
	 * destAbsPath parameter is actually an absolute path to the parent node of
	 * the new location, appended with the new name desired for the copied node.
	 * It does not specify a position within the child node ordering. If ordering
	 * is supported by the node type of the parent node of the new location, then
	 * the new copy of the node is appended to the end of the child node list.
	 *
	 * This method cannot be used to copy just an individual property by itself.
	 * It copies an entire node and its subtree (including, of course, any
	 * properties contained therein).
	 *
	 * @param string $srcAbsPath the path of the node to be copied.
	 * @param string $destAbsPath the location to which the node at srcAbsPath is to be copied in this workspace.
	 * @param string $srcWorkspace the name of the workspace from which the copy is to be made.
	 * @return void
	 * @throws F3::PHPCR::NoSuchWorkspaceException if srcWorkspace does not exist or if the current Session does not have permission to access it.
	 * @throws F3::PHPCR::ConstraintViolationException if the operation would violate a node-type or other implementation-specific constraint
	 * @throws F3::PHPCR::Version::VersionException if the parent node of destAbsPath is versionable and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws F3::PHPCR::AccessDeniedException if the current session does have permission to access srcWorkspace but otherwise does not have sufficient access rights to complete the operation.
	 * @throws F3::PHPCR::PathNotFoundException if the node at srcAbsPath in srcWorkspace or the parent of destAbsPath in this workspace does not exist.
	 * @throws F3::PHPCR::ItemExistsException if a node already exists at destAbsPath and same-name siblings are not allowed.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the copy.
	 * @throws F3::PHPCR::RepositoryException if the last element of destAbsPath has an index or if another error occurs.
	 */
	public function copy($srcAbsPath, $destAbsPath, $srcWorkspace = NULL);

	/**
	 * Clones the subtree at the node srcAbsPath in srcWorkspace to the new
	 * location at destAbsPath in this workspace.
	 * Unlike the signature of copy that copies between workspaces, this method
	 * does not assign new identifiers to the newly cloned nodes but preserves
	 * the identifiers of their respective source nodes. This applies to both
	 * referenceable and non-referenceable nodes.
	 *
	 * In some implementations there may be cases where preservation of a
	 * non-referenceable identifier is not possible, due to how non-referenceable
	 * identifiers are constructed in that implementation. In such a case this
	 * method will throw a RepositoryException.
	 *
	 * If removeExisting is true and an existing node in this workspace (the
	 * destination workspace) has the same identifier as a node being cloned
	 * from srcWorkspace, then the incoming node takes precedence, and the
	 * existing node (and its subtree) is removed. If removeExisting is false
	 * then an identifier collision causes this method to throw a
	 * ItemExistsException and no changes are made.
	 *
	 * If successful, the change is persisted immediately, there is no need
	 * to call save.
	 *
	 * The destAbsPath provided must not have an index on its final element.
	 * If it does then a RepositoryException is thrown. Strictly speaking,
	 * the destAbsPath parameter is actually an absolute path to the parent
	 * node of the new location, appended with the new name desired for the
	 * cloned node. It does not specify a position within the child node ordering.
	 * If ordering is supported by the node type of the parent node of the new
	 * location, then the new clone of the node is appended to the end of the
	 * child node list.
	 *
	 * This method cannot be used to clone just an individual property by itself.
	 * It clones an entire node and its subtree (including, of course, any
	 * properties contained therein).
	 *
	 * @param string $srcWorkspace - The name of the workspace from which the node is to be copied.
	 * @param string $srcAbsPath - the path of the node to be copied in srcWorkspace.
	 * @param string $destAbsPath - the location to which the node at srcAbsPath is to be copied in this workspace.
	 * @param boolean $removeExisting - if false then this method throws an ItemExistsException on identifier conflict with an incoming node. If true then a identifier conflict is resolved by removing the existing node from its location in this workspace and cloning (copying in) the one from srcWorkspace.
	 * @return void
	 * @throws F3::PHPCR::NoSuchWorkspaceException if destWorkspace does not exist.
	 * @throws F3::PHPCR::ConstraintViolationException if the operation would violate a node-type or other implementation-specific constraint.
	 * @throws F3::PHPCR::Version::VersionException if the parent node of destAbsPath is versionable and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in. This exception will also be thrown if removeExisting is true, and an identifier conflict occurs that would require the moving and/or altering of a node that is checked-in.
	 * @throws F3::PHPCR::AccessDeniedException if the current session does not have sufficient access rights to complete the operation.
	 * @throws F3::PHPCR::PathNotFoundException if the node at srcAbsPath in srcWorkspace or the parent of destAbsPath in this workspace does not exist.
	 * @throws F3::PHPCR::ItemExistsException if a node already exists at destAbsPath and same-name siblings are not allowed or if removeExisting is false and an identifier conflict occurs.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the clone.
	 * @throws F3::PHPCR::RepositoryException if the last element of destAbsPath has an index or if another error occurs.
	 */
	public function klone($srcWorkspace, $srcAbsPath, $destAbsPath, $removeExisting);

	/**
	 * Moves the node at srcAbsPath (and its entire subtree) to the new location
	 * at destAbsPath.
	 * If successful, the change is persisted immediately, there is no need to
	 * call save. Note that this is in contrast to
	 * Session->move($srcAbsPath, $destAbsPath) which operates within the transient
	 * space and hence requires a save.
	 *
	 * The identifiers of referenceable nodes must not be changed by a move. The
	 * identifiers of non-referenceable nodes may change.
	 *
	 * The destAbsPath provided must not have an index on its final element. If
	 * it does then a RepositoryException is thrown. Strictly speaking, the
	 * destAbsPath parameter is actually an absolute path to the parent node of
	 * the new location, appended with the new name desired for the moved node.
	 * It does not specify a position within the child node ordering. If ordering
	 * is supported by the node type of the parent node of the new location, then
	 * the newly moved node is appended to the end of the child node list.
	 *
	 * This method cannot be used to move just an individual property by itself.
	 * It moves an entire node and its subtree (including, of course, any
	 * properties contained therein).
	 *
	 * The identifiers of referenceable nodes must not be changed by a move. The
	 * identifiers of non-referenceable nodes may change.
	 *
	 * @param string $srcAbsPath the path of the node to be moved.
	 * @param string $destAbsPath the location to which the node at srcAbsPath is to be moved.
	 * @return void
	 * @throws F3::PHPCR::ConstraintViolationException if the operation would violate a node-type or other implementation-specific constraint
	 * @throws F3::PHPCR::Version::VersionException if the parent node of destAbsPath or the parent node of srcAbsPath is versionable and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws F3::PHPCR::AccessDeniedException if the current session (i.e. the session that was used to acquire this Workspace object) does not have sufficient access rights to complete the operation.
	 * @throws F3::PHPCR::PathNotFoundException if the node at srcAbsPath or the parent of destAbsPath does not exist.
	 * @throws F3::PHPCR::ItemExistsException if a node already exists at destAbsPath and same-name siblings are not allowed.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the move.
	 * @throws F3::PHPCR::RepositoryException if the last element of destAbsPath has an index or if another error occurs.
	 */
	public function move($srcAbsPath, $destAbsPath);

	/**
	 * Restores a set of versions at once. Used in cases where a "chicken and egg"
	 * problem of mutually referring REFERENCE properties would prevent the restore
	 * in any serial order.
	 * If the restore succeeds the changes made to this node are persisted
	 * immediately, there is no need to call save.
	 *
	 * The following restrictions apply to the set of versions specified:
	 *
	 * If S is the set of versions being restored simultaneously,
	 *
	 * For every version V in S that corresponds to a missing node, there must
	 * also be a parent of V in S.
	 * S must contain at least one version that corresponds to an existing node
	 * in the workspace.
	 * No V in S can be a root version (jcr:rootVersion).
	 * If any of these restrictions does not hold, the restore will fail because
	 * the system will be unable to determine the path locations to which one or
	 *  more versions are to be restored. In this case a VersionException is thrown.
	 * The versionable nodes in this workspace that correspond to the versions
	 * being restored define a set of (one or more) subtrees. An identifier
	 * collision occurs when this workspace contains a node outside these subtrees
	 * that has the same identifier as one of the nodes that would be introduced by
	 * the restore operation into one of these subtrees. The result in such a case
	 * is governed by the removeExisting flag. If removeExisting is true then the
	 * incoming node takes precedence, and the existing node (and its subtree) is
	 * removed. If removeExisting is false then a ItemExistsException is thrown and
	 * no changes are made. Note that this applies not only to cases where the
	 * restored node itself conflicts with an existing node but also to cases where
	 * a conflict occurs with any node that would be introduced into the workspace
	 * by the restore operation. In particular, conflicts involving subnodes of the
	 * restored node that have OnParentVersion settings of COPY or VERSION are also
	 * governed by the removeExisting flag.
	 *
	 * @param array $versions The set of versions (array of F3::PHPCR::Version::VersionInterface) to be restored
	 * @param boolean $removeExisting governs what happens on identifier collision.
	 * @return void
	 * @throws F3::PHPCR::ItemExistsException if removeExisting is false and an identifier collision occurs with a node being restored.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if one or more of the nodes to be restored is not versionable.
	 * @throws F3::PHPCR::Version::VersionException if the set of versions to be restored is such that the original path location of one or more of the versions cannot be determined or if the restore would change the state of a existing versionable node that is currently checked-in or if a root version (jcr:rootVersion) is among those being restored.
	 * @throws F3::PHPCR::Version::LockException if a lock prevents the restore.
	 * @throws F3::PHPCR::InvalidItemStateException if this Session has pending unsaved changes.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function restore(array $versions, $removeExisting);

	/**
	 * Returns the LockManager object, through which locking methods are accessed.
	 *
	 * @return F3::PHPCR::Lock::LockManagerInterface
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if the implementation does not support locking.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getLockManager();

	/**
	 * Returns the QueryManager object, through search methods are accessed.
	 *
	 * @return F3::PHPCR::Query::QueryManagerInterface the QueryManager object.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getQueryManager();

	/**
	 * Returns the NamespaceRegistry object, which is used to access the mapping
	 * between prefixes and namespaces. In level 2 repositories the NamespaceRegistry
	 * can also be used to change the namespace mappings.
	 *
	 * @return F3::PHPCR::NamespaceRegistryInterface the NamespaceRegistry.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getNamespaceRegistry();

	/**
	 * Returns the NodeTypeManager through which node type information can be queried.
	 * There is one node type registry per repository, therefore the NodeTypeManager
	 * is not workspace-specific; it provides introspection methods for the global,
	 * repository-wide set of available node types. In repositories that support it,
	 * the NodeTypeManager can also be used to register new node types.
	 *
	 * @return F3::PHPCR::NodeType::NodeTypeManagerInterface a NodeTypeManager object.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getNodeTypeManager();

	/**
	 * Returns the ObservationManager object.
	 *
	 * @return F3::PHPCR::Observation::ObservationManagerInterface an ObservationManager object.
	 * @throws F3::PHPCR::F3::PHPCR::UnsupportedRepositoryOperationException if the implementation does not support observation.
	 * @throws F3::PHPCR::F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getObservationManager();

	/**
	 * Returns a string array containing the names of all workspaces in this
	 * repository that are accessible to this user, given the Credentials that
	 * were used to get the Session to which this Workspace is tied.
	 * In order to access one of the listed workspaces, the user performs
	 * another Repository.login, specifying the name of the desired workspace,
	 * and receives a new Session object.
	 *
	 * @return array string array of names of accessible workspaces.
	 * @throws F3::PHPCR::RepositoryException if an error occurs
	 */
	public function getAccessibleWorkspaceNames();

	/**
	 * Returns an org.xml.sax.ContentHandler which can be used to push SAX events
	 * into the repository. If the incoming XML stream (in the form of SAX events)
	 * does not appear to be a JCR system view XML document then it is interpreted
	 * as a document view XML document.
	 * The incoming XML is deserialized into a subtree of items immediately below
	 * the node at parentAbsPath.
	 *
	 * This method simply returns the ContentHandler without altering the state of
	 * the repository; the actual deserialization is done through the methods of
	 * the ContentHandler. Invalid XML data will cause the ContentHandler to throw
	 * a SAXException.
	 *
	 * As SAX events are fed into the ContentHandler, changes are made directly at
	 * the workspace level, without going through the Session. As a result, there
	 * is not need to call save. The advantage of this direct-to-workspace method
	 * is that a large import will not result in a large cache of pending nodes in
	 * the Session. The disadvantage is that structures that violate node type
	 * constraints cannot be imported, fixed and then saved. Instead, a constraint
	 * violation will cause the ContentHandler to throw a SAXException.
	 * See Session.getImportContentHandler for a version of this method that does go
	 * through the Session.
	 *
	 * The flag uuidBehavior governs how the identifiers of incoming (deserialized)
	 * nodes are handled. There are four options:
	 *
	 * * ImportUUIDBehavior.IMPORT_UUID_CREATE_NEW: Incoming nodes are assigned newly
	 *   created identifiers upon addition to the workspace. As a result identifier
	 *  collisions never occur.
	 * * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an incoming node
	 *   has the same identifier as a node already existing in the workspace, then the
	 *   already existing node (and its subtree) is removed from wherever it may be in
	 *   the workspace before the incoming node is added. Note that this can result in
	 *   nodes "disappearing" from locations in the workspace that are remote from the
	 *   location to which the incoming subtree is being written.
	 * * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an incoming node
	 *   has the same identifier as a node already existing in the workspace then the
	 *   already existing node is replaced by the incoming node in the same position as
	 *   the existing node. Note that this may result in the incoming subtree being
	 *   disaggregated and "spread around" to different locations in the workspace. In
	 *   the most extreme case this behavior may result in no node at all being added as
	 *   child of parentAbsPath. This will occur if the topmost element of the incoming
	 *   XML has the same identifier as an existing node elsewhere in the workspace.
	 * * ImportUUIDBehavior.IMPORT_UUID_COLLISION_THROW: If an incoming node has the same
	 *   identifier as a node already existing in the workspace then a SAXException is
	 *   thrown by the returned ContentHandler during deserialization.
	 * A SAXException will be thrown by the returned ContentHandler during deserialization
	 * if the top-most element of the incoming XML would deserialize to a node with the same
	 * name as an existing child of parentAbsPath and that child does not allow same-name
	 * siblings.
	 * A SAXException will also be thrown by the returned ContentHandler during
	 * deserialization if uuidBehavior is set to IMPORT_UUID_COLLISION_REMOVE_EXISTING
	 * and an incoming node has the same identifier as the node at parentAbsPath or
	 * one of its ancestors.
	 *
	 * @param string $parentAbsPath the absolute path of a node under which (as child) the imported subtree will be built.
	 * @param integer $uuidBehavior a four-value flag that governs how incoming identifiers are handled.
	 * @return an org.xml.sax.ContentHandler whose methods may be called to feed SAX events into the deserializer.
	 * @throws F3::PHPCR::PathNotFoundException if no node exists at parentAbsPath.
	 * @throws F3::PHPCR::ConstraintViolationException if the new subtree cannot be added to the node at parentAbsPath due to node-type or other implementation-specific constraints, and this can be determined before the first SAX event is sent.
	 * @throws F3::PHPCR::Version::VersionException if the node at parentAbsPath is versionable and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the addition of the subtree.
	 * @throws F3::PHPCR::AccessDeniedException if the session associated with this Workspace object does not have sufficient permissions to perform the import.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 * @todo Decide on a return type that fits the PHP world
	 */
	public function getImportContentHandler($parentAbsPath, $uuidBehavior);

	/**
	 * Deserializes an XML document and adds the resulting item subtree as a
	 * child of the node at parentAbsPath.
	 * If the incoming XML stream does not appear to be a JCR system view XML
	 * document then it is interpreted as a document view XML document.
	 *
	 * The passed resource handler is closed before this method returns either
	 * normally or because of an exception.
	 *
	 * Changes are made directly at the workspace level, without going through
	 * the Session. As a result, there is not need to call save. The advantage
	 * of this direct-to-workspace method is that a large import will not result
	 * in a large cache of pending nodes in the Session. The disadvantage is
	 * that invalid data cannot be imported, fixed and then saved. Instead,
	 * invalid data will cause this method to throw an InvalidSerializedDataException.
	 * See Session.importXML for a version of this method that does go through
	 * the Session.
	 *
	 * The flag uuidBehavior governs how the identifiers of incoming (deserialized)
	 * nodes are handled. There are four options:
	 *
	 * * ImportUUIDBehavior.IMPORT_UUID_CREATE_NEW: Incoming nodes are assigned newly
	 *   created identifiers upon addition to the workspace. As a result identifier
	 *   collisions never occur.
	 * * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an incoming node
	 *   has the same identifier as a node already existing in the workspace then the
	 *   already existing node (and its subtree) is removed from wherever it may be
	 *   in the workspace before the incoming node is added. Note that this can result
	 *   in nodes "disappearing" from locations in the workspace that are remote from
	 *   the location to which the incoming subtree is being written. If an incoming
	 *   node has the same identifier as the existing root node of this workspace then
	 * * ImportUUIDBehavior.IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an incoming node
	 *   has the same identifier as a node already existing in the workspace then the
	 *   already existing node is replaced by the incoming node in the same position as
	 *   the existing node. Note that this may result in the incoming subtree being
	 *   disaggregated and "spread around" to different locations in the workspace. In
	 *   the most extreme edge case this behavior may result in no node at all being
	 *   added as child of parentAbsPath. This will occur if the topmost element of the
	 *   incoming XML has the same identifier as an existing node elsewhere in the
	 *   workspace.
	 * * ImportUUIDBehavior.IMPORT_UUID_COLLISION_THROW: If an incoming node has the
	 *   same identifier as a node already existing in the workspace then an
	 *   ItemExistsException is thrown.
	 *
	 * @param string $parentAbsPath the absolute path of the node below which the deserialized subtree is added.
	 * @param resource $in The resource handler from which the XML to be deserialized is read.
	 * @param integer $uuidBehavior a four-value flag that governs how incoming identifiers are handled.
	 * @return void
	 * @throws RuntimeException if an error during an I/O operation occurs.
	 * @throws F3::PHPCR::PathNotFoundException if no node exists at parentAbsPath.
	 * @throws F3::PHPCR::ConstraintViolationException if node-type or other implementation-specific constraints prevent the addition of the subtree or if uuidBehavior is set to IMPORT_UUID_COLLISION_REMOVE_EXISTING and an incoming node has the same identifier as the node at parentAbsPath or one of its ancestors.
	 * @throws F3::PHPCR::Version::VersionException if the node at parentAbsPath is versionable and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws F3::PHPCR::InvalidSerializedDataException if incoming stream is not a valid XML document.
	 * @throws F3::PHPCR::ItemExistsException if the top-most element of the incoming XML would deserialize to a node with the same name as an existing child of parentAbsPath and that child does not allow same-name siblings, or if a uuidBehavior is set to IMPORT_UUID_COLLISION_THROW and an identifier collision occurs.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the addition of the subtree.
	 * @throws F3::PHPCR::AccessDeniedException if the session associated with this Workspace object does not have sufficient permissions to perform the import.
	 * @throws F3::PHPCR::RepositoryException is another error occurs.
	 */
	public function importXML($parentAbsPath, $in, $uuidBehavior);

	/**
	 * Creates a new Workspace with the specified name. The new workspace is
	 * empty, meaning it contains only root node.
	 *
	 * If srcWorkspace is given:
	 * Creates a new Workspace with the specified name initialized with a
	 * clone of the content of the workspace srcWorkspace. Semantically,
	 * this method is equivalent to creating a new workspace and manually
	 * cloning srcWorkspace to it; however, this method may assist some
	 * implementations in optimizing subsequent Node.update and Node.merge
	 * calls between the new workspace and its source.
	 *
	 * The new workspace can be accessed through a login specifying its name.
	 *
	 * @param string $name A String, the name of the new workspace.
	 * @param string $srcWorkspace The name of the workspace from which the new workspace is to be cloned.
	 * @return void
	 * @throws F3::PHPCR::AccessDeniedException if the session through which this Workspace object was acquired does not have permission to create the new workspace.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if the repository does not support the creation of workspaces.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function createWorkspace($name, $srcWorkspace = NULL);

	/**
	 * Deletes the workspace with the specified name from the repository,
	 * deleting all content within it.
	 *
	 * @param string $name A String, the name of the workspace to be deleted.
	 * @return void
	 * @throws F3::PHPCR::AccessDeniedException if the session through which this Workspace object was acquired does not have permission to remove the workspace.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if the repository does not support the removal of workspaces.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function deleteWorkspace($name);

	/**
	 * This method creates a new nt:activity at an implementation-determined
	 * location in the /jcr:system/jcr:activities subtree.
	 * The repository may, but is not required to, use the title as a hint for
	 * what to name the new activity node. The new activity Node is returned.
	 *
	 * The new node is persisted immediately and does not require a save.
	 *
	 * @param string $title a String
	 * @return F3::PHPCR::NodeInterface the new activity Node.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if the repository does not support activities.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function createActivity($title);

	/**
	 * This method merges the changes that were made under the specified activity
	 * into this workspace.
	 * An activity A will be associated with a set of versions through the jcr:activity
	 * reference of each version node in the set. We call each such associated
	 * version a member of A.
	 *
	 * For each version history H that contains one or more members of A, one such
	 * member will be the latest member of A in H. The latest member of A in H is
	 * the version in H that is a member of A and that has no successor versions (to
	 * any degree) that are also members of A.
	 *
	 * The set of versions that are the latest members of A in their respective
	 * version histories is called the change set of A. It fully describes the
	 * changes made under the activity A.
	 *
	 * This method performs a shallow merge into this workspace of each version
	 * in the change set of the activity specified by activityNode. If there is
	 * no corresponding node in this workspace for a given member of the change
	 * set, that member is ignored.
	 *
	 * This method returns a NodeIterator over all versionable nodes in the
	 * subtree that received a merge result of fail.
	 *
	 * @param F3::PHPCR::NodeInterface $activityNode an nt:activity node
	 * @return F3::PHPCR::NodeIteratorInterface a NodeIterator
	 * @throws F3::PHPCR::AccessDeniedException if the current session does not have sufficient rights to perform the operation.
	 * @throws F3::PHPCR::Version::VersionException if the specified node is not an nt:activity node.
	 * @throws F3::PHPCR::MergeException in the same cases as in a regular shallow merge (see Node.merge(String, boolean, boolean)).
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the merge.
	 * @throws F3::PHPCR::InvalidItemStateException if this Session has pending unsaved changes.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function merge(F3::PHPCR::NodeInterface $activityNode);

}

?>