<?php
/**
 * Interface description of how to implement a class handling an event fired by the observation mechanism .
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */

declare(ENCODING = 'utf-8');
namespace PHPCR\Observation;

/**
 * An event fired by the observation mechanism.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface EventInterface {

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
     *    SessionInterface->move() or WorkspaceInterface->move() then the
     *    returned array has keys srcAbsPath and destAbsPath with values
     *    corresponding to the parameters passed to the move() method.
     *
     *  If the method that caused this event was a NodeInterface.orderBefore()
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
     * @api
     */
    public function getPath();

    /**
     * Returns the user ID connected with this event.
     *
     * This is the string returned by Session.getUserID() of the session that caused the event.
     *
     * @return string The identifier of the user connected to the event.
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
     * @api
     */
    public function getInfo();

    /**
     * Returns the user data set through ObservationManager.setUserData() on the
     * ObservationManager bound to the Session that caused the event.
     *
     * @return string The user data string.
     * @throws \PHPCR\RepositoryException if an error occurs.
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
     * @api
     */
    public function getDate();

}
