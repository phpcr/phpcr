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
 * A node definition. Used in node type definitions.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NodeDefinitionInterface extends \PHPCR\NodeType\ItemDefinitionInterface
{
    /**
     * Gets the minimum set of primary node types that the child node must have.
     *
     * Returns an array to support those implementations with multiple inheritance.
     * This method never returns an empty array. If this node definition places
     * no requirements on the primary node type, then this method will return an
     * array containing only the NodeType object representing nt:base, which is
     * the base of all primary node types and therefore constitutes the least
     * restrictive node type requirement. Note that any particular node instance
     * still has only one assigned primary node type, but in multiple-inheritance-
     * supporting implementations the RequiredPrimaryTypes attribute can be used
     * to restrict that assigned node type to be a subtype of all of a specified
     * set of node types.
     * In implementations that support node type registration an NodeDefinition
     * object may be acquired (in the form of a NodeDefinitionTemplate) that is
     * not attached to a live NodeType. In such cases this method returns null.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface An array of NodeType objects.
     *
     * @api
     */
    function getRequiredPrimaryTypes();

    /**
     * Returns the names of the required primary node types.
     *
     * If this NodeDefinition is acquired from a live NodeType this list will
     * reflect the node types returned by getRequiredPrimaryTypes, above.
     *
     * If this NodeDefinition is actually a NodeDefinitionTemplate that is not
     * part of a registered node type, then this method will return the required
     * primary types as set in that template. If that template is a newly-created
     * empty one, then this method will return null.
     *
     * @return array a String array
     *
     * @api
     */
    function getRequiredPrimaryTypeNames();

    /**
     * Gets the default primary node type that will be assigned to the child node
     * if it is created without an explicitly specified primary node type.
     *
     * This node type must be a subtype of (or the same type as) the node types
     * returned by getRequiredPrimaryTypes.
     * If null is returned this indicates that no default primary type is
     * specified and that therefore an attempt to create this node without
     * specifying a node type will throw a ConstraintViolationException. In
     * implementations that support node type registration an NodeDefinition
     * object may be acquired (in the form of a NodeDefinitionTemplate) that is
     * not attached to a live NodeType. In such cases this method returns null.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface A NodeType.
     *
     * @api
     */
    function getDefaultPrimaryType();

    /**
     * Returns the name of the default primary node type.
     *
     * If this NodeDefinition is acquired from a live NodeType this list will
     * reflect the NodeType returned by getDefaultPrimaryType, above.
     *
     * If this NodeDefinition is actually a NodeDefinitionTemplate that is not
     * part of a registered node type, then this method will return the required
     * primary types as set in that template. If that template is a newly-created
     * empty one, then this method will return null.
     *
     * @return string The name of the default primary type.
     *
     * @api
     */
    function getDefaultPrimaryTypeName();

    /**
     * Reports whether this child node can have same-name siblings.
     *
     * In other words, whether the parent node can have more than one child
     * node of this name. If this NodeDefinition is actually a
     * NodeDefinitionTemplate that is not part of a registered node type, then
     * this method will return the same name siblings status as set in that
     * template. If that template is a newly-created empty one, then this
     * method will return false.
     *
     * @return boolean True, if the node my have a same-name sibling, else false.
     *
     * @api
     */
    function allowsSameNameSiblings();
}
