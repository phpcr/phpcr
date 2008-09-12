<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR::NodeType;

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
 * @subpackage NodeType
 * @version $Id$
 */

/**
 * A NodeType object represents a "live" node type that is registered in the repository.
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface NodeTypeInterface extends F3::PHPCR::NodeType::NodeTypeDefinitionInterface {

	/**
	 * Returns all supertypes of this node type in the node type inheritance
	 * hierarchy. For primary types apart from nt:base, this list will always
	 * include at least nt:base. For mixin types, there is no required supertype.
	 *
	 * @return array of F3::PHPCR::NodeType::NodeType objects.
	 */
	public function getSupertypes();

	/**
	 * Returns the direct supertypes of this node type in the node type
	 * inheritance hierarchy, that is, those actually declared in this node
	 * type. In single-inheritance systems, this will always be an array of
	 * size 0 or 1. In systems that support multiple inheritance of node
	 * types this array may be of size greater than 1.
	 *
	 * @return array of F3::PHPCR::NodeType::NodeType objects.
	 */
	public function getDeclaredSupertypes();

	/**
	 * Returns true if this node type is nodeTypeName or a subtype of
	 * nodeTypeName, otherwise returns false.
	 *
	 * @param string $nodeTypeName the name of a node type.
	 * @return boolean
	 */
	public function isNodeType($nodeTypeName);

	/**
	 * Returns an array containing the property definitions of this node
	 * type. This includes both those property definitions actually declared
	 * in this node type and those inherited from the supertypes of this type.
	 *
	 * @return array an array of F3::PHPCR::NodeType::PropertyDefinition containing the property definitions.
	 */
	public function getPropertyDefinitions();

	/**
	 * Returns an array containing the child node definitions of this node type.
	 * This includes both those child node definitions actually declared in this
	 * node type and those inherited from the supertypes of this node type.
	 *
	 * @return array an array of F3::PHPCR::NodeType::NodeDefinition containing the child node definitions.
	 */
	public function getChildNodeDefinitions();

	/**
	 * Returns true if setting propertyName to value is allowed by this node type.
	 * Otherwise returns false.
	 *
	 * @param string $propertyName The name of the property
	 * @param F3::PHPCR::ValueInterface|array $value A F3::PHPCR::ValueInterface object or an array of F3::PHPCR::ValueInterface objects.
	 * @return boolean
	 */
	public function canSetProperty($propertyName, $value);

	/**
	 * Returns true if this node type allows the addition of a child node called
	 * childNodeName without specific node type information (that is, given the
	 * definition of this parent node type, the child node name is sufficient to
	 * determine the intended child node type). Returns false otherwise.
	 * If $nodeTypeName is given returns true if this node type allows the
	 * addition of a child node called childNodeName of node type nodeTypeName.
	 * Returns false otherwise.
	 *
	 * @param string $childNodeName The name of the child node.
	 * @param string $nodeTypeName The name of the node type of the child node.
	 * @return boolean
	 */
	public function canAddChildNode($childNodeName, $nodeTypeName = NULL);

	/**
	 * Returns true if removing the child node called nodeName is allowed by this
	 * node type. Returns false otherwise.
	 *
	 * @param string $nodeName The name of the child node
	 * @return boolean
	 */
	public function canRemoveNode($nodeName);

	/**
	 * Returns true if removing the property called propertyName is allowed by this
	 * node type. Returns false otherwise.
	 *
	 * @param string $propertyName The name of the property
	 * @return boolean
	 */
	public function canRemoveProperty($propertyName);
}

?>