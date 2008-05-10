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
 * Tests if {@link Session#impersonate(Credentials)} to a read-only session
 * respects access controls.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_ImpersonateTest extends phpCR_Test {

    /**
     * Tests if <code>Session->impersonate(Credentials)</code> works properly
     */
    public function testImpersonate() {
        // impersonate to read-only user
        try {
            $session = $this->session->impersonate($this->getReadOnlyCredentials());
        } catch (phpCR_LoginException $e) {
            $this->fail('impersonate threw LoginException');
        }

        // get a path to test the permissions on
        $thePath = '';
        $ni = $session->getRootNode()->getNodes();
        while ($ni->hasNext()) {
            $n = $ni->nextNode();
            if ($n->getPath() != '/' . $this->jcrSystem) {
                $thePath = $n->getPath();
                break;
            }
        }

        // check that all 4 permissions are granted/denied correctly
        $session->checkPermission($thePath, 'read');

        try {
            $session->checkPermission($thePath . '/' . $this->nodeName1, 'add_node');
            $this->fail('add_node permission on ' . $thePath . '/' . $this->nodeName1 . ' granted to read-only Session');
        } catch (phpCR_AccessControlException $e) {
            // ok
        }

        try {
            $session->checkPermission($thePath . '/' . $this->propName1, 'set_property');
            $this->fail('set_property permission on ' . $thePath . '/' . $this->propName1 . ' granted to read-only Session');
        } catch (phpCR_AccessControlException $e) {
            // ok
        }

        try {
            $session->checkPermission($thePath, 'remove');
            $this->fail('remove permission on ' . $thePath . ' granted to read-only Session');
        } catch (phpCR_AccessControlException $e) {
            // ok
        }

        $session->logout();
    }
}
?>