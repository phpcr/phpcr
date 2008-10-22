<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR;

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
 * Each repository has a single, persistent namespace registry represented by
 * the NamespaceRegistry object, accessed via Workspace.getNamespaceRegistry().
 * The namespace registry contains the default prefixes of the registered
 * namespaces. The namespace registry may contain namespaces that are not used
 * in repository content, and there may be repository content with namespaces
 * that are not included n the registry.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface NamespaceRegistryInterface {

	/**
	 * A constant for the predefined namespace prefix "jcr".
	 */
	const PREFIX_JCR = "jcr";

	/**
	 * A constant for the predefined namespace prefix "nt".
	 */
	const PREFIX_NT = "nt";

	/**
	 * A constant for the predefined namespace prefix "mix".
	 */
	const PREFIX_MIX = "mix";

	/**
	 * A constant for the predefined namespace prefix "xml".
	 */
	const PREFIX_XML = "xml";

	/**
	 * A constant for the predefined namespace prefix "" (the empty prefix).
	 */
	const PREFIX_EMPTY = "";

	/**
	 * A constant for the predefined namespace mapped by default to the prefix "jcr"
	 */
	const NAMESPACE_JCR = "http://www.jcp.org/jcr/1.0";

	/**
	 * A constant for the predefined namespace mapped by default to the prefix "nt"
	 */
	const NAMESPACE_NT = "http://www.jcp.org/jcr/nt/1.0";

	/**
	 * A constant for the predefined namespace mapped by default to the prefix "mix"
	 */
	const NAMESPACE_MIX = "http://www.jcp.org/jcr/mix/1.0";

	/**
	 * A constant for the predefined namespace mapped by default to the prefix "xml"
	 */
	const NAMESPACE_XML = "http://www.w3.org/XML/1998/namespace";

	/**
	 * A constant for the predefined namespace mapped by default to the prefix "" (the empty prefix)
	 */
	const NAMESPACE_EMPTY = "";

	/**
	 * Sets a one-to-one mapping between prefix and uri in the global namespace
	 * registry of this repository.
	 * Assigning a new prefix to a URI that already exists in the namespace
	 * registry erases the old prefix. In general this can almost always be
	 * done, though an implementation is free to prevent particular
	 * remappings by throwing a NamespaceException.
	 *
	 * On the other hand, taking a prefix that is already assigned to a URI
	 * and re-assigning it to a new URI in effect unregisters that URI.
	 * Therefore, the same restrictions apply to this operation as to
	 * NamespaceRegistry.unregisterNamespace:
	 * * Attempting to re-assign a built-in prefix (jcr, nt, mix, sv, xml,
	 *   or the empty prefix) to a new URI will throw a
	 *   F3::PHPCR::NamespaceException.
	 * * Attempting to register a namespace with a prefix that begins with
	 *   the characters "xml" (in any combination of case) will throw a
	 *   F3::PHPCR::NamespaceException.
	 * * An implementation may prevent the re-assignment of any other namespace
	 *   prefixes for implementation-specific reasons by throwing a
	 *   F3::PHPCR::NamespaceException.
	 *
	 * @param string $prefix The prefix to be mapped.
	 * @param string $uri The URI to be mapped.
	 * @return void
	 * @throws F3::PHPCR::NamespaceException if an illegal attempt is made to register a mapping.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException in a level 1 implementation
	 * @throws F3::PHPCR::AccessDeniedException if the session associated with the Workspace object through which this registry was acquired does not have sufficient permissions to register the namespace.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 * */
	public function registerNamespace($prefix, $uri);


	/**
	 * Removes a namespace mapping from the registry. The following restriction
	 * apply:
	 * * Attempting to unregister a built-in namespace (jcr, nt, mix, sv, xml or
	 *   the empty namespace) will throw a F3::PHPCR::NamespaceException.
	 * * An attempt to unregister a namespace that is not currently registered
	 *   will throw a F3::PHPCR::NamespaceException.
	 * * An implementation may prevent the unregistering of any other namespace
	 *   for implementation-specific reasons by throwing a
	 *   F3::PHPCR::NamespaceException.
	 *
	 * @param string $prefix The prefix of the mapping to be removed.
	 * @return void
	 * @throws F3::PHPCR::NamespaceException if an illegal attempt is made to remove a mapping.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException in a level 1 implementation
	 * @throws F3::PHPCR::AccessDeniedException if the session associated with the Workspace object through which this registry was acquired does not have sufficient permissions to unregister the namespace.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 * */
	public function unregisterNamespace($prefix);

	/**
	 * Returns an array holding all currently registered prefixes.
	 *
	 * @return array a string array
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 * */
	public function getPrefixes();

	/**
	 * Returns an array holding all currently registered URIs.
	 *
	 * @return array a string array
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 * */
	public function getURIs();

	/**
	 * Returns the URI to which the given prefix is mapped.
	 *
	 * @param $prefix a string
	 * @return string a string
	 * @throws F3::PHPCR::NamespaceException if a mapping with the specified prefix does not exist.
	 * @throws F3::PHPCR::RepositoryException is another error occurs
	 * */
	public function getURI($prefix);

	/**
	 * Returns the prefix which is mapped to the given uri.
	 *
	 * @param string $uri a string
	 * @return string a string
	 * @throws F3::PHPCR::NamespaceException if a mapping with the specified uri does not exist.
	 * @throws F3::PHPCR::RepositoryException is another error occurs
	 * */
	public function getPrefix($uri);

}

?>