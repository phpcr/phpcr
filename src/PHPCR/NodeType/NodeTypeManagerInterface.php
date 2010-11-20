<?php
/**
 * Interface description of how to implement a node type manager.
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
 * Allows for the retrieval and (in implementations that support it) the
 * registration of node types. Accessed via Workspace.getNodeTypeManager().
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NodeTypeManagerInterface {

    /**
     * Returns the named node type.
     *
     * @param string $nodeTypeName the name of an existing node type.
     * @return \PHPCR\NodeType\NodeTypeInterface A NodeType object.
     *
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if no node type by the given name exists.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function getNodeType($nodeTypeName);

    /**
     * Determines if the given node type is registered.
     *
     * Returns true if a node type with the specified name is registered. Returns
     * false otherwise.
     *
     * @param string $name The name of node type.
     * @return boolean True, if the node type identified by its name is registered, else false.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function hasNodeType($name);

    /**
     * Returns an iterator over all available node types (primary and mixin).
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>. Keys are the node type names,
     *                  values the corresponding NodeTypeInterface instances.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getAllNodeTypes();

    /**
     * Returns an iterator over all available primary node types.
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>. Keys are the node type names,
     *                  values the corresponding NodeTypeInterface instances.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getPrimaryNodeTypes();

    /**
     * Returns an iterator over all available mixin node types.
     *
     * If none are available, an empty iterator is returned.
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>. Keys are the node type names,
     *                  values the corresponding NodeTypeInterface instances.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getMixinNodeTypes();

    /**
     * Returns an empty NodeTypeTemplate which can then be used to define a node type
     * and passed to NodeTypeManager.registerNodeType.
     *
     * If <b>$ntd</b> is given:
     * Returns a NodeTypeTemplate holding the specified node type definition. This
     * template can then be altered and passed to NodeTypeManager.registerNodeType.
     *
     * @param \PHPCR\NodeType\NodeTypeDefinitionInterface $ntd a NodeTypeDefinition.
     * @return \PHPCR\NodeType\NodeTypeTemplateInterface A NodeTypeTemplate.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not support
     *                                                        node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function createNodeTypeTemplate($ntd = NULL);

    /**
     * Returns an empty NodeDefinitionTemplate which can then be used to create a
     * child node definition and attached to a NodeTypeTemplate.
     *
     * @return \PHPCR\NodeType\NodeDefinitionTemplateInterface A NodeDefinitionTemplate.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not support
     *                                                        node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function createNodeDefinitionTemplate();

    /**
     * Returns an empty PropertyDefinitionTemplate which can then be used to create
     * a property definition and attached to a NodeTypeTemplate.
     *
     * @return \PHPCR\NodeType\PropertyDefinitionTemplateInterface A PropertyDefinitionTemplate.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not support
     *                                                        node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function createPropertyDefinitionTemplate();

    /**
     * Registers a new node type or updates an existing node type using the specified
     * definition and returns the resulting NodeType object.
     *
     * Typically, the object passed to this method will be a NodeTypeTemplate (a
     * subclass of NodeTypeDefinition) acquired from NodeTypeManager.createNodeTypeTemplate
     * and then filled-in with definition information.
     *
     * @param \PHPCR\NodeType\NodeTypeDefinitionInterface $ntd an NodeTypeDefinition.
     * @param boolean $allowUpdate Switch to allow the update a registered node type.
     * @return \PHPCR\NodeType\NodeTypeInterface the registered node type
     *
     * @throws \PHPCR\InvalidNodeTypeDefinitionException if the NodeTypeDefinition is invalid.
     * @throws \PHPCR\NodeType\NodeTypeExistsException if allowUpdate is false and the NodeTypeDefinition
     *                                                 specifies a node type name that is already registered.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not support
     *                                                        node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function registerNodeType(\PHPCR\NodeType\NodeTypeDefinitionInterface $ntd, $allowUpdate);

    /**
     * Registers or updates the specified array of NodeTypeDefinition objects.
     *
     * This method is used to register or update a set of node types with mutual
     * dependencies. Returns an iterator over the resulting NodeType objects.
     * The effect of the method is "all or nothing"; if an error occurs, no node
     * types are registered or updated.
     *
     * @param array $definitions an array of NodeTypeDefinitions
     * @param boolean $allowUpdate Switch to allow the update a registered node type.
     * @return Iterator over the registered node types implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Keys are the node type names, values the corresponding NodeTypeInterface instances.
     *
     * @throws \PHPCR\InvalidNodeTypeDefinitionException if a NodeTypeDefinition within the Collection is
     *                                                   invalid or if the Collection contains an object of a
     *                                                   type other than NodeTypeDefinition.
     * @throws \PHPCR\NodeType\NodeTypeExistsException if allowUpdate is false and a NodeTypeDefinition within
     *                                                 the Collection specifies a node type name that is already
     *                                                 registered.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not support node type
     *                                                        registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function registerNodeTypes(array $definitions, $allowUpdate);

    /**
     * Unregisters the specified node type.
     *
     * @param string $name The name of the node type to be removed from the registry.
     * @return void
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not
     *                                                        support node type registration.
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if no registered node type exists with the specified name.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function unregisterNodeType($name);

    /**
     * Unregisters the specified set of node types. Used to unregister a set of node
     * types with mutual dependencies.
     *
     * @param array $names List of node type names to be removed from the registry.
     * @return void
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this implementation does not support
     *                                                        node type registration.
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if one of the names listed is not a registered node type.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function unregisterNodeTypes(array $names);
}
