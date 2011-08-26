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

namespace PHPCR;

/**
 * Interface to define a visitor on an item.
 *
 * This interface defines two signatures of the visit method; one taking a
 * Node, the other a Property. When an object implementing this interface is
 * passed to Item->accept(ItemVisitor) the appropriate visit method is
 * automatically called, depending on whether the Item in question is a Node
 * or a Property. Different implementations of this interface can be written
 * for different purposes. It is, for example, possible for the visit(Node)
 * method to call accept on the children of the passed node and thus recurse
 * through the tree performing some operation on each Item.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface ItemVisitorInterface
{
    /**
     * This method is called when the ItemVisitor is passed to the accept
     * method of a Node or Property.
     *
     * If this method throws an exception the visiting process is aborted.
     *
     * PHPCR Note: you need to distinguish between Node and Property objects
     * being visited in your implementation.
     *
     * @param \PHPCR\ItemInterface $item a node or property accepting this
     *      visitor
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    function visit(\PHPCR\ItemInterface $item);
}
