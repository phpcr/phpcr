<?php
// $Id: NamespaceRegistry.interface.php 453 2005-08-20 02:56:48Z tswicegood $
/**
 * This file contains {@link NodeIterator} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170, and 
 * is licensed under the Apache License, Version 2.0.
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
 * {@link NamespaceRegistry} represents the global persistent namespace
 * registry of the phpCR Repository.
 *
 * @see Workspace::getNamespaceRegistry()
 *
 * @package phpContentRepository
 */
interface phpCR_NamespaceRegistry 
{
	/**
	 * Sets a one-to-one mapping between prefix and URI in the global namespace
	 * registry of this repository.
	 *
	 * Assigning a new prefix to a URI that already exists in the namespace 
	 * registry erases the old prefix.  In general this can almost always be
	 * done, though an implementation is free to prevent particular remappings 
	 * by throwing a {@link NamespaceException}.
	 *
	 * On the other hand, taking a prefix that is already assigned to a URI and
	 * re-assigning it to a new URI in effect unregisters that URI. Therefore, 
	 * the same restrictions apply to this operation as to
	 * {@link unregisterNamespace()}>:
	 * <ul>
	 *    <li>
	 *        Attempting to unregister a built-in namespace (<i>jcr</i>, 
	 *        <i>nt</i>, <i>mix</i>, <i>sv</i>, 
	 *        <i>xml</i> or the empty namespace) will throw a 
	 *        {@link NamespaceException}.
	 *    </li>
	 *    <li>
	 *        Attempting to unregister a namespace that is currently present in
	 *        content (either within an item name or within the value of a
	 *        <i>NAME</i> or <i>PATH</i> property) will throw a
	 *        {@link NamespaceException}. This includes prefixes in use within 
	 *        in-content node type  definitions.
	 *    </li>
	 *    <li>
	 *        An attempt to unregister a namespace that is not currently 
	 *        registered will throw a {@link NamespaceException}.
	 *    </li>
	 *    <li>
	 *        An implementation may prevent the unregistering of any other 
	 *        namespace for implementation-specific reasons by throwing a 
	 *        {@link NamespaceException}.
	 *    </li>
	 * </ul>
	 *
	 * @param string
	 *    The prefix to be mapped.
	 * @param string
	 *    The URI to be mapped.
	 *
	 * @throws {@link NamespaceException}
	 *    If an illegal attempt is made to register a mapping.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    In a level 1 implementation
	 * @throws {@link AccessDeniedException}
	 *    If the session associated with the {@link Workspace} object through 
	 *    which this registry was acquired does not have sufficient permissions
	 *    to register the namespace.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function registerNamespace($prefix, $uri);
	
	
	/**
	 * Removes a namespace mapping from the registry.
	 *
	 * The following restriction apply:
	 *
	 * <ul>
	 *    <li>
	 *        Attempting to unregister a built-in namespace (<i>jcr</i>, 
	 *        <i>nt</i>, <i>mix</i>, <i>sv</i>, 
	 *        <i>xml</i> or the empty namespace) will throw a 
	 *        {@link NamespaceException}.
	 *    </li>
	 *    <li>
	 *        Attempting to unregister a namespace that is currently present in
	 *        content (either within an item name or within the value of a
	 *        <i>NAME</i> or <i>PATH</i> property) will throw a
	 *        {@link NamespaceException}. This includes prefixes in use within 
	 *        in-content node type  definitions.
	 *    </li>
	 *    <li>
	 *        An attempt to unregister a namespace that is not currently 
	 *        registered will throw a {@link NamespaceException}.
	 *    </li>
	 *    <li>
	 *        An implementation may prevent the unregistering of any other 
	 *        namespace for implementation-specific reasons by throwing a 
	 *        {@link NamespaceException}.
	 *    </li>
	 * </ul>

	 *
	 * @param string
	 *    The prefix of the mapping to be removed.
	 *
	 * @throws {@link NamespaceException}
	 *    If an illegal attempt is made to remove a mapping.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    In a level 1 implementation
	 * @throws {@link AccessDeniedException}
	 *    If the session associated with the {@link Workspace} object through
	 *    which this registry was acquired does not have sufficient permissions
	 *    to unregister the namespace.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function unregisterNamespace($prefix);
	
	
	/**
	 * Returns an array holding all currently registered prefixes.
	 *
	 * @return array
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs
	 */
	public function getPrefixes();
	
	
	/**
	 * Returns an array holding all currently registered URIs.
	 *
	 * @return array
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs
	 */
	public function getURIs();
	
	
	/**
	 * Returns the URI to which the given $prefix is mapped.
	 *
	 * @param string
	 * @return string
	 *
	 * @throws {@link NamespaceException}
	 *    If the URI is unknown
	 * @throws {@link RepositoryException}
	 *    If another error occurs
	 */
	public function getURI($prefix);
	
	
	/**
	 * Returns the prefix to which the given $uri is mapped.
	 *
	 * @param string
	 * @return string
	 *
	 * @throws {@link NamespaceException}
	 *    If the URI is unknown
	 * @throws {@link RepositoryException}
	 *    If another error occurs
	 */
	public function getPrefix($uri);
}

?>