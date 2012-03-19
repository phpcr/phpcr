<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

namespace PHPCR;

/**
 * Interface representing a view onto a persistent workspace within a repository.
 *
 * A Workspace object represents a view onto a persistent workspace within a
 * repository. This view is defined by the authorization settings of the Session
 * object associated with the Workspace object. Each Workspace object is
 * associated one-to-one with a Session object. The Workspace object can be
 * acquired by calling $session->getWorkspace() on the associated Session object.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface WorkspaceInterface {

    /**#@+
     * @var string
     */

    /**
     * A constant for the name of the workspace root node.
     * @api
     */
    const NAME_WORKSPACE_ROOT = '';

    /**
     * A constant for the absolute path of the workspace root node.
     * @api
     */
    const PATH_WORKSPACE_ROOT = '/';

    /**
     * A constant for the name of the system node.
     * @api
     */
    const NAME_SYSTEM_NODE = '{http://www.jcp.org/jcr/1.0}system';

    /**
     * A constant for the absolute path of the system node.
     * This is '/' . NAME_SYSTEM_NODE
     * @api
     */
    const PATH_SYSTEM_NODE = '/{http://www.jcp.org/jcr/1.0}system';

    /**
     * A constant for the name of the node type definition storage node.
     * @api
     */
    const NAME_NODE_TYPES_NODE = '{http://www.jcp.org/jcr/1.0}nodeTypes';

    /**
     * A constant for the absolute path of the node type definition storage node.
     * This is PATH_SYSTEM_NODE . '/' . NAME_NODE_TYPES_NODE
     * @api
     */
    const PATH_NODE_TYPES_NODE = '/{http://www.jcp.org/jcr/1.0}system/{http://www.jcp.org/jcr/1.0}nodeTypes';

    /**
     * A constant for the name of the version storage node.
     * @api
     */
    const NAME_VERSION_STORAGE_NODE = '{http://www.jcp.org/jcr/1.0}versionStorage';

    /**
     * A constant for the absolute path of the version storage node.
     * This is PATH_SYSTEM_NODE . '/' . NAME_VERSION_STORAGE_NODE
     * @api
     */
    const PATH_VERSION_STORAGE_NODE = '/{http://www.jcp.org/jcr/1.0}system/{http://www.jcp.org/jcr/1.0}versionStorage';

    /**
     * A constant for the name of the activities node.
     * @api
     */
    const NAME_ACTIVITIES_NODE = '{http://www.jcp.org/jcr/1.0}activities';

    /**
     * A constant for the absolute path of the activities node.
     * This is PATH_SYSTEM_NODE . '/' . NAME_ACTIVITIES_NODE
     * @api
     */
    const PATH_ACTIVITIES_NODE = '/{http://www.jcp.org/jcr/1.0}system/{http://www.jcp.org/jcr/1.0}activities';

    /**
     * A constant for the name of the configurations node.
     * @api
     */
    const NAME_CONFIGURATIONS_NODE = '{http://www.jcp.org/jcr/1.0}configurations';

    /**
     * A constant for the absolute path of the configurations node.
     * This is PATH_SYSTEM_NODE . '/' . NAME_CONFIGURATIONS_NODE
     * @api
     */
    const PATH_CONFIGURATIONS_NODE = '/{http://www.jcp.org/jcr/1.0}system/{http://www.jcp.org/jcr/1.0}configurations';

    /**
     * A constant for the name of the unfiled storage node.
     * @api
     */
    const NAME_UNFILED_NODE = '{http://www.jcp.org/jcr/1.0}unfiled';

    /**
     * A constant for the absolute path of the unfiled storage node.
     * This is PATH_SYSTEM_NODE . '/' . NAME_UNFILED_NODE
     * @api
     */
    const PATH_UNFILED_NODE = '/{http://www.jcp.org/jcr/1.0}system/{http://www.jcp.org/jcr/1.0}unfiled';

    /**
     * A constant for the name of the jcr:xmltext node produced on importXML().
     * @api
     */
    const NAME_JCR_XMLTEXT = '{http://www.jcp.org/jcr/1.0}xmltext';

    /**
     * A constant for the name of the jcr:xmlcharacters property produced on importXML().
     * @api
     */
    const NAME_JCR_XMLCHARACTERS = '{http://www.jcp.org/jcr/1.0}xmlcharacters';

    /**
     * A constant for the relative path from the node representing the imported XML element of
     * the jcr:xmlcharacters property produced on importXML().
     * This is NAME_JCR_XMLTEXT . '/' . NAME_JCR_XMLCHARACTERS
     * @api
     */
    const RELPATH_JCR_XMLCHARACTERS = '{http://www.jcp.org/jcr/1.0}xmltext/{http://www.jcp.org/jcr/1.0}xmlcharacters';

    /**#@-*/

    /**
     * Returns the Session object through which this Workspace object was acquired.
     *
     * @return \PHPCR\SessionInterface a Session object.
     * @api
     */
    function getSession();

    /**
     * Returns the name of the actual persistent workspace represented by this Workspace object.
     *
     * This the name used in Repository->login.
     *
     * @return string the name of this workspace.
     * @api
     */
    function getName();

    /**
     * Copies a Node including its children to a new location to the given workspace.
     *
     * This method copies the subgraph rooted at, and including, the node at
     * $srcWorkspace (if given) and $srcAbsPath to the new location in this
     * Workspace at $destAbsPath.
     *
     * This is a workspace-write operation and therefore dispatches changes
     * immediately and does not require a save.
     *
     * When a node N is copied to a path location where no node currently
     * exists, a new node N' is created at that location.
     * The subgraph rooted at and including N' (call it S') is created and is
     * identical to the subgraph rooted at and including N (call it S) with the
     * following exceptions:
     * - Every node in S' is given a new and distinct identifier
     *   - or, if $srcWorkspace is given -
     *   Every referenceable node in S' is given a new and distinct identifier
     *   while every non-referenceable node in S' may be given a new and
     *   distinct identifier.
     * - The repository may automatically drop any mixin node type T present on
     *   any node M in S. Dropping a mixin node type in this context means that
     *   while M remains unchanged, its copy M' will lack the mixin T and any
     *   child nodes and properties defined by T that are present on M. For
     *   example, a node M that is mix:versionable may be copied such that the
     *   resulting node M' will be a copy of N except that M' will not be
     *   mix:versionable and will not have any of the properties defined by
     *   mix:versionable. In order for a mixin node type to be dropped it must
     *   be listed by name in the jcr:mixinTypes property of M. The resulting
     *   jcr:mixinTypes property of M' will reflect any change.
     * - If a node M in S is referenceable and its mix:referenceable mixin is
     *   not dropped on copy, then the resulting jcr:uuid property of M' will
     *   reflect the new identifier assigned to M'.
     * - Each REFERENCE or WEAKEREFERENCE property R in S is copied to its new
     *   location R' in S'. If R references a node M within S then the value of
     *   R' will be the identifier of M', the new copy of M, thus preserving the
     *   reference within the subgraph.
     *
     * When a node N is copied to a location where a node N' already exists, the
     * repository may either immediately throw an ItemExistsException or attempt
     * to update the node N' by selectively replacing part of its subgraph with
     * a copy of the relevant part of the subgraph of N. If the node types of N
     * and N' are compatible, the implementation supports update-on-copy for
     * these node types and no other errors occur, then the copy will succeed.
     * Otherwise an ItemExistsException is thrown.
     *
     * Which node types can be updated on copy and the details of any such
     * updates are implementation-dependent. For example, some implementations
     * may support update-on-copy for mix:versionable nodes. In such a case the
     * versioning-related properties of the target node would remain unchanged
     * (jcr:uuid, jcr:versionHistory, etc.) while the substantive content part
     * of the subgraph would be replaced with that of the source node.
     *
     * The $destAbsPath provided must not have an index on its final element. If
     * it does then a RepositoryException is thrown. Strictly speaking, the
     * $destAbsPath parameter is actually an absolute path to the parent node of
     * the new location, appended with the new name desired for the copied node.
     * It does not specify a position within the child node ordering. If ordering
     * is supported by the node type of the parent node of the new location, then
     * the new copy of the node is appended to the end of the child node list.
     *
     * This method cannot be used to copy an individual property by itself. It
     * copies an entire node and its subgraph (including, of course, any
     * properties contained therein).
     *
     * @param string $srcAbsPath the path of the node to be copied.
     * @param string $destAbsPath the location to which the node at srcAbsPath
     *      is to be copied in this workspace.
     * @param string $srcWorkspace the name of the workspace from which the
     *      copy is to be made.
     *
     * @return void
     *
     * @throws \PHPCR\NoSuchWorkspaceException if srcWorkspace does not exist
     *      or if the current Session does not have permission to access it.
     * @throws \PHPCR\NodeType\ConstraintViolationException if the operation
     *      would violate a node-type or other implementation-specific
     *      constraint.
     * @throws \PHPCR\Version\VersionException if the parent node of
     *      destAbsPath is read-only due to a checked-in node.
     * @throws \PHPCR\AccessDeniedException if the current session does have
     *      access srcWorkspace but otherwise does not have sufficient access
     *      to complete the operation.
     * @throws \PHPCR\PathNotFoundException if the node at srcAbsPath in
     *      srcWorkspace or the parent of destAbsPath in this workspace does
     *      not exist.
     * @throws \PHPCR\ItemExistsException if a node already exists at
     *      destAbsPath and either same-name siblings are not allowed or update
     *      on copy is not supported for the nodes involved.
     * @throws \PHPCR\Lock\LockException if a lock prevents the copy.
     * @throws \PHPCR\RepositoryException if the last element of destAbsPath
     *      has an index or if another error occurs.
     *
     * @api
     */
    function copy($srcAbsPath, $destAbsPath, $srcWorkspace = null);

    /**
     * Clones the subgraph at the node srcAbsPath in srcWorkspace to the new
     * location at destAbsPath in the current workspace.
     *
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
     * existing node (and its subgraph) is removed. If removeExisting is false
     * then an identifier collision causes this method to throw an
     * ItemExistsException and no changes are made.
     *
     * If successful, the change is persisted immediately, there is no need
     * to call save.
     *
     * The destAbsPath provided must not have an index on its final element.
     * If it does then a RepositoryException is thrown.
     * If ordering is supported by the node type of the parent node of the new
     * location, then the new clone of the node is appended to the end of the
     * child node list.
     *
     * This method cannot be used to clone just an individual property; it
     * clones a node and its subgraph.
     *
     * PHP Notice: The JCR method is called clone, but that is a reserved
     * keyword in PHP, thus we named the method cloneFrom.
     *
     * @param string $srcWorkspace The name of the workspace from which the
     *      node is to be copied.
     * @param string $srcAbsPath The path of the node to be copied in
     *      srcWorkspace.
     * @param string $destAbsPath The location to which the node at srcAbsPath
     *      is to be copied in this workspace.
     * @param boolean $removeExisting if false then this method throws an
     *      ItemExistsException on identifier conflict with an incoming node.
     *      If true then a identifier conflict is resolved by removing the
     *      existing node from its location in this workspace and cloning
     *      (copying in) the one from srcWorkspace.
     *
     * @return void
     *
     * @throws \PHPCR\NoSuchWorkspaceException if destWorkspace does not exist.
     * @throws \PHPCR\NodeType\ConstraintViolationException if the operation
     *      would violate a node-type or other implementation-specific
     *      constraint.
     * @throws \PHPCR\Version\VersionException if the parent node of
     *      destAbsPath is read-only due to a checked-in node. This exception
     *      will also be thrown if removeExisting is true, and an identifier
     *      conflict occurs that would require the moving and/or altering of a
     *      node that is checked-in.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to complete the operation.
     * @throws \PHPCR\PathNotFoundException if the node at srcAbsPath in
     *      srcWorkspace or the parent of destAbsPath in this workspace does
     *      not exist.
     * @throws \PHPCR\ItemExistsException if a node already exists at
     *      destAbsPath and same-name siblings are not allowed or if
     *      removeExisting is false and an identifier conflict occurs.
     * @throws \PHPCR\Lock\LockException if a lock prevents the clone.
     * @throws \PHPCR\RepositoryException if the last element of destAbsPath
     *      has an index or if another error occurs.
     *
     * @api
     */
    function cloneFrom($srcWorkspace, $srcAbsPath, $destAbsPath, $removeExisting);

    /**
     * Moves the node at srcAbsPath (and its entire subgraph) to the new
     * location at destAbsPath.
     *
     * If successful, the change is persisted immediately, there is no need to
     * call save. Note that this is in contrast to
     * Session->move($srcAbsPath, $destAbsPath) which operates within the
     * transient space and hence requires a save.
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
     * It moves an entire node and its subgraph (including, of course, any
     * properties contained therein).
     *
     * The identifiers of referenceable nodes must not be changed by a move. The
     * identifiers of non-referenceable nodes may change.
     *
     * @param string $srcAbsPath the path of the node to be moved.
     * @param string $destAbsPath the location to which the node at srcAbsPath
     *      is to be moved.
     *
     * @return void
     *
     * @throws \PHPCR\NodeType\ConstraintViolationException if the operation
     *      would violate a node-type or other implementation-specific
     *      constraint.
     * @throws \PHPCR\Version\VersionException if the parent node of
     *      destAbsPath is read-only due to a checked-in node.
     * @throws \PHPCR\AccessDeniedException if the current session (i.e. the
     *      session that was used to acquire this Workspace object) does not
     *      have sufficient access rights to complete the operation.
     * @throws \PHPCR\PathNotFoundException if the node at srcAbsPath or the
     *      parent of destAbsPath does not exist.
     * @throws \PHPCR\ItemExistsException if a node already exists at
     *      destAbsPath and same-name siblings are not allowed.
     * @throws \PHPCR\Lock\LockException if a lock prevents the move.
     * @throws \PHPCR\RepositoryException if the last element of destAbsPath
     *      has an index or if another error occurs.
     *
     * @api
     */
    function move($srcAbsPath, $destAbsPath);

    /**
     * Returns the LockManager object, through which locking methods are accessed.
     *
     * @return \PHPCR\Lock\LockManagerInterface
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the
     *      implementation does not support locking.
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getLockManager();

    /**
     * Returns the QueryManager object, through search methods are accessed.
     *
     * @return \PHPCR\Query\QueryManagerInterface the QueryManager object.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getQueryManager();

    /**
     * Returns the UserTransaction object associated with this session
     *
     * @return \PHPCR\Transaction\UserTransactionInterface a UserTransaction
     *      object.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the
     *      implementation does not support observation.
     *
     * @api
     */
    function getTransactionManager();

    /**
     * Returns the NamespaceRegistry object, which is used to access the
     * mapping between prefixes and namespaces.
     *
     * In level 2 repositories the NamespaceRegistry can also be used to change
     * the namespace mappings.
     *
     * @return \PHPCR\NamespaceRegistryInterface the NamespaceRegistry.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getNamespaceRegistry();

    /**
     * Returns the NodeTypeManager through which node type information can be
     * queried.
     *
     * There is one node type registry per repository, therefore the NodeTypeManager
     * is not workspace-specific; it provides introspection methods for the global,
     * repository-wide set of available node types. In repositories that support it,
     * the NodeTypeManager can also be used to register new node types.
     *
     * @return \PHPCR\NodeType\NodeTypeManagerInterface a NodeTypeManager object.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getNodeTypeManager();

    /**
     * Returns the ObservationManager object.
     *
     * @return \PHPCR\Observation\ObservationManagerInterface an
     *      ObservationManager object.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the
     *      implementation does not support observation.
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getObservationManager();

    /**
     * Returns the VersionManager object.
     *
     * @return \PHPCR\Version\VersionManagerInterface a VersionManager object.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the
     *      implementation does not support versioning.
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getVersionManager();

    /**
     * Gets a set of workspace accessible to the current user.
     *
     * Returns a string array containing the names of all workspaces in this
     * repository that are accessible to this user, given the Credentials that
     * were used to get the Session to which this Workspace is tied.
     * In order to access one of the listed workspaces, the user performs
     * another RepositoryInterface::login(), specifying the name of the desired
     * workspace, and receives a new Session object.
     *
     * @return array string array of names of accessible workspaces.
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function getAccessibleWorkspaceNames();

    /**
     * Returns an \PHPCR\ContentHandlerInterface which can be used to push SAX events into the repository.
     *
     * If the incoming XML stream (in the form of SAX events)
     * does not appear to be a JCR system view XML document then it is interpreted
     * as a document view XML document.
     * The incoming XML is deserialized into a subgraph of items immediately below
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
     * See SessionInterface::getImportContentHandler for a version of this method
     * that does go through the Session.
     *
     * The flag uuidBehavior governs how the identifiers of incoming (deserialized)
     * nodes are handled. There are four options:
     *
     * - ImportUUIDBehavior::IMPORT_UUID_CREATE_NEW: Incoming nodes are assigned newly
     *   created identifiers upon addition to the workspace. As a result identifier
     *  collisions never occur.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an incoming node
     *   has the same identifier as a node already existing in the workspace, then the
     *   already existing node (and its subgraph) is removed from wherever it may be in
     *   the workspace before the incoming node is added. Note that this can result in
     *   nodes "disappearing" from locations in the workspace that are remote from the
     *   location to which the incoming subgraph is being written.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an incoming node
     *   has the same identifier as a node already existing in the workspace then the
     *   already existing node is replaced by the incoming node in the same position as
     *   the existing node. Note that this may result in the incoming subgraph being
     *   disaggregated and "spread around" to different locations in the workspace. In
     *   the most extreme case this behavior may result in no node at all being added as
     *   child of parentAbsPath. This will occur if the topmost element of the incoming
     *   XML has the same identifier as an existing node elsewhere in the workspace.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_THROW: If an incoming node has the same
     *   identifier as a node already existing in the workspace then a SAXException is
     *   thrown by the returned ContentHandler during deserialization.
     *
     * A SAXException will be thrown by the returned ContentHandler during deserialization
     * if the top-most element of the incoming XML would deserialize to a node with the same
     * name as an existing child of parentAbsPath and that child does not allow same-name
     * siblings.
     * A SAXException will also be thrown by the returned ContentHandler during
     * deserialization if uuidBehavior is set to IMPORT_UUID_COLLISION_REMOVE_EXISTING
     * and an incoming node has the same identifier as the node at parentAbsPath or
     * one of its ancestors.
     *
     * @param string $parentAbsPath the absolute path of a node under which (as child) the imported subgraph will be built.
     * @param integer $uuidBehavior a four-value flag that governs how incoming identifiers are handled.
     * @return \PHPCR\ContentHandlerInterface whose methods may be called to feed SAX events into the deserializer.
     *
     * @throws \PHPCR\PathNotFoundException if no node exists at $parentAbsPath.
     * @throws \PHPCR\NodeType\ConstraintViolationException if the new subgraph cannot be added to the node at $parentAbsPath due
     *                                             to node-type or other implementation-specific constraints, and this
     *                                             can be determined before the first SAX event is sent. Unlike
     *                                             Session#getImportContentHandler, this method also enforces node type
     *                                             constraints by throwing SAXExceptions during deserialization.
     *                                             However, which node type constraints are enforced depends upon
     *                                             whether node type information in the imported data is respected,
     *                                             and this is an implementation-specific issue.
     * @throws \PHPCR\Version\VersionException if the node at $parentAbsPath is read-only due to a checked-in node.
     * @throws \PHPCR\Lock\LockException if a lock prevents the addition of the subgraph.
     * @throws \PHPCR\AccessDeniedException if the session associated with this Workspace object does not have
     *                                      sufficient access to perform the import.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    //Dropped for now. If you have an excellent and generic idea for this, suggestions are welcome
    //function getImportContentHandler($parentAbsPath, $uuidBehavior);

    /**
     * Deserializes an XML document and adds the resulting item subgraph as a
     * child of the node at $parentAbsPath.
     *
     * If the incoming XML does not appear to be a JCR system view XML document
     * then it is interpreted as a document view XML document.
     *
     * Changes are made directly at the workspace level, without going through
     * the Session. As a result, there is not need to call save. The advantage
     * of this direct-to-workspace method is that a large import will not result
     * in a large cache of pending nodes in the Session. The disadvantage is
     * that invalid data cannot be imported, fixed and then saved. Instead,
     * invalid data will cause this method to throw an
     * InvalidSerializedDataException.
     * See SessionInterface::importXML() for a version of this method that does
     * go through the Session.
     *
     * The flag $uuidBehavior governs how the identifiers of incoming (deserialized)
     * nodes are handled. There are four options:
     *
     * - ImportUUIDBehavior::IMPORT_UUID_CREATE_NEW: Incoming nodes are assigned newly
     *   created identifiers upon addition to the workspace. As a result identifier
     *   collisions never occur.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an incoming node
     *   has the same identifier as a node already existing in the workspace then the
     *   already existing node (and its subgraph) is removed from wherever it may be
     *   in the workspace before the incoming node is added. Note that this can result
     *   in nodes "disappearing" from locations in the workspace that are remote from
     *   the location to which the incoming subgraph is being written. If an incoming
     *   node has the same identifier as the existing root node of this workspace then
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an incoming node
     *   has the same identifier as a node already existing in the workspace then the
     *   already existing node is replaced by the incoming node in the same position as
     *   the existing node. Note that this may result in the incoming subgraph being
     *   disaggregated and "spread around" to different locations in the workspace. In
     *   the most extreme edge case this behavior may result in no node at all being
     *   added as child of parentAbsPath. This will occur if the topmost element of the
     *   incoming XML has the same identifier as an existing node elsewhere in the
     *   workspace.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_THROW: If an incoming node has the
     *   same identifier as a node already existing in the workspace then an
     *   ItemExistsException is thrown.
     *
     * @param string $parentAbsPath the absolute path of the node below which
     *      the deserialized subgraph is added.
     * @param string $uri Source location for the XML to be read, Can be
     *      anything that works with fopen.
     * @param integer $uuidBehavior a four-value flag that governs how incoming
     *      identifiers are handled.
     *
     * @return void
     *
     * @throws \RuntimeException if an error during an I/O operation occurs.
     * @throws \PHPCR\PathNotFoundException if no node exists at parentAbsPath.
     * @throws \PHPCR\NodeType\ConstraintViolationException if node-type or
     *      other implementation-specific constraints prevent the addition of
     *      the subgraph or if uuidBehavior is set to
     *      IMPORT_UUID_COLLISION_REMOVE_EXISTING and an incoming node has the
     *      same identifier as the node at parentAbsPath or one of its
     *      ancestors.
     * @throws \PHPCR\Version\VersionException if the node at parentAbsPath is
     *      read-only due to a checked-in node.
     * @throws \PHPCR\InvalidSerializedDataException if incoming stream is not
     *      a valid XML document.
     * @throws \PHPCR\ItemExistsException if the top-most element of the
     *      incoming XML would deserialize to a node with the same name as an
     *      existing child of parentAbsPath and that child does not allow
     *      same-name siblings, or if a uuidBehavior is set to
     *      IMPORT_UUID_COLLISION_THROW and an identifier collision occurs.
     * @throws \PHPCR\Lock\LockException if a lock prevents the addition of the
     *      subgraph.
     * @throws \PHPCR\AccessDeniedException if the session associated with this
     *      Workspace object does not have sufficient access to perform the
     *      import.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function importXML($parentAbsPath, $uri, $uuidBehavior);

    /**
     * Creates a new Workspace with the specified name. The new workspace is
     * empty, meaning it contains only root node.
     *
     * If srcWorkspace is given:<br/>
     * Creates a new Workspace with the specified name initialized with a
     * clone of the content of the workspace srcWorkspace. Semantically,
     * this method is equivalent to creating a new workspace and manually
     * cloning srcWorkspace to it; however, this method may assist some
     * implementations in optimizing subsequent NodeInterface::update() and
     * NodeInterface::merge() calls between the new workspace and its source.
     *
     * The new workspace can be accessed through a login specifying its name.
     *
     * @param string $name A String, the name of the new workspace.
     * @param string $srcWorkspace The name of the workspace from which the new
     *      workspace is to be cloned.
     *
     * @return void
     *
     * @throws \PHPCR\AccessDeniedException if the session through which this
     *      Workspace object was acquired does not have sufficient access to
     *      create the new workspace.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the repository
     *      does not support the creation of workspaces.
     * @throws \PHPCR\NoSuchWorkspaceException if $srcWorkspace does not exist.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function createWorkspace($name, $srcWorkspace = null);

    /**
     * Deletes the workspace with the specified name from the repository,
     * deleting all content within it.
     *
     * @param string $name A String, the name of the workspace to be deleted.
     *
     * @return void
     *
     * @throws \PHPCR\AccessDeniedException if the session through which this
     *      Workspace object was acquired does not have sufficient access to
     *      remove the workspace.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the repository
     *      does not support the removal of workspaces.
     * @throws \PHPCR\NoSuchWorkspaceException if $name does not exist.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function deleteWorkspace($name);
}
