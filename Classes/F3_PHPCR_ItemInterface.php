<?php
declare(ENCODING = 'utf-8');

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
 * The Item is the base interface of Node and Property.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_ItemInterface {

	/**
	 * Returns the absolute path to this item. If the path includes items that
	 * are same-name sibling nodes properties then those elements in the path
	 * will include the appropriate "square bracket" index notation (for
	 * example, /a/b[3]/c).
	 *
	 * @returns string the path of this Item.
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function getPath();

	/**
	 * Returns the name of this Item. The name of an item is the last element
	 * in its path, minus any square-bracket index that may exist.
	 * If this Item is the root node of the workspace (i.e., if
	 * $this->getDepth() == 0), an empty string will be returned.
	 *
	 * @return string the (or a) name of this Item or an empty string if this Item is the root node.
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function getName();

	/**
	 * Returns the ancestor of the specified depth.
	 *
	 * An ancestor of depth x is the Item that is x levels down along the path from
	 * the root node to this Item.
	 *
	 * * depth = 0 returns the root node.
	 * * depth = 1 returns the child of the root node along the path to this Item.
	 * * depth = 2 returns the grandchild of the root node along the path to this Item.
	 * * And so on to depth = n, where n is the depth of this Item, which returns this Item itself.
	 *
	 * If depth > n is specified then a ItemNotFoundException is thrown.
	 *
	 * @param integer $depth An integer, 0 <= depth <= n where n is the depth of this Item.
	 * @return F3_PHPCR_ItemInterface The ancestor of this Item at the specified depth.
	 * @throws F3_PHPCR_ItemNotFoundException if depth &lt; 0 or depth &gt; n where n is the depth of this item.
	 * @throws F3_PHPCR_AccessDeniedException if the current session does not have sufficient access rights to retrieve the specified node.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function getAncestor($depth);

	/**
	 * Returns the depth of this Item in the workspace tree. Returns the depth
	 * below the root node of this Item (counting this Item itself).
	 *
	 * * The root node returns 0.
	 * * A property or child node of the root node returns 1.
	 * * A property or child node of a child node of the root returns 2.
	 * * And so on to this Item.
	 *
	 * @return integer The depth of this Item in the workspace hierarchy.
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function getDepth();

	/**
	 * Returns the Session through which this Item was acquired. Every Item
	 * can ultimately be traced back through a series of method calls to the
	 * call Session->getRootNode(), Session->getItem() or
	 * Session.getNodeByIdentifier(). This method returns that Session object.
	 *
	 * @return F3_PHPCR_SessionInterface the Session through which this Item was acquired.
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function getSession();

	/**
	 * Indicates whether this Item is a Node or a Property. Returns true if
	 * this Item is a Node; Returns false if this Item is a Property.
	 *
	 * @return boolean TRUE if this Item is a Node, FALSE if it is a Property.
	 */
	public function isNode();

	/**
	 * Returns true if this is a new item, meaning that it exists only in
	 * transient storage on the Session and has not yet been saved. Within a
	 * transaction, isNew on an Item may return false (because the item has
	 * been saved) even if that Item is not in persistent storage (because the
	 * transaction has not yet been committed).
	 *
	 * Note that if an item returns true on isNew, then by definition is parent
	 * will return true on isModified.
	 *
	 * Note that in level 1 (that is, read-only) implementations, this method
	 * will always return false.
	 *
	 * @return boolean TRUE if this item is new; FALSE otherwise.
	 */
	public function isNew();

	/**
	 * Returns true if this Item has been saved but has subsequently been
	 * modified through the current session and therefore the state of this
	 * item as recorded in the session differs from the state of this item as
	 * saved. Within a transaction, isModified on an Item may return false
	 * (because the Item has been saved since the modification) even if the
	 * modification in question is not in persistent storage (because the
	 * transaction has not yet been committed).
	 *
	 * Note that in level 1 (that is, read-only) implementations, this method
	 * will always return false.
	 *
	 * @return boolean TRUE if this item is modified; FALSE otherwise.
	 */
	public function isModified();

	/**
	 * Returns TRUE if this Item object represents the same actual workspace
	 * item as the object otherItem.
	 *
	 * Two Item objects represent the same workspace item if all the following
	 * are true:
	 *
	 * * Both objects were acquired through Session objects that were created
	 *   by the same Repository object.
	 * * Both objects were acquired through Session objects bound to the same
	 *   repository workspace.
	 * * The objects are either both Node objects or both Property
	 *   objects.
	 * * If they are Property objects they have identical names and
	 *   isSame is true of their parent nodes.
	 *
	 * This method does not compare the states of the two items. For example, if two
	 * Item objects representing the same actual workspace item have been
	 * retrieved through two different sessions and one has been modified, then this method
	 * will still return true when comparing these two objects. Note that if two
	 * Item objects representing the same workspace item
	 * are retrieved through the same session they will always reflect the
	 * same state (see section 5.1.3 Reflecting Item State in the JSR 283 specification
	 * document) so comparing state is not an issue.
	 *
	 * @param F3_PHPCR_ItemInterface $otherItem the Item object to be tested for identity with this Item.
	 * @return boolean TRUE if this Item object and otherItem represent the same actual repository item; FALSE otherwise.
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function isSame(F3_PHPCR_ItemInterface $otherItem);

	/**
	 * Accepts an ItemVistor. Calls the appropriate ItemVistor visit method of
	 * the visitor according to whether this Item is a Node or a Property.
	 *
	 * @param F3_PHPCR_ItemVisitorInterface $visitor The ItemVisitor to be accepted.
	 * @throws F3_PHPCR_RepositoryException if an error occurs.
	 */
	public function accept(F3_PHPCR_ItemVisitorInterface $visitor);

	/**
	 * If keepChanges is false, this method discards all pending changes
	 * currently recorded in this Session that apply to this Item or any
	 * of its descendants (that is, the subtree rooted at this Item) and
	 * returns all items to reflect the current saved state. Outside a
	 * transaction this state is simple the current state of persistent
	 * storage. Within a transaction, this state will reflect persistent
	 * storage as modified by changes that have been saved but not yet
	 * committed.
	 * If keepChanges is true then pending change are not discarded but
	 * items that do not have changes pending have their state refreshed
	 * to reflect the current saved state, thus revealing changes made by
	 * other sessions.
	 *
	 * @param boolean $keepChanges a boolean
	 * @return void
	 * @throws F3_PHPCR_InvalidItemStateException if this Item object represents a workspace item that has been removed (either by this session or another).
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	*/
	public function refresh($keepChanges);

	/**
	 * Removes this item (and its subtree).
	 * To persist a removal, a save must be performed that includes the (former)
	 * parent of the removed item within its scope.
	 *
	 * If a node with same-name siblings is removed, this decrements by one the
	 * indices of all the siblings with indices greater than that of the removed
	 * node. In other words, a removal compacts the array of same-name siblings
	 * and causes the minimal re-numbering required to maintain the original
	 * order but leave no gaps in the numbering.
	 *
	 * A ReferentialIntegrityException will be thrown on save if this item or
	 * an item in its subtree is currently the target of a REFERENCE property
	 * located in this workspace but outside this item's subtree and the
	 * current Session has read access to that REFERENCE property.
	 *
	 * An AccessDeniedException will be thrown on save if this item or an item
	 * in its subtree is currently the target of a REFERENCE property located
	 * in this workspace but outside this item's subtree and the current Session
	 * does not have read access to that REFERENCE property.
	 *
	 * @return void
	 * @throws F3_PHPCR_Version_VersionException if the parent node of this item is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3_PHPCR_Lock_LockException if a lock prevents the removal of this item and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3_PHPCR_ConstraintViolationException if removing the specified item would violate a node type or implementation-specific constraint and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3_PHPCR_RepositoryException if another error occurs.
	 */
	public function remove();
}
?>