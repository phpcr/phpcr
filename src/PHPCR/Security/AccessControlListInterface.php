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

namespace PHPCR\Security;

/**
 * The AccessControlList is an AccessControlPolicy representing a list of
 * access control entries.
 *
 * It is mutable before being set to the AccessControlManager and consequently
 * defines methods to read and mutate the list i.e. to get, add or remove
 * individual entries.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. AccessControlList has to implement either \RecursiveIterator
 * or \Iterator.
 * The iterator is equivalent to <b>getAccessControlEntries()</b> returning a
 * list of AccessControlEntry. The iterator keys have no significant meaning.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface AccessControlListInterface extends \PHPCR\Security\AccessControlPolicyInterface, \Traversable
{
    /**
     * Gets every registered access control entry.
     *
     * Returns all access control entries present with this policy.
     * This method is only guaranteed to return an AccessControlEntry if that
     * AccessControlEntry has been assigned through this API.
     *
     * @return array Lis of all AccessControlEntry objects present with this
     *      policy.
     *
     * @throws \PHPCR\RepositoryException - if an error occurs.
     *
     * @api
     */
    function getAccessControlEntries();

    /**
     * Registers an access control entry object to the registry.
     *
     * Adds an access control entry to this policy consisting of the specified
     * principal and the specified privileges.
     * This method returns true if this policy was modified, false otherwise.
     *
     * How the entries are grouped within the list is an implementation detail.
     * An implementation may e.g. combine the specified privileges with those
     * added by a previous call to addAccessControlEntry for the same
     * Principal. However, a call to addAccessControlEntry for a given
     * Principal can never remove a Privilege added by a previous call.
     *
     * The modification does not take effect until this policy has been set to
     * a node by calling AccessControlManagerInterface::setPolicy() and save is
     * performed.
     *
     * @param ? $principal - a Principal. TODO: define a type for this. JCR has javax.security.Principal
     * @param array $privileges - an array of Privileges.
     *
     * @return boolean true if this policy was modify; false otherwise.
     *
     * @throws \PHPCR\Security\AccessControlException if the specified
     *      principal or any of the privileges does not exist or if some other
     *      access control related exception occurs.
     * @throws \PHPCR\RepositoryException - if another error occurs.
     *
     * @todo find replacement for java.security.Principal
     *
     * @api
     */
    function addAccessControlEntry($principal, array $privileges);

    /**
     * Removes the specified access control entry object from this policy.
     *
     * Only exactly those entries obtained through getAccessControlEntries can
     * be removed. This method does not take effect until this policy has been
     * re-set to a node by calling AccessControlManagerInterface::setPolicy()
     * and save is performed.
     *
     * @param \PHPCR\Security\AccessControlEntryInterface $ace the access
     *      control entry to be removed.
     *
     * @return void
     *
     * @throws \PHPCR\Security\AccessControlException if the specified entry is
     *      not present on the specified node.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function removeAccessControlEntry(\PHPCR\Security\AccessControlEntryInterface $ace);
}
