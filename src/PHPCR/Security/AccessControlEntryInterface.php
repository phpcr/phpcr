<?php
/**
 * Interface description of an implementation of an access control entry .
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
namespace PHPCR\Security;

/**
 * An AccessControlEntry represents the association of one or more Privilege
 * objects with a specific Principal.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. AccessControlEntry has to implement either \RecursiveIterator
 * or \Iterator.
 * The iterator is equivalent to <b>getPrivileges()</b> returning a list of
 * PrivilegeInterface. The iterator keys have no significant meaning.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface AccessControlEntryInterface extends \Traversable {

    /**
     * Returns the principal associated with this access control entry.
     *
     * @return java.security.Principal a Principal.
     *
     * @todo find replacement for java.security.Principal
     * @api
     */
    public function getPrincipal();

    /**
     * Returns the privileges associated with this access control entry.
     *
     * @return array an array of Privileges.
     * @api
     */
    public function getPrivileges();

}
