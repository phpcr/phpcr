<?php
// $Id: Repository.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link Repository} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 */


/**
 * The entry point into the content repository.
 *
 * @package phpContentRepository
 */
interface phpCR_Repository
{
	/**
	 * The descriptor key for the version of the specification
	 * that this repository implements.
	 */
	const SPEC_VERSION_DESC = "phpcr.specification.version";

	/**
	 * The descriptor key for the name of the specification
	 * that this repository implements.
	 */
	const SPEC_NAME_DESC = "phpcr.specification.name";

	/**
	 * The descriptor key for the name of the repository vendor.
	 */
	const REP_VENDOR_DESC = "phpcr.repository.vendor";

	/**
	 * The descriptor key for the URL of the repository vendor.
	 */
	const REP_VENDOR_URL_DESC = "phpcr.repository.vendor.url";

	/**
	 * The descriptor key for the name of this repository implementation.
	 */
	const REP_NAME_DESC = "phpcr.repository.name";

	/**
	 * The descriptor key for the version of this repository implementation.
	 */
	const REP_VERSION_DESC = "phpcr.repository.version";

	/**
	 * The presence of this key indicates that this implementation supports
	 * all level 1 features. This key will always be present.
	 */
	const LEVEL_1_SUPPORTED = "level.1.supported";

	/**
	 * The presence of this key indicates that this implementation supports
	 * all level 2 features.
	 */
	const LEVEL_2_SUPPORTED = "level.2.supported";

	/**
	 * The presence of this key indicates that this implementation supports 
	 * transactions.
	 */
	const OPTION_TRANSACTIONS_SUPPORTED = "option.transactions.supported";

	/**
	 * The presence of this key indicates that this implementation supports 
	 * versioning.
	 */
	const OPTION_VERSIONING_SUPPORTED = "option.versioning.supported";

	/**
	 * The presence of this key indicates that this implementation supports 
	 * observation.
	 */
	const OPTION_OBSERVATION_SUPPORTED = "option.observation.supported";

	/**
	 * The presence of this key indicates that this implementation supports 
	 * locking.
	 */
	const OPTION_LOCKING_SUPPORTED = "option.locking.supported";

	/**
	 * The presence of this key indicates that this implementation supports the 
	 * SQL query language.
	 */
	const OPTION_QUERY_SQL_SUPPORTED = "option.query.sql.supported";

	/**
	 * The presence of this key indicates that the index position notation for
	 * same-name siblings is supported within XPath queries.
	 */
	const QUERY_XPATH_POS_INDEX = "query.xpath.pos.index";

	/**
	 * The presence of this key indicates that XPath queries return results in 
	 * document order.
	 */
	const QUERY_XPATH_DOC_ORDER = "query.xpath.doc.order";
	
	/**
	 * Returns a string array holding all descriptor keys available for this 
	 * implementation.
	 *
	 * This set must contain at least the built-in keys defined by the string 
	 * constants in this interface.  It is used in conjunction with 
	 * {@link getDescriptor()} to query information about this repository 
	 * implementation.
	 *
	 * @return array
	 */
	public function getDescriptorKeys();
	
	
	/**
	 * Returns the descriptor for the specified key. 
	 *
	 * Used to query information about this repository implementation. The set 
	 * of available keys can be found by calling {@link getDescriptorKeys()}.
	 * If the specifed key is not found, <i>NULL</i> is returned.
	 *
	 * @param string
	 *    A string corresponding to a descriptor for this repository 
	 *    implementation.
	 * @return string|null
	 *    A descriptor string or null if unavailable
	 */
	public function getDescriptor($key);


	/**
	 * Authenticates the user using the supplied <i>credentials</i>.
	 *
	 * If <i>$workspaceName</i> is recognized as the name of an existing
	 * workspace in the repository and authorization to access that workspace 
	 * is granted, then a new {@link Session} object is returned.  The format 
	 * of the string <i>$workspaceName</i> depends upon the 
	 * implementation.
	 *
	 * If <i>$credentials</i> is <i>NULL</i>, it is assumed that 
	 * authentication is handled by a mechanism external to the repository 
	 * itself (for example, through the JAAS framework) and that the repository 
	 * implementation exists within a context (for example, an application 
	 * server) that allows it to handle authorization of the request for 
	 * access to the specified workspace.
	 *
	 * If <i>$workspaceName</i> is <i>NULL</i>, a default workspace
	 * is automatically selected by the repository implementation.  This may,
	 * for example, be the "home workspace" of the user whose credentials were 
	 * passed, though this is entirely up to the configuration and 
	 * implementation of the repository.  Alternatively, it may be a 
	 * "null workspace" that serves only to provide the method 
	 * {@link Workspace::getAccessibleWorkspaceNames()}, allowing the client 
	 * to select from among available "real" workspaces.
	 *
	 * <b>PHP Note</b>: As <i>$credentials</i> can be left 
	 * <i>NULL</i>, no type hinting is done.  It is incumbent upon the
	 * implementation to check for the proper type prior to executing.
	 *
	 * @param object|null
	 *	A {@link Credentials} object or null
	 * @param string|null 
	 *    The name of a workspace or null
	 * @return object
	 *	A {@link Session} object
	 *    A valid session for the user to access the repository.
	 *
	 * @throws {@link LoginException}
	 *      If the login fails.
	 * @throws {@link NoSuchWorkspaceException}
	 *     If the specified <i>$workspaceName</i> is not recognized.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function login($credentials=NULL, $workspaceName=NULL);
}

?>