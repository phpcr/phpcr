<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

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
 *
 * @package phpcr
 * @subpackage interfaces
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
     *   \PHPCR\NamespaceException.
     * - Attempting to register a namespace with a prefix that begins with
     *   the characters "xml" (in any combination of case) will throw a
     *   \PHPCR\NamespaceException.
     * - An implementation may prevent the re-assignment of any other namespace
     *   prefixes for implementation-specific reasons by throwing a
     *   \PHPCR\NamespaceException.
     *
     * @param string $prefix The prefix to be mapped.
     * @param string $uri The URI to be mapped.
     *
     * @return void
     *
     * @throws \PHPCR\NamespaceException If an attempt is made to re-assign a
     *      built-in prefix to a new URI or, to register a namespace with a
     *      prefix that begins with the characters "xml" (in any combination of
     *      case) or an attempt is made to perform a prefix re-assignment that
     *      is forbidden for implementation-specific reasons.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      repository does not support namespace registry changes.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to register the namespace.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function registerNamespace($prefix, $uri);

    /**
     * Removes a namespace mapping from the registry.
     *
     * The following restrictions apply:
     *
     * - Attempting to unregister a built-in namespace (jcr, nt, mix, sv, xml or
     *   the empty namespace) will throw a \PHPCR\NamespaceException.
     * - An attempt to unregister a namespace that is not currently registered
     *   will throw a \PHPCR\NamespaceException.
     * - An implementation may prevent the unregistering of any other namespace
     *   for implementation-specific reasons by throwing a
     *   \PHPCR\NamespaceException.
     *
     * @param string $prefix The prefix of the mapping to be removed.
     *
     * @return void
     *
     * @throws \PHPCR\NamespaceException unregister a built-in namespace or a
     *      namespace that is not currently registered or a namespace whose
     *      unregistration is forbidden for implementation-specific reasons.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this
     *      repository does not support namespace registry changes.
     * @throws \PHPCR\AccessDeniedException if the current session does not
     *      have sufficient access to unregister the namespace.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function unregisterNamespace($prefix);

    /**
     * Returns an array holding all currently registered namespace prefixes.
     *
     * @return array a string array
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getPrefixes();

    /**
     * Returns an array holding all currently registered namespace URIs.
     *
     * @return array a string array
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getURIs();

    /**
     * Returns the namespace URI to which the given prefix is mapped.
     *
     * @param string $prefix a string
     *
     * @return string a string
     *
     * @throws \PHPCR\NamespaceException if a mapping with the specified prefix
     *      does not exist.
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getURI($prefix);

    /**
     * Returns the prefix which is mapped to the given uri.
     *
     * @param string $uri a string
     *
     * @return string a string
     *
     * @throws \PHPCR\NamespaceException if a mapping with the specified uri
     *      does not exist.
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getPrefix($uri);
}
