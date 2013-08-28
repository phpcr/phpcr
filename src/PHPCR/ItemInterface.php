<?php

namespace PHPCR;

/**
 * The Item is the base interface of Node and Property.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface ItemInterface
{
    /**
     * Returns the normalized absolute path to this item.
     *
     * @return string              the normalized absolute path of this Item.
     * @throws RepositoryException if an error occurs.
     * @api
     */
    public function getPath();

    /**
     * Returns the name of this Item in qualified form.
     *
     * If this Item is the root node of the workspace, an empty string is returned.
     *
     * @return string the name of this Item in qualified form or an empty
     *      string if this Item is the root node of a workspace.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function getName();

    /**
     * Returns the ancestor of this Item at the specified depth.
     *
     * An ancestor of depth x is the Item that is x levels down along the path
     * from the root node to this Item.
     *
     * - depth = 0 returns the root node of a workspace.
     * - depth = 1 returns the child of the root node along the path to this
     *      Item.
     * - depth = 2 returns the grandchild of the root node along the path to
     *      this Item.
     * - And so on to depth = n, where n is the depth of this Item, which
     *      returns this Item itself.
     *
     * If this node has more than one path (i.e., if it is a descendant of a
     * shared node) then the path used to define the ancestor is implementaion-
     * dependent.
     *
     * @param integer $depth An integer, 0 <= depth <= n where n is the depth
     *      of this Item.
     *
     * @return ItemInterface The ancestor of this Item at the specified
     *      depth.
     *
     * @throws ItemNotFoundException if depth < 0 or depth > n
     *      where n is the depth of this item.
     * @throws AccessDeniedException if the current session does not
     *      have sufficient access to retrieve the specified node.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function getAncestor($depth);

    /**
     * Returns the parent of this Item.
     *
     * @return NodeInterface The parent of this Item.
     *
     * @throws ItemNotFoundException if this Item is the root node of a
     *      workspace.
     * @throws AccessDeniedException if the current session does not
     *      have sufficient access to retrieve the parent of this item.
     * @throws RepositoryException if another error occurs.
     *
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
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function getDepth();

    /**
     * Returns the Session through which this Item was acquired.
     *
     * @return SessionInterface the Session through which this Item was
     *      acquired.
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function getSession();

    /**
     * Indicates whether this Item is a Node or a Property.
     *
     * Returns true if this Item is a Node; Returns false if this Item is a
     * Property.
     *
     * @return boolean true if this Item is a Node, false if it is a Property.
     *
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
     * @return boolean true if this item is new; false otherwise.
     *
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
     * @return boolean true if this item is modified; false otherwise.
     *
     * @api
     */
    public function isModified();

    /**
     * Determines if this Item object represents the same actual workspace item
     * as the object otherItem.
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
     *   isSame() is true of their parent nodes.
     *
     * This method does not compare the states of the two items. For example, if
     * two Item objects representing the same actual workspace item have been
     * retrieved through two different sessions and one has been modified, then
     * this method will still return true when comparing these two objects.
     * Note that if two Item objects representing the same workspace item are
     * retrieved through the same session they will always reflect the same
     * state.
     *
     * @param ItemInterface $otherItem the Item object to be tested for
     *      identity with this Item.
     *
     * @return boolean true if this Item object and otherItem represent the
     *      same actual repository item; false otherwise.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function isSame(ItemInterface $otherItem);

    /**
     * Call the ItemVisitor::visit() method.
     *
     * This is less relevant in PHP (Java had it to avoid typecasting in the
     * visitor). We leave it here, to allow sanity checks or other operations
     * an implementation might wants to do.
     *
     * @param ItemVisitorInterface $visitor The ItemVisitor to be
     *      accepted.
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function accept(ItemVisitorInterface $visitor);

    /**
     * Discard all pending changes on this item and its children.
     *
     * This method discards all pending changes currently recorded in this
     * <code>Session</code> that apply to this Item or any of its child nodes
     * and properties and returns these items to reflect the current saved
     * state. Outside a transaction this state is simply the current state of
     * persistent storage. Within a transaction, this state will reflect
     * persistent storage as modified by changes that have been saved but not
     * yet committed.
     *
     * @throws InvalidItemStateException if this <code>Item</code> object
     *      represents a workspace item that has been removed (either by this
     *      session or another).
     * @throws RepositoryException if another error occurs.
     *
     * @since JCR 2.1
     */
    public function revert();

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
     * @throws \PHPCR\Version\VersionException if the parent node of this item
     *      is versionable and checked-in or is non-versionable but its nearest
     *      versionable ancestor is checked-in and this implementation performs
     *      this validation immediately instead of waiting until save.
     * @throws \PHPCR\Lock\LockException if a lock prevents the removal of this
     *      item and this implementation performs this validation immediately
     *      instead of waiting until save.
     * @throws \PHPCR\NodeType\ConstraintViolationException if removing the
     *      specified item would violate a node type or implementation-specific
     *      constraint and this implementation performs this validation
     *      immediately instead of waiting until save.
     * @throws \PHPCR\AccessDeniedException if this item or an item in its
     *      subgraph is currently the target of a REFERENCE property located in
     *      this workspace but outside this item's subgraph and the current
     *      Session does not have read access to that REFERENCE property or if
     *      the current Session does not have sufficient privileges to remove
     *      the item.
     * @throws RepositoryException if another error occurs.
     *
     * @see SessionInterface::removeItem(String)
     *
     * @api
     */
    public function remove();
}
