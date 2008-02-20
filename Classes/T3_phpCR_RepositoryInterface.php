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

/**
 * A Repository interface
 *
 * @package		phpCR
 * @version 	$Id$
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface T3_phpCR_RepositoryInterface {

	const SPEC_VERSION_DESC = '2.0';
	const SPEC_NAME_DESC = 'Content Repository for Java Technology API';

	/**
	 * Authenticates the user using the supplied credentials.
	 * 
	 * If workspaceName is recognized as the name of an existing workspace in the
	 * repository and authorization to access that workspace is granted, then a new
	 * Session object is returned. The format of the string workspaceName depends
	 * upon the implementation.
	 * 
	 * If credentials is null, it is assumed that authentication is handled by a
	 * mechanism external to the repository itself (for example, through the JAAS
	 * framework) and that the repository implementation exists within a context
	 * (for example, an application server) that allows it to handle authorization of
	 * the request for access to the specified workspace. See 6.7 Access Control for
	 * more details.
	 * 
	 * If workspaceName is null, a default workspace is automatically selected by
	 * the repository implementation. This may, for example, be the "home
	 * workspace" of the user whose credentials were passed, though this is entirely
	 * up to the configuration and implementation of the repository. Alternatively,
	 * this may be a "null workspace" that serves only to provide the method
	 * Workspace.getAccessibleWorkspaceNames, allowing the client to select
	 * from among available "real" workspaces.
	 * 
	 * @param T3_phpCR_CredentialsInterface|null $credentials
	 * @param string|null $workspaceName
	 * @return T3_phpCR_SessionInterface
	 * @throws T3_phpCR_LoginException if authentication or authorization for the specified workspace fails
	 * @throws T3_phpCR_NoSuchWorkspaceException if workspaceName is not recognized
	 * @throws T3_phpCR_RepositoryException if another error occurs
	 */
	public function login($credentials = NULL, $workspaceName = NULL);

	/**
	 * Returns a string array holding all descriptor keys available for this
	 * implementation. This set must contain at least the built-in keys defined by
	 * the string constants in this interface (see below). Used in conjunction with
	 * Repository.getDescriptor(String name) to query information about this
	 * repository implementation.
	 *
	 * @return array
	 */
	public function getDescriptorKeys();

	/**
	 * Returns the descriptor for the specified key.
	 * Used to query information about this repository implementation.
	 * The set of available keys can be found by calling getDescriptorKeys.
	 * If the specified key is not found, null is returned.
	 *
	 * @param string $key The key to return the descriptor for
	 * @return string|null
	 */
	public function getDescriptor($key);
}

?>