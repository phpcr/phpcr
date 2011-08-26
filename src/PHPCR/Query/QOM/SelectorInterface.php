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
 * Selects a subset of the nodes in the repository based on node type.
 *
 * A selector selects every node in the repository, subject to access control
 * constraints, that satisfies at least one of the following conditions:
 *
 * - the node's primary node type is nodeType
 * - the node's primary node type is a subtype of nodeType
 * - the node has a mixin node type that is nodeType
 * - the node has a mixin node type that is a subtype of nodeType
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface SelectorInterface extends SourceInterface
{
    /**
     * Gets the name of the required node type.
     *
     * @return string the node type name; non-null
     * @api
     */
    function getNodeTypeName();

    /**
     * Gets the selector name.
     *
     * A selector's name can be used elsewhere in the query to identify the
     * selector.
     *
     * @return string the selector name; non-null
     * @api
     */
    function getSelectorName();
}
