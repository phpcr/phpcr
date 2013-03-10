<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

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
 * @api
 */
interface NodeTypeTemplateInterface extends \PHPCR\NodeType\NodeTypeDefinitionInterface
{
    /**
     * Sets the name of the node type.
     *
     * @param string $name The name of the node type to be set.
     *
     * @api
     */
    public function setName($name);

    /**
     * Sets the names of the supertypes of the node type.
     *
     * @param array $names The name of the node supertype to be set.
     *
     * @api
     */
    public function setDeclaredSuperTypeNames(array $names);

    /**
     * Sets the abstract flag of the node type.
     *
     * @param boolean $abstractStatus Whether this type is abstract.
     *
     * @api
     */
    public function setAbstract($abstractStatus);

    /**
     * Sets the mixin flag of the node type.
     *
     * @param boolean $mixin Whether this type is a mixin type (or a primary
     *      type).
     *
     * @api
     */
    public function setMixin($mixin);

    /**
     * Sets the orderable child nodes flag of the node type.
     *
     * @param boolean $orderable Whether nodes of this type can have orderable
     *      children
     *
     * @api
     */
    public function setOrderableChildNodes($orderable);

    /**
     * Sets the name of the primary item.
     *
     * @param string $name The name of the primary item.
     *
     * @api
     */
    public function setPrimaryItemName($name);

    /**
     * Sets the queryable status of the node type.
     *
     * @param bool $queryable Whether this node is queryable.
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
     *      and \Countable) of PropertyDefinitionTemplate objects
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
     *      and \Countable) of NodeDefinitionTemplate objects
     *
     * @api
     */
    public function getNodeDefinitionTemplates();
}
