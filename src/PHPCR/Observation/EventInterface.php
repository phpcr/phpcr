<?php

namespace PHPCR\Observation;

/**
 * An event fired by the observation mechanism.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface EventInterface
{
    /**#@+
     * @var integer
     */

    /**
     * Generated on persist when a node is added.
     * - getPath() returns the absolute path of the node that was added.
     * - getIdentifier() returns the identifier of the node that was added.
     * - getInfo() returns an empty array
     *
     * @api
     */
    const NODE_ADDED = 0x1;

    /**
     * Generated on persist when a node is removed.
     * - getPath() returns the absolute path of the node that was removed.
     * - getIdentifier() returns the identifier of the node that was removed.
     * - getInfo() returns an empty array
     *
     * @api
     */
    const NODE_REMOVED = 0x2;

    /**
     * Generated on persist when a property is added.
     * - getPath() returns the absolute path of the property that was added.
     * - getIdentifier() returns the identifier of the parent node of the property that was added.
     * - getInfo() returns an empty array
     *
     * @api
     */
    const PROPERTY_ADDED = 0x4;

    /**
     * Generated on persist when a property is removed.
     * - getPath() returns the absolute path of the property that was removed.
     * - getIdentifier() returns the identifier of the parent node of the property that was removed.
     * - getInfo() returns an empty array
     * @api
     */
    const PROPERTY_REMOVED = 0x8;

    /**
     * Generated on persist when a property is changed.
     * - getPath() returns the absolute path of the property that was changed.
     * - getIdentifier() returns the identifier of the parent node of the property that was changed.
     * - getInfo() returns an empty array
     *
     * @api
     */
    const PROPERTY_CHANGED = 0x10;

    /**
     * Generated on persist when a node is moved.
     * - getPath() returns the absolute path of the destination of the move.
     * - getIdentifier() returns the identifier of the moved node.
     * - getInfo() If the method that caused this event was a
     *    SessionInterface::move() or WorkspaceInterface::move() then the
     *    returned array has keys srcAbsPath and destAbsPath with values
     *    corresponding to the parameters passed to the move() method.
     *
     *  If the method that caused this event was a NodeInterface::orderBefore()
     *  then the returned aray has keys srcChildRelPath and destChildRelPath
     *  with values corresponding to the parameters passed to the orderBefore()
     *  method.
     *
     * @api
     */
    const NODE_MOVED = 0x20;

    /**
     * If event bundling is supported, this event is used to indicate a
     * bundle boundary within the event journal.
     * - getPath() returns null.
     * - getIdentifier() returns null.
     * - getInfo() returns an empty array.
     *
     * @api
     */
    const PERSIST = 0x40;

    /**#@-*/

    /**
     * Returns the type of this event: a constant defined by this interface.
     * One of:
     * - NODE_ADDED
     * - NODE_REMOVED
     * - PROPERTY_ADDED
     * - PROPERTY_REMOVED
     * - PROPERTY_CHANGED
     * - NODE_MOVED
     * - PERSIST
     *
     * @return integer the type of this event.
     *
     * @api
     */
    public function getType();

    /**
     * Returns the absolute path associated with this event or null if this
     * event has no associated identifier.
     *
     * The meaning of the associated path depends upon the type of the event.
     * See event type constants above.
     *
     * @return string The absolute path associated with this event or null.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getPath();

    /**
     * Returns the user ID connected with this event.
     *
     * This is the string returned by SessionInterface::getUserID() of the session that caused the event.
     *
     * @return string The identifier of the user connected to the event.
     *
     * @api
     */
    public function getUserID();

    /**
     * Returns the identifier associated with this event or null if this event
     * has no associated identifier.
     *
     * The meaning of the associated identifier depends upon the type of the event.
     * See event type constants above.
     *
     * @return string The identifier associated with this event or null.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getIdentifier();

    /**
     * Returns the information map associated with this event.
     *
     * The meaning of the map depends upon the type of the event.
     * See event type constants above.
     *
     * @return array A list containing parameter information for instances of a NODE_MOVED event.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getInfo();

    /**
     * Returns the user data set through ObservationManagerInterface::setUserData() on the
     * ObservationManager bound to the Session that caused the event.
     *
     * @return string The user data string.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getUserData();

    /**
     * Returns the date when the change was persisted that caused this event.
     *
     * The date is represented as a millisecond value that is an offset from the
     * Epoch, January 1, 1970 00:00:00.000 GMT (Gregorian). The granularity of
     * the returned value is implementation dependent.
     *
     * @return integer The date when the change was persisted that caused this event (milliseconds since epoch).
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function getDate();

    /**
     * Return the type of the property this property related event is about.
     *
     * If this event is of type PROPERTY_ADDED or PROPERTY_REMOVED then this
     * method returns the property type * of the property at (or formerly at)
     * the path returned by getPath(). The property type is one of the
     * constants defined in PropertyType.
     *
     * @return int constant from PropertyType
     *
     * @throws \PHPCR\RepositoryException
     */
    public function getPropertyType();

    /**
     * Return the primary type of the node this node related event is about,
     * or the primary type of the parent of the property this property related
     * event is about.
     *
     * If this event is of type NODE_ADDED, NODE_REMOVED or NODE_MOVED then
     * this method returns the declared primary node type of the node at (or
     * formerly at) the path returned by getPath(). If this event is of type
     * PROPERTY_ADDED, PROPERTY_REMOVED or PROPERTY_CHANGED then this method
     * returns the declared primary node type of the parent node of the
     * property affected.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     */
    public function getPrimaryNodeType();

    /**
     * Return the mixin types of the node this node related event is about,
     * or the mixin types of the parent of the property this property related
     * event is about.
     *
     * If this event is of type NODE_ADDED, NODE_REMOVED or NODE_MOVED then
     * this method returns the declared mixin node types of the node at (or
     * formerly at) the path returned by getPath(). If this event is of type
     * PROPERTY_ADDED, PROPERTY_REMOVED or PROPERTY_CHANGED then this method
     * returns the declared mixin node types of the parent node of the property
     * affected.
     *
     * @return \PHPCR\NodeType\NodeTypeInterface[]
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     */
    public function getMixinNodeTypes();

}
