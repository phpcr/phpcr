<?php
declare(ENCODING = 'utf-8');
namespace PHPCR\Util;

/*                                                                        *
 * This file was ported from the Java JCR API to PHP by                   *
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.          *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version. Alternatively, you may use the Simplified   *
 * BSD License.                                                           *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * An implementation of ItemVisitor.
 *
 * TraversingItemVisitor is an abstract utility class which allows to easily
 * traverse an Item hierarchy.
 * TraversingItemVisitor makes use of the Visitor Pattern as described in the
 * book 'Design Patterns' by the Gang Of Four (Gamma et al.).
 * Tree traversal is done observing the left-to-right order of child Items if
 * such an order is supported and exists.
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @api
 */
abstract class TraversingItemVisitor implements \PHPCR\ItemVisitorInterface {

    /**
     * Indicates if traversal should be done in a breadth-first manner rather
     * than depth-first (which is the default).
     * @var boolean
     */
    protected $breadthFirst = FALSE;

    /**
     * The 0-based level up to which the hierarchy should be traversed (if it's
     * -1, the hierarchy will be traversed until there are no more children of
     * the current item).
     * @var integer
     */
    protected $maxLevel = -1;

    /**
     * Queue used to implement breadth-first traversal.
     * @var \SplQueue
     */
    protected $currentQueue;

    /**
     * Queue used to implement breadth-first traversal.
     * @var \SplQueue
     */
    protected $nextQueue;

    /**
     * Used to track hierarchy level of item currently being processed.
     * @var integer
     */
    protected $currentLevel;

    /**
     * Constructs a new instance of this class.
     *
     * @param boolean $breadthFirst if $breadthFirst is TRUE then traversal is done in a breadth-first manner; otherwise it is done in a depth-first manner (which is the default behavior).
     * @param integer $maxLevel the 0-based level up to which the hierarchy should be traversed (if it's -1, the hierarchy will be traversed until there are no more children of the current item).
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @author Day Management AG, Switzerland
     * @api
     */
    public function TraversingItemVisitor($breadthFirst = FALSE, $maxLevel = -1) {
        $this->breadthFirst = $breadthFirst;
        $this->maxLevel = $maxLevel;

        if ($this->breadthFirst === TRUE) {
            $this->currentQueue = new \SplQueue();
            $this->nextQueue = new \SplQueue();
        }
        $this->currentLevel = 0;
    }

    /**
     * Implement this method to add behavior performed before an Item is visited.
     *
     * @param \PHPCR\ItemInterface $item the Item that is accepting this visitor.
     * @param integer $level hierarchy level of this node (the root node starts at level 0).
     * @return void
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    protected abstract function entering(\PHPCR\ItemInterface $item, $level);

    /**
     * Implement this method to add behavior performed after an Item is visited.
     *
     * @param \PHPCR\ItemInterface $item the Item that is accepting this visitor.
     * @param integer $level hierarchy level of this property (the root node starts at level 0).
     * @return void
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    protected abstract function leaving(\PHPCR\ItemInterface $item, $level);

    /**
     * Called when the Visitor is passed to an Item.
     * It calls TraversingItemVisitor.entering(ItemInterface, int) followed by
     * TraversingItemVisitor.leaving(ItemInterface, int). Implement these
     * abstract methods to specify behavior on 'arrival at' and 'after leaving'
     * the $item.
     *
     * If this method throws, the visiting process is aborted.
     *
     * @param \PHPCR\ItemInterface $item the Node or Property that is accepting this visitor.
     * @return void
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @author Day Management AG, Switzerland
     * @api
     */
    public function visit(\PHPCR\ItemInterface $item) {
        if ($item instanceof \PHPCR\PropertyInterface) {
            $this->entering($item);
            $this->leaving($item);
        } else {
            try {
                if ($this->breadthFirst === FALSE) {
                        // depth-first traversal
                    $this->entering($item, $this->currentLevel);
                    if ($this->maxLevel == -1 || $this->currentLevel < $this->maxLevel) {
                        $this->currentLevel++;
                        $propertyIterator = $item->getProperties();
                        while ($propertyIterator->hasNext()) {
                            $propertyIterator->nextProperty()->accept($this);
                        }
                        $nodeIterator = $item->getNodes();
                        while ($nodeIterator->hasNext()) {
                            $nodeIterator->nextNode()->accept($this);
                        }
                        $this->currentLevel--;
                    }
                    $this->leaving($item, $this->currentLevel);
                } else {
                        // breadth-first traversal
                    $this->entering($item, $this->currentLevel);
                    $this->leaving($item, $this->currentLevel);

                    if ($this->maxLevel == -1 || $this->currentLevel < $this->maxLevel) {
                        $propertyIterator = $item->getProperties();
                        while ($propertyIterator->hasNext()) {
                            $this->nextQueue->enqueue($propertyIterator->nextProperty());
                        }
                        $nodeIterator = $item->getNodes();
                        while ($nodeIterator->hasNext()) {
                            $this->nextQueue->enqueue($nodeIterator->nextNode());
                        }
                    }

                    while (!$this->currentQueue->isEmpty() || !$this->nextQueue->isEmpty()) {
                        if ($this->currentQueue->isEmpty()) {
                            $this->currentLevel++;
                            $this->currentQueue = $this->nextQueue;
                            $this->nextQueue = new \SplQueue();
                        }
                        $item = $this->currentQueue->dequeue();
                        $item->accept($this);
                    }
                    $this->currentLevel = 0;
                }
            } catch (\PHPCR\RepositoryException $exception) {
                $this->currentLevel = 0;
                throw $exception;
            }
        }
    }

}
