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
 * A Node interface
 *
 * @package		phpCR
 * @version 	$Id: T3_phpCR_NodeInterface.php 234 2007-06-06 01:28:26Z karsten $
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface T3_phpCR_ItemInterface {

	/**
	 * Returns the name of this Item. The name of an item is the
	 * last element in its path, minus any square-bracket index that may exist.
	 * If this Item is the root node of the workspace (i.e., if
	 * $this->getDepth() == 0), an empty string will be returned.
	 *
	 * @return 	string	the (or a) name of this Item or an empty string if this Item is the root node.
	 * @throws 	T3_phpCR_RepositoryException if an error occurs.
	 */
	public function getName();

	/**
	 * Returns the ancestor of the specified depth.
	 * 
	 * An ancestor of depth x is the Item that is x levels down along the path from 
	 * the root node to this Item.
	 *
	 * - depth = 0 returns the root node.
	 * - depth = 1 returns the child of the root node along the path to this Item.
	 * - depth = 2 returns the grandchild of the root node along the path to this Item.
	 * - And so on to depth = n, where n is the depth of this Item, which returns this Item itself.
	 * 
	 * If depth > n is specified then a ItemNotFoundException is thrown.
	 * 
	 * @param 	integer		$depth
	 * @return 	T3_phpCR_Item	The ancestor of this Item at the specified depth.
	 * @throws 	T3_phpCR_ItemNotFoundException if depth &lt; 0 or depth &gt; n where n is the depth of this item.
	 * @throws 	T3_phpCR_AccessDeniedException if the current session does not have sufficient access rights to retrieve the specified node.
	 * @throws 	T3_phpCR_RepositoryException if another error occurs.
	 */
	public function getAncestor($depth);

	/**
	 * Returns the depth of this Item in the workspace tree.
	 * 
	 * Returns the depth below the root node of this Item (counting this Item itself).
	 * 
	 * - The root node returns 0.
	 * - A property or child node of the root node returns 1.
	 * - A property or child node of a child node of the root returns 2.
	 * - And so on to this Item.
	 *
	 * @return	integer	The depth of this Item in the workspace hierarchy.
	 * @throws 	T3_phpCR_RepositoryException if an error occurs.
	 */
	public function getDepth();

	/**
	 * Returns the Session through which this Item was acquired.
	 *
	 * @return 	T3_phpCR_Session the Session through which this Item was acquired.
	 * @throws 	T3_phpCR_RepositoryException if an error occurs.
	 */
	public function getSession();

	/**
	 * Returns true if this Item object represents the same actual workspace 
	 * item as the object otherItem.
	 * 
	 * Two Item objects represent the same workspace item if all the following
	 * are true:
	 * 
	 * - Both objects were acquired through Session objects that were created
	 *	 by the same Repository object.
	 * - Both objects were acquired through Session objects bound to the same
	 *	 repository workspace.
	 * - The objects are either both Node objects or both Property
	 *	 objects.
	 * - If they are Property objects they have identical names and
	 *	 isSame is true of their parent nodes.
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
	 * @param 	T3_phpCR_Item	$otherItem: the Item object to be tested for identity with this Item.
	 * @return 	boolean	true if this Item object and otherItem represent the same actual repository item; false otherwise.
	 * @throws 	T3_phpCR_RepositoryException if an error occurs.
	 */
	public function isSame(T3_phpCR_ItemInterface $otherItem);
}
?>