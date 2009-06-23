<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
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
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface RepositoryInterface {

	/**
	 * The descriptor key for the version of the specification
	 * that this repository implements. For JCR 2.0
	 * the value of this descriptor is the string "2.0".
	 */
	const SPEC_VERSION_DESC = "jcr.specification.version";

	/**
	 * The descriptor key for the name of the specification
	 * that this repository implements. For JCR 2.0
	 * the value of this descriptor is the string "Content Repository for
	 * Java Technology API".
	 */
	const SPEC_NAME_DESC = "jcr.specification.name";

	/**
	 * The descriptor key for the name of the repository vendor.
	 * The descriptor returned for this key is a String.
	 */
	const REP_VENDOR_DESC = "jcr.repository.vendor";

	/**
	 * The descriptor key for the URL of the repository vendor.
	 * The descriptor returned for this key is a String.
	 */
	const REP_VENDOR_URL_DESC = "jcr.repository.vendor.url";

	/**
	 * The descriptor key for the name of this repository implementation.
	 * The descriptor returned for this key is a String.
	 */
	const REP_NAME_DESC = "jcr.repository.name";

	/**
	 * The descriptor key for the version of this repository implementation.
	 * The descriptor returned for this key is a String.
	 */
	const REP_VERSION_DESC = "jcr.repository.version";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if repository content can be updated through the JCR API
	 * (as opposed to having read-only access).
	 */
	const WRITE_SUPPORTED = "write.supported";

	/**
	 * Key to a String descriptor. Returns one of the following
	 * javax.jcr.Repository constants indicating the stability
	 * of identifiers:
	 *
	 * IDENTIFIER_STABILITY_METHOD_DURATION - Identifiers may change between method calls.
	 * IDENTIFIER_STABILITY_SAVE_DURATION - Identifers are guaranteed stable within a single save/refresh cycle.
	 * IDENTIFIER_STABILITY_SESSION_DURATION - Identifiers are guaranteed stable within a single session.
	 * IDENTIFIER_STABILITY_INDEFINITE_DURATION - Identifers are guaranteed to be stable forever.
	 */
	const IDENTIFIER_STABILITY = "identifier.stability";

	/**
	 * One of four possible values for the descriptor IDENTIFIER_STABILITY.
	 * Indicates that identifiers may change between method calls.
	 */
	const IDENTIFIER_STABILITY_METHOD_DURATION = "identifier.stability.method.duration";

	/**
	 * One of four possible values for the descriptor IDENTIFIER_STABILITY.
	 * Indicates that identifiers are guaranteed stable within a single save/refresh cycle.
	 */
	const IDENTIFIER_STABILITY_SAVE_DURATION = "identifier.stability.save.duration";

	/**
	 * One of four possible values for the descriptor IDENTIFIER_STABILITY.
	 * Indicates that identifiers are guaranteed stable within a single session.
	 */
	const IDENTIFIER_STABILITY_SESSION_DURATION = "identifier.stability.session.duration";

	/**
	 * One of four possible values for the descriptor IDENTIFIER_STABILITY.
	 * Indicates that identifiers are guaranteed to be stable forever.
	 */
	const IDENTIFIER_STABILITY_INDEFINITE_DURATION = "identifier.stability.indefinite.duration";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if XML export is supported.
	 */
	const OPTION_XML_EXPORT_SUPPORTED = "option.xml.export.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if XML import is supported.
	 */
	const OPTION_XML_IMPORT_SUPPORTED = "option.xml.import.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if unfiled content is supported.
	 */
	const OPTION_UNFILED_CONTENT_SUPPORTED = "option.unfiled.content.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if full versioning is supported.
	 */
	const OPTION_VERSIONING_SUPPORTED = "option.versioning.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if simple versioning is supported.
	 */
	const OPTION_SIMPLE_VERSIONING_SUPPORTED = "option.simple.versioning.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE if and only if activities are
	 * supported.
	 */
	const OPTION_ACTIVITIES_SUPPORTED = "option.activities.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE if and only if configurations
	 * and baselines are supported.
	 */
	const OPTION_BASELINES_SUPPORTED = "option.baselines.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if access control is supported.
	 */
	const OPTION_ACCESS_CONTROL_SUPPORTED = "option.access.control.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if locking is supported.
	 */
	const OPTION_LOCKING_SUPPORTED = "option.locking.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if asynchronous observation is supported.
	 */
	const OPTION_OBSERVATION_SUPPORTED = "option.observation.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if journaled observation is supported.
	 */
	const OPTION_JOURNALED_OBSERVATION_SUPPORTED = "option.journaled.observation.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if retention and hold are supported.
	 */
	const OPTION_RETENTION_SUPPORTED = "option.retention.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if lifecycles are supported.
	 */
	const OPTION_LIFECYCLE_SUPPORTED = "option.lifecycle.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if transactions are supported.
	 */
	const OPTION_TRANSACTIONS_SUPPORTED = "option.transactions.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if workspace management is supported.
	 */
	const OPTION_WORKSPACE_MANAGEMENT_SUPPORTED = "option.workspace.management.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if the primary node type of an existing node can be updated.
	 */
	const OPTION_UPDATE_PRIMARY_NODETYPE_SUPPORTED = "option.update.primary.nodetype.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if the mixin node types of an existing node can be added and removed.
	 */
	const OPTION_UPDATE_MIXIN_NODETYPES_SUPPORTED = "option.update.mixin.nodetypes.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if the creation of shareable nodes is supported.
	 */
	const OPTION_SHAREABLE_NODES_SUPPORTED = "option.shareable.nodes.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if node type management is supported.
	 */
	const OPTION_NODE_TYPE_MANAGEMENT_SUPPORTED = "option.node.type.management.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE if and only if node and
	 * property with same name is supported.
	 */
	const OPTION_NODE_AND_PROPERTY_WITH_SAME_NAME_SUPPORTED = "option.node.and.property.with.same.name.supported";

	/**
	 * Key to string descriptor. Returns one of the following
	 * javax.jcr.Repository constants indicating the level of
	 * support for node type inheritance:
	 *
	 * NODE_TYPE_MANAGEMENT_INHERITANCE_MINIMAL
	 *   Registration of primary node types is limited to those which have only
	 *   nt:base as supertype. Registration of mixin node types is limited to
	 *   those without any supertypes.
	 *
	 * NODE_TYPE_MANAGEMENT_INHERITANCE_SINGLE
	 *   Registration of primary node types is limited to those with exactly one
	 *   supertype. Registration of mixin node types is limited to those with at
	 *   most one supertype.
	 *
	 * NODE_TYPE_MANAGEMENT_INHERITANCE_MULTIPLE
	 *   Primary node types can be registered with one or more supertypes. Mixin node
	 *   types can be registered with zero or more supertypes.
	 */
	const NODE_TYPE_MANAGEMENT_INHERITANCE = "node.type.management.inheritance";

	/**
	 * One of three possible values for the descriptor NODE_TYPE_MANAGEMENT_INHERITANCE.
	 * Indicates that registration of primary node types is limited to those which have only nt:base
	 * as supertype. Registration of mixin node types is limited to those without any supertypes.
	 */
	const NODE_TYPE_MANAGEMENT_INHERITANCE_MINIMAL = "node.type.management.inheritance.minimal";

	/**
	 * One of three possible values for the descriptor NODE_TYPE_MANAGEMENT_INHERITANCE.
	 * Indicates that registration of primary node types is limited to those with exactly one supertype.
	 * Registration of mixin node types is limited to those with at most one supertype.
	 */
	const NODE_TYPE_MANAGEMENT_INHERITANCE_SINGLE = "node.type.management.inheritance.single";

	/**
	 * One of three possible values for the descriptor NODE_TYPE_MANAGEMENT_INHERITANCE.
	 * Indicates that primary node types can be registered with one or more supertypes.
	 * Mixin node types can be registered with zero or more supertypes.
	 */
	const NODE_TYPE_MANAGEMENT_INHERITANCE_MULTIPLE = "node.type.management.inheritance.multiple";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if override of inherited property or child node definitions is supported.
	 */
	const NODE_TYPE_MANAGEMENT_OVERRIDES_SUPPORTED = "node.type.management.overrides.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if primary items are supported.
	 */
	const NODE_TYPE_MANAGEMENT_PRIMARY_ITEM_NAME_SUPPORTED = "node.type.management.primary.item.name.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if preservation of child node ordering is supported.
	 */
	const NODE_TYPE_MANAGEMENT_ORDERABLE_CHILD_NODES_SUPPORTED = "node.type.management.orderable.child.nodes.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if residual property and child node definitions are supported.
	 */
	const NODE_TYPE_MANAGEMENT_RESIDUAL_DEFINITIONS_SUPPORTED = "node.type.management.residual.definitions.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if autocreated properties and child nodes are supported.
	 */
	const NODE_TYPE_MANAGEMENT_AUTOCREATED_DEFINITIONS_SUPPORTED = "node.type.management.autocreated.definitions.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if same-name sibling child nodes are supported.
	 */
	const NODE_TYPE_MANAGEMENT_SAME_NAME_SIBLINGS_SUPPORTED = "node.type.management.same.name.siblings.supported";

	/**
	 * Key to an integer[] descriptor. Returns an array holding the
	 * javax.jcr.PropertyType constants for the property types
	 * (including UNDEFINED, if supported) that a registered node
	 * type can specify, or a zero-length array if registered node types cannot
	 * specify property definitions.
	 */
	const NODE_TYPE_MANAGEMENT_PROPERTY_TYPES = "node.type.management.property.types";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if multivalue properties are supported.
	 */
	const NODE_TYPE_MANAGEMENT_MULTIVALUED_PROPERTIES_SUPPORTED = "node.type.management.multivalued.properties.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if registration of a node types with more than one BINARY
	 * property is permitted.
	 */
	const NODE_TYPE_MANAGEMENT_MULTIPLE_BINARY_PROPERTIES_SUPPORTED = "node.type.management.multiple.binary.properties.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only value-constraints are supported.
	 */
	const NODE_TYPE_MANAGEMENT_VALUE_CONSTRAINTS_SUPPORTED = "node.type.management.value.constraints.supported";

	/**
	 * Key to a string[] descriptor. Returns an array holding the
	 * constants representing the supported query languages, or a zero-length
	 * if query is not supported.
	 */
	const QUERY_LANGUAGES = "query.languages";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if stored queries are supported.
	 */
	const QUERY_STORED_QUERIES_SUPPORTED = "query.stored.queries.supported";

	/**
	 * Key to a boolean descriptor. Returns TRUE
	 * if and only if full-text search is supported.
	 */
	const QUERY_FULL_TEXT_SEARCH_SUPPORTED = "query.full.text.search.supported";

	/**
	 * Key to String descriptor. Returns one of the following
	 * javax.jcr.Repository constants indicating the level of
	 * support for joins in queries:
	 *
	 * QUERY_JOINS_NONE - Joins are not supported. Queries are limited to a single selector.
	 * QUERY_JOINS_INNER - Inner joins are supported.
	 * QUERY_JOINS_INNER_OUTER - Inner and outer joins are supported.
	 */
	const QUERY_JOINS = "query.joins";

	/**
	 * One of three possible values for the descriptor QUERY_JOINS .
	 * Indicates that joins are not supported. Queries are limited to a single selector.
	 */
	const QUERY_JOINS_NONE = "query.joins.none";

	/**
	 * One of three possible values for the descriptor QUERY_JOINS .
	 * Indicates that inner joins are supported.
	 */
	const QUERY_JOINS_INNER = "query.joins.inner";

	/**
	 * One of three possible values for the descriptor QUERY_JOINS .
	 * Indicates that inner and outer joins are supported.
	 */
	const QUERY_JOINS_INNER_OUTER = "query.joins.inner.outer";

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
	 * @param \F3\PHPCR\CredentialsInterface $credentials The credentials of the user
	 * @param string $workspaceName the name of a workspace
	 * @return \F3\PHPCR\SessionInterface a valid session for the user to access the repository
	 * @throws \F3\PHPCR\LoginException if authentication or authorization (for the specified workspace) fails
	 * @throws \F3\PHPCR\NoSuchWorkspacexception if the specified workspaceName is not recognized
	 * @throws \F3\PHPCR\RepositoryException if another error occurs
	 */
	public function login($credentials = NULL, $workspaceName = NULL);

	/**
	 * Returns a string array holding all descriptor keys available for this
	 * implementation, both the standard descriptors defined by the string
	 * constants in this interface and any implementation-specific descriptors.
	 * Used in conjunction with getDescriptorValue($key) and getDescriptorValues($key)
	 * to query information about this repository implementation.
	 *
	 * @return array a string array holding all descriptor keys
	 */
	public function getDescriptorKeys();

	/**
	 * Returns TRUE if $key is a standard descriptor
	 * defined by the string constants in this interface and FALSE if it is
	 * either a valid implementation-specific key or not a valid key.
	 *
	 * @param string $key a descriptor key.
	 * @return boolan whether $key is a standard descriptor.
	 */
	public function isStandardDescriptor($key);

	/**
	 * Returns TRUE if $key is a valid single-value descriptor;
	 * otherwise returns FALSE.
	 *
	 * @param string $key a descriptor key.
	 * @return boolean whether the specified descriptor is multi-valued.
	 */
	public function isSingleValueDescriptor($key);

	/**
	 * The value of a single-value descriptor is found by
	 * passing the key for that descriptor to this method.
	 * If $key is the key of a multi-value descriptor
	 * or not a valid key this method returns NULL.
	 *
	 * @param string $key a descriptor key.
	 * @return \F3\PHPCR\ValueInterface The value of the indicated descriptor
	 */
	public function getDescriptorValue($key);

	/**
	 * The value array of a multi-value descriptor is found by
	 * passing the key for that descriptor to this method.
	 * If $key is the key of a single-value descriptor
	 * then this method returns that value as an array of size one.
	 * If $key is not a valid key this method returns NULL.
	 *
	 * @param string $key a descriptor key.
	 * @return array of \F3\PHPCR\ValueInterface the value array for the indicated descriptor
	 */
	public function getDescriptorValues($key);

	/**
	 * A convenience method. The call
	 *  String s = repository.getDescriptor(key);
	 * is equivalent to
	 *  Value v = repository.getDescriptor(key);
	 *  String s = (v == null) ? null : v.getString();
	 *
	 * @param key a descriptor key.
	 * @return a descriptor value in string form.
	 */
	public function getDescriptor($key);

}

?>