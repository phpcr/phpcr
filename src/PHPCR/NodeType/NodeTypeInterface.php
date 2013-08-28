<?php

namespace PHPCR\NodeType;

/**
 * A NodeType object represents a "live" node type that is registered in the
 * repository.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeTypeInterface extends \PHPCR\NodeType\NodeTypeDefinitionInterface
{
    /**#@+
     * @var string
     */

    /**
     * A constant for the node type name nt:base (in extended form).
     * Constants for the names of the properties declared by nt:base are:
     *
     * - \PHPCR\PropertyInterface::JCR_PRIMARY_TYPE
     * - \PHPCR\PropertyInterface::JCR_MIXIN_TYPES
     *
     * @api
     */
    const NT_BASE = "{http://www.jcp.org/jcr/nt/1.0}base";

    /**
     * A constant for the node type name nt:hierarchyNode (in extended form).
     * @api
     */
    const NT_HIERARCHY_NODE = "{http://www.jcp.org/jcr/nt/1.0}hierarchyNode";

    /**
     * A constant for the node type name nt:folder (in extended form).
     * @api
     */
    const NT_FOLDER = "{http://www.jcp.org/jcr/nt/1.0}folder";

    /**
     * A constant for the node type name nt:file (in extended form).
     * A constant for the name of the child node declared by nt:file is:
     * \PHPCR\NodeInterface::JCR_CONTENT
     *
     * @api
     */
    const NT_FILE = "{http://www.jcp.org/jcr/nt/1.0}file";

    /**
     * A constant for the node type name nt:linkedFile (in extended form).
     * A constant for the name of the property declared by nt:linkedFile is:
     * \PHPCR\PropertyInterface::JCR_CONTENT
     *
     * @api
     */
    const NT_LINKED_FILE = "{http://www.jcp.org/jcr/nt/1.0}linkedFile";

    /**
     * A constant for the node type name nt:resource (in extended form).
     * A constant for the name of the property declared by nt:resource is:
     * \PHPCR\PropertyInterface::JCR_DATA
     *
     * @api
     */
    const NT_RESOURCE = "{http://www.jcp.org/jcr/nt/1.0}resource";

    /**
     * A constant for the node type name nt:unstructured (in extended form).
     * @api
     */
    const NT_UNSTRUCTURED = "{http://www.jcp.org/jcr/nt/1.0}unstructured";

    /**
     * A constant for the node type name nt:address (in extended form).
     * Constants for the names of the properties declared by nt:base are:
     *
     * - \PHPCR\PropertyInterface::JCR_PROTOCOL
     * - \PHPCR\PropertyInterface::JCR_HOST
     * - \PHPCR\PropertyInterface::JCR_PORT
     * - \PHPCR\PropertyInterface::JCR_REPOSITORY
     * - \PHPCR\PropertyInterface::JCR_WORKSPACE
     * - \PHPCR\PropertyInterface::JCR_PATH
     * - \PHPCR\PropertyInterface::JCR_ID
     *
     * @api
     */
    const NT_ADDRESS = "{http://www.jcp.org/jcr/nt/1.0}address";

    /**
     * A constant for the node type name mix:referenceable (in extended form).
     * A constant for the name of the property declared by mix:referenceable is:
     * \PHPCR\PropertyInterface::JCR_UUID
     *
     * @api
     */
    const MIX_REFERENCEABLE = "{http://www.jcp.org/mix/1.0}referenceable";

    /**
     * A constant for the node type name mix:title (in extended form).
     * Constants for the names of the properties declared by mix:title are:
     *
     * - \PHPCR\PropertyInterface::JCR_TITLE
     * - \PHPCR\PropertyInterface::JCR_DESCRIPTION
     *
     * @api
     */
    const MIX_TITLE = "{http://www.jcp.org/mix/1.0}title";

    /**
     * A constant for the node type name mix:created (in extended form).
     * Constants for the names of the properties declared by mix:created are:
     *
     * - \PHPCR\PropertyInterface::JCR_CREATED
     * - \PHPCR\PropertyInterface::JCR_CREATED_BY
     *
     * @api
     */
    const MIX_CREATED = "{http://www.jcp.org/mix/1.0}created";

    /**
     * A constant for the node type name mix:lastModified (in extended form).
     * Constants for the names of the properties declared by mix:lastModified are:
     *
     * - \PHPCR\PropertyInterface::JCR_LAST_MODIFIED
     * - \PHPCR\PropertyInterface::JCR_LAST_MODIFIED_BY
     *
     * @api
     */
    const MIX_LAST_MODIFIED = "{http://www.jcp.org/mix/1.0}lastModified";

    /**
     * A constant for the node type name mix:language (in extended form).
     * A constant for the name of the property declared by mix:language is:
     * \PHPCR\PropertyInterface::JCR_LANGUAGE
     *
     * @api
     */
    const MIX_LANGUAGE = "{http://www.jcp.org/mix/1.0}language";

    /**
     * A constant for the node type name mix:mimeType (in extended form).
     * Constants for the names of the properties declared by mix:mimeType are:
     *
     * - \PHPCR\PropertyInterface::JCR_MIMETYPE
     * - \PHPCR\PropertyInterface::JCR_ENCODING
     *
     * @api
     */
    const MIX_MIMETYPE = "{http://www.jcp.org/mix/1.0}mimeType";

    /**
     * A constant for the node type name nt:nodeType (in extended form).
     * Constants for the names of the child items declared by nt:nodeType are:
     *
     * - \PHPCR\PropertyInterface::JCR_NODE_TYPE_NAME
     * - \PHPCR\PropertyInterface::JCR_SUPERTYPES
     * - \PHPCR\PropertyInterface::JCR_IS_ABSTRACT
     * - \PHPCR\PropertyInterface::JCR_IS_MIXIN
     * - \PHPCR\PropertyInterface::JCR_HAS_ORDERABLE_CHILD_NODES
     * - \PHPCR\PropertyInterface::JCR_PRIMARY_ITEM_NAME
     * - \PHPCR\NodeInterface::JCR_PROPERTY_DEFINITION
     * - \PHPCR\NodeInterface::JCR_CHILD_NODE_DEFINITION
     *
     * @api
     */
    const NT_NODE_TYPE = "{http://www.jcp.org/jcr/nt/1.0}nodeType";

    /**
     * A constant for the node type name nt:propertyDefinition (in extended form).
     * Constants for the names of the properties declared by nt:propertyDefinition are:
     *
     * - \PHPCR\PropertyInterface::JCR_NAME
     * - \PHPCR\PropertyInterface::JCR_AUTOCREATED
     * - \PHPCR\PropertyInterface::JCR_MANDATORY
     * - \PHPCR\PropertyInterface::JCR_PROTECTED
     * - \PHPCR\PropertyInterface::JCR_ON_PARENT_VERSION
     * - \PHPCR\PropertyInterface::JCR_REQUIRED_TYPE
     * - \PHPCR\PropertyInterface::JCR_VALUE_CONSTRAINTS
     * - \PHPCR\PropertyInterface::JCR_DEFAULT_VALUES
     * - \PHPCR\PropertyInterface::JCR_MULTIPLE
     *
     * @api
     */
    const NT_PROPERTY_DEFINITION = "{http://www.jcp.org/jcr/nt/1.0}propertyDefinition";

    /**
     * A constant for the node type name nt:childNodeDefinition (in extended form).
     * Constants for the names of the properties declared by nt:childNodeDefinition are:
     *
     * - \PHPCR\PropertyInterface::JCR_NAME
     * - \PHPCR\PropertyInterface::JCR_AUTOCREATED
     * - \PHPCR\PropertyInterface::JCR_MANDATORY
     * - \PHPCR\PropertyInterface::JCR_PROTECTED
     * - \PHPCR\PropertyInterface::JCR_ON_PARENT_VERSION
     * - \PHPCR\PropertyInterface::JCR_REQUIRED_PRIMARY_TYPES
     * - \PHPCR\PropertyInterface::JCR_DEFAULT_PRIMARY_TYPE
     * - \PHPCR\PropertyInterface::JCR_SAME_NAME_SIBLINGS
     *
     * @api
     */
    const NT_CHILD_NODE_DEFINITION = "{http://www.jcp.org/jcr/nt/1.0}childNodeDefinition";

    /**
     * A constant for the node type name mix:shareable (in extended form).
     *
     * @api
     */
    const MIX_SHAREABLE = "{http://www.jcp.org/mix/1.0}shareable";

    /**
     * A constant for the node type name mix:lockable (in extended form).
     * Constants for the names of the properties declared by mix:lockable are:
     *
     * - \PHPCR\PropertyInterface::JCR_LOCK_OWNER
     * - \PHPCR\PropertyInterface::JCR_LOCK_IS_DEEP
     *
     * @api
     */
    const MIX_LOCKABLE = "{http://www.jcp.org/mix/1.0}lockable";

    /**
     * A constant for the node type name mix:lifecycle (in extended form).
     * Constants for the names of the properties declared by mix:lifecycle are:
     *
     * - \PHPCR\PropertyInterface::JCR_LIFECYCLE_POLICY
     * - \PHPCR\PropertyInterface::JCR_CURRENT_LIFECYCLE_STATE
     *
     * @api
     */
    const MIX_LIFECYCLE = "{http://www.jcp.org/mix/1.0}lifecycle";

    /**
     * A constant for the node type name mix:simpleVersionable (in extended form).
     * A constant for the name of the property declared by mix:simpleVersionable is:
     * \PHPCR\PropertyInterface::JCR_IS_CHECKED_OUT
     *
     * @api
     */
    const MIX_SIMPLE_VERSIONABLE = "{http://www.jcp.org/mix/1.0}simpleVersionable";

    /**
     * A constant for the node type name mix:versionable (in extended form).
     * Constants for the names of the properties declared by mix:versionable are:
     *
     * - \PHPCR\PropertyInterface::JCR_VERSION_HISTORY
     * - \PHPCR\PropertyInterface::JCR_BASE_VERSION
     * - \PHPCR\PropertyInterface::JCR_PREDECESSORS
     * - \PHPCR\PropertyInterface::JCR_MERGE_FAILED
     * - \PHPCR\PropertyInterface::JCR_ACTIVITY
     * - \PHPCR\PropertyInterface::JCR_CONFIGURATION
     *
     * @api
     */
    const MIX_VERSIONABLE = "{http://www.jcp.org/mix/1.0}versionable";

    /**
     * A constant for the node type name nt:versionHistory (in extended form).
     * Constants for the names of the child items declared by nt:versionHistory are:
     *
     * - \PHPCR\PropertyInterface::JCR_VERSIONABLE_UUID
     * - \PHPCR\PropertyInterface::JCR_COPIED_FROM
     * - \PHPCR\NodeInterface::JCR_ROOT_VERSION
     * - \PHPCR\NodeInterface::JCR_VERSION_LABELS
     *
     * @api
     */
    const NT_VERSION_HISTORY = "{http://www.jcp.org/jcr/nt/1.0}versionHistory";

    /**
     * A constant for the node type name nt:version (in extended form).
     * Constants for the names of the child items declared by nt:version are:
     *
     * - \PHPCR\PropertyInterface::JCR_CREATED
     * - \PHPCR\PropertyInterface::JCR_PREDECESSORS
     * - \PHPCR\PropertyInterface::JCR_SUCCESSORS
     * - \PHPCR\PropertyInterface::JCR_ACTIVITY
     * - \PHPCR\NodeInterface::JCR_FROZEN_NODE
     *
     * @api
     */
    const NT_VERSION = "{http://www.jcp.org/jcr/nt/1.0}version";

    /**
     * A constant for the node type name nt:frozenNode (in extended form).
     * Constants for the names of the properties declared by nt:frozenNode are:
     *
     * - \PHPCR\PropertyInterface::JCR_FROZEN_PRIMARY_TYPE
     * - \PHPCR\PropertyInterface::JCR_FROZEN_MIXIN_TYPES
     * - \PHPCR\PropertyInterface::JCR_FROZEN_UUID
     *
     * @api
     */
    const NT_FROZEN_NODE = "{http://www.jcp.org/jcr/nt/1.0}frozenNode";

    /**
     * A constant for the node type name nt:versionedChild (in extended form).
     * A constant for the name of the property declared by nt:versionedChild is:
     * \PHPCR\PropertyInterface::JCR_CHILD_VERSION_HISTORY
     *
     * @api
     */
    const NT_VERSIONED_CHILD = "{http://www.jcp.org/jcr/nt/1.0}versionedChild";

    /**
     * A constant for the node type name nt:activity (in extended form).
     * A constant for the name of the property declared by nt:activity is:
     * \PHPCR\PropertyInterface::JCR_TITLE
     *
     * @api
     */
    const NT_ACTIVITY = "{http://www.jcp.org/jcr/nt/1.0}activity";

    /**
     * A constant for the node type name nt:configuration (in extended form).
     * A constant for the name of the property declared by nt:configuration is:
     * \PHPCR\PropertyInterface::JCR_ROOT
     *
     * @api
     */
    const NT_CONFIGURATION = "{http://www.jcp.org/jcr/nt/1.0}configuration";

    /**
     * A constant for the node type name nt:query (in extended form).
     * Constants for the names of the properties declared by nt:query are:
     *
     * - \PHPCR\PropertyInterface::JCR_STATEMENT
     * - \PHPCR\PropertyInterface::JCR_LANGUAGE
     *
     * @api
     */
    const NT_QUERY = "{http://www.jcp.org/jcr/nt/1.0}query";

    /**#@-*/

    /**
     * Returns all supertypes of this node type in the node type inheritance
     * hierarchy.
     *
     * For primary types apart from nt:base, this list will always
     * include at least nt:base. For mixin types, there is no required supertype.
     *
     * @return NodeTypeInterface[] an array of all parent NodeTypes
     *
     * @api
     */
    public function getSupertypes();

    /**
     * Returns the names of all supertypes of this node type in the node type
     * inheritance hierarchy.
     *
     * For primary types apart from nt:base, this list will always
     * include at least nt:base. For mixin types, there is no required supertype.
     *
     * @see getSupertypes()
     * @see NodeTypeDefinition::getDeclaredSupertypeNames()
     *
     * @return array the names of all supertypes
     *
     * @since JCR 2.1
     */
    public function getSupertypeNames();

    /**
     * Returns the direct supertypes of this node type in the node type
     * inheritance hierarchy, that is, those actually declared in this node
     * type.
     *
     * In single-inheritance systems, this will always be an array of
     * size 0 or 1. In systems that support multiple inheritance of node
     * types this array may be of size greater than 1.
     *
     * @return NodeTypeInterface[] an array of NodeTypes that are direct
     *      parents of this type.
     *
     * @api
     */
    public function getDeclaredSupertypes();

    /**
     * Returns all subtypes of this node type in the node type inheritance
     * hierarchy.
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *      Keys are the node type names, values the corresponding
     *      NodeTypeInterface instances.
     *
     * @see getDeclaredSubtypes()
     *
     * @api
     */
    public function getSubtypes();

    /**
     * Returns the direct subtypes of this node type in the node type inheritance
     * hierarchy, that is, those which actually declared this node type in their
     * list of supertypes.
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *      Keys are the node type names, values the corresponding
     *      NodeTypeInterface instances.
     *
     * @see getSubtypes()
     *
     * @api
     */
    public function getDeclaredSubtypes();

    /**
     * Reports if the name of this node type or any of its direct or indirect
     * supertypes is equal to nodeTypeName.
     *
     * Returns true if the name of this node type or any of its direct or
     * indirect supertypes is equal to nodeTypeName, otherwise returns false.
     *
     * @param string $nodeTypeName the name of a node type.
     *
     * @return boolean
     *
     * @api
     */
    public function isNodeType($nodeTypeName);

    /**
     * Returns an array containing the property definitions of this node type.
     *
     * This includes both those property definitions actually declared
     * in this node type and those inherited from the supertypes of this type.
     *
     * @return PropertyDefinitionInterface[] an array of property definitions
     *
     * @api
     */
    public function getPropertyDefinitions();

    /**
     * Returns an array containing the child node definitions of this node type.
     *
     * This includes both those child node definitions actually declared in this
     * node type and those inherited from the supertypes of this node type.
     *
     * @return NodeDefinitionInterface[] An array of child node definitions
     *
     * @api
     */
    public function getChildNodeDefinitions();

    /**
     * Determines if the node type allows to set the value of a property.
     *
     * Returns true if setting propertyName is allowed and the value is of the
     * required type or can be converted into that type.
     * Otherwise returns false.
     *
     * @param string $propertyName The name of the property
     * @param mixed  $value        A value or an array of values
     *
     * @return boolean True if setting propertyName to value is allowed by this
     *      node type, else false.
     *
     * @api
     */
    public function canSetProperty($propertyName, $value);

    /**
     * Determines if this node type allows the addition of a child node.
     *
     * Returns true if this node type allows the addition of a child node called
     * childNodeName without specific node type information (that is, given the
     * definition of this parent node type, the child node name is sufficient to
     * determine the intended child node type). Returns false otherwise.
     * If $nodeTypeName is given returns true if this node type allows the
     * addition of a child node called childNodeName of node type nodeTypeName.
     * Returns false otherwise.
     *
     * @param string $childNodeName The name of the child node.
     * @param string $nodeTypeName  The name of the node type of the child node.
     *
     * @return boolean True, if the node type allows the addition of a child
     *      node, else false.
     *
     * @api
     */
    public function canAddChildNode($childNodeName, $nodeTypeName = null);

    /**
     * Reports if the node type allows the removal of the given node.
     *
     * Returns true if removing the child node called nodeName is allowed by this
     * node type. Returns false otherwise.
     *
     * @param string $nodeName The name of the child node.
     *
     * @return boolean True, if the node type allows to remove the passed node,
     *      else false.
     *
     * @api
     */
    public function canRemoveNode($nodeName);

    /**
     * Determines if the node type allows to remove the property identified by
     * the given name.
     *
     * Returns true if removing the property called propertyName is allowed by
     * this node type. Returns false otherwise.
     *
     * @param string $propertyName The name of the property
     *
     * @return boolean True, if the removal of the property is allowed, else
     *      false.
     *
     * @api
     */
    public function canRemoveProperty($propertyName);
}
