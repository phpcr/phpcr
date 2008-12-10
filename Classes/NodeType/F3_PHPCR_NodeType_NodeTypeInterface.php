<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\NodeType;

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
 * @subpackage NodeType
 * @version $Id$
 */

/**
 * A NodeType object represents a "live" node type that is registered in the repository.
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface NodeTypeInterface extends \F3\PHPCR\NodeType\NodeTypeDefinitionInterface {

	/**
	 * A constant for the node type name nt:base (in extended form).
	 * Constants for the names of the properties declared by nt:base are:
	 *
	 * Property#JCR_PRIMARY_TYPE
	 * Property#JCR_MIXIN_TYPES
	 */
	const NT_BASE = "{http://www.jcp.org/nt/1.0}base";

	/**
	 * A constant for the node type name nt:hierarchyNode (in extended form).
	 */
	const NT_HIERARCHY_NODE = "{http://www.jcp.org/nt/1.0}hierarchyNode";

	/**
	 * A constant for the node type name nt:folder (in extended form).
	 */
	const NT_FOLDER = "{http://www.jcp.org/nt/1.0}folder";

	/**
	 * A constant for the node type name nt:file (in extended form).
	 * A constant for the name of the child node declared by nt:file is:
	 *
	 * Node#JCR_CONTENT
	 */
	const NT_FILE = "{http://www.jcp.org/nt/1.0}file";

	/**
	 * A constant for the node type name nt:linkedFile (in extended form).
	 * A constant for the name of the property declared by nt:linkedFile is:
	 *
	 * Property#JCR_CONTENT
	 */
	const NT_LINKED_FILE = "{http://www.jcp.org/nt/1.0}linkedFile";

	/**
	 * A constant for the node type name nt:resource (in extended form).
	 * A constant for the name of the property declared by nt:resource is:
	 *
	 * Property#JCR_DATA
	 */
	const NT_RESOURCE = "{http://www.jcp.org/nt/1.0}resource";

	/**
	 * A constant for the node type name nt:unstructured (in extended form).
	 */
	const NT_UNSTRUCTURED = "{http://www.jcp.org/nt/1.0}unstructured";

	/**
	 * A constant for the node type name nt:address (in extended form).
	 * Constants for the names of the properties declared by nt:base are:
	 *
	 * Property#JCR_PROTOCOL
	 * Property#JCR_HOST
	 * Property#JCR_PORT
	 * Property#JCR_REPOSITORY
	 * Property#JCR_WORKSPACE
	 * Property#JCR_PATH
	 * Property#JCR_ID
	 */
	const NT_ADDRESS = "{http://www.jcp.org/nt/1.0}address";

	/**
	 * A constant for the node type name mix:referenceable (in extended form).
	 * A constant for the name of the property declared by mix:referenceable is:
	 *
	 * Property#JCR_UUID
	 */
	const MIX_REFERENCEABLE = "{http://www.jcp.org/mix/1.0}referenceable";

	/**
	 * A constant for the node type name mix:title (in extended form).
	 * Constants for the names of the properties declared by mix:title are:
	 *
	 * Property#JCR_TITLE
	 * Property#JCR_DESCRIPTION
	 */
	const MIX_TITLE = "{http://www.jcp.org/mix/1.0}title";

	/**
	 * A constant for the node type name mix:created (in extended form).
	 * Constants for the names of the properties declared by mix:created are:
	 *
	 * Property#JCR_CREATED
	 * Property#JCR_CREATED_BY
	 */
	const MIX_CREATED = "{http://www.jcp.org/mix/1.0}created";

	/**
	 * A constant for the node type name mix:lastModified (in extended form).
	 * Constants for the names of the properties declared by mix:lastModified are:
	 *
	 * Property#JCR_LAST_MODIFIED
	 * Property#JCR_LAST_MODIFIED_BY
	 */
	const MIX_LAST_MODIFIED = "{http://www.jcp.org/mix/1.0}lastModified";

	/**
	 * A constant for the node type name mix:language (in extended form).
	 * A constant for the name of the property declared by mix:language is:
	 *
	 * Property#JCR_LANGUAGE
	 */
	const MIX_LANGUAGE = "{http://www.jcp.org/mix/1.0}language";

	/**
	 * A constant for the node type name mix:mimetype (in extended form).
	 * Constants for the names of the properties declared by mix:mimetype are:
	 *
	 * Property#JCR_MIMETYPE
	 * Property#JCR_ENCODING
	 */
	const MIX_MIMETYPE = "{http://www.jcp.org/mix/1.0}mimetype";

	/**
	 * A constant for the node type name nt:nodeType (in extended form).
	 * Constants for the names of the child items declared by nt:nodeType are:
	 *
	 * Property#JCR_NODE_TYPE_NAME
	 * Property#JCR_SUPERTYPES
	 * Property#JCR_IS_ABSTRACT
	 * Property#JCR_IS_MIXIN
	 * Property#JCR_HAS_ORDERABLE_CHILD_NODES
	 * Property#JCR_PRIMARY_ITEM_NAME
	 * Node#JCR_PROPERTY_DEFINITION
	 * Node#JCR_CHILD_NODE_DEFINITION
	 */
	const NT_NODE_TYPE = "{http://www.jcp.org/nt/1.0}nodeType";

	/**
	 * A constant for the node type name nt:propertyDefinition (in extended form).
	 * Constants for the names of the properties declared by nt:propertyDefinition are:
	 *
	 * Property#JCR_NAME
	 * Property#JCR_AUTOCREATED
	 * Property#JCR_MANDATORY
	 * Property#JCR_PROTECTED
	 * Property#JCR_ON_PARENT_VERSION
	 * Property#JCR_REQUIRED_TYPE
	 * Property#JCR_VALUE_CONSTRAINTS
	 * Property#JCR_DEFAULT_VALUES
	 * Property#JCR_MULTIPLE
	 */
	const NT_PROPERTY_DEFINITION = "{http://www.jcp.org/nt/1.0}propertyDefinition";

	/**
	 * A constant for the node type name nt:childNodeDefinition (in extended form).
	 * Constants for the names of the properties declared by nt:childNodeDefinition are:
	 *
	 * Property#JCR_NAME
	 * Property#JCR_AUTOCREATED
	 * Property#JCR_MANDATORY
	 * Property#JCR_PROTECTED
	 * Property#JCR_ON_PARENT_VERSION
	 * Property#JCR_REQUIRED_PRIMARY_TYPES
	 * Property#JCR_DEFAULT_PRIMARY_TYPE
	 * Property#JCR_SAME_NAME_SIBLINGS
	 */
	const NT_CHILD_NODE_DEFINITION = "{http://www.jcp.org/nt/1.0}childNodeDefinition";

	/**
	  * A constant for the node type name mix:shareable (in extended form).
	  */
	const MIX_SHAREABLE = "{http://www.jcp.org/mix/1.0}shareable";

	/**
	 * A constant for the node type name mix:lockable (in extended form).
	 * Constants for the names of the properties declared by mix:lockable are:
	 *
	 * Property#JCR_LOCK_OWNER
	 * Property#JCR_LOCK_IS_DEEP
	 */
	const MIX_LOCKABLE = "{http://www.jcp.org/mix/1.0}lockable";

	/**
	 * A constant for the node type name mix:lifecycle (in extended form).
	 * Constants for the names of the properties declared by mix:lifecycle are:
	 *
	 * Property#JCR_LIFECYCLE_POLICY
	 * Property#JCR_CURRENT_LIFECYCLE_STATE
	 */
	const MIX_LIFECYCLE = "{http://www.jcp.org/mix/1.0}lifecycle";

	/**
	 * A constant for the node type name mix:simpleVersionable (in extended form).
	 * A constant for the name of the property declared by mix:simpleVersionable is:
	 *
	 * Property#JCR_IS_CHECKED_OUT
	 */
	const MIX_SIMPLE_VERSIONABLE = "{http://www.jcp.org/mix/1.0}simpleVersionable";

	/**
	 * A constant for the node type name mix:versionable (in extended form).
	 * Constants for the names of the properties declared by mix:versionable are:
	 *
	 * Property#JCR_VERSION_HISTORY
	 * Property#JCR_BASE_VERSION
	 * Property#JCR_PREDECESSORS
	 * Property#JCR_MERGE_FAILED
	 * Property#JCR_ACTIVITY
	 * Property#JCR_CONFIGURATION
	 */
	const MIX_VERSIONABLE = "{http://www.jcp.org/mix/1.0}versionable";

	/**
	 * A constant for the node type name nt:versionHistory (in extended form).
	 * Constants for the names of the child items declared by nt:versionHistory are:
	 *
	 * Property#JCR_VERSIONABLE_UUID
	 * Property#JCR_COPIED_FROM
	 * Node#JCR_ROOT_VERSION
	 * Node#JCR_VERSION_LABELS
	 */
	const NT_VERSION_HISTORY = "{http://www.jcp.org/nt/1.0}versionHistory";

	/**
	 * A constant for the node type name nt:version (in extended form).
	 * Constants for the names of the child items declared by nt:version are:
	 *
	 * Property#JCR_CREATED
	 * Property#JCR_PREDECESSORS
	 * Property#JCR_SUCCESSORS
	 * Property#JCR_ACTIVITY
	 * Node#JCR_FROZEN_NODE
	 */
	const NT_VERSION = "{http://www.jcp.org/nt/1.0}version";

	/**
	 * A constant for the node type name nt:frozenNode (in extended form).
	 * Constants for the names of the properties declared by nt:frozenNode are:
	 *
	 * Property#JCR_FROZEN_PRIMARY_TYPE
	 * Property#JCR_FROZEN_MIXIN_TYPES
	 * Property#JCR_FROZEN_UUID
	 */
	const NT_FROZEN_NODE = "{http://www.jcp.org/nt/1.0}frozenNode";

	/**
	 * A constant for the node type name nt:versionedChild (in extended form).
	 * A constant for the name of the property declared by nt:versionedChild is:
	 *
	 * Property#JCR_CHILD_VERSION_HISTORY
	 */
	const NT_VERSIONED_CHILD = "{http://www.jcp.org/nt/1.0}versionedChild";

	/**
	 * A constant for the node type name nt:activity (in extended form).
	 * A constant for the name of the property declared by nt:activity is:
	 *
	 * Property#JCR_TITLE
	 */
	const NT_ACTIVITY = "{http://www.jcp.org/nt/1.0}activity";

	/**
	 * A constant for the node type name nt:configuration (in extended form).
	 * A constant for the name of the property declared by nt:configuration are:
	 *
	 * Property#JCR_ROOT
	 */
	const NT_CONFIGURATION = "{http://www.jcp.org/nt/1.0}configuration";

	/**
	 * A constant for the node type name nt:query (in extended form).
	 * Constants for the names of the properties declared by nt:query are:
	 *
	 * Property#JCR_STATEMENT
	 * Property#JCR_LANGUAGE
	 */
	const NT_QUERY = "{http://www.jcp.org/nt/1.0}query";

	/**
	 * Returns all supertypes of this node type in the node type inheritance
	 * hierarchy. For primary types apart from nt:base, this list will always
	 * include at least nt:base. For mixin types, there is no required supertype.
	 *
	 * @return array of \F3\PHPCR\NodeType\NodeType objects.
	 */
	public function getSupertypes();

	/**
	 * Returns the direct supertypes of this node type in the node type
	 * inheritance hierarchy, that is, those actually declared in this node
	 * type. In single-inheritance systems, this will always be an array of
	 * size 0 or 1. In systems that support multiple inheritance of node
	 * types this array may be of size greater than 1.
	 *
	 * @return array of \F3\PHPCR\NodeType\NodeType objects.
	 */
	public function getDeclaredSupertypes();

	/**
	 * Returns all subtypes of this node type in the node type inheritance
	 * hierarchy.
	 *
	 * @see getDeclaredSubtypes()
	 *
	 * @return \F3\PHPCR\NodeType\NodeTypeIteratorInterface a NodeTypeIterator.
	 */
	public function getSubtypes();

	/**
	 * Returns the direct subtypes of this node type in the node type inheritance
	 * hierarchy, that is, those which actually declared this node type in their
	 * list of supertypes.
	 *
	 * @see getSubtypes()
	 *
	 * @return \F3\PHPCR\NodeType\NodeTypeIteratorInterface a NodeTypeIterator.
	 */
	public function getDeclaredSubtypes();

	/**
	 * Returns true if this node type is nodeTypeName or a subtype of
	 * nodeTypeName, otherwise returns false.
	 *
	 * @param string $nodeTypeName the name of a node type.
	 * @return boolean
	 */
	public function isNodeType($nodeTypeName);

	/**
	 * Returns an array containing the property definitions of this node
	 * type. This includes both those property definitions actually declared
	 * in this node type and those inherited from the supertypes of this type.
	 *
	 * @return array an array of \F3\PHPCR\NodeType\PropertyDefinition containing the property definitions.
	 */
	public function getPropertyDefinitions();

	/**
	 * Returns an array containing the child node definitions of this node type.
	 * This includes both those child node definitions actually declared in this
	 * node type and those inherited from the supertypes of this node type.
	 *
	 * @return array an array of \F3\PHPCR\NodeType\NodeDefinition containing the child node definitions.
	 */
	public function getChildNodeDefinitions();

	/**
	 * Returns true if setting propertyName to value is allowed by this node type.
	 * Otherwise returns false.
	 *
	 * @param string $propertyName The name of the property
	 * @param \F3\PHPCR\ValueInterface|array $value A \F3\PHPCR\ValueInterface object or an array of \F3\PHPCR\ValueInterface objects.
	 * @return boolean
	 */
	public function canSetProperty($propertyName, $value);

	/**
	 * Returns true if this node type allows the addition of a child node called
	 * childNodeName without specific node type information (that is, given the
	 * definition of this parent node type, the child node name is sufficient to
	 * determine the intended child node type). Returns false otherwise.
	 * If $nodeTypeName is given returns true if this node type allows the
	 * addition of a child node called childNodeName of node type nodeTypeName.
	 * Returns false otherwise.
	 *
	 * @param string $childNodeName The name of the child node.
	 * @param string $nodeTypeName The name of the node type of the child node.
	 * @return boolean
	 */
	public function canAddChildNode($childNodeName, $nodeTypeName = NULL);

	/**
	 * Returns true if removing the child node called nodeName is allowed by this
	 * node type. Returns false otherwise.
	 *
	 * @param string $nodeName The name of the child node
	 * @return boolean
	 */
	public function canRemoveNode($nodeName);

	/**
	 * Returns true if removing the property called propertyName is allowed by this
	 * node type. Returns false otherwise.
	 *
	 * @param string $propertyName The name of the property
	 * @return boolean
	 */
	public function canRemoveProperty($propertyName);
}

?>