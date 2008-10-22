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
 * A Property object represents the smallest granularity of content storage.
 * It has a single parent node and no children. A property consists of a name
 * and a value, or in the case of multi-value properties, a set of values all
 * of the same type. See Value.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface PropertyInterface extends F3::PHPCR::ItemInterface {

	/**
	 * A constant for the property name jcr:primaryType (in extended form),
	 * declared in node type nt:base.
	 */
	const JCR_PRIMARY_TYPE = "{http://www.jcp.org/jcr/1.0}primaryType";

	/**
	 * A constant for the property name jcr:mixinTypes (in extended form),
	 * declared in node type nt:base.
	 */
	const JCR_MIXIN_TYPES = "{http://www.jcp.org/jcr/1.0}mixinTypes";

	/**
	 * A constant for the property name jcr:content (in extended form),
	 * declared in node type nt:linkedFile.
	 * Note, jcr:content is also the name of a child node declared in nt:file.
	 */
	const JCR_CONTENT = "{http://www.jcp.org/jcr/1.0}content";

	/**
	 * A constant for the property name jcr:data (in extended form),
	 * declared in node type nt:resource.
	 */
	const JCR_DATA = "{http://www.jcp.org/jcr/1.0}data";

	/**
	 * A constant for the property name jcr:protocol (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_PROTOCOL = "{http://www.jcp.org/jcr/1.0}protocol";

	/**
	 * A constant for the property name jcr:host (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_HOST = "{http://www.jcp.org/jcr/1.0}host";

	/**
	 * A constant for the property name jcr:port (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_PORT = "{http://www.jcp.org/jcr/1.0}port";

	/**
	 * A constant for the property name jcr:repository (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_REPOSITORY = "{http://www.jcp.org/jcr/1.0repository";

	/**
	 * A constant for the property name jcr:workspace (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_WORKSPACE = "{http://www.jcp.org/jcr/1.0}workspace";

	/**
	 * A constant for the property name jcr:path (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_PATH = "{http://www.jcp.org/jcr/1.0}path";

	/**
	 * A constant for the property name jcr:id (in extended form),
	 * declared in node type nt:address.
	 */
	const JCR_ID = "{http://www.jcp.org/jcr/1.0}id";

	/**
	 * A constant for the property name jcr:uuid (in extended form),
	 * declared in node type mix:referenceable.
	 */
	const JCR_UUID = "{http://www.jcp.org/jcr/1.0}uuid";

	/**
	 * A constant for the property name jcr:title (in extended form),
	 * declared in node types mix:title and nt:activity.
	 */
	const JCR_TITLE = "{http://www.jcp.org/jcr/1.0}title";

	/**
	 * A constant for the property name jcr:description (in extended form),
	 * declared in node type mix:title.
	 */
	const JCR_DESCRIPTION = "{http://www.jcp.org/jcr/1.0}description";

	/**
	 * A constant for the property name jcr:created (in extended form),
	 * declared in node types mix:created and nt:version.
	 */
	const JCR_CREATED = "{http://www.jcp.org/jcr/1.0}created";

	/**
	 * A constant for the property name jcr:createdBy (in extended form),
	 * declared in node type mix:created.
	 */
	const JCR_CREATED_BY = "{http://www.jcp.org/jcr/1.0}createdBy";

	/**
	 * A constant for the property name jcr:lastModified (in extended form),
	 * declared in node type mix:lastModified.
	 */
	const JCR_LAST_MODIFIED = "{http://www.jcp.org/jcr/1.0}lastModified";

	/**
	 * A constant for the property name jcr:lastModifiedBy (in extended form),
	 * declared in node type mix:lastModified.
	 */
	const JCR_LAST_MODIFIED_BY = "{http://www.jcp.org/jcr/1.0}lastModifiedBy";

	/**
	 * A constant for the property name jcr:language (in extended form),
	 * declared in node types mix:language and nt:query.
	 */
	const JCR_LANGUAGE = "{http://www.jcp.org/jcr/1.0}language";

	/**
	 * A constant for the property name jcr:mimetype (in extended form),
	 * declared in node type mix:mimetype.
	 */
	const JCR_MIMETYPE = "{http://www.jcp.org/jcr/1.0}mimetype";

	/**
	 * A constant for the property name jcr:encoding (in extended form),
	 * declared in node type mix:mimetype.
	 */
	const JCR_ENCODING = "{http://www.jcp.org/jcr/1.0}encoding";

	/**
	 * A constant for the property name jcr:nodeTypeName (in extended form),
	 * declared in node type nt:nodeType.
	 */
	const JCR_NODE_TYPE_NAME = "{http://www.jcp.org/jcr/1.0}nodeTypeName";

	/**
	 * A constant for the property name jcr:supertypes (in extended form),
	 * declared in node type nt:nodeType.
	 */
	const JCR_SUPERTYPES = "{http://www.jcp.org/jcr/1.0}supertypes";

	/**
	 * A constant for the property name jcr:isAbstract (in extended form),
	 * declared in node type nt:nodeType.
	 */
	const JCR_IS_ABSTRACT = "{http://www.jcp.org/jcr/1.0}isAbstract";

	/**
	 * A constant for the property name jcr:isMixin (in extended form),
	 * declared in node type nt:nodeType.
	 */
	const JCR_IS_MIXIN = "{http://www.jcp.org/jcr/1.0}isMixin";

	/**
	 * A constant for the property name jcr:hasOrderableChildNodes (in extended form),
	 * declared in node type nt:nodeType.
	 */
	const JCR_HAS_ORDERABLE_CHILD_NODES = "{http://www.jcp.org/jcr/1.0}hasOrderableChildNodes";

	/**
	 * A constant for the property name jcr:primaryItemName (in extended form),
	 * declared in node type nt:nodeType.
	 */
	const JCR_PRIMARY_ITEM_NAME = "{http://www.jcp.org/jcr/1.0}primaryItemName";

	/**
	 * A constant for the property name jcr:name (in extended form),
	* declared in node types nt:propertyDefinition and nt:childNodeDefinition.
	 */
	const JCR_NAME = "{http://www.jcp.org/jcr/1.0}name";

	/**
	 * A constant for the property name jcr:autoCreated (in extended form),
	* declared in node types nt:propertyDefinition and nt:childNodeDefinition.
	 */
	const JCR_AUTOCREATED = "{http://www.jcp.org/jcr/1.0}autoCreated";

	/**
	 * A constant for the property name jcr:mandatory (in extended form),
	* declared in node types nt:propertyDefinition and nt:childNodeDefinition.
	 */
	const JCR_MANDATORY = "{http://www.jcp.org/jcr/1.0}mandatory";

	/**
	 * A constant for the property name jcr:protected (in extended form),
	 * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
	 */
	const JCR_PROTECTED = "{http://www.jcp.org/jcr/1.0}protected";

	/**
	 * A constant for the property name jcr:onParentVersion (in extended form),
	 * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
	 */
	const JCR_ON_PARENT_VERSION = "{http://www.jcp.org/jcr/1.0}onParentVersion";

	/**
	 * A constant for the property name jcr:requiredType (in extended form),
	 * declared in node type nt:propertyDefinition.
	 */
	const JCR_REQUIRED_TYPE = "{http://www.jcp.org/jcr/1.0}requiredType";

	/**
	 * A constant for the property name jcr:valueConstraints (in extended form),
	 * declared in node type nt:propertyDefinition.
	 */
	const JCR_VALUE_CONSTRAINTS = "{http://www.jcp.org/jcr/1.0}valueConstraints";

	/**
	 * A constant for the property name jcr:defaultValues (in extended form),
	 * declared in node type nt:propertyDefinition.
	 */
	const JCR_DEFAULT_VALUES = "{http://www.jcp.org/jcr/1.0}defaultValues";

	/**
	 * A constant for the property name jcr:multiple (in extended form),
	 * declared in node type nt:propertyDefinition.
	 */
	const JCR_MULTIPLE = "{http://www.jcp.org/jcr/1.0}multiple";

	/**
	 * A constant for the property name jcr:requiredPrimaryTypes (in extended form),
	 * declared in node type nt:childNodeDefinition.
	 */
	const JCR_REQUIRED_PRIMARY_TYPES = "{http://www.jcp.org/jcr/1.0}requiredPrimaryTypes";

	/**
	 * A constant for the property name jcr:defaultPrimaryType (in extended form),
	 * declared in node type nt:childNodeDefinition.
	 */
	const JCR_DEFAULT_PRIMARY_TYPE = "{http://www.jcp.org/jcr/1.0}defaultPrimaryType";

	/**
	 * A constant for the property name jcr:sameNameSiblings (in extended form),
	 * declared in node type nt:childNodeDefinition.
	 */
	const JCR_SAME_NAME_SIBLINGS = "{http://www.jcp.org/jcr/1.0}sameNameSiblings";

	/**
	 * A constant for the property name jcr:lockOwner (in extended form),
	 * declared in node type mix:lockable.
	 */
	const JCR_LOCK_OWNER = "{http://www.jcp.org/jcr/1.0}lockOwner";

	/**
	 * A constant for the property name jcr:lockIsDeep (in extended form),
	 * declared in node type mix:lockable.
	 */
	const JCR_LOCK_IS_DEEP = "{http://www.jcp.org/jcr/1.0}lockIsDeep";

	/**
	 * A constant for the property name jcr:lifecyclePolicy (in extended form),
	 * declared in node type mix:lifecycle.
	 */
	const JCR_LIFECYCLE_POLICY = "{http://www.jcp.org/jcr/1.0}lifecyclePolicy";

	/**
	 * A constant for the property name jcr:currentLifecycleState (in extended form),
	 * declared in node type mix:lifecycle.
	 */
	const JCR_CURRENT_LIFECYCLE_STATE = "{http://www.jcp.org/jcr/1.0}currentLifecycleState";

	/**
	 * A constant for the property name jcr:isCheckedOut (in extended form),
	 * declared in node type mix:simpleVersionable.
	 */
	const JCR_IS_CHECKED_OUT = "{http://www.jcp.org/jcr/1.0}isCheckedOut";

	/**
	 * A constant for the property name jcr:frozenPrimaryType (in extended form),
	 * declared in node type nt:frozenNode.
	 */
	const JCR_FROZEN_PRIMARY_TYPE = "{http://www.jcp.org/jcr/1.0}frozenPrimaryType";

	/**
	 * A constant for the property name jcr:frozenMixinTypes (in extended form),
	 * declared in node type nt:frozenNode.
	 */
	const JCR_FROZEN_MIXIN_TYPES = "{http://www.jcp.org/jcr/1.0}frozenMixinTypes";

	/**
	 * A constant for the property name jcr:frozenUuid (in extended form),
	 * declared in node type nt:frozenNode.
	 */
	const JCR_FROZEN_UUID = "{http://www.jcp.org/jcr/1.0}frozenUuid";

	/**
	 * A constant for the property name jcr:versionHistory (in extended form),
	 * declared in node type mix:versionable.
	 */
	const JCR_VERSION_HISTORY = "{http://www.jcp.org/jcr/1.0}versionHistory";

	/**
	 * A constant for the property name jcr:baseVersion (in extended form),
	 * declared in node type mix:versionable.
	 */
	const JCR_BASE_VERSION = "{http://www.jcp.org/jcr/1.0}baseVersion";

	/**
	 * A constant for the property name jcr:predecessors (in extended form),
	 * declared in node types mix:versionable and nt:version.
	 */
	const JCR_PREDECESSORS = "{http://www.jcp.org/jcr/1.0}predecessors";

	/**
	 * A constant for the property name jcr:mergeFailed (in extended form),
	 * declared in node type mix:versionable.
	 */
	const JCR_MERGE_FAILED = "{http://www.jcp.org/jcr/1.0}mergeFailed";

	/**
	 * A constant for the property name jcr:activity (in extended form),
	 * declared in node types mix:versionable and nt:version.
	 */
	const JCR_ACTIVITY = "{http://www.jcp.org/jcr/1.0}activity";

	/**
	 * A constant for the property name jcr:configuration (in extended form),
	 * declared in node type mix:versionable.
	 */
	const JCR_CONFIGURATION = "{http://www.jcp.org/jcr/1.0}configuration";

	/**
	 * A constant for the property name jcr:versionableUuid (in extended form),
	 * declared in node type nt:version.
	 */
	const JCR_VERSIONABLE_UUID = "{http://www.jcp.org/jcr/1.0}versionableUuid";

	/**
	 * A constant for the property name jcr:copiedFrom (in extended form),
	 * declared in node type nt:version.
	 */
	const JCR_COPIED_FROM = "{http://www.jcp.org/jcr/1.0}copiedFrom";

	/**
	 * A constant for the property name jcr:successors (in extended form),
	 * declared in node type nt:version.
	 */
	const JCR_SUCCESSORS = "{http://www.jcp.org/jcr/1.0}successors";

	/**
	 * A constant for the property name jcr:childVersionHistory (in extended form),
	 * declared in node type nt:versionedChild.
	 */
	const JCR_CHILD_VERSION_HISTORY = "{http://www.jcp.org/jcr/1.0}childVersionHistory";

	/**
	 * A constant for the property name jcr:root (in extended form),
	 * declared in node type nt:configuration.
	 */
	const JCR_ROOT = "{http://www.jcp.org/jcr/1.0}root";

	/**
	 * A constant for the property name jcr:statement (in extended form),
	 * declared in node type nt:query.
	 */
	const JCR_STATEMENT = "{http://www.jcp.org/jcr/1.0}statement";

	/**
	 * Sets the value of this property to value. If this property's property
	 * type is not constrained by the node type of its parent node, then the
	 * property type is changed to that of the supplied value. If the property
	 * type is constrained, then a best-effort conversion is attempted. If
	 * conversion fails, a ValueFormatException is thrown immediately (not on
	 * save). The change will be persisted (if valid) on save
	 *
	 * For Node objects as value:
	 * Sets this REFERENCE property to refer to the specified node. If this
	 * property is not of type REFERENCE or the specified node is not
	 * referenceable (i.e., is not of mixin node type mix:referenceable and
	 * therefore does not have a UUID) then a ValueFormatException is thrown.
	 *
	 * If value is an array:
	 * If this property is not multi-valued then a ValueFormatException is
	 * thrown immediately.
	 *
	 * @param mixed $value The value to set
	 * @return void
	 * @throws F3::PHPCR::ValueFormatException if the type or format of the specified value is incompatible with the type of this property.
	 * @throws F3::PHPCR::Version::VersionException if this property belongs to a node that is versionable and checked-in or is non-versionable but whose nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::Lock::LockException if a lock prevents the setting of the value and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::ConstraintViolationException if the change would violate a node-type or other constraint and this implementation performs this validation immediately instead of waiting until save.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	*/
	public function setValue($value);

	/**
	 * Returns the value of this property as a Value object.
	 *
	 * The object returned is a copy of the stored value and is immutable.
	 *
	 * @return F3::PHPCR::ValueInterface the value
	 * @throws F3::PHPCR::ValueFormatException if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getValue();

	/**
	 * Returns an array of all the values of this property. Used to access
	 * multi-value properties. If the property is single-valued, this method
	 * throws a ValueFormatException. The array returned is a copy of the
	 * stored values, so changes to it are not reflected in internal storage.
	 *
	 * @return array of F3::PHPCR::ValueInterface
	 * @throws F3::PHPCR::ValueFormatException if the property is single-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getValues();

	/**
	 * Returns a String representation of the value of this property. A
	 * shortcut for Property.getValue().getString(). See Value.
	 *
	 * @return string A string representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if conversion to a String is not possible or if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getString();

	/**
	 * Returns a Binary representation of the value of this property. A
	 * shortcut for Property.getValue().getBinary(). See Value.
	 *
	 * @return F3::PHPCR::BinaryInterface A Binary representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getBinary();

	/**
	 * Returns an integer representation of the value of this property. A shortcut
	 * for Property.getValue().getLong(). See Value.
	 *
	 * @return integer An integer representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if conversion to a long is not possible or if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getLong();

	/**
	 * Returns a double representation of the value of this property. A
	 * shortcut for Property.getValue().getDouble(). See Value.
	 *
	 * @return float A float representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if conversion to a double is not possible or if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getDouble();

	/**
	 * Returns a BigDecimal representation of the value of this property. A
	 * shortcut for Property.getValue().getDecimal(). See Value.
	 *
	 * @return float A float representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if conversion to a BigDecimal is not possible or if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getDecimal();

	/**
	 * Returns a DateTime representation of the value of this property. A
	 * shortcut for Property.getValue().getDate(). See Value.
	 * The object returned is a copy of the stored value, so changes to it
	 * are not reflected in internal storage.
	 *
	 * @return DateTime A date representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if conversion to a string is not possible or if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getDate();

	/**
	 * Returns a boolean representation of the value of this property. A
	 * shortcut for Property.getValue().getBoolean(). See Value.
	 *
	 * @return boolean A boolean representation of the value of this property.
	 * @throws F3::PHPCR::ValueFormatException if conversion to a boolean is not possible or if the property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getBoolean();

	/**
	 * If this property is of type REFERENCE, WEAKREFERENCE or PATH (or
	 * convertible to one of these types) this method returns the Node to
	 * which this property refers.
	 * If this property is of type PATH and it contains a relative path, it is
	 * interpreted relative to the parent node of this property. For example "."
	 * refers to the parent node itself, ".." to the parent of the parent node
	 * and "foo" to a sibling node of this property.
	 *
	 * @return F3::PHPCR::NodeInterface the referenced Node
	 * @throws F3::PHPCR::ValueFormatException if this property cannot be converted to a referring type (REFERENCE, WEAKREFERENCE or PATH), if the property is multi-valued or if this property is a referring type but is currently part of the frozen state of a version in version storage.
	 * @throws F3::PHPCR::ItemNotFoundException If this property is of type PATH and no node accessible by the current Session exists in this workspace at the specified path.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getNode();

	/**
	 * If this property is of type PATH (or convertible to this type) this
	 * method returns the Property to which this property refers.
	 * If this property contains a relative path, it is interpreted relative
	 * to the parent node of this property. For example "." refers to the
	 * parent node itself, ".." to the parent of the parent node and "foo" to a
	 * sibling property of this property or this property itself.
	 *
	 * @return F3::PHPCR::PropertyInterface the referenced property
	 * @throws F3::PHPCR::ValueFormatException if this property cannot be converted to a PATH, if the property is multi-valued or if this property is a referring type but is currently part of the frozen state of a version in version storage.
	 * @throws F3::PHPCR::ItemNotFoundException If this property is of type PATH and no property accessible by the current Session exists in this workspace at the specified path.
	 * @throws F3::PHPCR::RepositoryException if another error occurs
	 */
	public function getProperty();

	/**
	 * Returns the length of the value of this property.
	 *
	 * For a BINARY property, getLength returns the number of bytes.
	 * For other property types, getLength returns the same value that would be
	 * returned by calling strlen() on the value when it has been converted to a
	 * STRING according to standard JCR propety type conversion.
	 *
	 * Returns -1 if the implementation cannot determine the length.
	 *
	 * @return integer an integer.
	 * @throws F3::PHPCR::ValueFormatException if this property is multi-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getLength();

	/**
	 * Returns an array holding the lengths of the values of this (multi-value)
	 * property in bytes where each is individually calculated as described in
	 * getLength().
	 *
	 * @return array an array of lengths
	 * @throws F3::PHPCR::ValueFormatException if this property is single-valued.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getLengths();

	/**
	 * Returns the property definition that applies to this property. In some
	 * cases there may appear to be more than one definition that could apply
	 * to this node. However, it is assumed that upon creation or change of
	 * this property, a single particular definition is chosen by the
	 * implementation. It is that definition that this method returns. How this
	 * governing definition is selected upon property creation or change from
	 * among others which may have been applicable is an implementation issue
	 * and is not covered by this specification.
	 *
	 * @return F3::PHPCR::NodeType::PropertyDefinitionInterface a PropertyDefinition object.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getDefinition();

	/**
	 * Returns the type of this Property. One of:
	 * * PropertyType.STRING
	 * * PropertyType.BINARY
	 * * PropertyType.DATE
	 * * PropertyType.DOUBLE
	 * * PropertyType.LONG
	 * * PropertyType.BOOLEAN
	 * * PropertyType.NAME
	 * * PropertyType.PATH
	 * * PropertyType.REFERENCE
	 * * PropertyType.WEAKREFERENCE
	 * * PropertyType.URI
	 *
	 * The type returned is that which was set at property creation. Note that
	 * for some property p, the type returned by p.getType() will differ from
	 * the type returned by p.getDefinition.getRequiredType() only in the case
	 * where the latter returns UNDEFINED. The type of a property instance is
	 * never UNDEFINED (it must always have some actual type).
	 *
	 * @return integer an int
	 * @throws F3::PHPCR::RepositoryException if an error occurs
	 */
	public function getType();

}

?>