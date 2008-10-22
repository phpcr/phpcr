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
 * Allows for the retrieval and (in implementations that support it) the
 * registration of node types. Accessed via Workspace.getNodeTypeManager().
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface NodeTypeManagerInterface {

	/**
	 * Returns the named node type.
	 *
	 * @param string $nodeTypeName the name of an existing node type.
	 * @return F3::PHPCR::NodeType::NodeTypeInterface A NodeType object.
	 * @throws F3::PHPCR::NodeType::NoSuchNodeTypeException if no node type by the given name exists.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getNodeType($nodeTypeName);

	/**
	 * Returns true if a node type with the specified name is registered. Returns
	 * false otherwise.
	 *
	 * @param string $name - a String.
	 * @return boolean a boolean
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function hasNodeType($name);

	/**
	 * Returns an iterator over all available node types (primary and mixin).
	 *
	 * @return F3::PHPCR::NodeType::NodeTypeInteratorInterface An NodeTypeIterator.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getAllNodeTypes();

	/**
	 * Returns an iterator over all available primary node types.
	 *
	 * @return F3::PHPCR::NodeType::NodeTypeIteratorInterface An NodeTypeIterator.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getPrimaryNodeTypes();

	/**
	 * Returns an iterator over all available mixin node types. If none are available,
	 * an empty iterator is returned.
	 *
	 * @return F3::PHPCR::NodeType::NodeTypeIteratorInterface An NodeTypeIterator.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getMixinNodeTypes();

	/**
	 * Returns an empty NodeTypeTemplate which can then be used to define a node type
	 * and passed to NodeTypeManager.registerNodeType.
	 *
	 * If $ntd is given:
	 * Returns a NodeTypeTemplate holding the specified node type definition. This
	 * template can then be altered and passed to NodeTypeManager.registerNodeType.
	 *
	 * @param F3::PHPCR::NodeType::NodeTypeDefinitionInterface $ntd a NodeTypeDefinition.
	 * @return F3::PHPCR::NodeType::NodeTypeTemplateInterface A NodeTypeTemplate.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function createNodeTypeTemplate($ntd = NULL);

	/**
	 * Returns an empty NodeDefinitionTemplate which can then be used to create a
	 * child node definition and attached to a NodeTypeTemplate.
	 * Throws an UnsupportedRepositoryOperationException if this implementation does
	 * not support node type registration.
	 *
	 * @return F3::PHPCR::NodeType::NodeDefinitionTemplateInterface A NodeDefinitionTemplate.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function createNodeDefinitionTemplate();

	/**
	 * Returns an empty PropertyDefinitionTemplate which can then be used to create
	 * a property definition and attached to a NodeTypeTemplate.
	 *
	 * @return F3::PHPCR::NodeType::PropertyDefinitionTemplateInterface A PropertyDefinitionTemplate.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function createPropertyDefinitionTemplate();

	/**
	 * Registers a new node type or updates an existing node type using the specified
	 * definition and returns the resulting NodeType object.
	 * Typically, the object passed to this method will be a NodeTypeTemplate (a
	 * subclass of NodeTypeDefinition) acquired from NodeTypeManager.createNodeTypeTemplate
	 * and then filled-in with definition information.
	 *
	 * @param F3::PHPCR::NodeType::NodeTypeDefinitionInterface $ntd an NodeTypeDefinition.
	 * @param boolean $allowUpdate a boolean
	 * @return F3::PHPCR::NodeType::NodeTypeInterface the registered node type
	 * @throws F3::PHPCR::InvalidNodeTypeDefinitionException if the NodeTypeDefinition is invalid.
	 * @throws F3::PHPCR::NodeType::NodeTypeExistsException if allowUpdate is false and the NodeTypeDefinition specifies a node type name that is already registered.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function registerNodeType(F3::PHPCR::NodeType::NodeTypeDefinitionInterface $ntd, $allowUpdate);

	/**
	 * Registers or updates the specified array of NodeTypeDefinition objects.
	 * This method is used to register or update a set of node types with mutual
	 * dependencies. Returns an iterator over the resulting NodeType objects.
	 * The effect of the method is "all or nothing"; if an error occurs, no node
	 * types are registered or updated.
	 *
	 * @param array $definitions an array of NodeTypeDefinitions
	 * @param boolean $allowUpdate a boolean
	 * @return F3::PHPCR::NodeType::NodeTypeIteratorInterface the registered node types.
	 * @throws F3::PHPCR::InvalidNodeTypeDefinitionException - if a NodeTypeDefinition within the Collection is invalid or if the Collection contains an object of a type other than NodeTypeDefinition.
	 * @throws F3::PHPCR::NodeType::NodeTypeExistsException if allowUpdate is false and a NodeTypeDefinition within the Collection specifies a node type name that is already registered.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function registerNodeTypes(array $definitions, $allowUpdate);

	/**
	 * Unregisters the specified node type.
	 *
	 * @param string $name a String.
	 * @return void
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::NodeType::NoSuchNodeTypeException if no registered node type exists with the specified name.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function unregisterNodeType($name);

	/**
	 * Unregisters the specified set of node types. Used to unregister a set of node
	 * types with mutual dependencies.
	 *
	 * @param array $names a String array
	 * @return void
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this implementation does not support node type registration.
	 * @throws F3::PHPCR::NodeType::NoSuchNodeTypeException if one of the names listed is not a registered node type.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function unregisterNodeTypes(array $names);
}
?>