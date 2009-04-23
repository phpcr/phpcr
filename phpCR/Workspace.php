<?php
// $Id: Workspace.interface.php 550 2005-08-26 02:44:12Z tswicegood $

/**
 * This file contains {@link Workspace} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the b created for
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
 * The {@link Workspace} object represents a "view" of an actual repository workspace
 * entity as seen through the authorization settings of its associated {@link Session}.
 *
 * Each {@link Workspace} object is associated one-to-one with a {@link Session}
 * object. The {@link Workspace} object can be acquired by calling
 * {@link Session::getWorkspace()} on the associated {@link Session} object.
 *
 * @package phpContentRepository
 */
interface phpCR_Workspace
{
	/**
	 * Returns the {@link Session} object through which this {@link Workspace}
	 * object was acquired.
	 *
	 * @return phpCR_Session
	 *	A {@link Session} object
	 */
	public function getSession();


	/**
	 * Returns the name of the actual persistent workspace represented by this
	 * {@link Workspace} object.
	 *
	 * @return string
	 */
	public function getName();


	/**
	/**
	 * This method copies the subtree at <i>$srcAbsPath</i> in <i>$srcWorkspace</i>
	 * to <i>$destAbsPath</i> in <i>$this</i> workspace. Unlike <i>$clone</i>,
	 * this method <i>does</i> assign new UUIDs to the new copies of referenceable nodes.
	 * This operation is performed entirely within the persistent workspace, it does not involve
	 * transient storage and therefore does not require a <i>$save</i>.
	 *
	 * Copies of referenceable nodes (nodes with UUIDs) are automatically given new UUIDs.
	 *
	 * The <i>$destAbsPath</i> provided must not
	 * have an index on its final element. If it does then a {@link RepositoryException}
	 * is thrown. Strictly speaking, the <i>$destAbsPath</i> parameter is actually an <i>absolute path</i>
	 * to the parent node of the new location, appended with the new <i>name</i> desired for the
	 * copied node. It does not specify a position within the child node
	 * ordering. If ordering is supported by the node type of
	 * the parent node of the new location, then the new copy of the node is appended to the end of the
	 * child node list.
	 *
	 * This method cannot be used to copy just an individual property by itself.
	 * It copies an entire node and its subtree (including, of course, any properties contained therein).
	 *
	 * @param string|null
	 *    The name of the workspace from which the copy is to be made.  This can
	 *    be left <i>NULL</i> if you wish to keep it within the same
	 *    workspace.
	 * @param string
	 *    The path of the node to be copied.
	 * @param string
	 *    The location to which the node at <i>$srcAbsPath</i> is to be
	 *    copied.
	 *
	 * @throws {@link ConstraintViolationException}
	 *    If the operation would violate a node-type or other
	 *    implementation-specific constraint.
	 * @throws {@link VersionException}
	 *    If the parent node of <i>$destAbsPath</i> is versionable and
	 *    checked-in, or is non-versionable but its nearest versionable ancestor
	 *    is checked-in.
	 * @throws {@link AccessDeniedException}
	 *    If the current session does not have sufficient access rights to
	 *    complete the operation.
	 * @throws {@link PathNotFoundException}
	 *    If the node at <i>$srcAbsPath</i> or the parent of
	 *    <i>$destAbsPath</i> does not exist.
	 * @throws {@link ItemExistsException}
	 *    If a property already exists at <i>$destAbsPath</i> or a
	 *    node already exist there, and same name siblings are not allowed.
	 * @throws {@link LockException}
	 *    If a lock prevents the copy.
	 * @throws {@link RepositoryException}
	 *    If the last element of <i>$destAbsPath</i> has an index or if
	 *    another error occurs.
	 */
	public function copy($srcWorkspace, $srcAbsPath, $destAbsPath);


