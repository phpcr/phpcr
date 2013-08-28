<?php

namespace PHPCR;

/**
 * The entry point into the content repository.
 *
 * The Repository object is usually acquired through an implementation of the
 * RepositoryFactoryInterface.
 *
 * <strong>PHPCR Note:</strong> This interface has been simplified compared to
 * JCR:
 *
 * - getDescriptor returns array on multivalue, single variable otherwise
 * - removed isSingleValueDescriptor
 * - removed getDescriptorValue and getDescriptorValues as ValueInterface has
 *      been dropped. Use getDescriptor to get the variable value.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface RepositoryInterface
{
    /**#@+
     * @var string
     */

    /**
     * The descriptor key for the version of the specification this repository
     * implements.
     *
     * For JCR 2.0 the value of this descriptor is the string "2.0".
     *
     * @api
     */
    const SPEC_VERSION_DESC = "jcr.specification.version";

    /**
     * The descriptor key for the name of the specification this repository
     * implements.
     *
     * For JCR 2.0 the value of this descriptor is the string "Content
     * Repository for Java Technology API".
     *
     * @api
     */
    const SPEC_NAME_DESC = "jcr.specification.name";

    /**
     * The descriptor key for the name of the repository vendor.
     *
     * The descriptor returned for this key is a String.
     *
     * @api
     */
    const REP_VENDOR_DESC = "jcr.repository.vendor";

    /**
     * The descriptor key for the URL of the repository vendor.
     *
     * The descriptor returned for this key is a String.
     *
     * @api
     */
    const REP_VENDOR_URL_DESC = "jcr.repository.vendor.url";

    /**
     * The descriptor key for the name of this repository implementation.
     *
     * The descriptor returned for this key is a String.
     *
     * @api
     */
    const REP_NAME_DESC = "jcr.repository.name";

    /**
     * The descriptor key for the version of this repository implementation.
     *
     * The descriptor returned for this key is a String.
     *
     * @api
     */
    const REP_VERSION_DESC = "jcr.repository.version";

    /**
     * Key to a boolean descriptor. Returns true if and only if repository
     * content can be updated through the JCR API (as opposed to having
     * read-only access).
     *
     * @api
     */
    const WRITE_SUPPORTED = "write.supported";

    /**
     * Key to a String descriptor. Returns one of the following
     * RepositoryInterface constants indicating the stability of identifiers:
     *
     * - IDENTIFIER_STABILITY_METHOD_DURATION - Identifiers may change between
     *      method calls.
     * - IDENTIFIER_STABILITY_SAVE_DURATION - Identifiers are guaranteed stable
     *      within a single save/refresh cycle.
     * - IDENTIFIER_STABILITY_SESSION_DURATION - Identifiers are guaranteed
     *      stable within a single session.
     * - IDENTIFIER_STABILITY_INDEFINITE_DURATION - Identifiers are guaranteed
     *      to be stable forever.
     *
     * @api
     */
    const IDENTIFIER_STABILITY = "identifier.stability";

    /**
     * One of four possible values for the descriptor IDENTIFIER_STABILITY.
     * Indicates that identifiers may change between method calls.
     *
     * @api
     */
    const IDENTIFIER_STABILITY_METHOD_DURATION = "identifier.stability.method.duration";

    /**
     * One of four possible values for the descriptor IDENTIFIER_STABILITY.
     * Indicates that identifiers are guaranteed stable within a single
     * save/refresh cycle.
     *
     * @api
     */
    const IDENTIFIER_STABILITY_SAVE_DURATION = "identifier.stability.save.duration";

    /**
     * One of four possible values for the descriptor IDENTIFIER_STABILITY.
     * Indicates that identifiers are guaranteed stable within a single
     * session.
     *
     * @api
     */
    const IDENTIFIER_STABILITY_SESSION_DURATION = "identifier.stability.session.duration";

    /**
     * One of four possible values for the descriptor IDENTIFIER_STABILITY.
     * Indicates that identifiers are guaranteed to be stable forever.
     *
     * @api
     */
    const IDENTIFIER_STABILITY_INDEFINITE_DURATION = "identifier.stability.indefinite.duration";

    /**
     * Key to a boolean descriptor. Returns true if and only if XML export is
     * supported.
     *
     * @api
     */
    const OPTION_XML_EXPORT_SUPPORTED = "option.xml.export.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if XML import is
     * supported.
     *
     * @api
     */
    const OPTION_XML_IMPORT_SUPPORTED = "option.xml.import.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if unfiled content
     * is supported.
     *
     * @api
     */
    const OPTION_UNFILED_CONTENT_SUPPORTED = "option.unfiled.content.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if full versioning
     * is supported.
     *
     * @api
     */
    const OPTION_VERSIONING_SUPPORTED = "option.versioning.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if simple
     * versioning is supported.
     *
     * @api
     */
    const OPTION_SIMPLE_VERSIONING_SUPPORTED = "option.simple.versioning.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if activities are
     * supported.
     *
     * @api
     */
    const OPTION_ACTIVITIES_SUPPORTED = "option.activities.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if configurations
     * and baselines are supported.
     *
     * @api
     */
    const OPTION_BASELINES_SUPPORTED = "option.baselines.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if access control
     * is supported.
     *
     * @api
     */
    const OPTION_ACCESS_CONTROL_SUPPORTED = "option.access.control.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if locking is
     * supported.
     *
     * @api
     */
    const OPTION_LOCKING_SUPPORTED = "option.locking.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if asynchronous
     * observation is supported.
     *
     * @api
     */
    const OPTION_OBSERVATION_SUPPORTED = "option.observation.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if journaled
     * observation is supported.
     *
     * @api
     */
    const OPTION_JOURNALED_OBSERVATION_SUPPORTED = "option.journaled.observation.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if retention and
     * hold are supported.
     *
     * @api
     */
    const OPTION_RETENTION_SUPPORTED = "option.retention.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if lifecycles are
     * supported.
     *
     * @api
     */
    const OPTION_LIFECYCLE_SUPPORTED = "option.lifecycle.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if transactions
     * are supported.
     *
     * @api
     */
    const OPTION_TRANSACTIONS_SUPPORTED = "option.transactions.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if workspace
     * management is supported.
     *
     * @api
     */
    const OPTION_WORKSPACE_MANAGEMENT_SUPPORTED = "option.workspace.management.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if the primary
     * node type of an existing node can be updated.
     *
     * @api
     */
    const OPTION_UPDATE_PRIMARY_NODETYPE_SUPPORTED = "option.update.primary.nodetype.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if the mixin node
     * types of an existing node can be added and removed.
     *
     * @api
     */
    const OPTION_UPDATE_MIXIN_NODETYPES_SUPPORTED = "option.update.mixin.nodetypes.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if the creation of
     * shareable nodes is supported.
     *
     * @api
     */
    const OPTION_SHAREABLE_NODES_SUPPORTED = "option.shareable.nodes.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if node type
     * management is supported.
     *
     * @api
     */
    const OPTION_NODE_TYPE_MANAGEMENT_SUPPORTED = "option.node.type.management.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if node and
     * property with same name is supported.
     *
     * @api
     */
    const OPTION_NODE_AND_PROPERTY_WITH_SAME_NAME_SUPPORTED = "option.node.and.property.with.same.name.supported";

    /**
     * Key to string descriptor. Returns one of the following
     * RepositoryInterface constants indicating the level of support for node
     * type inheritance:
     *
     * - NODE_TYPE_MANAGEMENT_INHERITANCE_MINIMAL Registration of primary node
     *      types is limited to those which have only nt:base as supertype.
     *      Registration of mixin node types is limited to those without any
     *      supertypes.
     *
     * - NODE_TYPE_MANAGEMENT_INHERITANCE_SINGLE Registration of primary node
     *      types is limited to those with exactly one supertype. Registration
     *      of mixin node types is limited to those with at most one supertype.
     *
     * - NODE_TYPE_MANAGEMENT_INHERITANCE_MULTIPLE Primary node types can be
     *      registered with one or more supertypes. Mixin node types can be
     *      registered with zero or more supertypes.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_INHERITANCE = "node.type.management.inheritance";

    /**
     * One of three possible values for the descriptor
     * NODE_TYPE_MANAGEMENT_INHERITANCE.
     *
     * Indicates that registration of primary node types is limited to those
     * which have only nt:base as supertype. Registration of mixin node types
     * is limited to those without any supertypes.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_INHERITANCE_MINIMAL = "node.type.management.inheritance.minimal";

    /**
     * One of three possible values for the descriptor
     * NODE_TYPE_MANAGEMENT_INHERITANCE.
     *
     * Indicates that registration of primary node types is limited to those
     * with exactly one supertype. Registration of mixin node types is limited
     * to those with at most one supertype.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_INHERITANCE_SINGLE = "node.type.management.inheritance.single";

    /**
     * One of three possible values for the descriptor
     * NODE_TYPE_MANAGEMENT_INHERITANCE.
     *
     * Indicates that primary node types can be registered with one or more
     * supertypes. Mixin node types can be registered with zero or more
     * supertypes.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_INHERITANCE_MULTIPLE = "node.type.management.inheritance.multiple";

    /**
     * Key to a boolean descriptor. Returns true if and only if override of
     * inherited property or child node definitions is supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_OVERRIDES_SUPPORTED = "node.type.management.overrides.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if primary items
     * are supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_PRIMARY_ITEM_NAME_SUPPORTED = "node.type.management.primary.item.name.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if preservation of
     * child node ordering is supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_ORDERABLE_CHILD_NODES_SUPPORTED = "node.type.management.orderable.child.nodes.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if residual
     * property and child node definitions are supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_RESIDUAL_DEFINITIONS_SUPPORTED = "node.type.management.residual.definitions.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if autocreated
     * properties and child nodes are supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_AUTOCREATED_DEFINITIONS_SUPPORTED = "node.type.management.autocreated.definitions.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if same-name
     * sibling child nodes are supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_SAME_NAME_SIBLINGS_SUPPORTED = "node.type.management.same.name.siblings.supported";

    /**
     * Key to an integer[] descriptor. Returns an array holding the
     * PropertyType constants for the property types (including
     * UNDEFINED, if supported) that a registered node type can specify, or a
     * zero-length array if registered node types cannot specify property
     * definitions.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_PROPERTY_TYPES = "node.type.management.property.types";

    /**
     * Key to a boolean descriptor. Returns true if and only if multivalue
     * properties are supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_MULTIVALUED_PROPERTIES_SUPPORTED = "node.type.management.multivalued.properties.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if registration of
     * a node types with more than one BINARY property is permitted.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_MULTIPLE_BINARY_PROPERTIES_SUPPORTED = "node.type.management.multiple.binary.properties.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only value-constraints
     * are supported.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_VALUE_CONSTRAINTS_SUPPORTED = "node.type.management.value.constraints.supported";

    /**
     * Key to boolean descriptor. Indicates that you can change node definitions
     * that are in-use by existing nodes
     *
     * Note: JCR 2.0 had a typo with both the constant name and the value
     * (suported instead of supported). PHPCR implementations talking with legacy
     * backends should not break on this issue.
     *
     * @api
     */
    const NODE_TYPE_MANAGEMENT_UPDATE_IN_USE_SUPPORTED = "node.type.management.update.in.use.supported";

    /**
     * Key to a string[] descriptor. Returns an array holding the constants
     * representing the supported query languages, or a zero-length if query is
     * not supported.
     *
     * @api
     */
    const QUERY_LANGUAGES = "query.languages";

    /**
     * Key to a boolean descriptor. Returns true if and only if stored queries
     * are supported.
     *
     * @api
     */
    const QUERY_STORED_QUERIES_SUPPORTED = "query.stored.queries.supported";

    /**
     * Key to a boolean descriptor. Returns true if and only if full-text
     * search is supported.
     *
     * @api
     */
    const QUERY_FULL_TEXT_SEARCH_SUPPORTED = "query.full.text.search.supported";

    /**
     * Key to String descriptor. Returns one of the following
     * RepositoryInterface constants indicating the level of support for joins
     * in queries:
     *
     * - QUERY_JOINS_NONE - Joins are not supported. Queries are limited to a
     *      single selector.
     * - QUERY_JOINS_INNER - Inner joins are supported.
     * - QUERY_JOINS_INNER_OUTER - Inner and outer joins are supported.
     *
     * @api
     */
    const QUERY_JOINS = "query.joins";

    /**
     * One of three possible values for the descriptor QUERY_JOINS . Indicates
     * that joins are not supported. Queries are limited to a single selector.
     *
     * @api
     */
    const QUERY_JOINS_NONE = "query.joins.none";

    /**
     * One of three possible values for the descriptor QUERY_JOINS . Indicates
     * that inner joins are supported.
     *
     * @api
     */
    const QUERY_JOINS_INNER = "query.joins.inner";

    /**
     * One of three possible values for the descriptor QUERY_JOINS . Indicates
     * that inner and outer joins are supported.
     *
     * @api
     */
    const QUERY_JOINS_INNER_OUTER = "query.joins.inner.outer";

    /**
     * Key to a boolean descriptor. Returns true if
     * and only if query cancellation is supported.
     *
     * @since JCR 2.1
     */
    const QUERY_CANCEL_SUPPORTED = "query.cancel.supported";

    /**
     * Authenticates the user using the supplied credentials.
     *
     * If workspaceName is recognized as the name of an existing workspace in
     * the repository and authorization to access that workspace is granted,
     * then a new Session object is returned. The format of the string
     * workspaceName depends upon the implementation. If credentials is null,
     * it is assumed that authentication is handled by a mechanism external to
     * the repository itself and that the repository implementation exists
     * within a context (for example, an application server) that allows it to
     * handle authorization of the request for access to the specified
     * workspace.
     *
     * If workspaceName is null, a default workspace is automatically selected
     * by the repository implementation. This may, for example, be the "home
     * workspace" of the user whose credentials were passed, though this is
     * entirely up to the configuration and implementation of the repository.
     * Alternatively, it may be a "null workspace" that serves only to provide
     * the method WorkspaceInterface::getAccessibleWorkspaceNames(), allowing
     * the client to select from among available "real" workspaces.
     *
     * <b>Note:</b> The Java API defines this method with multiple differing
     * signatures.
     *
     * @param CredentialsInterface $credentials The credentials of the
     *      user
     * @param string $workspaceName the name of a workspace
     *
     * @return SessionInterface a valid session for the user to access
     *      the repository
     *
     * @throws LoginException if authentication or authorization (for
     *      the specified workspace) fails
     * @throws NoSuchWorkspaceException if the specified workspaceName
     *      is not recognized
     * @throws RepositoryException if another error occurs
     *
     * @api
     */
    public function login(CredentialsInterface $credentials = null, $workspaceName = null);

    /**
     * Returns a string array holding all descriptor keys available for this
     * implementation.
     *
     * Both, the standard descriptors defined by the string constants in this
     * interface and any implementation-specific descriptors. Used in
     * conjunction with getDescriptor($key) to query information about this
     * repository implementation.
     *
     * @return array a string array holding all descriptor keys
     *
     * @api
     */
    public function getDescriptorKeys();

    /**
     * Determines if the given identifier is a standard descriptor.
     *
     * Returns true if $key is a standard descriptor defined by the string
     * constants in this interface and false if it is either a valid
     * implementation-specific key or not a valid key.
     *
     * @param string $key a descriptor key.
     *
     * @return boolean whether $key is a standard descriptor.
     *
     * @api
     */
    public function isStandardDescriptor($key);

    /**
     * Get the value(s) for this key.
     *
     * If this is documented as a boolean property, this method returns a
     * boolean, otherwise a string.
     *
     * @param string $key a descriptor key.
     *
     * @return mixed a descriptor value in string or boolean form or an array
     *      of strings or booleans for multivalue descriptors
     *
     * @api
     */
    public function getDescriptor($key);
}
