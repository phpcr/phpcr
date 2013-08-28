<?php

namespace PHPCR\Version;

/**
 * The VersionManager object is accessed via
 * WorkspaceInterface::getVersionManager(). It provides methods for:
 *
 * - Version graph functionality (version history, base version, successors
 *      predecessors)
 * - Basic version operations (checkin, checkout, checkpoint)
 * - Restore feature
 * - Label feature
 * - Merge feature
 * - Configuration feature
 * - Activity feature
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface VersionManagerInterface
{
    /**
     * Creates for the versionable node at absPath a new version with a system
     * generated version name and returns that version (which will be the new
     * base version of this node). Sets the jcr:checkedOut property to false
     * thus putting the node into the checked-in state. This means that the node
     * and its connected non-versionable subgraph become read-only. A node's
     * connected non-versionable subgraph is the set of non-versionable descendant
     * nodes reachable from that node through child links without encountering
     * any versionable nodes. In other words, the read-only status flows down
     * from the checked-in node along every child link until either a versionable
     * node is encountered or an item with no children is encountered. In a
     * system that supports only simple versioning the connected non-versionable
     * subgraph will be equivalent to the whole subgraph, since simple-versionable
     * nodes cannot have simple-versionable descendants.
     *
     * Read-only status means that an item cannot be altered by the client using
     * standard API methods (addNode, setProperty, etc.). The only exceptions to
     * this rule are the restore(), restoreByLabel(), merge() and Node::update()
     * operations; these do not respect read-only status due to check-in. Note
     * that remove of a read-only node is possible, as long as its parent is not
     * read-only (since removal is an alteration of the parent node).
     *
     * If this node is already checked-in, this method has no effect but returns
     * the current base version of this node.
     *
     * If checkin succeeds, the change to the jcr:isCheckedOut property is
     * dispatched immediately.
     *
     * @param string $absPath an absolute path.
     *
     * @return VersionInterface the created version.
     *
     * @throws VersionException if jcr:predecessors does not contain at least
     *      one value or if a child item of the node at absPath has an
     *      OnParentVersion status of ABORT. This includes the case where an
     *      unresolved merge failure exists on the node, as indicated by the
     *      presence of a jcr:mergeFailed property.
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at $absPath is not versionable.
     * @throws \PHPCR\InvalidItemStateException
     *      if unsaved changes exist on the node at $absPath.
     * @throws \PHPCR\Lock\LockException
     *      if a lock prevents the operation.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function checkin($absPath);

    /**
     * Sets the versionable node at $absPath to checked-out status by setting
     * its jcr:isCheckedOut property to true. Under full versioning it also sets
     * the jcr:predecessors property to be a reference to the current base
     * version (the same value as held in jcr:baseVersion).
     *
     * This method puts the node into the checked-out state, making it and its
     * connected non-versionable subgraph no longer read-only (see checkin() for
     * an explanation of the term "connected non-versionable subgraph". Under
     * simple versioning this will simply be the whole subgraph).
     *
     * If successful, these changes are persisted immediately, there is no need
     * to call save.
     *
     * If this node is already checked-out, this method has no effect.
     *
     * @param string $absPath an absolute path.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws \PHPCR\Lock\LockException
     *      if a lock prevents the checkout.
     * @throws ActivityViolationException
     *      if the checkout conflicts with the activity present on the current
     *      session.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function checkout($absPath);

    /**
     * Performs a checkin() followed by a checkout() on the versionable node at
     * $absPath.
     *
     * If this node is already checked-in, this method is equivalent to checkout().
     *
     * @param string $absPath an absolute path.
     *
     * @return VersionInterface the created version.
     *
     * @throws VersionException
     *      if a child item of the node at absPath has an OnParentVersion of
     *      ABORT. This includes the case where an unresolved merge failure
     *      exists on the node, as indicated by the presence of the
     *      jcr:mergeFailed.
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws \PHPCR\InvalidItemStateException
     *      if there are unsaved changes pending on the node at absPath.
     * @throws \PHPCR\Lock\LockException
     *      if a lock prevents the operation.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function checkpoint($absPath);

    /**
     * Check whether the node at path is checked out.
     *
     * Returns true if the node at $absPath is either
     *
     * - versionable (full or simple) and currently checked-out,
     * - non-versionable and its nearest versionable ancestor is checked-out or
     * - non-versionable and it has no versionable ancestor.
     *
     * Returns false if the node at $absPath is either
     *
     * - versionable (full or simple) and currently checked-in or
     * - non-versionable and its nearest versionable ancestor is checked-in.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return boolean True, if the node identified by the given path is
     *      checked out, else false.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function isCheckedOut($absPath);

    /**
     * Returns the VersionHistory object of the node at $absPath. This object
     * provides access to the nt:versionHistory node holding this node's
     * versions.
     *
     * Note that, as with all cases where a JCR path is passed, this method may
     * be called with either the normal name-path of a version history node or
     * its identifier (in square brackets), that is, "[id]" where id is the raw
     * identifier string (see JCR 2.1 specification, section 3.4.4.1.2
     * Identifier-Based Absolute Paths).
     *
     * Version histories of nodes that have been removed must remain accessible
     * via that node's identifier, thus ensuring continued access. Note that
     * the application is responsible for saving the identifier in such cases.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return VersionHistoryInterface a VersionHistory object
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function getVersionHistory($absPath);

    /**
     * Returns the current base version of the versionable node at absPath.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @return VersionInterface a Version object.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function getBaseVersion($absPath);

    /**
     * In those implementations that support it, this method removes the entire
     * specified VersionHistory.
     *
     * Note that, as with all cases where a JCR path is passed, this method may
     * be called with either the normal name-path of a version history node or
     * its identifier (in square brackets), that is, "[id]" where id is the raw
     * identifier string. (see JCR 2.1 specification, section 3.4.4.1.2
     * Identifier-Based Absolute Paths).
     *
     * Even in implementations that do permit version history removal, this
     * method will only remove a version history that has no corresponding
     * versionable node in any workspace.
     *
     * This change is a workspace-write; there is no need to call save.
     *
     * @param string $absPath an absolute path.
     *
     * @throws VersionException if the version history has an existing
     *      corresponding versionable node in some workspace.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the operation
     *      is not supported by this implementation.
     * @throws \PHPCR\RepositoryException If another error occurs.
     *
     * @since JCR 2.1
     */
    public function removeVersionHistory($absPath);

    /**
     * Attempt to restore an old version of a node.
     *
     * <em>If $absPath is given and $version is a version name:</em>
     *  Restores the node at $absPath to the state defined by the version with
     *  the specified version name ($version).
     *  This method will work regardless of whether the node at absPath is
     *  checked-in or not.
     *
     *
     * <em>If $absPath is given and $version is a VersionInterface instance:
     * </em>
     *  Restores the specified version to $absPath. There must be no existing
     *  node at $absPath. If one exists, a VersionException is thrown.
     *  There must be a parent node to the location at $absPath, otherwise a
     *  PathNotFoundException is thrown.
     *  If the would-be parent of the location $absPath is actually a property,
     *  or if a node type restriction would be violated, then a
     *  ConstraintViolationException is thrown.
     *
     *
     * <em>If $version is VersionInterface instance:</em>
     *  Restores the node in the current workspace that is the versionable node
     *  of the specified version to the state reflected in that version.
     *  This method ignores checked-in status.
     *
     *
     * <em>If $version is an array of VersionInterface instances:</em>
     *  Restores a set of versions at once. Used in cases where a "chicken and
     *  egg" problem of mutually referring REFERENCE properties would prevent
     *  the restore in any serial order.
     *  The following restrictions apply to the set of versions specified: If S
     *  is the set of versions being restored simultaneously,
     *  - For every version V in S that corresponds to a missing node, there
     *    must also be a parent of V in S.
     *  - S must contain at least one version that corresponds to an existing
     *    node in the workspace.
     *  - No V in S can be a root version (jcr:rootVersion).
     *  If any of these restrictions does not hold, the restore will fail
     *  because the system will be unable to determine the path locations to
     *  which one or more versions are to be restored. In this case a
     *  VersionException is thrown.
     *  The versionable nodes in the current workspace that correspond to the
     *  versions being restored define a set of (one or more) subgraphs.
     *
     * <em>If the restore succeeds the changes made are dispatched immediately;
     * </em>
     * there is no need to call save.
     *
     * If an array of VersionInterface instances is restored, an identifier
     * collision occurs when the current workspace contains a node outside these
     * subgraphs that has the same identifier as one of the nodes that would be
     * introduced by the restore operation into one of these subgraphs.
     * Else, an identifier collision occurs when a node exists outside the
     * subgraph rooted at absPath with the same identifier as a node that would
     * be introduced by the restore operation into the affected subgraph.
     * The result in such a case is governed by the removeExisting flag. If
     * $removeExisting is true, then the incoming node takes precedence, and the
     * existing node (and its subgraph) is removed (if possible; otherwise a
     * RepositoryException is thrown). If $removeExisting is false, then an
     * ItemExistsException is thrown and no changes are made. Note that this
     * applies not only to cases where the restored node itself conflicts with
     * an existing node but also to cases where a conflict occurs with any node
     * that would be introduced into the workspace by the restore operation. In
     * particular, conflicts involving subnodes of the restored node that have
     * OnParentVersion settings of COPY or VERSION are also governed by the
     * $removeExisting flag.
     *
     * <b>Note:</b> The Java API defines this with multiple differing
     * signatures, you need to act accordingly in your implementation.
     *
     * @param boolean $removeExisting a boolean flag that governs what happens
     *      in case of an identifier collision
     * @param string|array|\Traversable|VersionInterface $version a version
     *      name, a list of Version objects or a Version object
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     *
     * @throws VersionException
     *      if the specified version does not have a corresponding node in the
     *      workspace this VersionManager has been created for or if an
     *      attempt is made to restore the root version (jcr:rootVersion).
     * @throws \PHPCR\ItemExistsException
     *      if $removeExisting is false and an identifier collision occurs or
     *      a node exists at $absPath.
     * @throws \PHPCR\InvalidItemStateException
     *      if this Session has pending unsaved changes.
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if versioning is not supported.
     * @throws \PHPCR\Lock\LockException
     *      if a lock prevents the restore.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function restore($removeExisting, $version, $absPath = null);

    /**
     * Restores the version of the node at absPath with the specified version
     * label. If this node is not versionable, an
     * UnsupportedRepositoryOperationException is thrown. If successful, the
     * change is persisted immediately and there is no need to call save.
     *
     * This method will work regardless of whether the node at absPath is
     * checked-in or not.
     *
     * An identifier collision occurs when a node exists outside the subgraph
     * rooted at this node with the same identifier as a node that would be
     * introduced by the restoreByLabel operation into the subgraph at this node.
     * The result in such a case is governed by the removeExisting flag. If
     * removeExisting is true, then the incoming node takes precedence, and the
     * existing node (and its subgraph) is removed (if possible; otherwise a
     * RepositoryException is thrown). If removeExisting is false, then a
     * ItemExistsException is thrown and no changes are made. Note that this
     * applies not only to cases where the restored node itself conflicts with
     * an existing node but also to cases where a conflict occurs with any node
     * that would be introduced into the workspace by the restore operation. In
     * particular, conflicts involving subnodes of the restored node that have
     * OnParentVersion settings of COPY or VERSION are also governed by the
     * removeExisting flag.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     * @param string  $versionLabel   a String
     * @param boolean $removeExisting a boolean flag that governs what happens
     *      in case of an identifier collision.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws VersionException
     *      if the specified versionLabel does not exist in this node's version
     *      history.
     * @throws \PHPCR\ItemExistsException
     *      if removeExisting is false and an identifier collision occurs.
     * @throws \PHPCR\Lock\LockException
     *      if a lock prevents the restore.
     * @throws \PHPCR\InvalidItemStateException
     *      if this Session (not necessarily the Node at absPath) has pending
     *      unsaved changes.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function restoreByLabel($absPath, $versionLabel, $removeExisting);

    /**
     * If an nt:activity Node is given:
     *
     * This method merges the changes that were made under the specified
     * activity into the current workspace.
     *
     * An activity A will be associated with a set of versions through the
     * jcr:activity reference of each version node in the set. We call each
     * such associated version a member of A.
     *
     * For each version history H that contains one or more members of A, one
     * such member will be the latest member of A in H. The latest member of A
     * in H is the version in H that is a member of A and that has no successor
     * versions (to any degree) that are also members of A.
     *
     * The set of versions that are the latest members of A in their respective
     * version histories is called the change set of A. It fully describes the
     * changes made under the activity A.
     *
     * This method performs a shallow merge into the current workspace of each
     * version in the change set of the activity specified by activityNode. If
     * there is no corresponding node in this workspace for a given member of
     * the change set, that member is ignored.
     *
     *
     * If an absolute path is given:
     *
     * This method can be thought of as a version-sensitive update.
     *
     * If isShallow is true, it tests the node at absPath against its
     * corresponding node in srcWorkspace with respect to the relation between
     * their respective base versions and either updates the node in question
     * or not, depending on the outcome of the test.
     *
     * If isShallow is false, this method recursively tests each versionable
     * node in the subgraph as mentioned above.
     *
     * If isShallow is true and this node is not versionable, then this method
     * returns and no changes are made.
     *
     * A MergeException is thrown if bestEffort is false and a versionable node
     * is encountered whose corresponding node's base version is on a divergent
     * branch from the base version of the node at absPath.
     *
     * This is a workspace-write method and therefore any changes are dispatched
     * immediately.
     *
     * This method returns an iterator over all versionable nodes in the
     * subgraph that received a merge result of fail. If bestEffort is false,
     * this iterator will be empty (since if merge returns successfully,
     * instead of throwing an exception, it will be because no failures were
     * encountered).
     * If bestEffort is true, this iterator will contain all nodes that received
     * a fail during the course of this merge operation.
     *
     *
     * See the JCR specifications for more details on the behavior of this
     * method.
     *
     * Note: The Java API defines this with multiple differing signatures.
     *
     * @param string|\PHPCR\NodeInterface $source an absolute path or an
     *      nt:activity node.
     * @param string $srcWorkspace the name of the source workspace (optional
     *      if $source is a Node).
     * @param boolean $bestEffort a boolean (optional if $source is a Node)
     * @param boolean $isShallow  a boolean (optional)
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and
     *      <b>Countable</b>. Keys are the Node names, values the corresponding
     *      NodeInterface instances that received a merge result of "fail" in
     *      the course of this operation.
     *
     * @throws \PHPCR\MergeException
     *      if bestEffort is false and a failed merge result is encountered.
     * @throws \PHPCR\InvalidItemStateException
     *      if this session (not necessarily the node at absPath) has pending
     *      unsaved changes.
     * @throws \PHPCR\NoSuchWorkspaceException
     *      if srcWorkspace does not exist.
     * @throws \PHPCR\AccessDeniedException
     *      if the current session does not have sufficient rights to perform
     *      the operation.
     * @throws \PHPCR\Lock\LockException
     *      if a lock prevents the merge.
     * @throws VersionException
     *      if the specified node is not an nt:activity node.
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if this operation is not supported by this implementation.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function merge($source, $srcWorkspace = null, $bestEffort = null, $isShallow = false);

    /**
     * Completes the merge process with respect to the node at absPath and the
     * specified version.
     *
     * When the merge(string, string, boolean) method is called on a node, every
     * versionable node in that subgraph is compared with its corresponding node
     * in the indicated other workspace and a "merge test result" is determined
     * indicating one of the following:
     *
     * <ol>
     * <li>
     *   This node will be updated to the state of its correspondee (if the
     *   base version of the correspondee is more recent in terms of version
     *   history)
     * </li><li>
     *   This node will be left alone (if this node's base version is more
     *   recent in terms of version history).
     * </li><li>
     *   This node will be marked as having failed the merge test (if this
     *   node's base version is on a different branch of the version history
     *   from the base version of its corresponding node in the other
     *   workspace, thus preventing an automatic determination of which is more
     *   recent).
     * </li>
     * </ol>
     *
     * (See merge() for more details)
     *
     * In the last case the merge of the non-versionable subgraph (the "content")
     * of this node must be done by the application (for example, by providing a
     * merge tool for the user).
     *
     * Additionally, once the content of the nodes has been merged, their version
     * graph branches must also be merged. The JCR versioning system provides for
     * this by keeping a record, for each versionable node that fails the merge
     * test, of the base version of the corresponding node that caused the merge
     * failure. This record is kept in the jcr:mergeFailed property of this node.
     * After a merge, this property will contain one or more (if multiple merges
     * have been performed) REFERENCEs that point to the "offending versions".
     *
     * To complete the merge process, the client calls doneMerge(Version v)
     * passing the version object referred to be the jcr:mergeFailed property
     * that the client wishes to connect to this node in the version graph. This
     * has the effect of moving the reference to the indicated version from the
     * jcr:mergeFailed property of this node to the jcr:predecessors.
     *
     * If the client chooses not to connect this node to a particular version
     * referenced in the jcr:mergeFailed property, he calls cancelMerge(String,
     * Version).
     * This has the effect of removing the reference to the specified version
     * from jcr:mergeFailed without adding it to jcr:predecessors.
     *
     * Once the last reference in jcr:mergeFailed has been either moved to
     * jcr:predecessors (with doneMerge) or just removed from jcr:mergeFailed
     * (with cancelMerge) the jcr:mergeFailed property is automatically removed,
     * thus enabling this node to be checked-in, creating a new version (note
     * that before the jcr:mergeFailed is removed, its OnParentVersion setting of
     * ABORT prevents checkin). This new version will have a predecessor
     * connection to each version for which doneMerge was called, thus joining
     * those branches of the version graph.
     *
     * If successful, these changes are dispatched immediately, there is no need
     * to call save.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     * @param VersionInterface $version a version referred to by the
     *      jcr:mergeFailed  property of the node at absPath.
     *
     * @throws VersionException
     *      if the version specified is not among those referenced in this
     *      node's jcr:mergeFailed or if the node is currently checked-in.
     * @throws \PHPCR\InvalidItemStateException
     *      if there are unsaved changes pending on the node at absPath.
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function doneMerge($absPath, VersionInterface $version);

    /**
     * Cancels the merge process with respect to the node at absPath and the
     * specified version.
     *
     * See doneMerge(string, Version) for a full explanation. Also see
     * merge(string, string, boolean) for more details.
     *
     * If successful, these changes are dispatched immediately, there is no
     * need to call save.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     * @param VersionInterface $version a version referred to by the
     *      jcr:mergeFailed  property of the node at absPath.
     *
     * @throws VersionException
     *      if the version specified is not among those referenced in the
     *      jcr:mergeFailed  property of the node at absPath  or if the node is
     *      currently checked-in.
     * @throws \PHPCR\InvalidItemStateException
     *      if there are unsaved changes pending on the node at absPath.
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the node at absPath is not versionable.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function cancelMerge($absPath, VersionInterface $version);

    /**
     * Calling createConfiguration on the node N at absPath creates, in the
     * configuration storage, a new nt:configuration node whose root is N. A
     * reference to N is recorded in the jcr:root property of the new
     * configuration, and a reference to the new configuration is recorded in
     * the jcr:configuration property of N.
     *
     * If the specified baseline is null, a new version history is created to
     * store baselines of the new configuration, and the jcr:baseVersion of the
     * new configuration references the root of the new version history. If the
     * specified baseline is not null, the jcr:baseVersion of the new
     * configuration references the specified baseline.
     *
     * The changes are persisted immediately, a save is not required.
     *
     * @param string $absPath The absolute path to a node the privileges shall
     *      be fetched of.
     * @param VersionInterface $baseline a Version
     *
     * @return \PHPCR\NodeInterface a new nt:configuration node
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if N is not versionable.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function createConfiguration($absPath, VersionInterface $baseline);

    /**
     * This method is called by the client to set the current activity on the
     * session from which this version manager has been obtained. Changing the
     * current activity is done by calling setActivity again. Cancelling the
     * current activity (so that the session has no current activity) is done
     * by calling setActivity(null). The activity Node is returned.
     *
     * @param \PHPCR\NodeInterface $activity an activity node
     *
     * @return \PHPCR\NodeInterface the activity node
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the repository does not support activities or if activity is not
     *      a nt:activity node.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function setActivity(\PHPCR\NodeInterface $activity);

    /**
     * Returns the node representing the current activity or null if there is no
     * current activity.
     *
     * @return \PHPCR\NodeInterface An nt:activity node or null.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the repository does not support activities.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function getActivity();

    /**
     * This method creates a new nt:activity at an implementation-determined
     * location in the /jcr:system/jcr:activities subgraph.
     *
     * The repository may, but is not required to, use the title as a hint for
     * what to name the new activity node. The new activity Node is returned.
     *
     * The new node is dispatched immediately and does not require a save.
     *
     * @param string $title The title of the activity to be created.
     *
     * @return \PHPCR\NodeInterface the new activity Node.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the repository does not support activities.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function createActivity($title);

    /**
     * This method removes the given $activityNode.
     *
     * The change is dispatched immediately and does not require a save.
     *
     * @param \PHPCR\NodeInterface $activityNode an activity Node
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException
     *      if the repository does not support activities.
     * @throws \PHPCR\RepositoryException
     *      if another error occurs.
     *
     * @api
     */
    public function removeActivity(\PHPCR\NodeInterface $activityNode);
}
