<?php

namespace PHPCR;

/**
 * Describes the implementation of a session class.
 *
 * The Session object provides read and (in level 2) write access to the
 * content of a particular workspace in the repository.
 *
 * The Session object is returned by Repository::login(). It encapsulates both
 * the authorization settings of a particular user (as specified by the passed
 * Credentials) and a binding to the workspace specified by the workspaceName
 * passed on login.
 *
 * Each Session object is associated one-to-one with a Workspace object. The
 * Workspace object represents a "view" of an actual repository workspace
 * entity as seen through the authorization settings of its associated Session.
 *
 * <b>PHPCR Note:</b>
 *   We removed getValueFactory as the ValueFactory interface has
 *   been removed. To set properties, use NodeInterface::setProperty() or
 *   PropertyInterface::setValue() with native PHP variables.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface SessionInterface
{
    /**#@+
     * @var string
     */

    /**
     * A constant representing the add_node action string, used to determine if
     * this Session has permission to add a new node.
     *
     * @api
     */
    const ACTION_ADD_NODE = 'add_node';

    /**
     * A constant representing the read action string, used to determine if
     * this Session has permission to retrieve an item (and read the value, in
     * the case of a property).
     *
     * @api
     */
    const ACTION_READ = 'read';

    /**
     * A constant representing the remove action string, used to determine if
     * this Session has permission to remove an item.
     *
     * @api
     */
    const ACTION_REMOVE = 'remove';

    /**
     * A constant representing the set_property action string, used to
     * determine if this Session has permission to set (add or modify) a
     * property.
     *
     * @api
     */
    const ACTION_SET_PROPERTY = 'set_property';

    /**#@-*/

    /**
     * Returns the Repository object through which this session was acquired.
     *
     * @return RepositoryInterface a Repository object.
     *
     * @api
     */
    public function getRepository();

    /**
     * Gets the user ID associated with this Session.
     *
     * How the user ID is set is up to the implementation, it may be a string
     * passed in as part of the credentials or it may be a string acquired in
     * some other way. This method is free to return an "anonymous user ID" or
     * null.
     *
     * @return string The user id associated with this Session.
     *
     * @api
     */
    public function getUserID();

    /**
     * Returns the names of the attributes set in this session as a result of
     * the Credentials that were used to acquire it.
     *
     * Not all Credentials implementations will contain attributes (though, for
     * example, SimpleCredentials does allow for them). This method returns an
     * empty array if the Credentials instance did not provide attributes.
     *
     * @return array A string array containing the names of all attributes
     *      passed in the credentials used to acquire this session.
     *
     * @api
     */
    public function getAttributeNames();

    /**
     * Returns the value of the named attribute, or null if no
     * attribute of the given name exists. See getAttributeNames().
     *
     * @param string $name The name of an attribute passed in the credentials
     *      used to acquire this session.
     *
     * @return mixed The value of the attribute or null if no attribute of the
     *      given name exists.
     *
     * @api
     */
    public function getAttribute($name);

    /**
     * Returns the Workspace attached to this Session.
     *
     * @return WorkspaceInterface a Workspace object.
     *
     * @api
     */
    public function getWorkspace();

    /**
     * Returns the root node of the workspace, "/".
     *
     * This node is the main access point to the content of the workspace.
     *
     * @return NodeInterface The root node of the workspace: a Node object.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function getRootNode();

    /**
     * Returns a new session in accordance with the specified (new)
     * Credentials.
     *
     * Allows the current user to acquire a new session using incomplete or
     * relaxed credentials requirements (perhaps including a user name but no
     * password, for example), assuming that this Session gives them that
     * permission. This method can be used to "impersonate" another user or to
     * clone the current session by passing in the same credentials that were
     * used to acquire the current session.
     *
     * The new Session is tied to a new Workspace instance. In other words,
     * Workspace instances are not re-used. However, the Workspace instance
     * returned represents the same actual persistent workspace entity in the
     * repository as is represented by the Workspace object tied to the current
     * Session.
     *
     * @param CredentialsInterface $credentials A Credentials object
     *
     * @return SessionInterface a Session object
     *
     * @throws LoginException if the current session does not have
     *      sufficient access to perform the operation.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function impersonate(CredentialsInterface $credentials);

    /**
     * Returns the node specified by the given identifier.
     *
     * Applies to both referenceable and non-referenceable nodes.
     *
     * @param string $id An identifier.
     *
     * @return NodeInterface A Node.
     *
     * @throws ItemNotFoundException if no node with the specified
     *      identifier exists or if this Session does not have read access to
     *      the node with the specified identifier.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getNodeByIdentifier($id);

    /**
     * Returns an iterator over the set of nodes specified by the given
     * identifiers in this workspace that are accessible to this session.
     *
     * Applies to both referenceable and non-referenceable nodes.
     * If none of the specified identifiers refer to an existing and accessible
     * node then an empty iterator is returned.
     *
     * @param array|\Traversable $ids A list of identifiers.
     *
     * @return \Iterator over all (matching) child Nodes implementing
     *      <b>SeekableIterator</b> and <b>Countable</b>. Keys are the
     *      identifiers, values the corresponding NodeInterface instances.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @since JCR 2.1
     *
     * @api
     */
    public function getNodesByIdentifier($ids);

    /**
     * Returns the node at the specified absolute path in the workspace. If no
     * such node exists, then it returns the property at the specified path.
     *
     * This method should only be used if the application does not know whether
     * the item at the indicated path is property or node. In cases where the
     * application has this information, either SessionInterface::getNode() or
     * SessionInterface::getProperty() should be used, as appropriate. In many
     * repository implementations the node and property-specific methods are
     * likely to be more efficient than getItem.
     *
     * @param string $absPath An absolute path.
     *
     * @return ItemInterface
     *
     * @throws PathNotFoundException if no accessible item is found at
     *      the specified path.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getItem($absPath);

    /**
     * Returns the node at the specified absolute path in the workspace.
     *
     * If $depthHint is set, the implementation may cache the subtree rooted at
     * $absPath to depth $depthHint in preparation for possible future access
     * requests by the client.
     *
     * The parameter $depthHint <i>may</i> be used by an implementation to
     * improve the efficiency of access for nodes in the subtree rooted at
     * $absPath. This may, for example, be advantageous to client-server
     * implementations by reducing round-trips to the server. An implementation
     * is free to ignore the $depthHint parameter.
     *
     * If the implementation does not ignore $depthHint then the following
     * rules apply:
     *
     * $depthHint &lt; 0: Equivalent to omitting the $deptHint
     * $depthHint = 0: The node at $absPath and all its properties are
     * retrieved. No child nodes (nor any further descendants) are retrieved.
     * This is referred to as a <i>shallow</i> getNode.
     *
     * $depthHint &gt; 0: The node at absPath and all its properties are
     * retrieved as well as all descendant nodes (and their respective
     * properties) up to degree $depthHint. A $depthHint of 1 retrieves the
     * node at $absPath and all its child nodes.
     * A $depthHint of 2 retrieves the node at $absPath, all its child nodes
     * and all <i>their</i> child nodes in turn. And so on.
     *
     * An implementation is free to set a limit on the amount of data cached
     * due to the $depthHint parameter. Thus, the implementation may fail to
     * retrieve to the full depth requested in cases where that depth is large
     * and the data size of the nodes and properties in the subtree is also
     * large. In order to guarantee a retrieval to the maximum depth possible,
     * the client can set $depthHint to PHP_INT_MAX.
     *
     * @param string $absPath   An absolute path.
     * @param int    $depthHint The requested caching depth
     *
     * @return NodeInterface A node
     *
     * @throws PathNotFoundException if no accessible node is found at the specified path.
     * @throws RepositoryException   if another error occurs.
     *
     * @api
     */
    public function getNode($absPath, $depthHint = -1);

    /**
     * Returns an iterator over all the nodes at the specified absolute paths
     * in the workspace that exist and are accessible to this session.
     *
     * Paths that do not lead to a accessible node are ignored, just as if the
     * node did not exist.
     *
     * If none of the specified paths leads to an existing and accessible
     * node then an empty iterator is returned.
     *
     * @param array|\Traversable $absPaths A list of absolute paths.
     *
     * @return \Iterator over all (matching) child Nodes implementing
     *      <b>SeekableIterator</b> and <b>Countable</b>. Keys are the
     *      paths, values the corresponding NodeInterface instances.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @since JCR 2.1
     *
     * @api
     */
    public function getNodes($absPaths);

    /**
     * Returns the property at the specified absolute path in the workspace.
     *
     * @param string $absPath An absolute path.
     *
     * @return PropertyInterface A property
     *
     * @throws PathNotFoundException if no accessible property is found
     *      at the specified path.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getProperty($absPath);

    /**
     * Returns an iterator over all the properties at the specified absolute
     * paths in the workspace that exist and are accessible to this session.
     *
     * If none of the specified paths leads to an existing and accessible
     * property then an empty iterator is returned.
     *
     * @param array|\Traversable $absPaths A list of absolute paths to properties.
     *
     * @return \Iterator over all (matching) child Nodes implementing
     *      <b>SeekableIterator</b> and <b>Countable</b>. Keys are the
     *      paths, values the corresponding NodeInterface instances.
     *
     * @throws RepositoryException If an error occurs.
     *
     * @since JCR 2.1
     *
     * @api
     */
    public function getProperties($absPaths);

    /**
     * Determines if the item identified by a path does exists.
     *
     * Returns true if an item exists at absPath and this Session has read
     * access to it; otherwise returns false.
     *
     * @param string $absPath An absolute path to an item to be found.
     *
     * @return boolean True if the item exists, else false.
     *
     * @throws RepositoryException if absPath is not a well-formed
     *      absolute path.
     *
     * @api
     */
    public function itemExists($absPath);

    /**
     * Determines if the node identified by the given absolute path does exist.
     *
     * Returns true if a node exists at absPath and this Session has read
     * access to it; otherwise returns false.
     *
     * @param string $absPath An absolute path to the node to be found.
     *
     * @return boolean True if the item does esist
     *
     * @throws RepositoryException if absPath is not a well-formed
     *      absolute path.
     *
     * @api
     */
    public function nodeExists($absPath);

    /**
     * Determines the existence of a property.
     *
     * Returns true if a property exists at absPath and this Session has read
     * access to it; otherwise returns false.
     *
     * @param string $absPath An absolute path to the property to be found.
     *
     * @return boolean True if the property is available.
     *
     * @throws RepositoryException if absPath is not a well-formed
     *      absolute path.
     *
     * @api
     */
    public function propertyExists($absPath);

    /**
     * Moves the node at srcAbsPath (and its entire subgraph) to the new
     * location at destAbsPath.
     *
     * This is a session-write method and therefor requires a save to dispatch
     * the change.
     *
     * The identifiers of referenceable nodes must not be changed by a move.
     * The identifiers of non-referenceable nodes may change.
     *
     * A ConstraintViolationException is thrown either immediately, on dispatch
     * or on persist, if performing this operation would violate a node type or
     * implementation-specific constraint. Implementations may differ on when
     * this validation is performed.
     *
     * As well, a ConstraintViolationException will be thrown on persist if an
     * attempt is made to separately save either the source or destination
     * node.
     *
     * Note that this behaviour differs from that of WorkspaceInterface::move(
     * $srcAbsPath, $destAbsPath), which is a workspace-write method and
     * therefore immediately dispatches changes.
     *
     * The destAbsPath provided must not have an index on its final element. If
     * ordering is supported by the node type of the parent node of the new
     * location, then the newly moved node is appended to the end of the child
     * node list.
     *
     * This method cannot be used to move an individual property by itself. It
     * moves an entire node and its subgraph.
     *
     * @param string $srcAbsPath  the root of the subgraph to be moved.
     * @param string $destAbsPath the location to which the subgraph is to be
     *      moved.
     *
     * @throws ItemExistsException if a node already exists at
     *      destAbsPath and same-name siblings are not allowed.
     * @throws PathNotFoundException if either srcAbsPath or destAbsPath
     *      cannot be found and this implementation performs this validation
     *      immediately.
     * @throws \PHPCR\Version\VersionException if the parent node of
     *      destAbsPath or the parent node of srcAbsPath is versionable and
     *      checked-in, or or is non-versionable and its nearest versionable
     *      ancestor is checked-in and this implementation performs this
     *      validation immediately.
     * @throws \PHPCR\NodeType\ConstraintViolationException if a node-type or
     *      other constraint violation is detected immediately and this
     *      implementation performs this validation immediately.
     * @throws \PHPCR\Lock\LockException if the move operation would violate a
     *      lock and this implementation performs this validation immediately.
     * @throws RepositoryException if the last element of destAbsPath
     *      has an index or if another error occurs.
     *
     * @api
     */
    public function move($srcAbsPath, $destAbsPath);

    /**
     * Removes the specified item and its subgraph.
     *
     * This is a session-write method and therefore requires a save in order to
     * dispatch the change.
     *
     * If a node with same-name siblings is removed, this decrements by one the
     * indices of all the siblings with indices greater than that of the
     * removed node. In other words, a removal compacts the array of same-name
     * siblings and causes the minimal re-numbering required to maintain the
     * original order but leave no gaps in the numbering.
     *
     * @param string $absPath the absolute path of the item to be removed.
     *
     * @throws \PHPCR\Version\VersionException if the parent node of the item
     *      at absPath is read-only due to a checked-in node and this
     *      implementation performs this validation immediately.
     * @throws \PHPCR\Lock\LockException if a lock prevents the removal of the
     *      specified item and this implementation performs this validation
     *      immediately instead.
     * @throws \PHPCR\NodeType\ConstraintViolationException if removing the
     *      specified item would violate a node type or implementation-specific
     *      constraint and this implementation performs this validation
     *      immediately.
     * @throws PathNotFoundException if no accessible item is found at
     *      $absPath property or if the specified item or an item in its
     *      subgraph is currently the target of a REFERENCE property located in
     *      this workspace but outside the specified item's subgraph and the
     *      current Session does not have read access to that REFERENCE
     *      property.
     * @throws RepositoryException if another error occurs.
     *
     * @see Item::remove()
     *
     * @api
     */
    public function removeItem($absPath);

    /**
     * Validates all pending changes currently recorded in this Session.
     *
     * If validation of all pending changes succeeds, then this change
     * information is cleared from the Session.
     *
     * If the save occurs outside a transaction, the changes are dispatched and
     * persisted. Upon being persisted the changes become potentially visible
     * to other Sessions bound to the same persistent workspace.
     *
     * If the save occurs within a transaction, the changes are dispatched but
     * are not persisted until the transaction is committed.
     *
     * If validation fails, then no pending changes are dispatched and they
     * remain recorded on the Session. There is no best-effort or partial save.
     *
     * @throws AccessDeniedException if any of the changes to be
     *      persisted would violate the access privileges of the this Session.
     *      Also thrown if any of the changes to be persisted would cause the
     *      removal of a node that is currently referenced by a REFERENCE
     *      property that this Session does not have read access to.
     * @throws ItemExistsException if any of the changes to be persisted
     *      would be prevented by the presence of an already existing item in
     *      the workspace.
     * @throws \PHPCR\NodeType\ConstraintViolationException if any of the
     *      changes to be persisted would violate a node type or restriction.
     *      Additionally, a repository may use this exception to enforce
     *      implementation- or configuration-dependent restrictions.
     * @throws InvalidItemStateException if any of the changes to be
     *      persisted conflicts with a change already persisted through another
     *      session and the implementation is such that this conflict can only
     *      be detected at save-time and therefore was not detected earlier, at
     *      change-time.
     * @throws ReferentialIntegrityException if any of the changes to be
     *      persisted would cause the removal of a node that is currently
     *      referenced by a REFERENCE property that this Session has read
     *      access to.
     * @throws \PHPCR\Version\VersionException if the save would make a result
     *      in a change to persistent storage that would violate the read-only
     *      status of a checked-in node.
     * @throws \PHPCR\Lock\LockException if the save would result in a change
     *      to persistent storage that would violate a lock.
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if the save would result
     *      in the addition of a node with an unrecognized node type.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function save();

    /**
     * Reloads the current session.
     *
     * If keepChanges is false, this method discards all pending changes
     * currently recorded in this Session and returns all items to reflect the
     * current saved state. Outside a transaction this state is simply the
     * current state of persistent storage. Within a transaction, this state
     * will reflect persistent storage as modified by changes that have been
     * saved but not yet committed.
     *
     * If keepChanges is true then pending change are not discarded but items
     * that do not have changes pending have their state refreshed to reflect
     * the current saved state, thus revealing changes made by other sessions.
     *
     * Implementors note: For performance reasons, implementations should only
     * mark nodes as dirty and reload them from the backend only if actually
     * needed.
     *
     * @param boolean $keepChanges Switch to override current changes kept in
     *      the session.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function refresh($keepChanges);

    /**
     * Determines if the current session has pending changes.
     *
     * Returns true if this session holds pending (that is, unsaved) changes;
     * otherwise returns false.
     *
     * @return boolean a boolean
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function hasPendingChanges();

    /**
     * Determines if the current session is permitted to run the passed
     * actions.
     *
     * Returns true if this Session has permission to perform the specified
     * actions at the specified absPath and false otherwise.
     * The actions parameter is a comma separated list of action strings.
     *
     * The following action strings are defined:
     *
     * - add_node: If hasPermission(path, "add_node") returns true, then this
     *      Session has permission to add a node at path.
     * - set_property: If hasPermission(path, "set_property") returns true,
     *      then this Session has permission to set (add or change) a property
     *      at path.
     * - remove: If hasPermission(path, "remove") returns true, then this
     *      Session has permission to remove an item at path.
     * - read: If hasPermission(path, "read") returns true, then this Session
     *      has permission to retrieve (and read the value of, in the case of
     *      a property) an item at path.
     *
     * When more than one action is specified in the actions parameter, this
     * method will only return true if this Session has permission to perform
     * all of the listed actions at the specified path.
     *
     * The information returned through this method will only reflect the
     * access control status (both JCR defined and implementation-specific) and
     * not other restrictions that may exist, such as node type constraints. For
     * example, even though hasPermission may indicate that a particular Session
     * may add a property at /A/B/C, the node type of the node at /A/B may
     * prevent the addition of a property called C.
     *
     * @param string $absPath an absolute path.
     * @param string $actions a comma separated list of action strings.
     *
     * @return boolean true if this Session has permission to perform the
     *      specified actions at the specified absPath.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function hasPermission($absPath, $actions);

    /**
     * Determines whether this Session has permission to perform the specified
     * actions at the specified absPath.
     *
     * This method quietly returns if the access request is
     * permitted, or throws a \PHPCR\Security\AccessControlException otherwise.
     * The actions parameter is a comma separated list of action strings.
     *
     * The following action strings are defined:
     *
     * - add_node: If checkPermission(path, "add_node") returns quietly, then
     *      this Session has permission to add a node at path, otherwise
     *      permission is denied.
     * - set_property: If checkPermission(path, "set_property") returns
     *      quietly, then this Session has permission to set (add or change) a
     *      property at path, otherwise permission is denied.
     * - remove: If checkPermission(path, "remove") returns quietly, then this
     *      Session has permission to remove an item at path, otherwise
     *      permission is denied.
     * - read: If checkPermission(path, "read") returns quietly, then this
     *      Session has permission to retrieve (and read the value of, in the
     *      case of a property) an item at path, otherwise permission is
     *      denied.
     *
     * When more than one action is specified in the actions parameter, this
     * method will only return true if this Session has permission to perform
     * all of the listed actions at the specified path.
     *
     * The information returned through this method will only reflect the
     * access control status (both JCR defined and implementation-specific) and
     * not other restrictions that may exist, such as node type constraints.
     * For example, even though hasPermission may indicate that a particular
     * Session may add a property at /A/B/C, the node type of the node at /A/B
     * may prevent the addition of a property called C.
     *
     * @param string $absPath an absolute path.
     * @param string $actions a comma separated list of action strings.
     *
     * @throws \PHPCR\Security\AccessControlException If permission is denied.
     * @throws RepositoryException                    if another error occurs.
     *
     * @api
     */
    public function checkPermission($absPath, $actions);

    /**
     * Checks whether an operation can be performed given as much context as
     * can be determined by the repository, including:
     *
     * - Permissions granted to the current user, including access control
     *      privileges.
     * - Current state of the target object (reflecting locks, checkin/checkout
     *   status, retention and hold status etc.).
     * - Repository capabilities.
     * - Node type-enforced restrictions.
     * - Repository configuration-specific restrictions.
     *
     * The implementation of this method is best effort: returning false
     * guarantees that the operation cannot be performed, but returning true
     * does not guarantee the opposite.
     *
     * The methodName parameter identifies the method in question by its name
     * as defined in the phpdoc.
     *
     * The target parameter identifies the object on which the specified method
     * is called.
     *
     * The arguments parameter contains a hash map consisting of parameter name
     * mapping to parameter value.
     *
     * For example, given a Session $s and Node $n then
     * <pre>
     *
     * $p['relPath'] = 'foo';
     * $b = $s->hasCapability("addNode", $n, $p);
     * </pre>
     *
     * will result in $b === false if a child node called foo cannot be added
     * to the node $n within the session $s.
     *
     * @param string $methodName the name of the method.
     * @param object $target     the target object of the operation.
     * @param array  $arguments  the arguments of the operation.
     *
     * @return boolean false if the operation cannot be performed, true if the
     *      operation can be performed or if the repository cannot determine
     *      whether the operation can be performed.
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function hasCapability($methodName, $target, array $arguments);

    /*
     * Fetches a content handler without altering the session.
     *
     * Returns an ContentHandlerInterface which is used to push SAX
     * events to the repository. If the incoming XML (in the form of SAX
     * events) does not appear to be a JCR system view XML document then it is
     * interpreted as a JCR document view XML document.
     * The incoming XML is deserialized into a subgraph of items immediately
     * below the node at parentAbsPath.
     *
     * This method simply returns the ContentHandler without altering the state
     * of the session; the actual deserialization to the session transient
     * space is done through the methods of the ContentHandler. Invalid XML
     * data will cause the ContentHandler to throw a SAXException.
     *
     * As SAX events are fed into the ContentHandler, the tree of new items is
     * built in the transient storage of the session. In order to dispatch the
     * new content, save must be called. See
     * WorkspaceInterface::getImportContentHandler() for a workspace-write
     * version of this method.
     *
     * The flag uuidBehavior governs how the identifiers of incoming nodes are
     * handled. There are four options:
     *
     * - ImportUUIDBehavior::IMPORT_UUID_CREATE_NEW: Incoming identifiers nodes
     *      are added in the same way that new node is added with
     *      NodeInterface::addNode(). That is, they are either assigned newly
     *      created identifiers upon addition or upon save (depending on the
     *      implementation). In either case, identifier collisions will not
     *      occur.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an
     *      incoming node has the same identifier as a node already existing in
     *      the workspace then the already existing node (and its subgraph) is
     *      removed from wherever it may be in the workspace before the
     *      incoming node is added. Note that this can result in nodes
     *      "disappearing" from locations in the workspace that are remote from
     *      the location to which the incoming subgraph is being written. Both
     *      the removal and the new addition will be persisted on save.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an
     *      incoming node has the same identifier as a node already existing in
     *      the workspace, then the already-existing node is replaced by the
     *      incoming node in the same position as the existing node. Note that
     *      this may result in the incoming subgraph being disaggregated and
     *      "spread around" to different locations in the workspace. In the
     *      most extreme case this behavior may result in no node at all being
     *      added as child of parentAbsPath. This will occur if the topmost
     *      element of the incoming XML has the same identifier as an existing
     *      node elsewhere in the workspace. The change will be persisted on
     *      save.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_THROW: If an incoming node
     *      has the same identifier as a node already existing in the workspace
     *      then a SAXException is thrown by the ContentHandler during
     *      deserialization.
     *
     * Unlike WorkspaceInterface::getImportContentHandler, this method does not
     * necessarily enforce all node type constraints during deserialization.
     * Those that would be immediately enforced in a session-write method
     * (NodeInterface::addNode(), NodeInterface::setProperty() etc.) of this
     * implementation cause the returned ContentHandler to throw an immediate
     * SAXException (todo: or whatever) during deserialization. All other
     * constraints are checked on save, just as they are in normal write
     * operations. However, which node type constraints are enforced depends
     * upon whether node type information in the imported data is respected,
     * and this is an implementation-specific issue.
     *
     * A SAXException will also be thrown by the returned ContentHandler during
     * deserialization if uuidBehavior is set to
     * IMPORT_UUID_COLLISION_REMOVE_EXISTING and an incoming node has the same
     * identifier as the node at parentAbsPath or one of its ancestors.
     *
     * @param string $parentAbsPath the absolute path of a node under which (as
     *      child) the imported subgraph will be built.
     * @param integer $uuidBehavior a four-value flag that governs how incoming
     *      identifiers are handled.
     *
     * @return ContentHandlerInterface whose methods may be called to
     *      feed SAX events into the deserializer.
     *
     * @throws PathNotFoundException if no node exists at parentAbsPath
     *      and this implementation performs this validation immediately.
     * @throws \PHPCR\NodeType\ConstraintViolationException if the new subgraph
     *      cannot be added to the node at parentAbsPath due to node-type or
     *      other implementation-specific constraints, and this implementation
     *      performs this validation immediately.
     * @throws \PHPCR\Version\VersionException if the node at $parentAbsPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws \PHPCR\Lock\LockException if a lock prevents the addition of the
     *      subgraph and this implementation performs this validation
     *      immediately.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    // Dropped for now. If you have an excellent and generic idea for this, suggestions are welcome
    // function getImportContentHandler($parentAbsPath, $uuidBehavior);

    /**
     * Deserializes an XML document and adds the resulting item subgraph as a
     * child of the node at $parentAbsPath.
     *
     * If the incoming XML does not appear to be a JCR system view XML document
     * then it is interpreted as a document view XML document.
     *
     * The tree of new items is built in the transient storage of the Session.
     * In order to persist the new content, save must be called. The advantage
     * of this through-the-session method is that (depending on what constraint
     * checks the implementation leaves until save) structures that violate
     * node type constraints can be imported, fixed and then saved. The
     * disadvantage is that a large import will result in a large cache of
     * pending nodes in the session. See WorkspaceInterface::importXML() for a
     * version of this method that does not go through the Session.
     *
     * The flag $uuidBehavior governs how the identifiers of incoming nodes are
     * handled. There are four options:
     *
     * - ImportUUIDBehavior::IMPORT_UUID_CREATE_NEW: Incoming nodes are added
     *      in the same way that new node is added with Node::addNode(). That
     *      is, they are either assigned newly created identifiers upon
     *      addition or upon save (depending on the implementation, see 4.9.1.1
     *      When Identifiers are Assigned in the specification). In either
     *      case, identifier collisions will not occur.
     *      (Weak)references will point to the original node if existing, to
     *      the imported node with matching id otherwise.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REMOVE_EXISTING: If an
     *      incoming node has the same identifier as a node already existing in
     *      the workspace then the already existing node (and its subgraph) is
     *      removed from wherever it may be in the workspace before the
     *      incoming node is added. Note that this can result in nodes
     *      "disappearing" from locations in the workspace that are remote from
     *      the location to which the incoming subgraph is being written. Both
     *      the removal and the new addition will be dispatched on save.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_REPLACE_EXISTING: If an
     *      incoming node has the same identifier as a node already existing in
     *      the workspace, then the already-existing node is replaced by the
     *      incoming node in the same position as the existing node. Note that
     *      this may result in the incoming subgraph being disaggregated and
     *      "spread around" to different locations in the workspace. In the
     *      most extreme case this behavior may result in no node at all being
     *      added as child of parentAbsPath. This will occur if the topmost
     *      element of the incoming XML has the same identifier as an existing
     *      node elsewhere in the workspace. The change will be dispatched on
     *      save.
     * - ImportUUIDBehavior::IMPORT_UUID_COLLISION_THROW: If an incoming node
     *      has the same identifier as a node already existing in the workspace
     *      then an ItemExistsException is thrown.
     *
     * Unlike WorkspaceInterface::importXML(), this method does not
     * necessarily enforce all node type constraints during deserialization.
     * Those that would be immediately enforced in a normal write method
     * (NodeInterface::addNode(), NodeInterface::setProperty() etc.) of this
     * implementation cause an immediate ConstraintViolationException during
     * deserialization. All other constraints are checked on save, just as they
     * are in normal write operations. However, which node type constraints are
     * enforced depends upon whether node type information in the imported data
     * is respected, and this is an implementation-specific issue.
     *
     * @param string $parentAbsPath the absolute path of the node below which
     *      the deserialized subgraph is added.
     * @param string $uri Source location for the XML to be read, Can be
     *      anything that works with fopen.
     * @param integer $uuidBehavior a four-value flag that governs how incoming
     *      identifiers are handled.
     *
     * @throws \RuntimeException     if an error during an I/O operation occurs.
     * @throws PathNotFoundException if no node exists at parentAbsPath
     *      and this implementation performs this validation immediately.
     * @throws ItemExistsException if deserialization would overwrite an
     *      existing item and this implementation performs this validation
     *      immediately.
     * @throws \PHPCR\NodeType\ConstraintViolationException if a node type or
     *      other implementation-specific constraint is violated that would be
     *      checked on a session write method or if uuidBehavior is set to
     *      IMPORT_UUID_COLLISION_REMOVE_EXISTING and an incoming node has the
     *      same UUID as the node at parentAbsPath or one of its ancestors.
     * @throws \PHPCR\Version\VersionException if the node at $parentAbsPath is
     *      read-only due to a checked-in node and this implementation performs
     *      this validation immediately.
     * @throws InvalidSerializedDataException if incoming stream is not
     *      a valid XML document.
     * @throws \PHPCR\Lock\LockException if a lock prevents the addition of the
     *      subgraph and this implementation performs this validation
     *      immediately.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function importXML($parentAbsPath, $uri, $uuidBehavior);

    /**
     * Serializes the node (and if $noRecurse is false, the whole subgraph) at
     * $absPath as an XML stream and outputs it to the supplied URI. The
     * resulting XML is in the system view form. Note that $absPath must be
     * the path of a node, not a property.
     *
     * If $skipBinary is true then any properties of PropertyType::BINARY will
     * be serialized as if they are empty. That is, the existence of the
     * property will be serialized, but its content will not appear in the
     * serialized output (the <sv:value> element will have no content). Note
     * that in the case of multi-value BINARY properties, the number of values
     * in the property will be reflected in the serialized output, though they
     * will all be empty. If $skipBinary is false then the actual value(s) of
     * each BINARY property is recorded using Base64 encoding.
     *
     * If $noRecurse is true then only the node at $absPath and its properties,
     * but not its child nodes, are serialized. If $noRecurse is false then the
     * entire subgraph rooted at $absPath is serialized.
     *
     * If the user lacks read access to some subsection of the specified tree,
     * that section simply does not get serialized, since, from the user's
     * point of view, it is not there.
     *
     * The serialized output will reflect the state of the current workspace as
     * modified by the state of this Session. This means that pending changes
     * (regardless of whether they are valid according to node type
     * constraints) and all namespace mappings in the namespace registry, as
     * modified by the current session-mappings, are reflected in the output.
     *
     * The output XML will be encoded in UTF-8.
     *
     * @param string $absPath The path of the root of the subgraph to be
     *      serialized. This must be the path to a node, not a property
     * @param resource $stream The stream resource (i.e. acquired with fopen) to
     *      which the XML serialization of the subgraph will be output. Must
     *      support the fwrite method.
     * @param boolean $skipBinary A boolean governing whether binary properties
     *      are to be serialized.
     * @param boolean $noRecurse A boolean governing whether the subgraph at
     *      absPath is to be recursed.
     *
     * @throws PathNotFoundException if no node exists at absPath.
     * @throws \RuntimeException     if an error during an I/O operation occurs.
     * @throws RepositoryException   if another error occurs.
     *
     * @api
     */
    public function exportSystemView($absPath, $stream, $skipBinary, $noRecurse);

    /**
     * Serializes the node (and if $noRecurse is false, the whole subgraph) at
     * $absPath as an XML stream and outputs it to the supplied URI.
     *
     * The resulting XML is in the document view form. Note that $absPath must
     * be the path of a node, not a property.
     *
     * If $skipBinary is true then any properties of PropertyType::BINARY will
     * be serialized as if they are empty. That is, the existence of the
     * property will be serialized, but its content will not appear in the
     * serialized output (the value of the attribute will be empty). If
     * $skipBinary is false then the actual value(s) of each BINARY property is
     * recorded using Base64 encoding.
     *
     * If $noRecurse is true then only the node at $absPath and its properties,
     * but not its child nodes, are serialized. If $noRecurse is false then the
     * entire subgraph rooted at $absPath is serialized.
     *
     * If the user lacks read access to some subsection of the specified tree,
     * that section simply does not get serialized, since, from the user's
     * point of view, it is not there.
     *
     * The serialized output will reflect the state of the current workspace as
     * modified by the state of this Session. This means that pending changes
     * (regardless of whether they are valid according to node type
     * constraints) and all namespace mappings in the namespace registry, as
     * modified by the current session-mappings, are reflected in the output.
     *
     * The output XML will be encoded in UTF-8.
     *
     * @param string $absPath The path of the root of the subgraph to be
     *      serialized. This must be the path to a node, not a property
     * @param resource $stream The stream resource (i.e. acquired with fopen) to
     *      which the XML serialization of the subgraph will be output. Must
     *      support the fwrite method.
     * @param boolean $skipBinary A boolean governing whether binary properties
     *      are to be serialized.
     * @param boolean $noRecurse A boolean governing whether the subgraph at
     *      absPath is to be recursed.
     *
     * @throws PathNotFoundException if no node exists at absPath.
     * @throws \RuntimeException     if an error during an I/O operation occurs.
     * @throws RepositoryException   if another error occurs.
     *
     * @api
     */
    public function exportDocumentView($absPath, $stream, $skipBinary, $noRecurse);

    /**
     * Sets the name of a namespace prefix.
     *
     * Within the scope of this Session, this method maps uri to prefix. The
     * remapping only affects operations done through this Session. To clear
     * all remappings, the client must acquire a new Session.
     * All local mappings already present in the Session that include either
     * the specified prefix or the specified uri are removed and the new
     * mapping is added.
     *
     * @param string $prefix The namespace prefix to be set as identifier.
     * @param string $uri    The location of the namespace definition (usually an
     *      uri).
     *
     * @throws NamespaceException if an attempt is made to map a
     *      namespace URI to a prefix beginning with the characters "xml" (in
     *      any combination of case) or if an attempt is made to map either the
     *      empty prefix or the empty namespace (i.e., if either $prefix or
     *      $uri are the empty string).
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function setNamespacePrefix($prefix, $uri);

    /**
     * Returns all prefixes currently mapped to URIs in this Session.
     *
     * @return array The list of currently registered namespace prefixes.
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function getNamespacePrefixes();

    /**
     * Returns the URI to which the given prefix is mapped as currently set in
     * this Session.
     *
     * @param string $prefix The identifier of the namespace location to be
     *      returned.
     *
     * @return string The location of the namespace definition identified by
     *      its prefix.
     *
     * @throws NamespaceException  if the specified prefix is unknown.
     * @throws RepositoryException if another error occurs
     *
     * @api
     */
    public function getNamespaceURI($prefix);

    /**
     * Returns the prefix to which the given uri is mapped as currently set in
     * this Session.
     *
     * @param string $uri The location of the namespace definition (usually a
     *      uri).
     *
     * @return string The prefix of a namespace identified by its uri.
     *
     * @throws NamespaceException  if the specified uri is unknown.
     * @throws RepositoryException if another error occurs
     *
     * @api
     */
    public function getNamespacePrefix($uri);

    /**
     * Releases all resources associated with this Session.
     *
     * This method should be called when a Session is no longer needed.
     *
     * @api
     */
    public function logout();

    /**
     * Determines if the current session is still valid.
     *
     * Returns true if this Session object is usable by the client. Otherwise,
     * returns false.
     *
     * A usable Session is one that is neither logged-out, timed-out nor in
     * any other way disconnected from the repository.
     *
     * @return boolean true if this Session is usable, false otherwise.
     *
     * @api
     */
    public function isLive();

    /**
     * Returns the access control manager for this Session.
     *
     * @return \PHPCR\Security\AccessControlManagerInterface the access control manager
     *      for this Session
     *
     * @throws UnsupportedRepositoryOperationException if access control
     *      is not supported.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getAccessControlManager();

    /**
     * Returns the retention and hold manager for this Session.
     *
     * @return \PHPCR\Retention\RetentionManagerInterface the retention manager
     *      for this Session.
     *
     * @throws UnsupportedRepositoryOperationException if retention and
     *      hold are not supported.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getRetentionManager();
}
