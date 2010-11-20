<?php
/**
 * Interface description of an implementation of a node type definition.
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
 * The NodeTypeDefinition interface provides methods for discovering the
 * static definition of a node type. These are accessible both before and
 * after the node type is registered. Its subclass NodeType adds methods
 * that are relevant only when the node type is "live"; that is, after it
 * has been registered. Note that the separate NodeDefinition interface only
 * plays a significant role in implementations that support node type
 * registration. In those cases it serves as the superclass of both NodeType
 * and NodeTypeTemplate. In implementations that do not support node type
 * registration, only objects implementing the subinterface NodeType will
 * be encountered.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NodeTypeDefinitionInterface {

    /**
     * Returns the name of the node type.
     *
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return null.
     *
     * @return string The name of the node type.
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
     * @return array List of names of declared supertypes.
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
     * @api
     */
    public function isMixin();

    /**
     * Determines if nodes of this type must support orderable child nodes.
     *
     * Returns true if nodes of this type must support orderable child nodes;
     * returns false otherwise. If a node type returns true on a call to this
     * method, then all nodes of that node type must support the method
     * Node.orderBefore. If a node type returns false on a call to this method,
     * then nodes of that node type may support Node.orderBefore. Only the primary
     * node type of a node controls that node's status in this regard. This setting
     * on a mixin node type will not have any effect on the node.
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return false.
     *
     * @return boolean True, if nodes of this type must support orderable child nodes, else false.
     * @api
     */
    public function hasOrderableChildNodes();

    /**
     * Determins if the node type is queryable.
     *
     * Returns TRUE if the node type is queryable, meaning that the
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
     * @api
     */
    public function isQueryable();

    /**
     * Returns the name of the primary item (one of the child items of the nodes
     * of this node type).
     *
     * If this node has no primary item, then this method
     * returns null. This indicator is used by the method Node.getPrimaryItem().
     * In implementations that support node type registration, if this
     * NodeTypeDefinition object is actually a newly-created empty
     * NodeTypeTemplate, then this method will return null.
     *
     * @return string The name of the primary item.
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
     * @return array An array of PropertyDefinitions.
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
     * @return array An array of NodeDefinitions.
     * @api
     */
    public function getDeclaredChildNodeDefinitions();
}
