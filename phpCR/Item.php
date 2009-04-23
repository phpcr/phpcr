<?php
declare(encoding = 'utf-8');

// $Id: Item.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link Item} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *      Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *      Version 2.0
 * @package phpContentRepository
 */


/**
 * {@link Item} is the base interface of {@link Node} and {@link Property}.
 *
 * @package phpContentRepository
 */
interface phpCR_Item
{
	/**
	 * Returns the absolute path to this {@link Item}.
	 *
	 * If the path includes items that are same-name sibling nodes properties
	 * then those elements in the path will include the appropriate
	 * "square bracket" index notation (for example, <i>/a/b[3]/c</i>).
	 *
	 * @return string 
	 *    The path (or one of the paths) of this {@link Item}.
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getPath();
	
	
	/**
	 * Returns the name of this {@link Item}.
	 *
	 * The name of an item is the last element in its path, minus any 
	 * square-bracket index that may exist.  If this {@link Item} is the root 
	 * node of the workspace (i.e., if <i>$this->getDepth() == 0</i>), an
	 * empty string will be returned.
	 *
	 * @return string
	 *     The (or a) name of this {@link Item} or an empty string if this 
	 *     {@link Item} is the root {@link Node}.
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getName();
	
	
	/**
	 * Returns the ancestor of the specified absolute degree.
	 *
	 * An ancestor of absolute degree x is the {@link Item} that is 
	 * x levels down along the path from the root node to 
	 * $this {@link Item}.
	 *
	 * <ul>
	 *       <li>$degree = 0 returns the root node.</li>
	 *       <li>$degree = 1 returns the child of the root node along 
	 *         the path to $this {@link Item}.
	 *       <li>$degree = 2 returns the grandchild of the root node 
	 *         along the path to $this {@link Item}.
	 *       <li>And so on to $degree = n, where n is
	 *         the depth of $this {@link Item}, which returns 
	 *         $this {@link Item} itself.
	 * </ul>
	 *
	 * If $degree &gt; n is specified then a 
	 * {@link ItemNotFoundException} is thrown.
	 *
	 * If multiple paths exist to this {@link Item} then the path used is the 
	 * same one that is returned by {@link getPath()}.
	 *
	 * @param int
	 *     An integer, 0 &lt;= $degree &lt;= n where 
	 *     n is the depth of $this {@link Item} along the
	 *     path returned by {@link getPath()}.
	 * @return object
	 *     The ancestor of the specified absolute degree of $this
	 *     {@link Item} along the path returned by{@link getPath()}.
	 *
	 * @throws {@link ItemNotFoundException}
	 *     If $degree &lt; 0 or $degree &gt; n
	 *     where n is the is the depth of $this {@link Item}
	 *     along the path returned by {@link getPath()}.
	 * @throws {@link AccessDeniedException}
	 *     If the current {@link Ticket} does not have sufficient access rights to
	 *     complete the operation.
	 * @throws {@link RepositoryException}
	 *     If another error occurs.
	 */
	public function getAncestor($degree);
	
	
	/**
	 * Returns the parent of this {@link Item}.
	 *
	 * If this {@link Item} has multiple paths then this method returns the
	 * parent along the path returned by {@link getPath()}.
	 *
	 * @return object
	 *     The parent of this {@link Item} along the path returned by 
	 *     {@link getPath()}.
	 *
	 * @throws {@link ItemNotFoundException}
	 *     If there is no parent.  This only happens if $this 
	 *     {@link Item} is the root node.
	 * @throws {@link AccessDeniedException}
	 *     If the current {@link Ticket} does not have sufficient access rights to
	 *     complete the operation.
	 * @throws {@link RepositoryException}
	 *     If another error occurs.
	 */
	public function getParent();
	
	
	/**
	 * Returns the depth of this {@link Item} in the repository tree.
	 *
	 * Returns the depth below the root node of $this {@link Item}
	 * (counting $this {@link Item} itself).
	 *
	 * <ul>
	 *       <li>The root {@link Node} returns 0.</li>
	 *       <li>A property or child {@link Node} of the root {@link Node} 
	 *         returns 1.</li>
	 *       <li>A property or child {@link Node} of a child {@link Node} of the 
	 *         root returns 2.</li>
	 *       <li>And so on to $this {@link Item}.</li>
	 * </ul>
	 *
	 * If multiple paths exist to this {@link Item} then the path used to 
	 * determine the depth is the same one that is returned by {@link getPath()}.
	 *
	 * @return int
	 *     The depth of this {@link Item} in the repository hierarchy.
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getDepth();
	
	
	/**
	 * Returns the {@link Session} through which this {@link Item} was acquired.
	 *
	 * Every {@link Item} can ultimately be traced back through a series
	 * of method calls to the call {@link Session::getRootNode()},
	 * {@link Session::getItem()} or {@link Session::getNodeByUUID()}. This
	 * method returns that {@link Session} object.
	 *
	 * @return object
	 *	A {@link Session} object
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getSession();
	
	
	/**
	 * Indicates whether this {@link Item} is a {@link Node} or a 
	 * {@link Property}.
	 * 
	 * @return bool 
	 *     Returns TRUE if this {@link Item} is a {@link Node};
	 *     Returns FALSE if this {@link Item} is a {@link Property}.
	 */
	public function isNode();
	
	
	/**
	 * Returns <i>true</i> if this is a new item, meaning that it exists 
	 * only in transient storage on the {@link Session} and has not yet been 
	 * saved. 
	 *
	 * Within a transaction, {@link isNew()} on an {@link Item} may return 
	 * <i>false</i> (because the item has been saved) even if that 
	 * {@link Item} is not in persistent storage (because the transaction has 
	 * not yet been committed).
	 *
	 * Note that if an item returns <i>true</i> on {@link isNew()}, then 
	 * by definition is parent will return <i>true</i> on 
	 * {@link isModified}.
	 *
	 * Note that in level 1 (that is, read-only) implementations, this method 
	 * will always return <i>false</i>.
	 *
	 * @return boolean
	 */
	public function isNew();
	
	
	/**
	 * Returns <i>true</i> if this {@link Item} has been saved but has
	 * subsequently been modified through the current session and therefore the
	 * state of this item as recorded in the session differs from the state of
	 * this item as saved.
	 *
	 * Within a transaction, {@link isModified} on an {@link Item} may return 
	 * <i>false</i> (because the {@link Item} has been saved since the
	 * modification) even if the modification in question is not in persistent 
	 * storage (because the transaction has not yet been committed). 
	 *
	 * Note that in level 1 (that is, read-only) implementations, this method 
	 * will always return <i>false</i>.
	 *
	 * @return boolean
	 */
	public function isModified();
	
	
	/**
	 * Returns <i>true</i> if this {@link Item} object (the PHP object 
	 * instance) represents the same actual repository item as the object 
	 * <i>$otherItem</i>.
	 *
	 * This method does not compare the <i>states</i> of the two items. For
	 * example, if two {@link Item} objects representing the same actual 
	 * repository item have been retrieved through two different sessions and 
	 * one has been modified, then this method will still return 
	 * <i>true</i> for these two objects.
	 *
	 * Note that if two {@link Item} objects representing the same repository 
	 * item are retrieved through the <i>same</i> session they will always 
	 * reflect the  same state (see section 6.3.1 <i>Reflecting Item State</i>
	 * in the specification document) so comparing state is not an issue.
	 *
	 * @param object
	 *	A {@link Item} object
	 * @return boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function isSame(phpCR_Item $otherItem);
	
	
	/**
	 * Accepts an {@link ItemVisitor}.
	 *
	 * Calls the appropriate {@link ItemVistor::visit()} method of this 
	 * according to whether this {@link Item} is a {@link Node} or a
	 * {@link Property}.
	 *
	 * @param object
	 *	A {@link ItemVisitor} object
	 *
	 * @throws {@link RepositoryException} 
	 *     If an error occurs.
	 */
	public function accept(phpCR_ItemVisitor $visitor);
	
	
	/**
	 * Validates all pending changes currently recorded in this {@link Session}
	 * that apply to this {@link Item} or any of its descendants (that is, the 
	 * subtree rooted at this Item). If validation of <i>all</i> pending 
	 * changes succeeds, then this change information is cleared from the 
	 * {@link Session}.
	 *
	 * If the {@link save()} occurs outside a transaction, the changes are 
	 * persisted and thus made visible to other {@link Session}s. If the
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
	 *        If the transient item has a UUID, then the changes are written 
	 *        to the persistent item with the same UUID.
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
	 * As a result of these rules, a {@link save()} of an item that has a 
	 * UUID will succeed even if that item has, in the meantime, been moved in
	 * persistent storage to a new location (that is, its path has changed). 
	 * However, a {@link save()} of a non-UUID item will fail (throwing an
	 * <i>InvalidItemStateException</i>) if it has, in the meantime, been 
	 * moved in persistent storage to a new location. A {@link save()} of a
	 * non-UUID item will also fail if it has, in addition to being moved, been
	 * replaced in its original position by a UUID-bearing item.
	 *
	 * Note that {@link save()} uses the same rules to match items between 
	 * transient storage and persistent storage as {@link Node::update()} does
	 * to match nodes between two workspaces.
	 *
	 * @throws {@link AccessDeniedException}
	 *    If any of the changes to be persisted would violate the access 
	 *    privileges of the this {@link Session}. Also thrown if any of the
	 *    changes to be persisted would cause the removal of a node that is
	 *    currently referenced by a <i>REFERENCE</i> property that this 
	 *    Session <i>does not</i> have read access to.
	 * @throws {@link ItemExistsException}
	 *    If any of the changes to be persisted would be prevented by the
	 *    presence of an already existing 	item in the workspace.
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
	 * Refreshes this {@link Item} from persistent storage.
	 *
	 * If <i>$keepChanges</i> is <i>false</i>, this method discards 
	 * all pending changes currently recorded in this {@link Session} that 
	 * apply to this Item or any of its descendants (that is, the subtree 
	 * rooted at this Item)and returns all items to reflect the current saved
	 * state. Outside a transaction this state is simple the current state of
	 * persistent storage. Within a transaction, this state will reflect 
	 * persistent storage as modified by changes that have been saved but not
	 * yet committed.
	 *
	 * If <i>$keepChanges</i> is true then pending change are not 
	 * discarded but items that do not have changes pending have their state 
	 * refreshed to reflect the current saved state, thus revealing changes 
	 * made by other sessions.
	 *
	 * @param boolean
	 *
	 * @throws {@link InvalidItemStateException}
	 *    If this {@link Item} object represents a workspace item that has been
	 *    removed (either by this session or another).
	 *
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function refresh($keepChanges);

	/**
	 * Removes <i>this</i> item (and its subtree).
	 *
	 * To persist a removal, a {@link save()} must be performed that includes
	 * the (former) parent of the removed item within its scope.
	 *
	 * @throws {@link VersionException}
	 *    If the parent node of this item is versionable and checked-in or is
	 *    non-versionable but its nearest versionable ancestor is checked-in 
	 *    and this implementation performs this validation immediately instead 
	 *    of waiting until {@link save()}.
	 * @throws {@link LockException}
	 *    If a lock prevents the removal of this item and this implementation 
	 *    performs this validation immediately instead of waiting until 
	 *    {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If removing the specified item would violate a node type or
	 *    implementation-specific constraint and this implementation performs 
	 *    this validation immediately instead of waiting until {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function remove();
}

?>