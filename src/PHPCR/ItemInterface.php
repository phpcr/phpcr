<?php
/**
 * Interface to describe the contract to implement aNode or a Property.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */

declare(ENCODING = 'utf-8');
namespace PHPCR;

/**
 * The Item is the base interface of Node and Property.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface ItemInterface {

    /**
     * Returns the normalized absolute path to this item.
     *
     * @returns string the normalized absolute path of this Item.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getPath();

    /**
     * Returns the name of this Item in qualified form.
     *
     * If this Item is the root node of the workspace, an empty string is returned.
     *
     * @return string the name of this Item in qualified form or an empty string if this Item is the root node of a workspace.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getName();

    /**
     * Returns the ancestor of this Item at the specified depth.
     *
     * An ancestor of depth x is the Item that is x levels down along the path from the root
     * node to this Item.
     *
     * - depth = 0 returns the root node of a workspace.
     * - depth = 1 returns the child of the root node along the path to this Item.
     * - depth = 2 returns the grandchild of the root node along the path to this Item.
     * - And so on to depth = n, where n is the depth of this Item, which returns this Item itself.
     *
     * If this node has more than one path (i.e., if it is a descendant of a
     * shared node) then the path used to define the ancestor is implementaion-
     * dependent.
     *
     * @param integer $depth An integer, 0 <= depth <= n where n is the depth of this Item.
     * @return \PHPCR\ItemInterface The ancestor of this Item at the specified depth.
     * @throws \PHPCR\ItemNotFoundException if depth &lt; 0 or depth &gt; n where n is the depth of this item.
     * @throws \PHPCR\AccessDeniedException if the current session does not have sufficient access to retrieve the specified node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function getAncestor($depth);

    /**
     * Returns the parent of this Item.
     *
     * @return \PHPCR\NodeInterface The parent of this Item.
     * @throws \PHPCR\ItemNotFoundException if this Item< is the root node of a workspace.
     * @throws \PHPCR\AccessDeniedException if the current session does not have sufficent access to retrieve the parent of this item.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function getParent();

    /**
     * Returns the depth of this Item in the workspace item graph.
     *
     * - The root node returns 0.
     * - A property or child node of the root node returns 1.
     * - A property or child node of a child node of the root returns 2.
     * - And so on to this Item.
     *
     * @return integer The depth of this Item in the workspace item graph.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getDepth();

    /**
     * Returns the Session through which this Item was acquired.
     *
     * @return \PHPCR\SessionInterface the Session through which this Item was acquired.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getSession();

    /**
     * Indicates whether this Item is a Node or a Property.
     *
     * Returns true if this Item is a Node; Returns false if this Item is a Property.
     *
     * @return boolean TRUE if this Item is a Node, FALSE if it is a Property.
     * @api
     */
    public function isNode();

    /**
     * Determines if the current item is a new one.
     *
     * Returns true if this is a new item, meaning that it exists only in
     * transient storage on the Session and has not yet been saved. Within a
     * transaction, isNew on an Item may return false (because the item has
     * been saved) even if that Item is not in persistent storage (because the
     * transaction has not yet been committed).
     *
     * Note that if an item returns true on isNew, then by definition is parent
     * will return true on isModified.
     *
     * Note that in read-only implementations, this method will always return
     * false.
     *
     * @return boolean TRUE if this item is new; FALSE otherwise.
     * @api
     */
    public function isNew();

    /**
     * Indicates if the current item has been modified.
     *
     * Returns true if this Item has been saved but has subsequently been
     * modified through the current session and therefore the state of this
     * item as recorded in the session differs from the state of this item as
     * saved. Within a transaction, isModified on an Item may return false
     * (because the Item has been saved since the modification) even if the
     * modification in question is not in persistent storage (because the
     * transaction has not yet been committed).
     *
     * Note that in read-only implementations, this method will always return
     * false.
     *
     * @return boolean TRUE if this item is modified; FALSE otherwise.
     * @api
     */
    public function isModified();

    /**
     * Determines if this Item object represents the same actual workspace item as the object otherItem.
     *
     * Two Item objects represent the same workspace item if all the following
     * are true:
     *
     * - Both objects were acquired through Session objects that were created
     *   by the same Repository object.
     * - Both objects were acquired through Session objects bound to the same
     *   repository workspace.
     * - The objects are either both Node objects or both Property
     *   objects.
     * - If they are Node objects, they have the same identifier.
     * - If they are Property objects they have identical names and
     *   isSame() is TRUE of their parent nodes.
     *
     * This method does not compare the states of the two items. For example, if
     * two Item objects representing the same actual workspace item have been
     * retrieved through two different sessions and one has been modified, then
     * this method will still return true when comparing these two objects.
     * Note that if two Item objects representing the same workspace item are
     * retrieved through the same session they will always reflect the same
     * state.
     *
     * @param \PHPCR\ItemInterface $otherItem the Item object to be tested for identity with this Item.
     * @return boolean TRUE if this Item object and otherItem represent the same actual repository item; FALSE otherwise.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function isSame(\PHPCR\ItemInterface $otherItem);

    /**
     * Calls the appropriate ItemVisitor::visit() method according to whether this Item is a Node or a Property.
     *
     * @param \PHPCR\ItemVisitorInterface $visitor The ItemVisitor to be accepted.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function accept(\PHPCR\ItemVisitorInterface $visitor);

    /**
     * Updates the state of the current item.
     *
     * If keepChanges is false, this method discards all pending changes
     * currently recorded in this Session that apply to this Item or any
     * of its descendants (that is, the subgraph rooted at this Item) and
     * returns all items to reflect the current saved state. Outside a
     * transaction this state is simple the current state of persistent
     * storage. Within a transaction, this state will reflect persistent
     * storage as modified by changes that have been saved but not yet
     * committed.
     *
     * If keepChanges is true then pending change are not discarded but
     * items that do not have changes pending have their state refreshed
     * to reflect the current saved state, thus revealing changes made by
     * other sessions.
     *
     * @param boolean $keepChanges a boolean
     * @return void
     * @throws \PHPCR\InvalidItemStateException if this Item object represents a workspace item that has been removed
     *                                          (either by this session or another).
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function refresh($keepChanges);

    /**
     * Removes this item (and its subgraph).
     *
     * To persist a removal, a save must be performed that includes the (former)
     * parent of the removed item within its scope.
     *
     * If a node with same-name siblings is removed, this decrements by one the
     * indices of all the siblings with indices greater than that of the removed
     * node. In other words, a removal compacts the array of same-name siblings
     * and causes the minimal re-numbering required to maintain the original
     * order but leave no gaps in the numbering.
     *
     * @return void
     * @throws \PHPCR\Version\VersionException if the parent node of this item is versionable and checked-in or is
     *                                         non-versionable but its nearest versionable ancestor is checked-in and
     *                                         this implementation performs this validation immediately instead of
     *                                         waiting until save.
     * @throws \PHPCR\Lock\LockException if a lock prevents the removal of this item and this implementation performs
     *                                   this validation immediately instead of waiting until save.
     * @throws \PHPCR\ConstraintViolationException if removing the specified item would violate a node type or
     *                                             implementation-specific constraint and this implementation performs
     *                                             this validation immediately instead of waiting until save.
     * @throws \PHPCR\AccessDeniedException if this item or an item in its subgraph is currently the target of a
     *                                      REFERENCE property located in this workspace but outside this item's
     *                                      subgraph and the current Session does not have read access to that
     *                                      REFERENCE property or if the current Session does not have sufficent
     *                                      privileges to remove the item.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @see SessionInterface::removeItem(String)
     * @api
     */
    public function remove();

}
