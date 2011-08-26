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
 * Evaluates to the value (or values, if multi-valued) of a property.
 *
 * If, for a node-tuple, the selector node does not have a property named
 * property, the operand evaluates to null.
 *
 * The query is invalid if:
 *
 * - selector is not the name of a selector in the query
 * - property is not a syntactically valid JCR name
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface PropertyValueInterface extends DynamicOperandInterface
{
    /**
     * Gets the name of the selector against which to evaluate this operand.
     *
     * @return string the selector name; non-null
     * @api
     */
    function getSelectorName();

    /**
     * Gets the name of the property.
     *
     * @return string the property name; non-null
     * @api
     */
    function getPropertyName();
}
