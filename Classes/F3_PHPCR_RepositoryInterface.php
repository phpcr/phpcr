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
 * @package PHPCR
 * @version $Id$
 */

/**
 * The entry point into the content repository. The Repository object is
 * usually acquired through the RepositoryFactory.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_RepositoryInterface {

	const LEVEL_1_SUPPORTED = 'level.1.supported';
	const LEVEL_2_SUPPORTED = 'level.2.supported';
	const OPTION_ACTIVITIES_SUPPORTED = 'option.activities.supported';
	const OPTION_BASELINES_SUPPORTED = 'option.baselines.supported';
	const OPTION_FULL_ACCESS_CONTROL_SUPPORTED = 'option.full.access.control.supported';
	const OPTION_JOURNALED_OBSERVATION_SUPPORTED = 'option.journaled.observation.supported';
	const OPTION_LIFECYCLE_SUPPORTED = 'option.lifecycle.supported';
	const OPTION_LOCKING_SUPPORTED = 'option.locking.supported';
	const OPTION_NODE_TYPE_REG_SUPPORTED = 'option.node.type.reg.supported';
	const OPTION_OBSERVATION_SUPPORTED = 'option.observation.supported';
	const OPTION_QUERY_SQL_SUPPORTED = 'option.query.sql.supported';
	const OPTION_SIMPLE_ACCESS_CONTROL_SUPPORTED = 'option.simple.access.control.supported';
	const OPTION_SIMPLE_VERSIONING_SUPPORTED = 'option.simple.versioning.supported';
	const OPTION_TRANSACTIONS_SUPPORTED = 'option.transactions.supported';
	const OPTION_VERSIONING_SUPPORTED = 'option.versioning.supported';
	const REP_NAME_DESC = 'jcr.repository.name';
	const REP_VENDOR_DESC = 'jcr.repository.vendor';
	const REP_VENDOR_URL_DESC = 'jcr.repository.vendor.url';
	const REP_VERSION_DESC = 'jcr.repository.version';
	const SPEC_NAME_DESC = 'jcr.specification.name';
	const SPEC_VERSION_DESC = 'jcr.specification.versioning';

	/**
	 * Authenticates the user using the supplied credentials. If workspaceName is recognized as the
	 * name of an existing workspace in the repository and authorization to access that workspace
	 * is granted, then a new Session object is returned. The format of the string workspaceName
	 * depends upon the implementation.
	 * If credentials is null, it is assumed that authentication is handled by a mechanism external
	 * to the repository itself and that the repository implementation exists within a context
	 * (for example, an application server) that allows it to handle authorization of the request
	 * for access to the specified workspace.
	 *
	 * If workspaceName is null, a default workspace is automatically selected by the repository
	 * implementation. This may, for example, be the "home workspace" of the user whose credentials
	 * were passed, though this is entirely up to the configuration and implementation of the
	 * repository. Alternatively, it may be a "null workspace" that serves only to provide the
	 * method Workspace.getAccessibleWorkspaceNames(), allowing the client to select from among
	 * available "real" workspaces.
	 *
	 * @param F3_PHPCR_CredentialsInterface $credentials The credentials of the user
	 * @param string $workspaceName the name of a workspace
	 * @return F3_PHPCR_SessionInterface a valid session for the user to access the repository
	 * @throws F3_PHPCR_LoginException If the login fails
	 * @throws F3_PHPCR_NoSuchWorkspacexception If the specified workspaceName is not recognized
	 * @throws F3_PHPCR_RepositoryException if another error occurs
	 */
	public function login($credentials = NULL, $workspaceName = NULL);

	/**
	 * Returns a string array holding all descriptor keys available for this
	 * implementation. This set must contain at least the built-in keys
	 * defined by the string constants in this interface. Used in conjunction
	 * with getDescriptor(String name) to query information about this
	 * repository implementation.
	 *
	 * @return array a string array holding all descriptor keys
	 */
	public function getDescriptorKeys();

	/**
	 * Returns the descriptor for the specified key. Used to query information
	 * about this repository implementation. The set of available keys can be
	 * found by calling getDescriptorKeys(). If the specified key is not found,
	 * null is returned.
	 *
	 * @param string $key a string corresponding to a descriptor for this repository implementation.
	 * @return string a descriptor string or NULL if not found
	 */
	public function getDescriptor($key);
}

?>