<?php

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
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
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
     * @param ItemInterface $item a node or property accepting this
     *      visitor
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function visit(ItemInterface $item);
}
