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
 * The PropertyDefinitionTemplate interface extends PropertyDefinition with the
 * addition of write methods, enabling the characteristics of a child property
 * definition to be set, after which the PropertyDefinitionTemplate is added to
 * a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in PropertyDefinition for
 * the default values assumed when a new empty PropertyDefinitionTemplate is
 * created (as opposed to one extracted from an existing NodeType).
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface PropertyDefinitionTemplateInterface extends \PHPCR\NodeType\PropertyDefinitionInterface
{
    /**
     * Sets the name of the property.
     *
     * @param string $name The name of the property definition template.
     *
     * @return void
     *
     * @api
     */
    function setName($name);

    /**
     * Sets the auto-create status of the property.
     *
     * @param boolean $autoCreated Flag to set the ability to be automatically
     *      created.
     *
     * @return void
     *
     * @api
     */
    function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the property.
     *
     * @param boolean $mandatory The mandatory status of the property.
     *
     * @return void
     *
     * @api
     */
    function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the property.
     *
     * @param integer $opv an int constant member of OnParentVersionAction.
     *
     * @return void
     *
     * @api
     */
    function setOnParentVersion($opv);

    /**
     * Sets the protected status of the property.
     *
     * @param boolean $protectedStatus The protection status of the property.
     *
     * @return void
     *
     * @api
     */
    function setProtected($protectedStatus);

    /**
     * Sets the required type of the property.
     *
     * @param integer $type An integer constant member of PropertyType.
     *
     * @return void
     *
     * @api
     */
    function setRequiredType($type);

    /**
     * Sets the value constraints of the property.
     *
     * @param array $constraints List of constrains registered on the property.
     *
     * @return void
     *
     * @api
     */
    function setValueConstraints(array $constraints);

    /**
     * Sets the default value (or values, in the case of a multi-value property)
     * of the property.
     *
     * @param array $defaultValues A List of values in the correct type for
     *      this property.
     *
     * @return void
     *
     * @api
     */
    function setDefaultValues(array $defaultValues);

    /**
     * Sets the multi-value status of the property.
     *
     * @param boolean $multiple The status of the ability to store multiple
     *      values.
     *
     * @return void
     *
     * @api
     */
    function setMultiple($multiple);

    /**
     * Sets the queryable status of the property.
     *
     * @param array operators An array of String constants
     *      {@link PropertyDefinition::getAvailableQueryOperators()}.
     *
     * @return void
     *
     * @api
     */
    function setAvailableQueryOperators(array $operators);

    /**
     * Sets the full-text-searchable status of the property.
     *
     * @param boolean $fullTextSearchable The status of the ability to be
     *      fulltext-searchable..
     *
     * @return void
     *
     * @api
     */
    function setFullTextSearchable($fullTextSearchable);

    /**
     * Sets the query-orderable status of the property.
     *
     * @param boolean $queryOrderable The status of the ability being
     *      query-orderable.
     *
     * @return void
     *
     * @api
     */
    function setQueryOrderable($queryOrderable);
}
