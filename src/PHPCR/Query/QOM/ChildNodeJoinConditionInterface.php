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
 * Tests whether the childSelector node is a child of the parentSelector node.
 *
 * A node-tuple satisfies the constraint only if:
 *  <code>$childSelectorNode->getParent()->isSame($parentSelectorNode)</code>
 * would return true, where $childSelectorNode is the node for childSelector
 * and $parentSelectorNode is the node for parentSelector.
 *
 * @api
 */
interface ChildNodeJoinConditionInterface extends JoinConditionInterface
{
    /**
     * Gets the name of the child selector.
     *
     * @return string the selector name; non-null
     *
     * @api
     */
    public function getChildSelectorName();

    /**
     * Gets the name of the parent selector.
     *
     * @return string the selector name; non-null
     *
     * @api
     */
    public function getParentSelectorName();
}
