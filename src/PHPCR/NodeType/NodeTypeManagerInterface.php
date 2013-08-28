<?php

namespace PHPCR\NodeType;

/**
 * Allows for the retrieval and (in implementations that support it) the
 * registration of node types. Accessed via WorkspaceInterface::getNodeTypeManager().
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. NodeTypeManager has to implement either \RecursiveIterator
 * or \Iterator.
 * The iterator is equivalent to <b>getAllNodeTypes()</b> returning a list of
 * all node types. The iterator keys have no significant meaning.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeTypeManagerInterface extends \Traversable
{
    /**
     * Returns the named node type.
     *
     * @param string $nodeTypeName the name of an existing node type.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface A NodeType object.
     *
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if no node type of the
     *      given name exists.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function getNodeType($nodeTypeName);

    /**
     * Determines if the given node type is registered.
     *
     * Returns true if a node type with the specified name is registered.
     * Returns false otherwise.
     *
     * @param string $name The name of node type.
     *
     * @return boolean True, if the node type identified by its name is
     *      registered, else false.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function hasNodeType($name);

    /**
     * Returns an iterator over all available node types (primary and mixin).
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *      Keys are the node type names, values the corresponding
     *      NodeTypeInterface instances.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getAllNodeTypes();

    /**
     * Returns an iterator over all available primary node types.
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *      Keys are the node type names, values the corresponding
     *      NodeTypeInterface instances.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getPrimaryNodeTypes();

    /**
     * Returns an iterator over all available mixin node types.
     *
     * If none are available, an empty iterator is returned.
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *      Keys are the node type names, values the corresponding
     *      NodeTypeInterface instances.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getMixinNodeTypes();

    /**
     * Returns an empty NodeTypeTemplateInterface which can then be used to
     * define a node type and passed to
     * NodeTypeManagerInterface::registerNodeType().
     *
     * If <b>$ntd</b> is given: Returns a NodeTypeTemplateInterface holding the
     * specified node type definition. This template can then be altered and
     * passed to NodeTypeManagerInterface::registerNodeType().
     *
     * @param \PHPCR\NodeType\NodeTypeDefinitionInterface $ntd a
     *      NodeTypeDefinition.
     *
     * @return \PHPCR\NodeType\NodeTypeTemplateInterface A NodeTypeTemplate.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function createNodeTypeTemplate($ntd = null);

    /**
     * Returns an empty NodeDefinitionTemplate which can then be used to create
     * a child node definition and attached to a NodeTypeTemplate.
     *
     * @return \PHPCR\NodeType\NodeDefinitionTemplateInterface A
     *      NodeDefinitionTemplate.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function createNodeDefinitionTemplate();

    /**
     * Returns an empty PropertyDefinitionTemplateInterface which can then be
     * used to create a property definition and attached to a
     * NodeTypeTemplateInterface.
     *
     * @return \PHPCR\NodeType\PropertyDefinitionTemplateInterface An empty
     *      PropertyDefinitionTemplateInterface instance.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function createPropertyDefinitionTemplate();

    /**
     * Registers a new node type or updates an existing node type using the
     * specified definition and returns the resulting NodeTypeInterface object.
     *
     * Typically, the object passed to this method will be a
     * NodeTypeTemplateInterface (a subclass of NodeTypeDefinitionInterface)
     * acquired from NodeTypeManagerInterface::createNodeTypeTemplate()
     * and then filled-in with definition information.
     *
     * @param \PHPCR\NodeType\NodeTypeDefinitionInterface $ntd a
     *      NodeTypeDefinitionInterface instance.
     * @param boolean $allowUpdate whether to fail if node already exists or to
     *      update it.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface the registered node type.
     *
     * @throws \PHPCR\NodeType\InvalidNodeTypeDefinitionException if the
     *      NodeTypeDefinitionInterface is invalid.
     * @throws \PHPCR\NodeType\NodeTypeExistsException if allowUpdate is false
     *      and the NodeTypeDefinition specifies a node type name that is
     *      already registered.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function registerNodeType(NodeTypeDefinitionInterface $ntd, $allowUpdate);

    /**
     * Registers or updates the specified array of NodeTypeDefinition objects.
     *
     * This method is used to register or update a set of node types with mutual
     * dependencies. Returns an iterator over the resulting NodeType objects.
     * The effect of the method is "all or nothing"; if an error occurs, no node
     * types are registered or updated.
     *
     * @param array   $definitions an array of NodeTypeDefinitions.
     * @param boolean $allowUpdate whether to fail if node already exists or to
     *      update it.
     *
     * @return \Iterator over the registered node types implementing
     *      <b>SeekableIterator</b> and <b>Countable</b>. Keys are the node
     *      type names, values the corresponding NodeTypeInterface instances.
     *
     * @throws \PHPCR\NodeType\InvalidNodeTypeDefinitionException if a
     *      NodeTypeDefinitionInterface within the Collection is invalid or if
     *      the Collection contains an object of a type other than
     *      NodeTypeDefinitionInterface.
     * @throws \PHPCR\NodeType\NodeTypeExistsException if allowUpdate is false
     *      and a NodeTypeDefinition within the Collection specifies a node
     *      type name that is already registered.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function registerNodeTypes(array $definitions, $allowUpdate);

    /**
     * Registers or updates the node type definitions as per the Compact Node
     * Definition (CND) given by the supplied string. This method is used to
     * register or update a set of node types with mutual dependencies. Returns
     * an iterator over the resulting NodeType objects.
     *
     * The effect of the method is "all or nothing"; if an error occurs, no node
     * types are registered or updated.
     *
     * A simple example is
     *   <'phpcr'='http://www.doctrine-project.org/projects/phpcr_odm'>
     *   [phpcr:managed]
     *     mixin
     *     - phpcr:class (string)
     *
     * For full documentation of the format, see
     * http://jackrabbit.apache.org/node-type-notation.html
     *
     * PHPCR Note: Rather than doing mixed arguments we decided to name this
     * method explicitly different, as we have no operator overloading in PHP.
     *
     * @param string  $cnd         containing the node type definitions in CND format
     * @param boolean $allowUpdate whether existing node type definitions
     *      should be modified/updated.
     *
     * @return \Iterator over the registered node types implementing
     *      <b>SeekableIterator</b> and <b>Countable</b>. Keys are the node
     *      type names, values the corresponding NodeTypeInterface instances.
     *
     * @throws \PHPCR\NodeType\InvalidNodeTypeDefinitionException if a
     *      NodeTypeDefinition within the CND is invalid.
     * @throws NodeTypeExistsException if allowUpdate is false
     *      and a the NodeTypeDefinition within the CND string specifies a node
     *      type name that is already registered.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @since JCR 2.1
     */
    public function registerNodeTypesCnd($cnd, $allowUpdate);

    /**
     * Unregisters the specified node type.
     *
     * @param string $name The name of the node type to be removed from the
     *      registry.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if no registered node
     *      type exists with the specified name.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function unregisterNodeType($name);

    /**
     * Unregisters the specified set of node types. Used to unregister a set of
     * node types with mutual dependencies.
     *
     * @param array $names List of node type names to be removed from the
     *      registry.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      implementation does not support node type registration.
     * @throws \PHPCR\NodeType\NoSuchNodeTypeException if one of the names
     *      listed is not a registered node type.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function unregisterNodeTypes(array $names);
}
