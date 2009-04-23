<?php
// $Id$
/**
 * This file contains {@link NodeDef} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *	Version 2.0
 * @package phpContentRepository
 * @package NodeTypes
 */

 
/**
 * Represents a {@link NodeType}.
 *
 * @see Workspace::getAccessManager(), AccessManager
 *
 * @package phpContentRepository
 * @package NodeTypes
 */
interface phpCR_NodeType
{
	/**
	 * Returns the name of the {@link NodeType}.
	 *
	 * @return string
	 */
	public function getName();
	
	
	/**
	 * Returns TRUE if this {@link NodeType} is a mixin 
	 * {@link NodeType}.  Returns FALSE if this {@link NodeType} is
	 * a primary {@link NodeType}.
	 *
	 * @return boolean
	 */
	public function isMixin();
	
	
	/**
	 * Returns TRUE if nodes of this type must support orderable child nodes; 
	 * returns FALSE otherwise.
	 *
	 * If a node type returns TRUE on a call to this method, then all nodes of
	 * that node type <i>must</i> support the method 
	 * {@link Node::orderBefore()}. If a node type returns FALSE on a call to
	 * this method, then nodes of that node type <i>may</i> support these 
	 * ordering methods. Only the primary node type of a node controls that 
	 * node's status in this regard. This setting on a mixin node type will not
	 * have any effect on the node.
	 *
	 * @return boolean
	 */
	public function hasOrderableChildNodes();
	
	
	/**
	 * Returns the name of the primary item (one of the child items of the nodes
	 * of this node type).
	 *
	 * If this node has no primary item, then this method returns <i>NULL</i>.
	 * This indicator is used by the method {@link Node::getPrimaryItem()}.
	 *
	 * @return string
	 */
	public function getPrimaryItemName();


	/**
	 * Returns all supertypes of this {@link NodeType} including both those directly
	 * declared and those inherited. For primary types, this list will always
	 * include at least nt:base. For mixin types, there is no required base 
	 * type.
	 *
	 * @see getDeclaredSupertypes()
	 * @return array
	 *   An array of {@link NodeType} objects.
	 */
	public function getSupertypes();
	
	
	/**
	 * Returns all direct supertypes as specified in the declaration of
	 * this {@link NodeType}, that is, those actually declared in this node 
	 * type. 
	 *
	 * In single inheritance systems this will always be an array of size 0 or 1.
	 * In systems that support multiple inheritance of {@link NodeType}s this 
	 * array may be of size greater than 1.
	 *
	 * @see getSupertypes()
	 * @return array
	 *   An array of {@link NodeType} objects.
	 */
	public function getDeclaredSupertypes();
	
	
	/**
	 * Returns TRUE if this node type is $nodeTypeName or a subtype of 
	 * $nodeTypeName, otherwise returns FALSE.
	 *
	 * @param string The name of a node type.
	 * @return boolean
	 */
	public function isNodeType($nodeTypeName);
	

	/**
	 * Returns an array containing the {@link PropertyDef}s of this 
	 * {@link NodeType}, including the {@link PropertyDef}s inherited from 
	 * supertypes of this {@link NodeType}.
	 *
	 * @see getDeclaredPropertyDefinitions()
	 * @return array
	 *   An array containing the {@link PropertyDef}s.
	 */
	public function getPropertyDefinitions();
	
	
	/**
	 * Returns an array containing the {@link PropertyDef}s explicitly specified
	 * in the declaration of this {@link NodeType}. 
	 *
	 * This does not include {@link PropertyDef}s inherited from 
	 * supertypes of this {@link NodeType}.
	 *
	 * @see getPropertyDefinitions()
	 * @return array
	 *   An array containing the {@link PropertyDef}s.
	 */
	public function getDeclaredPropertyDefinitions();
	
	
	/**
	 * Returns an array containing the child {@link NodeDef}s of this 
	 * {@link NodeType}, including the child {@link NodeDef}s inherited 
	 * from supertypes of this {@link NodeType}.
	 *
	 * @see getDeclaredChildNodeDefinitions()
	 * @return array
	 *   An array containing the child {@link NodeDef}s.
	 */
	public function getChildNodeDefinitions();
	
	
	/**
	 * Returns an array containing the child {@link NodeDef}s explicitly
	 * specified in the declaration of this {@link NodeType}. 
	 *
	 * This does not include child {@link NodeDef}s inherited from 
	 * supertypes of this {@link NodeType}.
	 *
	 * @see getChildNodeDefinitions()
	 * @return array
	 *   An array containing the child {@link NodeDef}s.
	 */
	public function getDeclaredChildNodeDefinitions();
	
	
	/**
	 * Returns TRUE if setting $propertyName to
	 * $value is allowed by this {@link NodeType}; otherwise returns
	 * FALSE.
	 *
	 * @param string
	 *   The name of the property
	 * @param object|array
	 *   A {@link Value} object or an array of {@link Value} objects.
	 * @return boolean
	 */
	public function canSetProperty($propertyName, $value);
	
	
	/**
	 * Returns TRUE if adding a child {@link Node} called
	 * $childNodeName is allowed by this {@link NodeType}.
	 *
	 * If $nodeTypeName is specified, this should determine if the
	 * child {@link Node} can be added with the specific {@link NodeType}.
	 *
	 * @param string
	 *   The name of the child {@link Node}.
	 * @param string|null
	 *   The name of the {@link NodeType} of the child {@link Node}.
	 * @return boolean
	 */
	public function canAddChildNode($childNodeName, $nodeTypeName = null);
	
	
	/**
	 * Returns TRUE if removing $itemName is allowed
	 * by this {@link NodeType}; otherwise returns FALSE.
	 *
	 * @param string
	 *   The name of the child item
	 * @return boolean
	 */
	public function canRemoveItem($itemName);
}

?>