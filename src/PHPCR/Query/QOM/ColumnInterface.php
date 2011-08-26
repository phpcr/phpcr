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

namespace PHPCR\Query\QOM;

/**
 * Defines a column to include in the tabular view of query results.
 *
 * If property is not specified, a column is included for each single-valued
 * non-residual property of the node type specified by the nodeType attribute
 * of selector.
 *
 * If property is specified, columnName is required and used to name the column
 * in the tabular results. If property is not specified, columnName must not be
 * specified, and the included columns will be named "selector.propertyName".
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface ColumnInterface
{
    /**
     * Gets the name of the selector.
     *
     * @return string the selector name; non-null
     *
     * @api
     */
    function getSelectorName();

    /**
     * Gets the name of the property.
     *
     * @return string the property name, or null to include a column for each
     *      single-value non-residual property of the selector's node type
     *
     * @api
     */
    function getPropertyName();

    /**
     * Gets the column name.
     *
     * @return string the column name; must be null if getPropertyName is null
     *      and non-null otherwise
     *
     * @api
     */
    function getColumnName();
}
