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

namespace PHPCR\Retention;

/**
 * Hold represents a hold that can be applied to an existing node in order to
 * prevent the node from being modified or removed. The format and interpretation
 * of the name are not specified. They are application-dependent.
 *
 * If isDeep() is true, the hold applies to the node and its entire subgraph.
 * Otherwise the hold applies to the node and its properties only.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface HoldInterface
{
    /**
     * Returns true if this Hold is deep.
     *
     * @return boolean true if this Hold is deep.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    function isDeep();

    /**
     * Returns the name of this Hold. A JCR name.
     *
     * @return string the name of this Hold. A JCR name.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    function getName();
}
