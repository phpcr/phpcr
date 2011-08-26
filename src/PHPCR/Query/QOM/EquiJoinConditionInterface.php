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
 * Tests whether the value of a property in a first selector is equal to the
 * value of a property in a second selector.
 *
 * A node-tuple satisfies the constraint only if:
 *  selector1 has a property named property1, and
 *  selector2 has a property named property2, and
 *  the value of property1 equals the value of property2
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface EquiJoinConditionInterface extends JoinConditionInterface
{
    /**
     * Gets the name of the first selector.
     *
     * @return string the selector name; non-null
     *
     * @api
     */
    function getSelector1Name();

    /**
     * Gets the property name in the first selector.
     *
     * @return string the property name; non-null
     *
     * @api
     */
    function getProperty1Name();

    /**
     * Gets the name of the second selector.
     *
     * @return string the selector name; non-null
     *
     * @api
     */
    function getSelector2Name();

    /**
     * Gets the property name in the second selector.
     *
     * @return string the property name; non-null
     *
     * @api
     */
    function getProperty2Name();
}
