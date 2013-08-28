<?php

namespace PHPCR\NodeType;

/**
 * The NodeTypeDefinition interface provides methods for discovering the
 * static definition of a node type.
 *
 * The information methods may be used both before and after the node type is
 * registered. Its subclass NodeType adds methods that are relevant only when
 * the node type is "live"; that is, after it has been registered. Note that
 * the separate NodeDefinition interface only plays a significant role in
 * implementations that support node type registration.
 *
 * In those cases it serves as the superclass of both NodeType and
 * NodeTypeTemplate. In implementations that do not support node type
 * registration, only objects implementing the subinterface NodeType will
 * be encountered.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeTypeDefinitionInterface
{
    /**
     * Returns the name of the node type.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return null.
     *
     * @return string The name of the node type.
     *
     * @api
     */
    public function getName();

    /**
     * Returns the names of the supertypes actually declared in this node type.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return an array containing a
     * single string indicating the node type nt:base.
     *
     * @return array the names of the declared supertypes.
     *
     * @api
     */
    public function getDeclaredSupertypeNames();

    /**
     * Reports if this is an abstract node type.
     *
     * Returns true if this is an abstract node type; returns false otherwise.
     * An abstract node type is one that cannot be assigned as the primary or
     * mixin type of a node but can be used in the definitions of other node
     * types as a superclass.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return false.
     *
     * @return boolean True, if the current type is abstract, else false.
     *
     * @api
     */
    public function isAbstract();

    /**
     * Reports if this is a mixin node type.
     *
     * Returns true if this is a mixin type; returns false if it is primary.
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return false.
     *
     * @return boolean True if this is a mixin type, else false;
     *
     * @api
     */
    public function isMixin();

    /**
     * Determines if nodes of this type must support orderable child nodes.
     *
     * Returns true if nodes of this type must support orderable child nodes;
     * returns false otherwise. If a node type returns true on a call to this
     * method, then all nodes of that node type must support the method
     * NodeInterface::orderBefore(). If a node type returns false on a call to
     * this method, then nodes of that node type may support
     * NodeInterface::orderBefore(). Only the primary node type of a node
     * controls that node's status in this regard. This setting on a mixin node
     * type will not have any effect on the node.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinitionInterface object is actually a newly-created empty
     * NodeTypeTemplateInterface, then this method will return false.
     *
     * @return boolean True, if nodes of this type must support orderable child
     *      nodes, else false.
     *
     * @api
     */
    public function hasOrderableChildNodes();

    /**
     * Determines if the node type is queryable.
     *
     * Returns true if the node type is queryable, meaning that the
     * available-query-operators, full-text-searchable and query-orderable
     * attributes of its property definitions take effect.
     *
     * If a node type is declared non-queryable then these attributes of its
     * property definitions have no effect.
     *
     * @return boolean True, if the node type is queryable, else false.
     *
     * @see PropertyDefinition::getAvailableQueryOperators()
     * @see PropertyDefinition::isFullTextSearchable()
     * @see PropertyDefinition::isQueryOrderable()
     *
     * @api
     */
    public function isQueryable();

    /**
     * Returns the name of the primary item (one of the child items of the nodes
     * of this node type).
     *
     * If this node has no primary item, then this method returns null. This
     * indicator is used by the method NodeInterface::getPrimaryItem().
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinitionInterface object is actually a newly-created empty
     * NodeTypeTemplateInterface, then this method will return null.
     *
     * @return string The name of the primary item.
     *
     * @api
     */
    public function getPrimaryItemName();

    /**
     * Returns an array containing the property definitions actually declared
     * in this node type.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return null.
     *
     * @return PropertyDefinitionInterface[] An array of PropertyDefinitions.
     *
     * @api
     */
    public function getDeclaredPropertyDefinitions();

    /**
     * Returns an array containing the child node definitions actually
     * declared in this node type.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return null.
     *
     * @return NodeDefinitionInterface[] An array of NodeDefinitions.
     *
     * @api
     */
    public function getDeclaredChildNodeDefinitions();
}
