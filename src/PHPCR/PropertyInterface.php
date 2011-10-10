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
 * The property interface describes how an item property shall look like.
 *
 * A Property object represents the smallest granularity of content storage.
 * It has a single parent node and no children. A property consists of a name
 * and a value, or in the case of multi-value properties, a set of values all
 * of the same type.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. Properties have to implement either \IteratorAggregate or
 * \Iterator.
 * The iterator is equivalent to <b>getValue()</b> returning an iterator
 * of all values of this property (which is exactly one except for multivalue
 * properties). The iterator keys have no significant meaning.
 *
 * <b>PHPCR Note:</b>
 * We removed the Value interface and consequently the getValue() and
 * getValues() methods. If you just want the property value in its native type,
 * use getValue, or just NodeInterface::getPropertyValue.
 * The PropertyInterface::getXX methods also work for multivalue properties.
 * They return arrays in case of multivalue.
 * PropertyInterface::setValue completely replaces the
 * ValueFactory::createValue method.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface PropertyInterface extends \PHPCR\ItemInterface, \Traversable
{
    /**
     * @var string
     */

    /**
     * A constant for the property name jcr:primaryType (in extended form),
     * declared in node type nt:base.
     * @api
     */
    const JCR_PRIMARY_TYPE = "{http://www.jcp.org/jcr/1.0}primaryType";

    /**
     * A constant for the property name jcr:mixinTypes (in extended form),
     * declared in node type nt:base.
     * @api
     */
    const JCR_MIXIN_TYPES = "{http://www.jcp.org/jcr/1.0}mixinTypes";

    /**
     * A constant for the property name jcr:content (in extended form),
     * declared in node type nt:linkedFile.
     *
     * <b>Note:</b> jcr:content is also the name of a child node declared in nt:file.
     * @api
     */
    const JCR_CONTENT = "{http://www.jcp.org/jcr/1.0}content";

    /**
     * A constant for the property name jcr:data (in extended form),
     * declared in node type nt:resource.
     * @api
     */
    const JCR_DATA = "{http://www.jcp.org/jcr/1.0}data";

    /**
     * A constant for the property name jcr:protocol (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_PROTOCOL = "{http://www.jcp.org/jcr/1.0}protocol";

    /**
     * A constant for the property name jcr:host (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_HOST = "{http://www.jcp.org/jcr/1.0}host";

    /**
     * A constant for the property name jcr:port (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_PORT = "{http://www.jcp.org/jcr/1.0}port";

    /**
     * A constant for the property name jcr:repository (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_REPOSITORY = "{http://www.jcp.org/jcr/1.0repository";

    /**
     * A constant for the property name jcr:workspace (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_WORKSPACE = "{http://www.jcp.org/jcr/1.0}workspace";

    /**
     * A constant for the property name jcr:path (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_PATH = "{http://www.jcp.org/jcr/1.0}path";

    /**
     * A constant for the property name jcr:id (in extended form),
     * declared in node type nt:address.
     * @api
     */
    const JCR_ID = "{http://www.jcp.org/jcr/1.0}id";

    /**
     * A constant for the property name jcr:uuid (in extended form),
     * declared in node type mix:referenceable.
     * @api
     */
    const JCR_UUID = "{http://www.jcp.org/jcr/1.0}uuid";

    /**
     * A constant for the property name jcr:title (in extended form),
     * declared in node types mix:title and nt:activity.
     * @api
     */
    const JCR_TITLE = "{http://www.jcp.org/jcr/1.0}title";

    /**
     * A constant for the property name jcr:description (in extended form),
     * declared in node type mix:title.
     * @api
     */
    const JCR_DESCRIPTION = "{http://www.jcp.org/jcr/1.0}description";

    /**
     * A constant for the property name jcr:created (in extended form),
     * declared in node types mix:created and nt:version.
     * @api
     */
    const JCR_CREATED = "{http://www.jcp.org/jcr/1.0}created";

    /**
     * A constant for the property name jcr:createdBy (in extended form),
     * declared in node type mix:created.
     * @api
     */
    const JCR_CREATED_BY = "{http://www.jcp.org/jcr/1.0}createdBy";

    /**
     * A constant for the property name jcr:lastModified (in extended form),
     * declared in node type mix:lastModified.
     * @api
     */
    const JCR_LAST_MODIFIED = "{http://www.jcp.org/jcr/1.0}lastModified";

    /**
     * A constant for the property name jcr:lastModifiedBy (in extended form),
     * declared in node type mix:lastModified.
     * @api
     */
    const JCR_LAST_MODIFIED_BY = "{http://www.jcp.org/jcr/1.0}lastModifiedBy";

    /**
     * A constant for the property name jcr:language (in extended form),
     * declared in node types mix:language and nt:query.
     * @api
     */
    const JCR_LANGUAGE = "{http://www.jcp.org/jcr/1.0}language";

    /**
     * A constant for the property name jcr:mimeType (in extended form),
     * declared in node type mix:mimeType.
     * @api
     */
    const JCR_MIMETYPE = "{http://www.jcp.org/jcr/1.0}mimeType";

    /**
     * A constant for the property name jcr:encoding (in extended form),
     * declared in node type mix:mimeType.
     * @api
     */
    const JCR_ENCODING = "{http://www.jcp.org/jcr/1.0}encoding";

    /**
     * A constant for the property name jcr:nodeTypeName (in extended form),
     * declared in node type nt:nodeType.
     * @api
     */
    const JCR_NODE_TYPE_NAME = "{http://www.jcp.org/jcr/1.0}nodeTypeName";

    /**
     * A constant for the property name jcr:supertypes (in extended form),
     * declared in node type nt:nodeType.
     * @api
     */
    const JCR_SUPERTYPES = "{http://www.jcp.org/jcr/1.0}supertypes";

    /**
     * A constant for the property name jcr:isAbstract (in extended form),
     * declared in node type nt:nodeType.
     * @api
     */
    const JCR_IS_ABSTRACT = "{http://www.jcp.org/jcr/1.0}isAbstract";

    /**
     * A constant for the property name jcr:isMixin (in extended form),
     * declared in node type nt:nodeType.
     * @api
     */
    const JCR_IS_MIXIN = "{http://www.jcp.org/jcr/1.0}isMixin";

    /**
     * A constant for the property name jcr:hasOrderableChildNodes (in extended form),
     * declared in node type nt:nodeType.
     * @api
     */
    const JCR_HAS_ORDERABLE_CHILD_NODES = "{http://www.jcp.org/jcr/1.0}hasOrderableChildNodes";

    /**
     * A constant for the property name jcr:primaryItemName (in extended form),
     * declared in node type nt:nodeType.
     * @api
     */
    const JCR_PRIMARY_ITEM_NAME = "{http://www.jcp.org/jcr/1.0}primaryItemName";

    /**
     * A constant for the property name jcr:name (in extended form),
     * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
     * @api
     */
    const JCR_NAME = "{http://www.jcp.org/jcr/1.0}name";

    /**
     * A constant for the property name jcr:autoCreated (in extended form),
     * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
     * @api
     */
    const JCR_AUTOCREATED = "{http://www.jcp.org/jcr/1.0}autoCreated";

    /**
     * A constant for the property name jcr:mandatory (in extended form),
     * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
     * @api
     */
    const JCR_MANDATORY = "{http://www.jcp.org/jcr/1.0}mandatory";

    /**
     * A constant for the property name jcr:protected (in extended form),
     * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
     * @api
     */
    const JCR_PROTECTED = "{http://www.jcp.org/jcr/1.0}protected";

    /**
     * A constant for the property name jcr:onParentVersion (in extended form),
     * declared in node types nt:propertyDefinition and nt:childNodeDefinition.
     * @api
     */
    const JCR_ON_PARENT_VERSION = "{http://www.jcp.org/jcr/1.0}onParentVersion";

    /**
     * A constant for the property name jcr:requiredType (in extended form),
     * declared in node type nt:propertyDefinition.
     * @api
     */
    const JCR_REQUIRED_TYPE = "{http://www.jcp.org/jcr/1.0}requiredType";

    /**
     * A constant for the property name jcr:valueConstraints (in extended form),
     * declared in node type nt:propertyDefinition.
     * @api
     */
    const JCR_VALUE_CONSTRAINTS = "{http://www.jcp.org/jcr/1.0}valueConstraints";

    /**
     * A constant for the property name jcr:defaultValues (in extended form),
     * declared in node type nt:propertyDefinition.
     * @api
     */
    const JCR_DEFAULT_VALUES = "{http://www.jcp.org/jcr/1.0}defaultValues";

    /**
     * A constant for the property name jcr:multiple (in extended form),
     * declared in node type nt:propertyDefinition.
     * @api
     */
    const JCR_MULTIPLE = "{http://www.jcp.org/jcr/1.0}multiple";

    /**
     * A constant for the property name jcr:requiredPrimaryTypes (in extended form),
     * declared in node type nt:childNodeDefinition.
     * @api
     */
    const JCR_REQUIRED_PRIMARY_TYPES = "{http://www.jcp.org/jcr/1.0}requiredPrimaryTypes";

    /**
     * A constant for the property name jcr:defaultPrimaryType (in extended form),
     * declared in node type nt:childNodeDefinition.
     * @api
     */
    const JCR_DEFAULT_PRIMARY_TYPE = "{http://www.jcp.org/jcr/1.0}defaultPrimaryType";

    /**
     * A constant for the property name jcr:sameNameSiblings (in extended form),
     * declared in node type nt:childNodeDefinition.
     * @api
     */
    const JCR_SAME_NAME_SIBLINGS = "{http://www.jcp.org/jcr/1.0}sameNameSiblings";

    /**
     * A constant for the property name jcr:lockOwner (in extended form),
     * declared in node type mix:lockable.
     * @api
     */
    const JCR_LOCK_OWNER = "{http://www.jcp.org/jcr/1.0}lockOwner";

    /**
     * A constant for the property name jcr:lockIsDeep (in extended form),
     * declared in node type mix:lockable.
     * @api
     */
    const JCR_LOCK_IS_DEEP = "{http://www.jcp.org/jcr/1.0}lockIsDeep";

    /**
     * A constant for the property name jcr:lifecyclePolicy (in extended form),
     * declared in node type mix:lifecycle.
     * @api
     */
    const JCR_LIFECYCLE_POLICY = "{http://www.jcp.org/jcr/1.0}lifecyclePolicy";

    /**
     * A constant for the property name jcr:currentLifecycleState (in extended form),
     * declared in node type mix:lifecycle.
     * @api
     */
    const JCR_CURRENT_LIFECYCLE_STATE = "{http://www.jcp.org/jcr/1.0}currentLifecycleState";

    /**
     * A constant for the property name jcr:isCheckedOut (in extended form),
     * declared in node type mix:simpleVersionable.
     * @api
     */
    const JCR_IS_CHECKED_OUT = "{http://www.jcp.org/jcr/1.0}isCheckedOut";

    /**
     * A constant for the property name jcr:frozenPrimaryType (in extended form),
     * declared in node type nt:frozenNode.
     * @api
     */
    const JCR_FROZEN_PRIMARY_TYPE = "{http://www.jcp.org/jcr/1.0}frozenPrimaryType";

    /**
     * A constant for the property name jcr:frozenMixinTypes (in extended form),
     * declared in node type nt:frozenNode.
     * @api
     */
    const JCR_FROZEN_MIXIN_TYPES = "{http://www.jcp.org/jcr/1.0}frozenMixinTypes";

    /**
     * A constant for the property name jcr:frozenUuid (in extended form),
     * declared in node type nt:frozenNode.
     * @api
     */
    const JCR_FROZEN_UUID = "{http://www.jcp.org/jcr/1.0}frozenUuid";

    /**
     * A constant for the property name jcr:versionHistory (in extended form),
     * declared in node type mix:versionable.
     * @api
     */
    const JCR_VERSION_HISTORY = "{http://www.jcp.org/jcr/1.0}versionHistory";

    /**
     * A constant for the property name jcr:baseVersion (in extended form),
     * declared in node type mix:versionable.
     * @api
     */
    const JCR_BASE_VERSION = "{http://www.jcp.org/jcr/1.0}baseVersion";

    /**
     * A constant for the property name jcr:predecessors (in extended form),
     * declared in node types mix:versionable and nt:version.
     * @api
     */
    const JCR_PREDECESSORS = "{http://www.jcp.org/jcr/1.0}predecessors";

    /**
     * A constant for the property name jcr:mergeFailed (in extended form),
     * declared in node type mix:versionable.
     * @api
     */
    const JCR_MERGE_FAILED = "{http://www.jcp.org/jcr/1.0}mergeFailed";

    /**
     * A constant for the property name jcr:activity (in extended form),
     * declared in node types mix:versionable and nt:version.
     * @api
     */
    const JCR_ACTIVITY = "{http://www.jcp.org/jcr/1.0}activity";

    /**
     * A constant for the property name jcr:configuration (in extended form),
     * declared in node type mix:versionable.
     * @api
     */
    const JCR_CONFIGURATION = "{http://www.jcp.org/jcr/1.0}configuration";

    /**
     * A constant for the property name jcr:versionableUuid (in extended form),
     * declared in node type nt:version.
     * @api
     */
    const JCR_VERSIONABLE_UUID = "{http://www.jcp.org/jcr/1.0}versionableUuid";

    /**
     * A constant for the property name jcr:copiedFrom (in extended form),
     * declared in node type nt:version.
     * @api
     */
    const JCR_COPIED_FROM = "{http://www.jcp.org/jcr/1.0}copiedFrom";

    /**
     * A constant for the property name jcr:successors (in extended form),
     * declared in node type nt:version.
     * @api
     */
    const JCR_SUCCESSORS = "{http://www.jcp.org/jcr/1.0}successors";

    /**
     * A constant for the property name jcr:childVersionHistory (in extended form),
     * declared in node type nt:versionedChild.
     * @api
     */
    const JCR_CHILD_VERSION_HISTORY = "{http://www.jcp.org/jcr/1.0}childVersionHistory";

    /**
     * A constant for the property name jcr:root (in extended form),
     * declared in node type nt:configuration.
     * @api
     */
    const JCR_ROOT = "{http://www.jcp.org/jcr/1.0}root";

    /**
     * A constant for the property name jcr:statement (in extended form),
     * declared in node type nt:query.
     * @api
     */
    const JCR_STATEMENT = "{http://www.jcp.org/jcr/1.0}statement";

    /**
     * Sets the value of this property to the value.
     *
     * If the type parameter is present and this implementation supports
     * dynamic re-binding of properties, this property changes its type.
     * First, a conversion of value into that type is attempted with
     * PropertyType::convertType() and if there is no ValueFormatException,
     * the property type changes to the new type.
     * If the node type does not allow the requested type, a
     * ConstraintViolationException is thrown.
     * If the implementation does not support dynamic re-binding, an
     * UnsupportedRepositoryException is thrown if the type parameter is
     * present and different from the current type.
     *
     * If no explicit type is given, then the type is derived from the value.
     * (First value in case of multivalue property.)
     * If the node type allows the type of the parameter, this property changes
     * its type to the type of the value. Otherwise, a conversion of the value
     * into the required type is attempted with PropertyType::convertType()
     *
     * If value is of type PropertyInterface, the value of the property is
     * copied into this property. (If type is set, the property value is
     * converted into this type, otherwise the type of the property is used
     * as in the case of no explicit type).
     * This can be used to copy a binary from one property into another without
     * getting the stream. The implemenation should take care to detect the
     * case and copy the binary data directly in the backend for optimal
     * performance.
     *
     * The type detection follows PropertyType::determineType. Thus, passing a
     * Node object without an explicit type (REFERENCE or WEAKREFERENCE) will
     * create a REFERENCE property. If the specified node is not referenceable,
     * a ValueFormatException is thrown.
     *
     * To create a PATH property with a reference to an other property, you can
     * call setValue with the return value of getPath called on the other
     * property and the PATH type constant. Passing the property itself and the
     * PATH type will convert the *value* of the property to a path.
     *
     * When assigning a stream resource to write a binary property, the client
     * application must leave the stream alone afterwards. The PHPCR
     * implementation is responsible for closing it after saving.
     *
     * This method is a session-write and therefore requires a <code>save</code>
     * to dispatch the change.
     *
     * If value is an array:
     * If this property is not multi-valued then a ValueFormatException is
     * thrown immediately.
     *
     * <strong>PHPCR Note:</strong> The Java API defines this method with
     *      multiple differing signatures.
     * <strong>PHPCR Note:</strong> Because we removed the Value interface,
     *      this method replaces ValueFactory::createValue.
     *
     * @param mixed $value The value to set
     * @param integer $type Type request for the property, optional. Must be a
     *      constant from PropertyType
     *
     * @return void
     *
     * @throws \PHPCR\ValueFormatException if the type or format of the
     *      specified value is incompatible with the type of this property.
     * @throws \PHPCR\Version\VersionException if this property belongs to a
     *      node that is read-only due to a checked-in node and this
     *      implementation performs this validation immediately.
     * @throws \PHPCR\Lock\LockException if a lock prevents the setting of the
     *      value and this implementation performs this validation immediately.
     * @throws \PHPCR\NodeType\ConstraintViolationException if the change would
     *      violate a node-type or other constraint and this implementation
     *      performs this validation immediately.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if the type
     *      parameter is set and different from the current type and this
     *      implementation does not support dynamic re-binding
     * @throws \InvalidArgumentException if the specified DateTime value
     *      cannot be expressed in the ISO 8601-based format defined in the JCR
     *      2.0 specification and the implementation does not support dates
     *      incompatible with that format.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    function setValue($value, $type = null);

    /**
     * Appends a value to a multi-value property. It is added at the end of the
     * list.
     *
     * <strong>PHPCR Note:</strong> This is a new method not found in Java JCR.
     * In PHP appending to strings is easy and this is more convenient than
     * getting the property and appending to the array and setting again.
     *
     * @param mixed value
     * @throws \PHPCR\ValueFormatException if the property is not multi-value.
     */
    function addValue($value);

    /**
     * Get the value in format default for the PropertyType of this property.
     *
     * In case of a (WEAK)REFERENCE, the node is dereferenced and returned. For
     * all other cases including PATH, the value is returned as is. If you want
     * to dereference a PATH to a property or node, you need to explicitly call
     * getNode() resp. getProperty().
     *
     * <b>PHPCR Note:</b> We dropped the Value interface as its unnecessary
     * with weak typing.
     *
     * @return mixed value of this property, or array in case of multi-value.
     */
    function getValue();

    /**
     * Returns a String representation of the value of this property.
     *
     * @return string A string representation of the value of this property, or
     *      an array of string for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if conversion to a String is not possible
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    function getString();

    /**
     * Returns a Binary representation of the value of this property.
     *
     * The Binary object in turn provides methods to access the binary data
     * itself. Uses the standard conversion to binary (see JCR specification).
     *
     * @return resource A stream resource if the underlying binary
     *
     * @throws \PHPCR\RepositoryException if another error occurs
     * @api
     */
    function getBinary();

    /**
     * Returns an integer representation of the value of this property.
     *
     * @return integer An integer representation of the value of this property,
     *      or an array of integer for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if conversion to integer is not
     *      possible
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getLong();

    /**
     * Returns a float representation of the value of this property.
     *
     * @return float A float representation of the value of this property, or
     *      an array of float for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if conversion to a double is not possible
     *
     * @throws \PHPCR\RepositoryException if another error occurs
     * @api
     */
    function getDouble();

    /**
     * Returns an arbitrary precision number (encoded as string) representation
     * of this value (a BigDecimal in Java).
     *
     * The string must be encoded with the C locale because of
     * http://bugs.php.net/bug.php?id=16532
     *
     * @return string A string representation of the value of this property, or
     *      an array of strings for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if conversion to a number string is
     *      not possible
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getDecimal();

    /**
     * Returns a \DateTime representation of the value of this property.
     *
     * The object returned is a copy of the stored value, so changes to it are
     * not reflected in internal storage.
     *
     * @return \DateTime A date representation of the value of this property,
     *      or an array of DateTime for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if conversion to \DateTime is not
     *      possible
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getDate();

    /**
     * Returns a boolean representation of the value of this property.
     *
     * <b>PHP Note:</b>Keep in mind that according to the specification, not
     * all property types can be converted to boolean. Most actually can not
     * be converted - see \PHPCR\PropertyType::convertType().
     * If you want to know if a value is empty in the PHP sense, use
     * getString() and do your checks on the string.
     *
     * @return boolean A boolean representation of the value of this property,
     *      or an array of boolean for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if conversion to a boolean is not
     *      possible
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getBoolean();

    /**
     * Gets the node the property refers to by its type.
     *
     * If this property is of type REFERENCE, WEAKREFERENCE or PATH (or
     * convertible to one of these types) this method returns the Node to
     * which this property refers.
     * If this property is of type PATH and it contains a relative path, it is
     * interpreted relative to the parent node of this property. For example "."
     * refers to the parent node itself, ".." to the parent of the parent node
     * and "foo" to a sibling node of this property.
     *
     * If you do not want to dereference the nodes yet, you can use getString
     * to get the unique ids and use the SessionInterface::getNodeByIdentifier
     * as all referenced nodes are referenciable and thus must have a uuid.
     * If its a PATH property, you will need the node of this property and use
     * getNodes to get the nodes with relative or absolute path.
     *
     * @return \PHPCR\NodeInterface the referenced Node, or an array of Nodes
     *      for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if this property cannot be converted
     *      to a referring type (REFERENCE, WEAKREFERENCE or PATH) or if this
     *      property is a referring type but is currently part of the frozen
     *      state of a version in version storage.
     * @throws \PHPCR\ItemNotFoundException If this property is of type PATH or
     *      WEAKREFERENCE and no target node accessible by the current Session
     *      exists in this workspace. Note that this applies even if the
     *      property is a PATH and a property exists at the specified location.
     *      To dereference to a target property (as opposed to a target node),
     *      the method PropertyInterface::getProperty() is used.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function getNode();

    /**
     * Gets the property the property refers to by its type.
     *
     * If this property is of type PATH (or convertible to this type) this
     * method returns the Property to which this property refers.
     * If this property contains a relative path, it is interpreted relative
     * to the parent node of this property. Therefore, when resolving such a
     * relative path, the segment "." refers to the parent node itself, ".." to
     * the parent of the parent node and "foo" to a sibling property of this
     * property or this property itself.
     *
     * For example, if this property is located at /a/b/c and it has a value of
     * "../d" then this method will return the property at /a/d if such exists.
     *
     * @return \PHPCR\PropertyInterface the referenced property, or an array of
     *      properties for multi-valued properties.
     *
     * @throws \PHPCR\ValueFormatException if this property cannot be converted
     *      to a PATH or if this property is a referring type but is currently
     *      part of the frozen state of a version in version storage.
     * @throws \PHPCR\ItemNotFoundException If no property accessible by the
     *      current Session exists in this workspace at the specified path.
     *      Note that this applies even if a node exists at the specified
     *      location. To dereference to a target node, the method
     *      PropertyInterface::getNode() is used.
     * @throws \PHPCR\RepositoryException if another error occurs
     *
     * @api
     */
    function getProperty();

    /**
     * Returns the length(s) of the value(s) of this property.
     *
     * For a BINARY property, getLength returns the number of bytes.
     * For other property types, getLength returns the same value that would be
     * returned by calling strlen() on the value when it has been converted to
     * a STRING according to standard JCR propety type conversion.
     *
     * Returns -1 if the implementation cannot determine the length.
     *
     * For multivalue properties, the same rules apply, but returns an array of
     * lengths with the same order as the values have in getValue.
     *
     * @return mixed integer with the length, for multivalue property array of
     *      lengths
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getLength();

    /**
     * Returns the property definition that applies to this property.
     *
     * In some cases there may appear to be more than one definition that could
     * apply to this node. However, it is assumed that upon creation or change
     * of this property, a single particular definition is chosen by the
     * implementation. It is that definition that this method returns. How this
     * governing definition is selected upon property creation or change from
     * among others which may have been applicable is an implementation issue
     * and is not covered by this specification.
     *
     * @return \PHPCR\NodeType\PropertyDefinitionInterface a PropertyDefinition
     *      object.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function getDefinition();

    /**
     * Returns the type of this Property.
     *
     * Following property types are available:
     *
     * - PropertyType::STRING
     * - PropertyType::BINARY
     * - PropertyType::DATE
     * - PropertyType::DOUBLE
     * - PropertyType::LONG
     * - PropertyType::BOOLEAN
     * - PropertyType::NAME
     * - PropertyType::PATH
     * - PropertyType::REFERENCE
     * - PropertyType::WEAKREFERENCE
     * - PropertyType::URI
     *
     * The type returned is that which was set at property creation. Note that
     * for some property p, the type returned by $p->getType() will differ from
     * the type returned by $p->getDefinition()->getRequiredType() only in the
     * case where the latter returns UNDEFINED. The type of a property instance
     * is never UNDEFINED (it must always have some actual type).
     *
     * @return integer The numerical representation of a property type.
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @see \PHPCR\PropertyType
     *
     * @api
     */
    function getType();

    /**
     * Determines if the current property is multi-valued.
     *
     * Returns true if this property is multi-valued and false if this property
     * is single-valued.
     *
     * @return boolean true if this property is multi-valued; false otherwise.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    function isMultiple();
}