	/**
	 * Clones the subtree at the node <i>$srcAbsPath</i> in <i>$srcWorkspace</i> to the new location at
	 * <i>$destAbsPath</i> in <i>$this</i> workspace. This method does not assign new UUIDs to
	 * the new nodes but preserves the UUIDs (if any) of their respective source nodes.
	 *
	 * If <i>$removeExisting</i> is true and an existing node in this workspace
	 * (the destination workspace) has the same UUID as a node being cloned from
	 * <i>$srcWorkspace</i>, then the incoming node takes precedence, and the
	 * existing node (and its subtree) is removed. If <i>$removeExisting</i>
	 * is false then a UUID collision causes this method to throw a
	 * {@link ItemExistsException} and no changes are made.
	 *
	 * If successful, the change is persisted immediately, there is no need to call <i>$save</i>.
	 *
	 * The <i>$destAbsPath</i> provided must not
	 * have an index on its final element. If it does then a {@link RepositoryException}
	 * is thrown. Strictly speaking, the <i>$destAbsPath</i> parameter is actually an <i>absolute path</i>
	 * to the parent node of the new location, appended with the new <i>name</i> desired for the
	 * cloned node. It does not specify a position within the child node
	 * ordering. If ordering is supported by the node type of the parent node of the new
	 * location, then the new clone of the node is appended to the end of the child node list.
	 *
	 * This method cannot be used to clone just an individual property by itself. It clones an
	 * entire node and its subtree (including, of course, any properties contained therein).
	 *
	 * <b>PHP Note</b>: This method has been renamed <i>clone_()</i> from
	 * JCR's <i>clone()</i> to avoid a naming collision with PHP's
	 * special clone() method.
	 *
	 * @param string
	 *    The name of the workspace from which the node is to be copied.
	 * @param string
	 *    The path of the node to be copied in <i>$srcWorkspace</i>.
	 * @param string
	 *    The location to which the node at <i>$srcAbsPath</i> is to be
	 *    copied in <i>$this</i> workspace.
	 * @param boolean
	 *    If <i>false</i> then this method throws an
	 *    {@link ItemExistsException} on UUID conflict with an incoming node.
	 *    If <i>true</i> then a UUID conflict is resolved by removing the
	 *    existing node from its location in this workspace and cloning (copying
	 *    in) the one from <i>$srcWorkspace</i>.
	 *
	 * @throws {@link NoSuchWorkspaceException}
	 *    If <i>$destWorkspace</i> does not exist.
	 * @throws {@link ConstraintViolationException}
	 *    If the operation would violate a node-type or other
	 *    implementation-specific constraint.
	 * @throws {@link VersionException}
	 *    If the parent node of <i>$destAbsPath</i> is versionable and
	 *    checked-in, or is non-versionable but its nearest versionable ancestor
	 *    is checked-in. This exception will also be thrown if
	 *    <i>$removeExisting</i> is <i>$true</i>, and a UUID
	 *    conflict occurs that would require the moving and/or altering of a
	 *    node that is checked-in.
	 * @throws {@link AccessDeniedException}
	 *    If the current session does not have sufficient access rights to
	 *    complete the operation.
	 * @throws {@link PathNotFoundException}
	 *    If the node at <i>$srcAbsPath</i> in <i>$srcWorkspace</i>
	 *    or the parent of <i>$destAbsPath</i> in this workspace does not
	 *    exist.
	 * @throws {@link ItemExistsException}
	 *    If a property already exists at <i>$destAbsPath</i> or a node
	 *    already exist there, and same name siblings are not allowed or if
	 *    <i>$removeExisting</i> is false and a UUID conflict occurs.
	 * @throws {@link LockException}
	 *    If a lock prevents the clone.
	 * @throws {@link RepositoryException}
	 *    If the last element of <i>$destAbsPath</i> has an index or if
	 *    another error occurs.
	 */
	public function clone_(
		$srcWorkspace,
		$srcAbsPath,
		$destAbsPath,
		$removeExisting);


