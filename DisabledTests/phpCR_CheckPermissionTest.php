<?php
declare(ENCODING = 'utf-8');

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

require_once('phpCR_Test.php');

/**
 * Tests if {@link Session#checkPermission(String, String)} yields the correct
 * permissions for a read-only session and a 'superuser' session.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_CheckPermissionTest extends phpCR_Test {

	/**
	 * Tests if <code>Session.checkPermission(String, String)</code> works
	 * properly: <ul> <li>Returns quietly if access is permitted.</li>
	 * <li>Throws an {@link java.security.AccessControlException} if access is
	 * denied.</li> </ul>
	 */
	public function testCheckPermissionReadOnly() {
		$readOnlySession = $this->getReadOnlySession();
		$pathPrefix = $this->testRootNode->getPath() . '/';

		try {
			$readOnlySession->checkPermission($pathPrefix, 'read');
		} catch (phpCR_AccessControlException $e) {
			$readOnlySession->logout();
			$this->fail('read permission not granted to read-only Session. '.$e->getMessage());
		}

		try {
			$readOnlySession->checkPermission($pathPrefix . $this->nodeName1 . '/', 'add_node');
			$readOnlySession->logout();
			$this->fail('add_node permission granted to read-only Session');
		} catch (phpCR_AccessControlException $e) {
			// ok
		}

		try {
			$readOnlySession->checkPermission($pathPrefix . $this->propName1, 'set_property');
			$readOnlySession->logout();
			$this->fail('set_property permission granted to read-only Session');
		} catch (phpCR_AccessControlException $e) {
			// ok
		}

		try {
			$readOnlySession->checkPermission($pathPrefix . $this->nodeName2, 'remove');
			$readOnlySession->logout();
			$this->fail('remove permission granted to read-only Session');
		} catch (phpCR_AccessControlException $e) {
			// ok
		}

		$readOnlySession->logout();
	}

	/**
	 * Tests if <code>Session.checkPermission(String, String)</code> works
	 * properly: <ul> <li>Returns quietly if access is permitted.</li>
	 * <li>Throws an {@link java.security.AccessControlException} if access is
	 * denied.</li> </ul>
	 */
	public function testCheckPermissionReadWrite() {
		$this->testRootNode->addNode($this->nodeName2);
		$this->session->save();

		$pathPrefix = $this->testRootNode->getPath() . '/';
		try {
			$this->session->checkPermission($pathPrefix, 'read');
			$this->session->checkPermission($pathPrefix . $this->nodeName1, 'add_node');
			$this->session->checkPermission($pathPrefix . $this->propName1, 'set_property');
			$this->session->checkPermission($pathPrefix . $this->nodeName2, 'remove');
		} catch (phpCR_AccessControlException $e) {
			$this->fail('read/write access check failed, last exception '.$e->getMessage());
		} catch (phpCR_RepositoryException $e) {
			$this->fail('read/write access failed with '.$e->getMessage());
		}
	}

}