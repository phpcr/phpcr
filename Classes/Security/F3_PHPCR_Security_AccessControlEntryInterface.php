<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR::Security;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Security
 * @version $Id:$
 */

/**
 * An AccessControlEntry represents the association of one or more Privilege
 * objects with a specific Principal
 *
 * @package PHPCR
 * @subpackage Security
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface AccessControlEntryInterface {

	/**
	 * Returns the principal associated with this access control entry.
	 *
	 * @return java.security.Principal a Principal.
	 * @todo find replacement for java.security.Principal
	 */
	public function getPrincipal();

	/**
	 * Returns the privileges associated with this access control entry.
	 *
	 * @return array an array of Privileges.
	 */
	public function getPrivileges();

}

?>