	/**
	 * Moves the node at <i>$srcAbsPath</i> (and its entire subtree) to the
	 * new location at <i>$destAbsPath</i>. If successful,
	 * the change is persisted immediately, there is no need to call <i>$save</i>.
	 * Note that this is in contrast to {@link Session#move} which operates within the
	 * transient space and hence requires a <i>$save</i>.
	 *
	 * The <i>$destAbsPath</i> provided must not
	 * have an index on its final element. If it does then a {@link RepositoryException}
	 * is thrown. Strictly speaking, the <i>$destAbsPath</i> parameter is actually an <i>absolute path</i>
	 * to the parent node of the new location, appended with the new <i>name</i> desired for the
	 * moved node. It does not specify a position within the child node
	 * ordering. If ordering is supported by the node type of
	 * the parent node of the new location, then the newly moved node is appended to the end of the
	 * child node list.
	 *
	 * This method cannot be used to move just an individual property by itself.
	 * It moves an entire node and its subtree (including, of course, any properties contained therein).
	 *
	 * @param string
	 *    The path of the node to be moved.
	 * @param string
	 *    The location to which the node at <i>$srcAbsPath</i> is to be
	 *    moved.
	 * @throws {@link ConstraintViolationException}
	 *    If the operation would violate a node-type or other
	 *    implementation-specific constraint
	 * @throws {@link VersionException}
	 *    If the parent node of <i>$destAbsPath</i> or the parent node
	 *    of <i>$srcAbsPath</i> is versionable and checked-in, or is
	 *    non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws {@link AccessDeniedException}
	 *    If the current session (i.e. the session that was used to aqcuire
	 *    this {@link Workspace} object) does not have sufficient access rights
	 *    to complete the operation.
	 * @throws {@link PathNotFoundException}
	 *    If the node at <i>$srcAbsPath</i> or the parent of
	 *    <i>$destAbsPath</i> does not exist.
	 * @throws {@link ItemExistsException}
	 *    If a property already exists at <i>$destAbsPath</i> or a node
	 *    already exist there, and same name siblings are not allowed.
	 * @throws {@link LockException}
	 *    If a lock prevents the move.
	 * @throws {@link RepositoryException}
	 *    If the last element of <i>$destAbsPath</i> has an index or if
	 *    another error occurs.
	 */
	public function move($srcAbsPath, $destAbsPath);


	/**
	 * Restores a set of versions at once. Used in cases where a "chicken and egg" problem of
	 * mutually referring <i>REFERENCE</i> properties would prevent the restore in any
	 * serial order.
	 *
	 * If the restore succeeds the changes made to <i>$this</i> node are
	 * persisted immediately, there is no need to call <i>$save</i>.
	 *
	 * The following restrictions apply to the set of versions specified:
	 *
	 * If <i>S</i> is the set of versions being restored simultaneously,
	 * <ul>
	 *    <li>
	 *        For every version <i>V</i> in <i>S</i> that corresponds to
	 *        a <i>missing</i> node, there must also be a parent of V in S.
	 *    </li>
	 *    <li>
	 *        <i>S</i> must contain at least one version that corresponds to
	 *        an existing node in the workspace.
	 *    </li>
	 *    <li>
	 *        No <i>V</i> in <i>S</i> can be a root version (<i>jcr:rootVersion</i>).
	 *    </li>
	 * </ul>
	 * If any of these restrictions does not hold, the restore will fail
	 * because the system will be unable to determine the path locations to which
	 * one or more versions are to be restored. In this case a
	 * {@link VersionException} is thrown.
	 *
	 * The versionable nodes in this workspace that correspond to the versions being restored
	 * define a set of (one or more) subtrees. A UUID collision occurs when this workspace
	 * contains a node <i>outside these subtrees</i> that has the same UUID as one of the nodes
	 * that would be introduced by the <i>$restore</i> operation <i>into one of these subtrees</i>.
	 * The result in such a case is governed by the <i>$removeExisting</i> flag.
	 * If <i>$removeExisting</i> is <i>$true</i> then the incoming node takes precedence,
	 * and the existing node (and its subtree) is removed. If <i>$removeExisting</i>
	 * is <i>$false</i> then a {@link ItemExistsException} is thrown and no changes are made.
	 * Note that this applies not only to cases where the restored
	 * node itself conflicts with an existing node but also to cases where a conflict occurs with any
	 * node that would be introduced into the workspace by the restore operation. In particular, conflicts
	 * involving subnodes of the restored node that have <i>OnParentVersion</i> settings of
	 * <i>COPY</i> or <i>VERSION</i> are also governed by the <i>$removeExisting</i> flag.
	 *
	 * @param array
	 *    The set of versions to be restored
	 * @param boolean
	 *    Governs what happens on UUID collision.
	 *
	 * @throws {@link ItemExistsException}
	 *    If <i>$removeExisting</i> is <i>$false</i> and a UUID
	 *    collision occurs with a node being restored.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If one or more of the nodes to be restored is not versionable.
	 * @throws {@link VersionException}
	 *    If the set of versions to be restored is such that the original path
	 *    location of one or more of the versions cannot be determined or if
	 *    the <i>$restore</i> would change the state of a existing
	 *    verisonable node that is currently checked-in or if a root version
	 *    (<i>jcr:rootVersion</i>) is among those being restored.
	 * @throws {@link LockException}
	 *    If a lock prevents the restore.
	 * @throws {@link InvalidItemStateException}
	 *    If this {@link Session} (not necessarily this <i>Node</i>) has
	 *    pending unsaved changes.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function restore($versions, $removeExisting);


	/**
	 * Gets the <i>QueryManager</i>.
	 * Returns the <i>QueryManager</i> object, through search methods are accessed.
	 *
	 * @return phpCR_QueryManager
	 *	A {@link QueryManager} object
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getQueryManager();


	/**
	 * Returns the <i>NamespaceRegistry</i> object, which is used to access information
	 * and (in level 2) set the mapping between namespace prefixes and URIs.
	 *
	 * @return object
	 *	A {@link NamespaceRegisty} object
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getNamespaceRegistry();


	/**
	 * Returns the <i>NodeTypeManager</i> through which node type
	 * information can be queried. There is one node type registry per
	 * repository, therefore the <i>NodeTypeManager</i> is not
	 * workspace-specific; it provides introspection methods for the
	 * global, repository-wide set of available node types.
	 *
	 * @return object
	 *	A {@link NodeTypeManager} object
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getNodeTypeManager();


	/**
	 * If the the implementation supports observation
	 * this method returns the <i>ObservationManager</i> object;
	 * otherwise it throws an {@link UnsupportedRepositoryOperationException}.
	 *
	 * @return object
	 *	A {@link ObservationManager} object
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If the implementation does not support observation.
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getObservationManager();


	/**
	 * Returns an string array containing the names of all workspaces
	 * in this repository that are accessible to this user, given the
	 * <i>Credentials</i> that were used to get the {@link Session}
	 * tied to this {@link Workspace}.
	 *
	 * In order to access one of the listed workspaces, the user performs another
	 * <i>Repository.login</i>, specifying the name of the desired workspace,
	 * and receives a new {@link Session} object.
	 *
	 * @return array
	 *    Containing names of accessible workspaces.
	 * @throws {@link RepositoryException}
	 *
	 */
	public function getAccessibleWorkspaceNames();

