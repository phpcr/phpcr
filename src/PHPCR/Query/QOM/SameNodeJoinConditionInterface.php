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
 * Tests whether two nodes are "the same" according to
 * \PHPCR\ItemInterface::isSame()
 *
 * If selector2Path is omitted:
 *  Tests whether the selector1 node is the same as the selector2 node.
 *  A node-tuple satisfies the constraint only if:
 *   <code>$selector1Node->isSame($selector2Node)</code>
 *  would return true, where $selector1Node is the node for selector1 and
 *  $selector2Node is the node for selector2.
 *
 * Otherwise, if selector2Path is specified:
 *  Tests whether the selector1 node is the same as a node identified by
 *  relative path from the selector2 node. A node-tuple satisfies the
 *  constraint only if:
 *   <code>$selector1Node->isSame($selector2Node->getNode($selector2Path))</code>
 *  would return true, where $selector1Node is the node for selector1 and
 *  $selector2Node is the node for selector2.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface SameNodeJoinConditionInterface extends JoinConditionInterface
{
    /**
     * Gets the name of the first selector.
     *
     * @return string the selector name; non-null
     * @api
     */
    function getSelector1Name();

    /**
     * Gets the name of the second selector.
     *
     * @return string the selector name; non-null
     * @api
     */
    function getSelector2Name();

    /**
     * Gets the path relative to the second selector.
     *
     * @return string the relative path, or null for none
     * @api
     */
    function getSelector2Path();
}
