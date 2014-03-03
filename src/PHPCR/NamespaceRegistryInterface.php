<?php

namespace PHPCR;

/**
 * Defines an interface to implement a single namespace registry.
 *
 * Each repository has a single, persistent namespace registry represented by
 * the NamespaceRegistry object, accessed via WorkspaceInterface::getNamespaceRegistry().
 * The namespace registry contains the default prefixes of the registered
 * namespaces. The namespace registry may contain namespaces that are not used
 * in repository content, and there may be repository content with namespaces
 * that are not included n the registry.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. NamespaceRegistry has to implement either \IteratorAggregate
 * or \Iterator.
 * The iterator lets you iterate over all namespaces, with the prefixes as keys
 * and corresponding url as value.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NamespaceRegistryInterface extends \Traversable
{
    /**
     * A constant for the predefined namespace prefix "jcr".
     * @api
     */
    const PREFIX_JCR = "jcr";

    /**
     * A constant for the predefined namespace prefix "nt".
     * @api
     */
    const PREFIX_NT = "nt";

    /**
     * A constant for the predefined namespace prefix "sv"
     * @api
     */
    const PREFIX_SV = "sv";

    /**
     * A constant for the predefined namespace prefix "mix".
     * @api
     */
    const PREFIX_MIX = "mix";

    /**
     * A constant for the predefined namespace prefix "xml".
     * @api
     */
    const PREFIX_XML = "xml";

    /**
     * A constant for the predefined namespace prefix "" (the empty prefix).
     * @api
     */
    const PREFIX_EMPTY = "";

    /**
     * A constant for the predefined namespace mapped by default to the prefix "jcr"
     * @api
     */
    const NAMESPACE_JCR = "http://www.jcp.org/jcr/1.0";

    /**
     * A constant for the predefined namespace mapped by default to the prefix "nt"
     * @api
     */
    const NAMESPACE_NT = "http://www.jcp.org/jcr/nt/1.0";

    /**
     * A constant for the predefined namespace mapped by default to the prefix "sv"
     * @api
     */
    const NAMESPACE_SV = "http://www.jcp.org/jcr/sv/1.0";

    /**
     * A constant for the predefined namespace mapped by default to the prefix "mix"
     * @api
     */
    const NAMESPACE_MIX = "http://www.jcp.org/jcr/mix/1.0";

    /**
     * A constant for the predefined namespace mapped by default to the prefix "xml"
     * @api
     */
    const NAMESPACE_XML = "http://www.w3.org/XML/1998/namespace";

    /**
     * A constant for the predefined namespace mapped by default to the prefix "" (the empty prefix)
     * @api
     */
    const NAMESPACE_EMPTY = "";

    /**
     * Sets a one-to-one mapping between prefix and uri in the global namespace
     * registry of this repository.
     *
     * Assigning a new prefix to a URI that already exists in the namespace
     * registry erases the old prefix. In general this can almost always be
     * done, though an implementation is free to prevent particular
     * remappings by throwing a NamespaceException.
     *
     * On the other hand, taking a prefix that is already assigned to a URI
     * and re-assigning it to a new URI in effect unregisters that URI.
     * Therefore, the same restrictions apply to this operation as to
     * NamespaceRegistryInterface::unregisterNamespace():
     *
     * - Attempting to re-assign a built-in prefix (jcr, nt, mix, sv, xml,
     *   or the empty prefix) to a new URI will throw a
     *   NamespaceException.
     * - Attempting to register a namespace with a prefix that begins with
     *   the characters "xml" (in any combination of case) will throw a
     *   NamespaceException.
     * - An implementation may prevent the re-assignment of any other namespace
     *   prefixes for implementation-specific reasons by throwing a
     *   NamespaceException.
     *
     * @param string $prefix The prefix to be mapped.
     * @param string $uri    The URI to be mapped.
     *
     * @throws NamespaceException If an attempt is made to re-assign a
     *      built-in prefix to a new URI or, to register a namespace with a
     *      prefix that begins with the characters "xml" (in any combination of
     *      case) or an attempt is made to perform a prefix re-assignment that
     *      is forbidden for implementation-specific reasons.
     * @throws UnsupportedRepositoryOperationException if this
     *      repository does not support namespace registry changes.
     * @throws AccessDeniedException if the current session does not
     *      have sufficient access to register the namespace.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function registerNamespace($prefix, $uri);

    /**
     * Removes the specified namespace URI from namespace registry.
     *
     * The following restrictions apply:
     *
     * - Attempting to unregister a built-in namespace (jcr, nt, mix, sv, xml or
     *   the empty namespace) will throw a NamespaceException.
     * - An attempt to unregister a namespace that is not currently registered
     *   will throw a NamespaceException.
     * - An implementation may prevent the unregistering of any other namespace
     *   for implementation-specific reasons by throwing a
     *   NamespaceException.
     *
     * @param string $uri The URI to be removed.
     *
     * @throws NamespaceException unregister a built-in namespace or a
     *      namespace that is not currently registered or a namespace whose
     *      unregistration is forbidden for implementation-specific reasons.
     * @throws UnsupportedRepositoryOperationException if this
     *      repository does not support namespace registry changes.
     * @throws AccessDeniedException if the current session does not
     *      have sufficient access to unregister the namespace.
     * @throws RepositoryException if another error occurs.
     *
     * @api
     */
    public function unregisterNamespaceByURI($uri);

    /**
     * Returns an array with the keys being the namespace prefixes and the
     * values being the namespaces URIs.
     *
     * @return array a hashmap of prefix => namespace uri
     *
     * @since 2.1.1
     *
     * @api
     */
    public function getNamespaces();

    /**
     * Returns an array holding all currently registered namespace prefixes.
     *
     * @return array a string array
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function getPrefixes();

    /**
     * Returns an array holding all currently registered namespace URIs.
     *
     * @return array a string array
     *
     * @throws RepositoryException if an error occurs.
     *
     * @api
     */
    public function getURIs();

    /**
     * Returns the namespace URI to which the given prefix is mapped.
     *
     * @param string $prefix a string
     *
     * @return string a string
     *
     * @throws NamespaceException if a mapping with the specified prefix
     *      does not exist.
     * @throws RepositoryException if another error occurs
     *
     * @api
     */
    public function getURI($prefix);

    /**
     * Returns the prefix which is mapped to the given uri.
     *
     * @param string $uri a string
     *
     * @return string a string
     *
     * @throws NamespaceException if a mapping with the specified uri
     *      does not exist.
     * @throws RepositoryException if another error occurs
     *
     * @api
     */
    public function getPrefix($uri);
}