	/**
	 * Returns an <i>org.xml.sax.ContentHandler</i> which can be used to push SAX events into the repository.
	 * If the incoming XML stream (in the form of SAX events) does not appear to be a JCR system view XML document then it is
	 * interpreted as a document view XML document.
	 *
	 * The incoming XML is deserialized into a subtree of items immediately below the node at
	 * <i>$parentAbsPath</i>.
	 *
	 * This method simply returns the <i>ContentHandler</i> without altering the state of the
	 * repository; the actual deserialization is done through the methods of the <i>ContentHandler</i>.
	 * Invalid XML data will cause the <i>ContentHandler</i> to throw a {@link SAXException}.
	 *
	 * As SAX events are fed into the <i>ContentHandler</i>, changes are made directly at the
	 * workspace level, without going through the {@link Session}. As a result, there is not need
	 * to call <i>$save</i>. The advantage of this
	 * direct-to-workspace method is that a large import will not result in a large cache of pending
	 * nodes in the {@link Session}. The disadvantage is that structures that violate node type constraints
	 * cannot be imported, fixed and then saved. Instead, a constraint violation will cause the
	 * <i>ContentHandler</i> to throw a {@link SAXException}. See <i>Session.getImportContentHandler</i> for a version of
	 * this method that <i>does</i> go through the {@link Session}.
	 *
	 * The flag <i>$uuidBehavior</i> governs how the UUIDs of incoming (deserialized) nodes are
	 * handled. There are four options:
	 * <ul>
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_CREATE_NEW}: Incoming referenceable nodes are assigned newly
	 * created UUIDs upon additon to the workspace. As a result UUID collisions never occur.
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REMOVE_EXISTING}: If an incoming referenceable node
	 * has the same UUID as a node already existing in the workspace, then the already exisitng node
	 * (and its subtree) is removed from wherever it may be in the workspace before the incoming node
	 * is added. Note that this can result in nodes "disappearing" from locations in the workspace that
	 * are remote from the location to which the incoming subtree is being written.
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REPLACE_EXISTING}: If an incoming referenceable node
	 * has the same UUID as a node already existing in the workspace then the already existing node
	 * is replaced by the incoming node in the same position as the existing node. Note that this may
	 * result in the incoming subtree being disaggregated and "spread around" to different locations
	 * in the workspace. In the most extreme case this behavior may result in no node at all
	 * being added as child of <i>$parentAbsPath</i>. This will occur if the topmost element
	 * of the incoming XML has the same UUID as an existing node elsewhere in the workspace.
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_THROW}: If an incoming referenceable node
	 * has the same UUID as a node already existing in the workspace then a SAXException
	 * is thrown by the returned <i>ContentHandler</i> during deserialization.
	 * </ul>
	 * A {@link SAXException} will be thrown by the returned <i>ContentHandler</i>
	 * during deserialization if the top-most element of the incoming XML would deserialize to
	 * a node with the same name as an existing child of <i>$parentAbsPath</i> and that
	 * child does not allow same-name siblings.
	 *
	 * A {@link SAXException} will also be thrown by the returned <i>ContentHandler</i>
	 * during deserialzation if <i>$uuidBehavior</i> is set to
	 * <i>IMPORT_UUID_COLLISION_REMOVE_EXISTING</i> and an incoming node has the same UUID as
	 * the node at <i>$parentAbsPath</i> or one of its ancestors.
	 *
	 * A {@link PathNotFoundException} is thrown if no node exists at <i>$parentAbsPath</i>.
	 *
	 * A {@link ConstraintViolationException} is thrown if the new subtree cannot be added to the node at
	 * <i>$parentAbsPath</i> due to node-type or other implementation-specific constraints, and this can
	 * be determined before the first SAX event is sent. Unlike {@link Session#getImportContentHandler},
	 * this method also enforces node type constraints by throwing {@link SAXException}s during
	 * deserialization. However, which node type constraints are enforced depends upon whether node type
	 * information in the imported data is respected, and this is an implementation-specific issue.
	 *
	 * A {@link VersionException} is thrown if the node at <i>$parentAbsPath</i> is versionable
	 * and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 *
	 * A {@link LockException} is thrown if a lock prevents the addition ofthe subtree.
	 *
	 * An {@link AccessDeniedException} is thrown if the session associated with this {@link Workspace} object does not have
	 * sufficient permissions to perform the import.
	 *
	 * @param parentAbsPath the absolute path of a node under which (as child) the imported subtree will be built.
	 * @param uuidBehavior a four-value flag that governs how incoming UUIDs are handled.
	 * @return an org.xml.sax.ContentHandler whose methods may be called to feed SAX events into the deserializer.
	 *
	 * @throws {@link PathNotFoundException}
	 *    If no node exists at <i>$parentAbsPath</i>.
	 * @throws {@link ConstraintViolationException}
	 *    If the new subtree cannot be added to the node at
	 * <i>$parentAbsPath</i> due to node-type or other implementation-specific constraints,
	 * and this can be determined before the first SAX event is sent.
	 * @throws {@link VersionException}
	 *    If the node at <i>$parentAbsPath</i> is versionable
	 * and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the subtree.
	 * @throws {@link AccessDeniedException}
	 *    If the session associated with this {@link Workspace} object does not have
	 * sufficient permissions to perform the import.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 *
	 * @todo Determine if feasiable within PHP
	 */
	public function getImportContentHandler($parentAbsPath, $uuidBehavior);


