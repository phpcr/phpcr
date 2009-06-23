<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Version;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 */

/**
 * The VersionManager object is accessed via Workspace.getVersionManager(). It
 * provides methods for:
 *  Version graph functionality (version history, base version, successors predecessors)
 *  Basic version operations (checkin, checkout, checkpoint)
 *  Restore feature
 *  Label feature
 *  Merge feature
 *  Configuration feature
 *  Activity feature
 *
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface VersionManagerInterface {


	/**
	 * Creates for the versionable node at absPath a new version with a system
	 * generated version name and returns that version (which will be the new
	 * base version of this node). Sets the jcr:checkedOut property to FALSE
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
	 * this rule are the restore(), restoreByLabel(), merge() and Node.update()
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
	 * @return \F3\PHPCR\Version\VersionInterface the created version.
	 * @throws \F3\PHPCR\Verson\VersionException if jcr:predecessors does not contain at least one value or if a child item of the node at absPath has an OnParentVersion status of ABORT. This includes the case where an unresolved merge failure exists on the node, as indicated by the presence of a jcr:mergeFailed property.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException If the node at $absPath is not versionable.
	 * @throws \F3\PHPCR\InvalidItemStateException If unsaved changes exist on the node at $absPath.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the operation.
	 * @throws \F3\PHPCR\RepositoryException If another error occurs.
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
	 * @return void
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException If the node at absPath is not versionable.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the checkout.
	 * @throws \F3\PHPCR\Version\ActivityViolationException If the checkout conflicts with the activity present on the current session.
	 * @throws \F3\PHPCR\RepositoryException If another error occurs.
	 */
	public function checkout($absPath);

	/**
	 * Performs a checkin() followed by a checkout() on the versionable node at
	 * $absPath.
	 *
	 * If this node is already checked-in, this method is equivalent to checkout().
	 *
	 * @param string $absPath an absolute path.
	 * @return \F3\PHPCR\Version\VersionInterface the created version.
	 * @throws \F3\PHPCR\Version\VersionException if a child item of the node at absPath has an OnParentVersion of ABORT. This includes the case where an unresolved merge failure exists on the node, as indicated by the presence of the jcr:mergeFailed.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the node at absPath is not versionable.
	 * @throws \F3\PHPCR\InvalidItemStateException if there are unsaved changes pending on the node at absPath.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the operation.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function checkpoint($absPath);

	/**
	 * Returns true if the node at $absPath is either
	 *  versionable (full or simple) and currently checked-out,
	 *  non-versionable and its nearest versionable ancestor is checked-out or
	 *  non-versionable and it has no versionable ancestor.
	 *
	 * Returns false if the node at $absPath is either
	 *  versionable (full or simple) and currently checked-in or
	 *  non-versionable and its nearest versionable ancestor is checked-in.
	 *
	 * @param $absPath an absolute path.
	 * @return boolean a boolean
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
	 */
	public function isCheckedOut($absPath);

	/**
	 * Returns the VersionHistory object of the node at $absPath. This object
	 * provides access to the nt:versionHistory node holding this node's versions.
	 *
	 * @param string $absPath an absolute path.
	 * @return \F3\PHPCR\Version\VersionHistoryInterface a VersionHistory object
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the node at absPath is not versionable.
	 * @throws \F3\PHPCR\RepositoryException If another error occurs.
	 */
	public function getVersionHistory($absPath);

	/**
	 * Returns the current base version of the versionable node at absPath.
	 *
	 * @param string $absPath an absolute path.
	 * @return \F3\PHPCR\Version\VersionInterface a Version object.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the node at absPath is not versionable.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getBaseVersion($absPath);

	/**
	 * pending
	 */
	public function restore();

	/**
	 * Restores the version of the node at absPath with the specified version
	 * label. If this node is not versionable, an UnsupportedRepositoryOperationException
	 * is thrown. If successful, the change is persisted immediately and there
	 * is no need to call save.
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
	 * @param string $absPath an absolute path.
	 * @param string $versionLabel a String
	 * @param boolean $removeExisting a boolean flag that governs what happens in case of an identifier collision.
	 * @return void
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the node at absPath is not versionable.
	 * @throws \F3\PHPCR\Version\VersionException if the specified versionLabel does not exist in this node's version history.
	 * @throws \F3\PHPCR\ItemExistsException if removeExisting is false and an identifier collision occurs.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the restore.
	 * @throws \F3\PHPCR\InvalidItemStateException if this Session (not necessarily the Node at absPath) has pending unsaved changes.
	 * @throws \F3\PHPCR\RepositoryException If another error occurs.
	 */
	public function restoreByLabel($absPath, $versionLabel, $removeExisting);

	/**
	 * If an nt:activity Node is given:
	 *
	 * This method merges the changes that were made under the specified activity
	 * into the current workspace.
	 *
	 * An activity A will be associated with a set of versions through the
	 * jcr:activity reference of each version node in the set. We call each such
	 * associated version a member of A.
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
	 * their respective base versions and either updates the node in question or
	 * not, depending on the outcome of the test.
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
	 * This is a worksapce-write method and therefore any changes are dispatched
	 * immediately.
	 *
	 * This method returns a NodeIterator over all versionable nodes in the
	 * subgraph that received a merge result of fail. If bestEffort is false,
	 * this iterator will be empty (since if merge returns successfully, instead
	 * of throwing an exception, it will be because no failures were encountered).
	 * If bestEffort is true, this iterator will contain all nodes that received
	 * a fail during the course of this merge operation.
	 *
	 *
	 * See the JCR specifications for more details on the behavior of this
	 * method.
	 *
	 * @param string|\F3\PHPCR\NodeInterface $source an absolute path or an nt:activity node.
	 * @param string $srcWorkspace the name of the source workspace (optional if $source is a Node).
	 * @param boolean $bestEffort a boolean (optional if $source is a Node)
	 * @param boolean $isShallow a boolean (optional)
	 * @return \F3\PHPCR\NodeIteratorInterface iterator over all nodes that received a merge result of "fail" in the course of this operation.
	 * @throws \F3\PHPCR\MergeException - if bestEffort is false and a failed merge result is encountered.
	 * @throws \F3\PHPCR\InvalidItemStateException - if this session (not necessarily the node at absPath) has pending unsaved changes.
	 * @throws \F3\PHPCR\NoSuchWorkspaceException - if srcWorkspace does not exist.
	 * @throws \F3\PHPCR\AccessDeniedException - if the current session does not have sufficient rights to perform the operation.
	 * @throws \F3\PHPCR\Lock\LockException - if a lock prevents the merge.
	 * @throws \F3\PHPCR\Version\VersionException - if the specified node is not an nt:activity node.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if this operation is not supported by this implementation.
	 * @throws \F3\PHPCR\RepositoryException - if another error occurs.
	 */
	public function merge($source, $srcWorkspace = NULL, $bestEffort = NULL, $isShallow = FALSE);

	/**
	 * Completes the merge process with respect to the node at absPath and the
	 * specified version.
	 *
	 * When the merge(string, string, boolean) method is called on a node, every
	 * versionable node in that subgraph is compared with its corresponding node
	 * in the indicated other workspace and a "merge test result" is determined
	 * indicating one of the following:
	 *
	 * 1. This node will be updated to the state of its correspondee (if the base
	 *    version of the correspondee is more recent in terms of version history)
	 * 2. This node will be left alone (if this node's base version is more recent
	 *    in terms of version history).
	 * 3. This node will be marked as having failed the merge test (if this node's
	 *    base version is on a different branch of the version history from the
	 *    base version of its corresponding node in the other workspace, thus
	 *    preventing an automatic determination of which is more recent).
	 *
	 * (See merge(java.lang.String, java.lang.String, boolean) for more details)
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
	 * referenced in the jcr:mergeFailed property, he calls cancelMerge(String, Version).
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
	 * @param string $absPath an absolute path.
	 * @param \F3\PHPCR\Version\VersionInterface $version a version referred to by the jcr:mergeFailed  property of the node at absPath.
	 * @return void
	 * @throws \F3\PHPCR\Version\VersionException if the version specified is not among those referenced in this node's jcr:mergeFailed or if the node is currently checked-in.
	 * @throws \F3\PHPCR\InvalidItemStateException if there are unsaved changes pending on the node at absPath.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the node at absPath is not versionable.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function doneMerge($absPath, \F3\PHPCR\Version\VersionInterface $version);

	/**
	 * Cancels the merge process with respect to the node at absPath and the
	 * specified version.
	 *
	 * See doneMerge(string, Version) for a full explanation. Also see
	 * merge(string, string, boolean) for more details.
	 *
	 * If successful, these changes are dispatched immediately, there is no need
	 * to call save.
	 *
	 * @param string $absPat an absolute path
	 * @param \F3\PHPCR\Version\VersionInterface a version referred to by the jcr:mergeFailed  property of the node at absPath.
	 * @return void
	 * @throws \F3\PHPCR\Version\VersionException if the version specified is not among those referenced in the jcr:mergeFailed  property of the node at absPath  or if the node is currently checked-in.
	 * @throws \F3\PHPCR\InvalidItemStateExceptionif there are unsaved changes pending on the node at absPath.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationExceptionif the node at absPath is not versionable.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function cancelMerge($absPath, \F3\PHPCR\Version\VersionInterface $version);

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
	 * @param string $absPath an absolute path.
	 * @param \F3\PHPCR\Version\VersionInterface $baseline a Version
	 * @return \F3\PHPCR\NodeInterface a new nt:configuration node
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if N is not versionable.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function createConfiguration($absPath, \F3\PHPCR\Version\VersionInterface $baseline);

	/**
	 * This method is called by the client to set the current activity on the
	 * session from which this version manager has been obtained. Changing the
	 * current activity is done by calling setActivity again. Cancelling the
	 * current activity (so that the session has no current activity) is done
	 * by calling setActivity(null). The activity Node is returned.
	 *
	 * @param \F3\PHPCR\NodeInterface $activity an activity node
	 * @return \F3\PHPCR\NodeInterface the activity node
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the repository does not support activities or if activity is not a nt:activity node.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function setActivity(\F3\PHPCR\NodeInterface $activity);

	/**
	 * Returns the node representing the current activity or NULL if there is no
	 * current activity.
	 *
	 * @return \F3\PHPCR\NodeInterface An nt:activity node or NULL.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the repository does not support activities.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
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
	 * @param string $title a String
	 * @return \F3\PHPCR\NodeInterface the new activity Node.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the repository does not support activities.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function createActivity($title);

	/**
	 * This method removes the given $activityNode.
	 *
	 * The change is dispatched immediately and does not require a save.
	 *
	 * @param \F3\PHPCR\NodeInterface $activityNode an activity Node
	 * @return void
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException if the repository does not support activities.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function removeActivity(\F3\PHPCR\NodeInterface $activityNode);

}

?>