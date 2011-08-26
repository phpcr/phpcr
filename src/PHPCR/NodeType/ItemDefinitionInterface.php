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
 * Superclass of NodeDefinition and PropertyDefinition.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface ItemDefinitionInterface
{
    /**
     * Gets the node type that contains the declaration of this ItemDefinition.
     *
     * In implementations that support node type registration an ItemDefinition
     * object may be acquired (in the form of a NodeDefinitionTemplate or
     * PropertyDefinitionTemplate) that is not attached to a live NodeType. In
     * such cases this method returns null.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface A NodeType object.
     *
     * @api
     */
    function getDeclaringNodeType();

    /**
     * Gets the name of the child item.
     *
     * If "*", this ItemDefinition defines a residual set of child items.
     * That is, it defines the characteristics of all those child items with names
     * apart from the names explicitly used in other child item definitions.
     *
     * In implementations that support node type registration, if this
     * ItemDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
     * will return null.
     *
     * @return string A string denoting the name or "*".
     *
     * @api
     */
    function getName();

    /**
     * Reports whether the item is to be automatically created when its parent
     * node is created.
     *
     * If true, then this ItemDefinition will necessarily not
     * be a residual set definition but will specify an actual item name (in
     * other words getName() will not return "*").
     *
     * An autocreated non-protected item must be created immediately when
     * its parent node is created in the transient session space. Creation of
     * autocreated non-protected items is never delayed until save.
     *
     * An autocreated protected item should be created immediately when its
     * parent node is created in the transient session space. Creation of
     * autocreated protected items should not be delayed until save, though
     * doing so does not violate JCR compliance.
     *
     * In implementations that support node type registration, if this
     * ItemDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
     * will return false.
     *
     * @return boolean True, if the item is automatically created when its
     *      parent node is created, else false.
     *
     * @api
     */
    function isAutoCreated();

    /**
     * Reports whether the item is mandatory.
     *
     * A mandatory item is one that, if its parent node exists, must also exist.
     * This means that a mandatory single-value property must have a value (since
     * there is no such thing a null value). In the case of multi-value properties
     * this means that the property must exist, though it can have zero or more
     * values.
     *
     * An attempt to save a node that has a mandatory child item without first
     * creating that child item will throw a ConstraintViolationException on save.
     *
     * In implementations that support node type registration, if this
     * ItemDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
     * will return false.
     *
     * An item definition cannot be both residual and mandatory.
     *
     * @return boolean True, if the item is mandatory, else false.
     *
     * @api
     */
    function isMandatory();

    /**
     * Gets the OnParentVersion status of the child item.
     *
     * This governs what occurs (in implementations that support versioning)
     * when the parent node of this item is checked-in. One of:
     *
     * - OnParentVersionAction::COPY
     * - OnParentVersionAction::VERSION
     * - OnParentVersionAction::IGNORE
     * - OnParentVersionAction::INITIALIZE
     * - OnParentVersionAction::COMPUTE
     * - OnParentVersionAction::ABORT
     *
     * In implementations that support node type registration, if this
     * ItemDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplateInterface or NodeDefinitionTemplateInterface,
     * then this method will return OnParentVersionAction::COPY.
     *
     * @return integer An int constant member of OnParentVersionAction.
     *
     * @api
     */
    function getOnParentVersion();

    /**
     * Reports whether the child item is protected.
     *
     * In level 2 implementations, a protected item is one that cannot be
     * removed (except by removing its parent) or modified through the the
     * standard write methods of this API (that is, ItemInterface::remove(),
     * NodeInterface::addNode(), NodeInterface::setProperty() and
     * PropertyInterface::setValue()).
     *
     * A protected node may be removed or modified (in a level 2
     * implementation), however, through some mechanism not defined by this
     * specification or as a side-effect of operations other than the standard
     * write methods of the API.
     *
     * In implementations that support node type registration, if this
     * ItemDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplateInterface or NodeDefinitionTemplateInterface,
     * then this method will return false.
     *
     * @return boolean True, if the child item is protected, else false.
     * @api
     */
    function isProtected();
}
