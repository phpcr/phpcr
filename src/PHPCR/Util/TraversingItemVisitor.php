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

namespace PHPCR\Util;

/**
 * An implementation of ItemVisitor.
 *
 * TraversingItemVisitor is an abstract utility class which allows to easily
 * traverse an Item hierarchy.
 * You overwrite entering and leaving methods that get called for all
 * properties encountered
 *
 * TraversingItemVisitor makes use of the Visitor Pattern as described in the
 * book 'Design Patterns' by the Gang Of Four (Gamma et al.).
 * Tree traversal is done observing the left-to-right order of child Items if
 * such an order is supported and exists.
 *
 * @author Karsten Dambekalns <karsten@typo3.org>
 * @author Day Management AG, Switzerland
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
abstract class TraversingItemVisitor implements \PHPCR\ItemVisitorInterface
{
    /**
     * Indicates if traversal should be done in a breadth-first manner rather
     * than depth-first (which is the default).
     *
     * @var boolean
     */
    protected $breadthFirst = false;

    /**
     * The 0-based depth up to which the hierarchy should be traversed (if it's
     * -1, the hierarchy will be traversed until there are no more children of
     * the current item).
     *
     * @var integer
     */
    protected $maxDepth = -1;

    /**
     * Queue used to implement breadth-first traversal.
     *
     * @var \SplQueue
     */
    protected $currentQueue;

    /**
     * Queue used to implement breadth-first traversal.
     *
     * @var \SplQueue
     */
    protected $nextQueue;

    /**
     * Used to track hierarchy depth of item currently being processed.
     *
     * @var integer
     */
    protected $currentDepth;

    /**
     * Constructs a new instance of this class.
     *
     * @param boolean $breadthFirst if $breadthFirst is true then traversal is
     *      done in a breadth-first manner; otherwise it is done in a
     *      depth-first manner (which is the default behavior).
     * @param integer $maxDepth the 0-based depth relative to the root node up
     *      to which the hierarchy should be traversed (if it's -1, the
     *      hierarchy will be traversed until there are no more children of the
     *      current item).
     *
     * @api
     */
    public function __construct($breadthFirst = false, $maxDepth = -1)
    {
        $this->breadthFirst = $breadthFirst;
        $this->maxDepth = $maxDepth;

        if ($this->breadthFirst === true) {
            $this->currentQueue = new \SplQueue();
            $this->nextQueue = new \SplQueue();
        }
        $this->currentDepth = 0;
    }

    /**
     * Implement this method to add behavior performed before a Property is
     * visited.
     *
     * @param \PHPCR\ItemInterface $item the Item that is accepting this
     *      visitor.
     * @param integer $depth hierarchy level of this node (the root node starts
     *      at depth 0).
     *
     * @return void
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    protected abstract function entering(\PHPCR\ItemInterface $item, $depth);

    /**
     * Implement this method to add behavior performed after a Property is
     * visited.
     *
     * @param \PHPCR\ItemInterface $item the Item that is accepting this
     *      visitor.
     * @param integer $depth hierarchy level of this property (the root node
     *      starts at depth 0).
     *
     * @return void
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    protected abstract function leaving(\PHPCR\ItemInterface $item, $depth);

    /**
     * Called when the Visitor is passed to an Item.
     *
     * It calls TraversingItemVisitor::entering() followed by
     * TraversingItemVisitor::leaving(). Implement these abstract methods to
     * specify behavior on 'arrival at' and 'after leaving' the $item.
     *
     * If this method throws, the visiting process is aborted.
     *
     * @param \PHPCR\ItemInterface $item the Node or Property that is accepting
     *      this visitor.
     *
     * @return void
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function visit(\PHPCR\ItemInterface $item)
    {
        if ($this->currentDepth == 0) {
            $this->currentDepth = $item->getDepth();
        }
        if ($item instanceof \PHPCR\PropertyInterface) {
            $this->entering($item, $this->currentDepth);
            $this->leaving($item, $this->currentDepth);
        } else {
            try {
                if ($this->breadthFirst === false) {
                    $this->entering($item, $this->currentDepth);
                    if ($this->maxDepth == -1 || $this->currentDepth < $this->maxDepth) {
                        $this->currentDepth++;
                        foreach ($item->getProperties() as $property) {
                            $property->accept($this);
                        }
                        foreach ($item->getNodes() as $node) {
                            $node->accept($this);
                        }
                        $this->currentDepth--;
                    }
                    $this->leaving($item, $this->currentDepth);
                } else {
                    $this->entering($item, $this->currentDepth);
                    $this->leaving($item, $this->currentDepth);

                    if ($this->maxDepth == -1 || $this->currentDepth < $this->maxDepth) {
                        foreach ($item->getProperties() as $property) {
                            $property->accept($this);
                        }
                        foreach ($item->getNodes() as $node) {
                            $node->accept($this);
                        }
                    }

                    while (!$this->currentQueue->isEmpty() || !$this->nextQueue->isEmpty()) {
                        if ($this->currentQueue->isEmpty()) {
                            $this->currentDepth++;
                            $this->currentQueue = $this->nextQueue;
                            $this->nextQueue = new \SplQueue();
                        }
                        $item = $this->currentQueue->dequeue();
                        $item->accept($this);
                    }
                    $this->currentDepth = 0;
                }
            } catch (\PHPCR\RepositoryException $exception) {
                $this->currentDepth = 0;
                throw $exception;
            }
        }
    }
}
