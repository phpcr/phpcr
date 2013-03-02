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
 * Performs a join between two node-tuple sources.
 *
 * @api
 */
interface JoinInterface extends SourceInterface
{
    /**
     * Gets the left node-tuple source.
     *
     * @return SourceInterface the left source; non-null
     *
     * @api
     */
    public function getLeft();

    /**
     * Gets the right node-tuple source.
     *
     * @return SourceInterface the right source; non-null
     *
     * @api
     */
    public function getRight();

    /**
     * Gets the join type.
     *
     * @return string one of QueryObjectModelConstants.JCR_JOIN_TYPE_*
     *
     * @api
     */
    public function getJoinType();

    /**
     * Gets the join condition.
     *
     * @return JoinConditionInterface the join condition; non-null
     *
     * @api
     */
    public function getJoinCondition();
}
