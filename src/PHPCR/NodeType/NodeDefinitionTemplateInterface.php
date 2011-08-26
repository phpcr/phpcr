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
 * The NodeDefinitionTemplate interface extends NodeDefinition with the addition
 * of write methods, enabling the characteristics of a child node definition to
 * be set, after which the NodeDefinitionTemplate is added to a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in NodeDefinition for the
 * default values assumed when a new empty NodeDefinitionTemplate is created (as
 * opposed to one extracted from an existing NodeType).
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NodeDefinitionTemplateInterface extends \PHPCR\NodeType\NodeDefinitionInterface
{
    /**
     * Sets the name of the node.
     *
     * @param string $name The name of the node.
     *
     * @return void
     *
     * @api
     */
    function setName($name);

    /**
     * Sets the auto-create status of the node.
     *
     * @param boolean $autoCreated The status the autocreate attribute of the
     *      node shall have.
     *
     * @return void
     *
     * @api
     */
    function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the node.
     *
     * @param boolean $mandatory The status of the mandatory attribute.
     *
     * @return void
     *
     * @api
     */
    function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the node.
     *
     * @param integer $opv An integer constant member of OnParentVersionAction.
     *
     * @return void
     *
     * @api
     */
    function setOnParentVersion($opv);

    /**
     * Sets the protected status of the node.
     *
     * @param boolean $protectedStatus The status of the protected attribute.
     *
     * @return void
     *
     * @api
     */
    function setProtected($protectedStatus);

    /**
     * Sets the names of the required primary types of this node.
     *
     * @param array $requiredPrimaryTypeNames List of primary type names to be
     *      registered.
     *
     * @return void
     *
     * @api
     */
    function setRequiredPrimaryTypeNames(Array $requiredPrimaryTypeNames);

    /**
     * Sets the name of the default primary type of this node.
     *
     * @param string $defaultPrimaryTypeName The name of a primary type name to
     *      be registered.
     *
     * @return void
     *
     * @api
     */
    function setDefaultPrimaryTypeName($defaultPrimaryTypeName);

    /**
     * Sets the same-name sibling status of this node.
     *
     * @param boolean $allowSameNameSiblings Whether same-name siblings of this
     *      node should be allowed
     *
     * @return void
     *
     * @api
     */
    function setSameNameSiblings($allowSameNameSiblings);
}
