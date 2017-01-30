<?php

namespace PHPCR\NodeType;

use Iterator;
use PHPCR\NamespaceRegistryInterface as NS;

/**
 * A NodeType object represents a "live" node type that is registered in the
 * repository.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeTypeInterface extends NodeTypeDefinitionInterface
{
    /**#@+
     * @var string
     */

    /**
     * A constant for the node type name nt:base (in extended form).
     * Constants for the names of the properties declared by nt:base are:
     *
     * - PropertyInterface::JCR_PRIMARY_TYPE
     * - PropertyInterface::JCR_MIXIN_TYPES
     *
     * @api
     */
    const NT_BASE = '{'.NS::NAMESPACE_NT.'}base';

    /**
     * A constant for the node type name nt:hierarchyNode (in extended form).
     * @api
     */
    const NT_HIERARCHY_NODE = '{'.NS::NAMESPACE_NT.'}hierarchyNode';

    /**
     * A constant for the node type name nt:folder (in extended form).
     * @api
     */
    const NT_FOLDER = '{'.NS::NAMESPACE_NT.'}folder';

    /**
     * A constant for the node type name nt:file (in extended form).
     * A constant for the name of the child node declared by nt:file is:
     * NodeInterface::JCR_CONTENT
     *
     * @api
     */
    const NT_FILE = '{'.NS::NAMESPACE_NT.'}file';

    /**
     * A constant for the node type name nt:linkedFile (in extended form).
     * A constant for the name of the property declared by nt:linkedFile is:
     * PropertyInterface::JCR_CONTENT
     *
     * @api
     */
    const NT_LINKED_FILE = '{'.NS::NAMESPACE_NT.'}linkedFile';

    /**
     * A constant for the node type name nt:resource (in extended form).
     * A constant for the name of the property declared by nt:resource is:
     * PropertyInterface::JCR_DATA
     *
     * @api
     */
    const NT_RESOURCE = '{'.NS::NAMESPACE_NT.'}resource';

    /**
     * A constant for the node type name nt:unstructured (in extended form).
     * @api
     */
    const NT_UNSTRUCTURED = '{'.NS::NAMESPACE_NT.'}unstructured';

    /**
     * A constant for the node type name nt:address (in extended form).
     * Constants for the names of the properties declared by nt:base are:
     *
     * - PropertyInterface::JCR_PROTOCOL
     * - PropertyInterface::JCR_HOST
     * - PropertyInterface::JCR_PORT
     * - PropertyInterface::JCR_REPOSITORY
     * - PropertyInterface::JCR_WORKSPACE
     * - PropertyInterface::JCR_PATH
     * - PropertyInterface::JCR_ID
     *
     * @api
     */
    const NT_ADDRESS = '{'.NS::NAMESPACE_NT.'}address';

    /**
     * A constant for the node type name mix:referenceable (in extended form).
     * A constant for the name of the property declared by mix:referenceable is:
     * PropertyInterface::JCR_UUID
     *
     * @api
     */
    const MIX_REFERENCEABLE = '{'.NS::NAMESPACE_MIX.'}referenceable';

    /**
     * A constant for the node type name mix:title (in extended form).
     * Constants for the names of the properties declared by mix:title are:
     *
     * - PropertyInterface::JCR_TITLE
     * - PropertyInterface::JCR_DESCRIPTION
     *
     * @api
     */
    const MIX_TITLE = '{'.NS::NAMESPACE_MIX.'}title';

    /**
     * A constant for the node type name mix:created (in extended form).
     * Constants for the names of the properties declared by mix:created are:
     *
     * - PropertyInterface::JCR_CREATED
     * - PropertyInterface::JCR_CREATED_BY
     *
     * @api
     */
    const MIX_CREATED = '{'.NS::NAMESPACE_MIX.'}created';

    /**
     * A constant for the node type name mix:lastModified (in extended form).
     * Constants for the names of the properties declared by mix:lastModified are:
     *
     * - PropertyInterface::JCR_LAST_MODIFIED
     * - PropertyInterface::JCR_LAST_MODIFIED_BY
     *
     * @api
     */
    const MIX_LAST_MODIFIED = '{'.NS::NAMESPACE_MIX.'}lastModified';

    /**
     * A constant for the node type name mix:language (in extended form).
     * A constant for the name of the property declared by mix:language is:
     * PropertyInterface::JCR_LANGUAGE
     *
     * @api
     */
    const MIX_LANGUAGE = '{'.NS::NAMESPACE_MIX.'}language';

    /**
     * A constant for the node type name mix:mimeType (in extended form).
     * Constants for the names of the properties declared by mix:mimeType are:
     *
     * - PropertyInterface::JCR_MIMETYPE
     * - PropertyInterface::JCR_ENCODING
     *
     * @api
     */
    const MIX_MIMETYPE = '{'.NS::NAMESPACE_MIX.'}mimeType';

    /**
     * A constant for the node type name nt:nodeType (in extended form).
     * Constants for the names of the child items declared by nt:nodeType are:
     *
     * - PropertyInterface::JCR_NODE_TYPE_NAME
     * - PropertyInterface::JCR_SUPERTYPES
     * - PropertyInterface::JCR_IS_ABSTRACT
     * - PropertyInterface::JCR_IS_MIXIN
     * - PropertyInterface::JCR_HAS_ORDERABLE_CHILD_NODES
     * - PropertyInterface::JCR_PRIMARY_ITEM_NAME
     * - NodeInterface::JCR_PROPERTY_DEFINITION
     * - NodeInterface::JCR_CHILD_NODE_DEFINITION
     *
     * @api
     */
    const NT_NODE_TYPE = '{'.NS::NAMESPACE_NT.'}nodeType';

    /**
     * A constant for the node type name nt:propertyDefinition (in extended form).
     * Constants for the names of the properties declared by nt:propertyDefinition are:
     *
     * - PropertyInterface::JCR_NAME
     * - PropertyInterface::JCR_AUTOCREATED
     * - PropertyInterface::JCR_MANDATORY
     * - PropertyInterface::JCR_PROTECTED
     * - PropertyInterface::JCR_ON_PARENT_VERSION
     * - PropertyInterface::JCR_REQUIRED_TYPE
     * - PropertyInterface::JCR_VALUE_CONSTRAINTS
     * - PropertyInterface::JCR_DEFAULT_VALUES
     * - PropertyInterface::JCR_MULTIPLE
     *
     * @api
     */
    const NT_PROPERTY_DEFINITION = '{'.NS::NAMESPACE_NT.'}propertyDefinition';

    /**
     * A constant for the node type name nt:childNodeDefinition (in extended form).
     * Constants for the names of the properties declared by nt:childNodeDefinition are:
     *
     * - PropertyInterface::JCR_NAME
     * - PropertyInterface::JCR_AUTOCREATED
     * - PropertyInterface::JCR_MANDATORY
     * - PropertyInterface::JCR_PROTECTED
     * - PropertyInterface::JCR_ON_PARENT_VERSION
     * - PropertyInterface::JCR_REQUIRED_PRIMARY_TYPES
     * - PropertyInterface::JCR_DEFAULT_PRIMARY_TYPE
     * - PropertyInterface::JCR_SAME_NAME_SIBLINGS
     *
     * @api
     */
    const NT_CHILD_NODE_DEFINITION = '{'.NS::NAMESPACE_NT.'}childNodeDefinition';

    /**
     * A constant for the node type name mix:shareable (in extended form).
     *
     * @api
     */
    const MIX_SHAREABLE = '{'.NS::NAMESPACE_MIX.'}shareable';

    /**
     * A constant for the node type name mix:lockable (in extended form).
     * Constants for the names of the properties declared by mix:lockable are:
     *
     * - PropertyInterface::JCR_LOCK_OWNER
     * - PropertyInterface::JCR_LOCK_IS_DEEP
     *
     * @api
     */
    const MIX_LOCKABLE = '{'.NS::NAMESPACE_MIX.'}lockable';

    /**
     * A constant for the node type name mix:lifecycle (in extended form).
     * Constants for the names of the properties declared by mix:lifecycle are:
     *
     * - PropertyInterface::JCR_LIFECYCLE_POLICY
     * - PropertyInterface::JCR_CURRENT_LIFECYCLE_STATE
     *
     * @api
     */
    const MIX_LIFECYCLE = '{'.NS::NAMESPACE_MIX.'}lifecycle';

    /**
     * A constant for the node type name mix:simpleVersionable (in extended form).
     * A constant for the name of the property declared by mix:simpleVersionable is:
     * PropertyInterface::JCR_IS_CHECKED_OUT
     *
     * @api
     */
    const MIX_SIMPLE_VERSIONABLE = '{'.NS::NAMESPACE_MIX.'}simpleVersionable';

    /**
     * A constant for the node type name mix:versionable (in extended form).
     * Constants for the names of the properties declared by mix:versionable are:
     *
     * - PropertyInterface::JCR_VERSION_HISTORY
     * - PropertyInterface::JCR_BASE_VERSION
     * - PropertyInterface::JCR_PREDECESSORS
     * - PropertyInterface::JCR_MERGE_FAILED
     * - PropertyInterface::JCR_ACTIVITY
     * - PropertyInterface::JCR_CONFIGURATION
     *
     * @api
     */
    const MIX_VERSIONABLE = '{'.NS::NAMESPACE_MIX.'}versionable';

    /**
     * A constant for the node type name nt:versionHistory (in extended form).
     * Constants for the names of the child items declared by nt:versionHistory are:
     *
     * - PropertyInterface::JCR_VERSIONABLE_UUID
     * - PropertyInterface::JCR_COPIED_FROM
     * - NodeInterface::JCR_ROOT_VERSION
     * - NodeInterface::JCR_VERSION_LABELS
     *
     * @api
     */
    const NT_VERSION_HISTORY = '{'.NS::NAMESPACE_NT.'}versionHistory';

    /**
     * A constant for the node type name nt:version (in extended form).
     * Constants for the names of the child items declared by nt:version are:
     *
     * - PropertyInterface::JCR_CREATED
     * - PropertyInterface::JCR_PREDECESSORS
     * - PropertyInterface::JCR_SUCCESSORS
     * - PropertyInterface::JCR_ACTIVITY
     * - NodeInterface::JCR_FROZEN_NODE
     *
     * @api
     */
    const NT_VERSION = '{'.NS::NAMESPACE_NT.'}version';

    /**
     * A constant for the node type name nt:frozenNode (in extended form).
     * Constants for the names of the properties declared by nt:frozenNode are:
     *
     * - PropertyInterface::JCR_FROZEN_PRIMARY_TYPE
     * - PropertyInterface::JCR_FROZEN_MIXIN_TYPES
     * - PropertyInterface::JCR_FROZEN_UUID
     *
     * @api
     */
    const NT_FROZEN_NODE = '{'.NS::NAMESPACE_NT.'}frozenNode';

    /**
     * A constant for the node type name nt:versionedChild (in extended form).
     * A constant for the name of the property declared by nt:versionedChild is:
     * PropertyInterface::JCR_CHILD_VERSION_HISTORY
     *
     * @api
     */
    const NT_VERSIONED_CHILD = '{'.NS::NAMESPACE_NT.'}versionedChild';

    /**
     * A constant for the node type name nt:activity (in extended form).
     * A constant for the name of the property declared by nt:activity is:
     * PropertyInterface::JCR_TITLE
     *
     * @api
     */
    const NT_ACTIVITY = '{'.NS::NAMESPACE_NT.'}activity';

    /**
     * A constant for the node type name nt:configuration (in extended form).
     * A constant for the name of the property declared by nt:configuration is:
     * PropertyInterface::JCR_ROOT
     *
     * @api
     */
    const NT_CONFIGURATION = '{'.NS::NAMESPACE_NT.'}configuration';

    /**
     * A constant for the node type name nt:query (in extended form).
     * Constants for the names of the properties declared by nt:query are:
     *
     * - PropertyInterface::JCR_STATEMENT
     * - PropertyInterface::JCR_LANGUAGE
     *
     * @api
     */
    const NT_QUERY = '{'.NS::NAMESPACE_NT.'}query';

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
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
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
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
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
     * @return bool
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
     * @return bool True if setting propertyName to value is allowed by this
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
     * @return bool True, if the node type allows the addition of a child
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
     * @return bool True, if the removal of the property is allowed, else
     *      false.
     *
     * @api
     */
    public function canRemoveProperty($propertyName);
}
