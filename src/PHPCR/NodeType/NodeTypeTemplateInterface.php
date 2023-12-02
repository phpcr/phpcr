<?php

namespace PHPCR\NodeType;

/**
 * The NodeTypeTemplate interface represents a simple container structure used
 * to define node types which are then registered through the
 * NodeTypeManagerInterface::registerNodeType() method.
 *
 * NodeTypeTemplateInterface, like NodeTypeInterface, is a subclass of
 * NodeTypeDefinitionInterface so it shares with NodeTypeInterface those
 * methods that are relevant to a static definition.
 * In addition, NodeTypeTemplate provides methods for setting the attributes of
 * the definition. Implementations of this interface need not contain any
 * validation logic.
 *
 * See the corresponding get methods for each attribute in
 * NodeTypeDefinitionInterface for the default values assumed when a new empty
 * NodeTypeTemplateInterface is created (as opposed to one extracted from an
 * existing NodeTypeInterface).
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeTypeTemplateInterface extends NodeTypeDefinitionInterface
{
    /**
     * Sets the name of the node type.
     *
     * @param string $name the name of the node type to be set
     *
     * @return void
     *
     * @api
     */
    public function setName($name);

    /**
     * Sets the names of the supertypes of the node type.
     *
     * @param string[] $names the names of the node supertypes to be set
     *
     * @return void
     *
     * @api
     */
    public function setDeclaredSuperTypeNames(array $names);

    /**
     * Sets the abstract flag of the node type.
     *
     * @param bool $abstractStatus whether this type is abstract
     *
     * @return void
     *
     * @api
     */
    public function setAbstract($abstractStatus);

    /**
     * Sets the mixin flag of the node type.
     *
     * @param bool $mixin whether this type is a mixin type (or a primary
     *                    type)
     *
     * @return void
     *
     * @api
     */
    public function setMixin($mixin);

    /**
     * Sets the orderable child nodes flag of the node type.
     *
     * @param bool $orderable Whether nodes of this type can have orderable
     *                        children
     *
     * @return void
     *
     * @api
     */
    public function setOrderableChildNodes($orderable);

    /**
     * Sets the name of the primary item.
     *
     * @param string $name the name of the primary item
     *
     * @return void
     *
     * @api
     */
    public function setPrimaryItemName($name);

    /**
     * Sets the queryable status of the node type.
     *
     * @param bool $queryable whether this node is queryable
     *
     * @return void
     *
     * @api
     */
    public function setQueryable($queryable);

    /**
     * Returns a mutable List of PropertyDefinitionTemplate objects.
     *
     * To define a new NodeTypeTemplate or change an existing one,
     * PropertyDefinitionTemplate objects can be added to or removed from this
     * list.
     *
     * @return object A mutable List (implementing \Traversable, \ArrayAccess,
     *                and \Countable) of PropertyDefinitionTemplate objects
     *
     * @api
     */
    public function getPropertyDefinitionTemplates();

    /**
     * Returns a mutable List of NodeDefinitionTemplate objects.
     *
     * To define a new NodeTypeTemplate or change an existing one,
     * NodeDefinitionTemplate objects can be added to or removed from this
     * list.
     *
     * @return object A mutable List (implementing \Traversable, \ArrayAccess,
     *                and \Countable) of NodeDefinitionTemplate objects
     *
     * @api
     */
    public function getNodeDefinitionTemplates();
}