	/**
	 * Deserializes an XML document and adds the resulting item subtree as a child of the node at
	 * <i>$parentAbsPath</i>.
	 *
	 * If the incoming XML stream does not appear to be a JCR system view XML document then it is interpreted as a
	 * <b>document view</b> XML document.
	 *
	 * Changes are made directly at the workspace level, without going through the {@link Session}.
	 * As a result, there is not need to call <i>$save</i>. The advantage of this
	 * direct-to-workspace method is that a large import will not result in a large cache of
	 * pending nodes in the {@link Session}. The disadvantage is that invalid data cannot
	 * be imported, fixed and then saved. Instead, invalid data will cause this method to throw an
	 * {@link InvalidSerializedDataException}. See <i>Session.importXML</i> for
	 * a version of this method that <i>does</i> go through the {@link Session}.
	 *
	 * The flag <i>$uuidBehavior</i> governs how the UUIDs of incoming (deserialized) nodes are
	 * handled. There are four options:
	 * <ul>
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_CREATE_NEW}: Incoming referenceable nodes are assigned newly
	 * created UUIDs upon additon to the workspace. As a result UUID collisions never occur.
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REMOVE_EXISTING}: If an incoming referenceable node
	 * has the same UUID as a node already existing in the workspace then the already exisitng node
	 * (and its subtree) is removed from wherever it may be in the workspace before the incoming node
	 * is added. Note that this can result in nodes "disappearing" from locations in the workspace that
	 * are remote from the location to which the incoming subtree is being written. If an incoming node
	 * has the same UUID as the existing root node of this workspace then
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_REPLACE_EXISTING}: If an incoming referenceable node
	 * has the same UUID as a node already existing in the workspace then the already existing node
	 * is replaced by the incoming node in the same position as the existing node. Note that this may
	 * result in the incoming subtree being disaggregated and "spread around" to different locations
	 * in the workspace. In the most extreme edge case this behavior may result in no node at all
	 * being added as child of <i>$parentAbsPath</i>. This will occur if the topmost element
	 * of the incoming XML has the same UUID as an existing node elsewhere in the workspace.
	 * <li>{@link ImportUUIDBehavior#IMPORT_UUID_COLLISION_THROW}: If an incoming referenceable node
	 * has the same UUID as a node already existing in the workspace then an {@link ItemExistsException}
	 * is thrown.
	 * </ul>
	 * An {@link ItemExistsException} will be thrown if <i>$uuidBehavior</i>
	 * is set to <i>IMPORT_UUID_CREATE_NEW</i> or <i>IMPORT_UUID_COLLISION_THROW</i>
	 * and the import would would overwrite an existing child of <i>$parentAbsPath</i>.
	 *
	 * An IOException is thrown if an I/O error occurs.
	 *
	 * If no node exists at <i>$parentAbsPath</i>, a {@link PathNotFoundException} is thrown.
	 *
	 * An ItemExisitsException is thrown if the top-most element of the incoming XML would deserialize
	 * to a node with the same name as an existing child of <i>$parentAbsPath</i> and that
	 * child does not allow same-name siblings, or if a <i>$uuidBehavior</i> is set to
	 * <i>IMPORT_UUID_COLLISION_THROW</i> and a UUID collision occurs.
	 *
	 * If node-type or other implementation-specific constraints
	 * prevent the addition of the subtree, a {@link ConstraintViolationException} is thrown.
	 *
	 * A {@link ConstraintViolationException} will also be thrown if <i>$uuidBehavior</i>
	 * is set to <i>IMPORT_UUID_COLLISION_REMOVE_EXISTING</i> and an incoming node has the same
	 * UUID as the node at <i>$parentAbsPath</i> or one of its ancestors.
	 *
	 * A {@link VersionException} is thrown if the node at <i>$parentAbsPath</i> is versionable
	 * and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 *
	 * A {@link LockException} is thrown if a lock prevents the addition of the subtree.
	 *
	 * An {@link AccessDeniedException} is thrown if the session associated with this {@link Workspace} object does not have
	 * sufficient permissions to perform the import.
	 *
	 * @param parentAbsPath the absolute path of the node below which the deserialized subtree is added.
	 * @param in The <i>Inputstream</i> from which the XML to be deserilaized is read.
	 * @param uuidBehavior a four-value flag that governs how incoming UUIDs are handled.
	 *
	 * @throws {@link java}
	 *    .io.IOException if an error during an I/O operation occurs.
	 * @throws {@link PathNotFoundException}
	 *    If no node exists at <i>$parentAbsPath</i>.
	 * @throws {@link ConstraintViolationException}
	 *    If node-type or other implementation-specific constraints
	 * prevent the addition of the subtree or if <i>$uuidBehavior</i>
	 * is set to <i>IMPORT_UUID_COLLISION_REMOVE_EXISTING</i> and an incoming node has the same
	 * UUID as the node at <i>$parentAbsPath</i> or one of its ancestors.
	 * @throws {@link VersionException}
	 *    If the node at <i>$parentAbsPath</i> is versionable
	 * and checked-in, or is non-versionable but its nearest versionable ancestor is checked-in.
	 * @throws {@link InvalidSerializedDataException}
	 *    If incoming stream is not a valid XML document.
	 * @throws {@link ItemExistsException}
	 *    If the top-most element of the incoming XML would deserialize
	 * to a node with the same name as an existing child of <i>$parentAbsPath</i> and that
	 * child does not allow same-name siblings, or if a <i>$uuidBehavior</i> is set to
	 * <i>IMPORT_UUID_COLLISION_THROW</i> and a UUID collision occurs.
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the subtree.
	 * @throws {@link AccessDeniedException}
	 *    If the session associated with this {@link Workspace} object does not have
	 * sufficient permissions to perform the import.
	 * @throws {@link RepositoryException}
	 *     is another error occurs.
	 *
	 * @todo Determine if feasiable within PHP
	 */
	public function importXML($parentAbsPath, $in, $uuidBehavior);
}

?>