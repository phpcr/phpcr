<?php
declare(ENCODING = 'utf-8');
namespace PHPCR\Security;

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
 * The AccessControlList is an AccessControlPolicy representing a list of access
 * control entries. It is mutable before being set to the AccessControlManager
 * and consequently defines methods to read and mutate the list i.e. to get, add
 * or remove individual entries.
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @api
 */
interface AccessControlListInterface extends \PHPCR\Security\AccessControlPolicyInterface {

    /**
     * Returns all access control entries present with this policy.
     * This method is only guaranteed to return an AccessControlEntry if that
     * AccessControlEntry has been assigned through this API.
     *
     * @return array all AccessControlEntry objects present with this policy.
     * @throws \PHPCR\RepositoryException - if an error occurs.
     * @api
     */
    public function getAccessControlEntries();

    /**
     * Adds an access control entry to this policy consisting of the specified
     * principal and the specified privileges.
     * This method returns true if this policy was modified, false otherwise.
     *
     * How the entries are grouped within the list is an implementation detail. An
     * implementation may e.g. combine the specified privileges with those added by
     * a previous call to addAccessControlEntry for the same Principal. However, a
     * call to addAccessControlEntry for a given Principal can never remove a
     * Privilege added by a previous call.
     *
     * The modification does not take effect until this policy has been set to a node
     * by calling AccessControlManager.setPolicy(String, AccessControlPolicy) and
     * save is performed.
     *
     * @param java.security.Principal $principal - a Principal.
     * @param array $privileges - an array of Privileges.
     * @return boolean true if this policy was modify; false otherwise.
     * @throws \PHPCR\Security\AccessControlException - if the specified principal or any of the privileges does not existor if some other access control related exception occurs.
     * @throws \PHPCR\RepositoryException - if another error occurs.
     * @todo find replacement for java.security.Principal
     * @api
     */
    public function addAccessControlEntry($principal, array $privileges);

    /**
     * Removes the specified AccessControlEntry from this policy.
     * Only exactly those entries obtained through getAccessControlEntries can be
     * removed. This method does not take effect until this policy has been re-set
     * to a node by calling AccessControlManager.setPolicy(String, AccessControlPolicy)
     * and save is performed.
     *
     * @param \PHPCR\Security\AccessControlEntryInterface $ace the access control entry to be removed.
     * @return void
     * @throws \PHPCR\Security\AccessControlException if the specified entry is not present on the specified node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function removeAccessControlEntry(\PHPCR\Security\AccessControlEntryInterface $ace);

}
