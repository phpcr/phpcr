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
 * <code>RepositoryLoginTest</code> tests the login methods of a repository.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_RepositoryLoginTest extends phpCR_Test {

    private $credentials = NULL;

	public function setUp() {
		parent::setUp();
		$this->credentials	= $this->getReadOnlyCredentials();
		$this->workspaceName= $this->session->getWorkspace()->getName();
	}

    /**
     * Tests if {@link javax.jcr.Repository#login(Credentials credentials, String workspaceName)}
     * throws a {@link javax.jcr.NoSuchWorkspaceException}
     * if no workspace of the requested name is existing.
     */
    public function testNoSuchWorkspaceException() {
        $name = 'notExistingWorkspaceName';

        try {
            $this->repository->login($this->credentials, $name);
            $this->fail('login with a not available workspace name must throw a NoSuchWorkspaceException');
        } catch (phpCR_NoSuchWorkspaceException $e) {
            // success
        }
    }

    /**
     * Tests if {@link javax.jcr.Repository#login(Credentials credentials, String workspaceName)}
     * does return a session, i. e. not null.
     */
    public function testSignatureCredentialsAndWorkspaceName() {
        $s = $this->repository->login($this->credentials, $this->workspaceName);
        $this->assertNotNull($s, 'Repository->login(Credentials credentials, String workspaceName) must not return null');
        $s->logout();
    }

    /**
     * Tests if {@link javax.jcr.Repository#login(Credentials credentials)} does
     * return a session, i. e. not null.
     */
    public function testSignatureCredentials() {
        $s = $this->repository->login($this->credentials);
        $this->assertNotNull($s, 'Repository->login(Credentials credentials) must not return null');
        $s->logout();
    }
}

?>