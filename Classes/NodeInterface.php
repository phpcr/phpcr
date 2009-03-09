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
 * The Node interface represents a node in the hierarchy that makes up the repository.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface NodeInterface extends \F3\PHPCR\ItemInterface {

	/**
	 * A constant for the node name jcr:content declared in NodeType nt:file.
	 * Note, jcr:content is also the name of a property declared in nt:linkedFile.
	 */
	const JCR_CONTENT = "{http://www.jcp.org/jcr/1.0}content";

	/**
	 * A constant for the node name jcr:propertyDefinition declared in nt:nodeType.
	 */
	const JCR_PROPERTY_DEFINITION = "{http://www.jcp.org/jcr/1.0}propertyDefinition";

	/**
	 * A constant for the node name jcr:childNodeDefinition declared in nt:nodeType.
	 */
	const JCR_CHILD_NODE_DEFINITION = "{http://www.jcp.org/jcr/1.0}childNodeDefinition";

	/**
	 * A constant for the node name jcr:rootVersion declared in nt:versionHistory.
	 */
	const JCR_ROOT_VERSION = "{http://www.jcp.org/jcr/1.0}rootVersion";

	/**
	 * A constant for the node name jcr:versionLabels declared in nt:versionHistory.
	 */
	const JCR_VERSION_LABELS = "{http://www.jcp.org/jcr/1.0}versionLabels";

	/**
	 * A constant for the node name jcr:frozenNode declared in nt:version.
	 */
	const JCR_FROZEN_NODE = "{http://www.jcp.org/jcr/1.0}frozenNode";

	/**
	 * Creates a new node at relPath. The new node will only be persisted on
	 * save() if it meets the constraint criteria of the parent node's node
	 * type.
	 * In order to save a newly added node, save must be called either on the
	 * Session, or on the new node's parent or higher-order ancestor (grandparent,
	 * etc.). An attempt to call save only on the newly added node will throw a
	 * RepositoryException.
	 *
	 * In the context of this method the relPath provided must not have an index
	 * on its final element. If it does then a RepositoryException is thrown.
	 *
	 * Strictly speaking, the parameter is actually a relative path to the parent
	 * node of the node to be added, appended with the name desired for the new
	 * node (if the a node is being added directly below this node then only the
	 * name need be specified). It does not specify a position within the child
	 * node ordering. If ordering is supported by the node type of the parent node
	 * then the new node is appended to the end of the child node list.
	 *
	 * The new node's primary node type will be determined (either immediately
	 * or on save, depending on the implementation) by the child node definitions
	 * in the node types of its parent, unless primaryNodeTypeName is given.
	 *
	 * @param string $relPath The path of the new node to be created.
	 * @param string $primaryNodeTypeName The name of the primary node type of the new node.
	 * @param string $identifier The identifier to use for the new node, if not given an UUID will be created. Non-JCR-spec parameter!
	 * @return \F3\PHPCR\NodeInterface The node that was added.
	 * @throws \F3\PHPCR\ItemExistsException if the identifier is already used, if an item at the specified path already exists, same-name siblings are not allowed and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\PathNotFoundException if the specified path implies intermediary Nodes that do not exist or the last element of relPath has an index, and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\ConstraintViolationException if a node type or implementation-specific constraint is violated or if an attempt is made to add a node as the child of a property and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if the node to which the new child is being added is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the addition of the node and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException If the last element of relPath has an index or if another error occurs.
	 */
	public function addNode($relPath, $primaryNodeTypeName = NULL, $identifier = NULL);

	/**
	 * If this node supports child node ordering, this method inserts the child
	 * node at srcChildRelPath before its sibling, the child node at
	 * destChildRelPath, in the child node list.
	 * To place the node srcChildRelPath at the end of the list, a destChildRelPath
	 * of null is used.
	 *
	 * Note that (apart from the case where destChildRelPath is null) both of
	 * these arguments must be relative paths of depth one, in other words they
	 * are the names of the child nodes, possibly suffixed with an index.
	 *
	 * If srcChildRelPath and destChildRelPath are the same, then no change is
	 * made.
	 *
	 * Changes to ordering of child nodes are persisted on save of the parent
	 * node.
	 *
	 * @param string $srcChildRelPath the relative path to the child node (that is, name plus possible index) to be moved in the ordering
	 * @param string $destChildRelPath the the relative path to the child node (that is, name plus possible index) before which the node srcChildRelPath will be placed.
	 * @return void
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException  if ordering is not supported.
	 * @throws \F3\PHPCR\ConstraintViolationException if an implementation-specific ordering restriction is violated and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\ItemNotFoundException if either parameter is not the relative path of a child node of this node.
	 * @throws \F3\PHPCR\Version\VersionException if this node is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the re-ordering and this implementation performs this validation immediately instead of waiting until save..
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function orderBefore($srcChildRelPath, $destChildRelPath);

	/**
	 * Sets the specified (single-value) property of this node to the specified
	 * value. If the property does not yet exist, it is created. The property type
	 * of the property will be that specified by the node type of this node.
	 * If, based on the name and value passed, there is more than one property
	 * definition that applies, the repository chooses one definition according
	 * to some implementation-specific criteria. Once property with name P has
	 * been created, the behavior of a subsequent setProperty(P,V) may differ
	 * across implementations. Some repositories may allow P to be dynamically
	 * re-bound to a different property definition (based for example, on the
	 * new value being of a different type than the original value) while other
	 * repositories may not allow such dynamic re-binding.
	 *
	 * If the property type one or more supplied Value objects is different from
	 * that required, then a best-effort conversion is attempted.
	 *
	 * If the node type of this node does not indicate a specific property type,
	 * then the property type of the supplied Value object is used and if the
	 * property already exists it assumes both the new value and new property type.
	 *
	 * Passing a null as the second parameter removes the property. It is equivalent
	 * to calling remove on the Property object itself. For example,
	 * N.setProperty("P", (Value)null) would remove property called "P" of the
	 * node in N.
	 *
	 * To save the addition or removal of a property, a save call must be
	 * performed that includes the parent of the property in its scope, that is,
	 * a save on either the session, this node, or an ancestor of this node. To
	 * save a change to an existing property, a save call that includes that
	 * property in its scope is required. This means that in addition to the
	 * above-mentioned save options, a save on the changed property itself will
	 * also work.
	 *
	 * Have a look at the JSR-283 spec and/or API documentation for more details
	 * on what is supposed to happen for different type of values being passed
	 * to this method.
	 *
	 * @param string $name The name of a property of this node
	 * @param mixed $value The value to be assigned
	 * @param integer $type The type to set for the property
	 * @return \F3\PHPCR\PropertyInterface The updated Property object
	 * @throws \F3\PHPCR\ValueFormatException if the specified property is a DATE but the value cannot be expressed in the ISO 8601-based format defined in the JCR 2.0 specification (section 3.6.4.3) and the implementation does not support dates incompatible with that format or if value cannot be converted to the type of the specified property or if the property already exists and is multi-valued.
	 * @throws \F3\PHPCR\Version\VersionException if this node is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException  if a lock prevents the setting of the property and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\ConstraintViolationException if the change would violate a node-type or other constraint and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function setProperty($name, $value, $type = NULL);

	/**
	 * Returns the node at relPath relative to this node.
	 * If relPath contains a path element that refers to a node with same-name
	 * sibling nodes without explicitly including an index using the array-style
	 * notation ([x]), then the index [1] is assumed (indexing of same name
	 * siblings begins at 1, not 0, in order to preserve compatibility with XPath).
	 *
	 * Within the scope of a single Session object, if a Node object has been
	 * acquired, any subsequent call of getNode reacquiring the same node must
	 * return a Node object reflecting the same state as the earlier Node object.
	 * Whether this object is actually the same Node instance, or simply one
	 * wrapping the same state, is up to the implementation.
	 *
	 * @param string $relPath The relative path of the node to retrieve.
	 * @return \F3\PHPCR\NodeInterface The node at relPath.
	 * @throws \F3\PHPCR\PathNotFoundException If no node exists at the specified path or the current Session does not read access to the node at the specified path.
	 * @throws \F3\PHPCR\RepositoryException If another error occurs.
	 */
	public function getNode($relPath);

	/**
	 * Gets all child nodes of this node accessible through the current Session
	 * that match namePattern (if no pattern is given, all accessible child nodes
	 * are returned). Does not include properties of this Node. The pattern may
	 * be a full name or a partial name with one or more wildcard characters ("*"),
	 * or a disjunction (using the "|" character to represent logical OR) of these.
	 * For example,
	 * N.getNodes("jcr:* | myapp:report | my doc")
	 * would return a NodeIterator holding all accessible child nodes of N that
	 * are either called 'myapp:report', begin with the prefix 'jcr:' or are
	 * called 'my doc'.
	 *
	 * Note that leading and trailing whitespace around a disjunct is ignored,
	 * but whitespace within a disjunct forms part of the pattern to be matched.
	 *
	 * The EBNF for namePattern is:
	 *
	 * namePattern ::= disjunct {'|' disjunct}
	 * disjunct ::= name [':' name]
	 * name ::= '*' | ['*'] fragment {'*' fragment} ['*']
	 * fragment ::= char {char}
	 * char ::= nonspace | ' '
	 * nonspace ::= Any XML Char (See http://www.w3.org/TR/REC-xml/) except:
	 *    '/', ':', '[', ']', '*', '|' or any whitespace character
	 *
	 * The pattern is matched against the names (not the paths) of the immediate
	 * child nodes of this node.
	 *
	 * If this node has no accessible matching child nodes, then an empty
	 * iterator is returned.
	 *
	 * The same reacquisition semantics apply as with getNode(String).
	 *
	 * @param string $namePattern a name pattern
	 * @return \F3\PHPCR\NodeIteratorInterface a NodeIterator over all (matching) child Nodes
	 * @throws \F3\PHPCR\RepositoryException If an unexpected error occurs.
	 */
	public function getNodes($namePattern = NULL);

	/**
	 * Returns the property at relPath relative to this node. The same
	 * reacquisition semantics apply as with getNode(String).
	 *
	 * @param string $relPath The relative path of the property to retrieve.
	 * @return \F3\PHPCR\PropertyInterface The property at relPath.
	 * @throws \F3\PHPCR\PathNotFoundException If no property exists at the specified path.
	 * @throws \F3\PHPCR\RepositoryException If another error occurs.
	 */
	public function getProperty($relPath);

	/**
	 * Gets all properties of this node accessible through the current Session
	 * that match namePattern (if no pattern is given, all accessible properties
	 * are returned). Does not include child nodes of this node. The pattern may
	 * be a full name or a partial name with one or more wildcard characters ("*"),
	 * or a disjunction (using the "|" character to represent logical OR) of
	 * these. For example,
	 * N.getProperties("jcr:* | myapp:name | my doc")
	 * would return a PropertyIterator holding all accessible properties of N
	 * that are either called 'myapp:name', begin with the prefix 'jcr:' or are
	 * called 'my doc'.
	 *
	 * Note that leading and trailing whitespace around a disjunct is ignored,
	 * but whitespace within a disjunct forms part of the pattern to be matched.
	 *
	 * The EBNF for namePattern is:
	 *
	 * namePattern ::= disjunct {'|' disjunct}
	 * disjunct ::= name [':' name]
	 * name ::= '*' | ['*'] fragment {'*' fragment} ['*']
	 * fragment ::= char {char}
	 * char ::= nonspace | ' '
	 * nonspace ::= Any XML Char (See http://www.w3.org/TR/REC-xml/)
	 *    except: '/', ':', '[', ']', '*', '|' or any whitespace character
	 *
	 * The pattern is matched against the names (not the paths) of the immediate
	 * child properties of this node.
	 *
	 * If this node has no accessible matching properties, then an empty iterator
	 * is returned.
	 *
	 * The same reacquisition semantics apply as with getNode(String).
	 *
	 * @param string $namePattern a name pattern
	 * @return \F3\PHPCR\PropertyIteratorInterface a PropertyIterator
	 * @throws \F3\PHPCR\RepositoryException If an unexpected error occurs.
	 */
	public function getProperties($namePattern = NULL);

	/**
	 * Returns the primary child item of this node. The primary node type of this
	 * node may specify one child item (child node or property) of this node as
	 * the primary child item. This method returns that item.
	 * In cases where the primary child item specifies the name of a set same-name
	 * sibling child nodes, the node returned will be the one among the same-name
	 * siblings with index [1].
	 *
	 * The same reacquisition semantics apply as with getNode(String).
	 *
	 * @return \F3\PHPCR\ItemInterface the primary child item.
	 * @throws \F3\PHPCR\ItemNotFoundException if this node does not have a primary child item, either because none is declared in the node type or because a declared primary item is not present on this node instance, or not accessible through the current Session
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getPrimaryItem();

	/**
	 * Returns the identifier of this node. Applies to both referenceable and
	 * non-referenceable nodes.
	 *
	 * @return string the identifier of this node
	 * @throws \F3\PHPCR\RepositoryException If an error occurs.
	 */
	public function getIdentifier();

	/**
	 * This method returns the index of this node within the ordered set of its
	 * same-name sibling nodes. This index is the one used to address same-name
	 * siblings using the square-bracket notation, e.g., /a[3]/b[4]. Note that
	 * the index always starts at 1 (not 0), for compatibility with XPath. As a
	 * result, for nodes that do not have same-name-siblings, this method will
	 * always return 1.
	 *
	 * @return integer The index of this node within the ordered set of its same-name sibling nodes.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
	 */
	public function getIndex();

	/**
	 * This method returns all REFERENCE properties that refer to this node, have
	 * the specified name and that are accessible through the current Session.
	 * If the name parameter is null then all referring REFERENCES are returned
	 * regardless of name.
	 *
	 * Some level 2 implementations may only return properties that have been
	 * saved (in a transactional setting this includes both those properties that
	 * have been saved but not yet committed, as well as properties that have been
	 * committed). Other level 2 implementations may additionally return properties
	 * that have been added within the current Session but are not yet saved.
	 *
	 * In implementations that support versioning, this method does not return
	 * properties that are part of the frozen state of a version in version storage.
	 *
	 * If this node has no referring properties with the specified name, an empty
	 * iterator is returned.
	 *
	 * @param string $name name of referring REFERENCE properties to be returned; if null then all referring REFERENCEs are returned
	 * @return \F3\PHPCR\PropertyIteratorInterface A PropertyIterator.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs
	 */
	public function getReferences($name = NULL);

	/**
	 * This method returns all WEAKREFERENCE properties that refer to this node,
	 * have the specified name and that are accessible through the current Session.
	 * If the name parameter is null then all referring WEAKREFERENCE are returned
	 * regardless of name.
	 *
	 * Some level 2 implementations may only return properties that have been
	 * saved (in a transactional setting this includes both those properties that
	 * have been saved but not yet committed, as well as properties that have
	 * been committed). Other level 2 implementations may additionally return
	 * properties that have been added within the current Session but are not yet
	 * saved.
	 *
	 * In implementations that support versioning, this method does not return
	 * properties that are part of the frozen state of a version in version storage.
	 *
	 * If this node has no referring properties with the specified name, an empty
	 * iterator is returned.
	 *
	 * @param string $name name of referring WEAKREFERENCE properties to be returned; if null then all referring WEAKREFERENCEs are returned
	 * @return \F3\PHPCR\PropertyIteratorInterface A PropertyIterator.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs
	 */
	public function getWeakReferences($name = NULL);

	/**
	 * Indicates whether a node exists at relPath Returns true if a node accessible
	 * through the current Session exists at relPath and false otherwise.
	 *
	 * @param string $relPath The path of a (possible) node.
	 * @return boolean true if a node exists at relPath; false otherwise.
	 * @throws \F3\PHPCR\RepositoryException If an unspecified error occurs.
	 */
	public function hasNode($relPath);

	/**
	 * Indicates whether a property exists at relPath Returns true if a property
	 * accessible through the current Session exists at relPath and false otherwise.
	 *
	 * @param string $relPath The path of a (possible) property.
	 * @return boolean true if a property exists at relPath; false otherwise.
	 * @throws \F3\PHPCR\RepositoryException If an unspecified error occurs.
	 */
	public function hasProperty($relPath);

	/**
	 * Indicates whether this node has child nodes. Returns true if this node has
	 * one or more child nodes accessible through the current Session; false otherwise.
	 *
	 * @return boolean true if this node has one or more child nodes; false otherwise.
	 * @throws \F3\PHPCR\RepositoryException If an unspecified error occurs.
	 */
	public function hasNodes();

	/**
	 * Indicates whether this node has properties. Returns true if this node has
	 * one or more properties accessible through the current Session; false otherwise.
	 *
	 * @return boolean true if this node has one or more properties; false otherwise.
	 * @throws \F3\PHPCR\RepositoryException If an unspecified error occurs.
	 */
	public function hasProperties();

	/**
	 * Returns the primary node type in effect for this node. Which NodeType is
	 * returned when this method is called on the root node of a workspace is up
	 * to the implementation.
	 *
	 * @return \F3\PHPCR\NodeType\NodeTypeInterface a NodeType object.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs
	 */
	public function getPrimaryNodeType();

	/**
	 * Returns an array of NodeType objects representing the mixin node types in
	 * effect for this node. This includes only those mixin types explicitly
	 * assigned to this node. It does not include mixin types inherited through
	 * the addition of supertypes to the primary type hierarchy or through the
	 * addition of supertypes to the type hierarchy of any of the declared mixin
	 * types.
	 *
	 * @return array of \F3\PHPCR\NodeType\NodeTypeInterface objects.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs
	 */
	public function getMixinNodeTypes();

	/**
	 * Returns true if this node is of the specified primary node type or mixin
	 * type, or a subtype thereof. Returns false otherwise.
	 * This method respects the effective node type of the node.
	 *
	 * @param string $nodeTypeName the name of a node type.
	 * @return boolean true if this node is of the specified primary node type or mixin type, or a subtype thereof. Returns false otherwise.
	 * @throws \F3\PHPCR\RepositoryException If an error occurs.
	 */
	public function isNodeType($nodeTypeName);

	/**
	 * Changes the primary node type of this node to nodeTypeName. Also immediately
	 * changes this node's jcr:primaryType property appropriately. Semantically,
	 * the new node type may take effect immediately and must take effect on save.
	 * Whichever behavior is adopted it must be the same as the behavior adopted
	 * for addMixin() (see below) and the behavior that occurs when a node is
	 * first created.
	 * If the presence of an existing property or child node would cause an
	 * incompatibility with the new node type a ConstraintViolationException is
	 * thrown either immediately or on save.
	 *
	 * @param string $nodeTypeName the name of the new node type.
	 * @return void
	 * @throws \F3\PHPCR\ConstraintViolationException If the specified primary node type is prevented from being assigned.
	 * @throws \F3\PHPCR\NodeType\NoSuchNodeTypeException If the specified nodeTypeName is not recognized and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if this node is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the change of the primary node type and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function setPrimaryType($nodeTypeName);

	/**
	 * Adds the mixin node type $mixinName to this node. If this node is already
	 * of type $mixinName (either due to a previously added mixin or due to its
	 * primary type, through inheritance) then this method has no effect.
	 * Otherwise $mixinName is added to this node's jcr:mixinTypes property.
	 *
	 * Semantically, the new node type may take effect immediately and must take
	 * effect on save. Whichever behavior is adopted it must be the same as the
	 * behavior adopted for setPrimaryType(java.lang.String) and the behavior
	 * that occurs when a node is first created.
	 *
	 * A ConstraintViolationException is thrown either immediately or on save if
	 * a conflict with another assigned mixin or the primary node type or for an
	 * implementation-specific reason. Implementations may differ on when this
	 * validation is done.
	 *
	 * @param string $mixinName the name of the mixin node type to be added
	 * @return void
	 * @throws \F3\PHPCR\NodeType\NoSuchNodeTypeException If the specified mixinName is not recognized and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\ConstraintViolationException If the specified mixin node type is prevented from being assigned.
	 * @throws \F3\PHPCR\Version\VersionException if this node is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save..
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the addition of the mixin and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function addMixin($mixinName);

	/**
	 * Removes the specified mixin node type from this node and removes mixinName
	 * from this node's jcr:mixinTypes property. Both the semantic change in
	 * effective node type and the persistence of the change to the jcr:mixinTypes
	 * property occur on save.
	 *
	 * @param string $mixinName the name of the mixin node type to be removed.
	 * @return void
	 * @throws \F3\PHPCR\NodeType\NoSuchNodeTypeException if the specified mixinName is not currently assigned to this node and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\ConstraintViolationException if the specified mixin node type is prevented from being removed and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Version\VersionException if this node is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the removal of the mixin and this implementation performs this validation immediately instead of waiting until save..
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function removeMixin($mixinName);

	/**
	 * Returns true if the specified mixin node type, mixinName, can be added to
	 * this node. Returns false otherwise. A result of false must be returned in
	 * each of the following cases:
	 * * The mixin's definition conflicts with an existing primary or mixin node
	 *   type of this node.
	 * * This node is versionable and checked-in or is non-versionable and its
	 *   nearest versionable ancestor is checked-in.
	 * * This node is protected (as defined in this node's NodeDefinition, found
	 *   in the node type of this node's parent).
	 * * An access control restriction would prevent the addition of the mixin.
	 * * A lock would prevent the addition of the mixin.
	 * * An implementation-specific restriction would prevent the addition of the mixin.
	 *
	 * @param string $mixinName The name of the mixin to be tested.
	 * @return boolean true if the specified mixin node type, mixinName, can be added to this node; false otherwise.
	 * @throws \F3\PHPCR\NodeType\NoSuchNodeTypeException if the specified mixin node type name is not recognized.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function canAddMixin($mixinName);

	/**
	 * Returns the node definition that applies to this node. In some cases there
	 * may appear to be more than one definition that could apply to this node.
	 * However, it is assumed that upon creation of this node, a single particular
	 * definition was used and it is that definition that this method returns.
	 * How this governing definition is selected upon node creation from among
	 * others which may have been applicable is an implementation issue and is
	 * not covered by this specification. The NodeDefinition returned when this
	 * method is called on the root node of a workspace is also up to the
	 * implementation.
	 *
	 * @return \F3\PHPCR\NodeType\NodeDefinitionInterface a NodeDefinition object.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
	 */
	public function getDefinition();

	/**
	 * If this node does have a corresponding node in the workspace srcWorkspace,
	 * then this replaces this node and its subtree with a clone of the
	 * corresponding node and its subtree.
	 * If this node does not have a corresponding node in the workspace srcWorkspace,
	 * then the update method has no effect.
	 *
	 * If the update succeeds the changes made are persisted immediately, there
	 * is no need to call save.
	 *
	 * Note that update does not respect the checked-in status of nodes. An update
	 * may change a node even if it is currently checked-in (This fact is only
	 * relevant in an implementation that supports versioning).
	 *
	 * @param string $srcWorkspace the name of the source workspace.
	 * @return void
	 * @throws \F3\PHPCR\NoSuchWorkspaceException if srcWorkspace does not exist.
	 * @throws \F3\PHPCR\InvalidItemStateException if this Session (not necessarily this Node) has pending unsaved changes.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session does not have sufficient rights to perform the operation.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the update.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function update($srcWorkspace);

	/**
	 * Returns the absolute path of the node in the specified workspace that
	 * corresponds to this node.
	 * If no corresponding node exists then an ItemNotFoundException is thrown.
	 *
	 * @param string $workspaceName the name of the workspace.
	 * @return string the absolute path to the corresponding node.
	 * @throws \F3\PHPCR\ItemNotFoundException if no corresponding node is found.
	 * @throws \F3\PHPCR\NoSuchWorkspaceException if the workspace is unknown.
	 * @throws \F3\PHPCR\AccessDeniedException if the current session has insufficient rights to perform this operation.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getCorrespondingNodePath($workspaceName);

	/**
	 * Returns an iterator over all nodes that are in the shared set of this node.
	 * If this node is not shared then the returned iterator contains only this node.
	 *
	 * @return \F3\PHPCR\NodeIteratorInterface a NodeIterator
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
	 */
	public function getSharedSet();

		/**
	 * A special kind of remove() that removes this node, but does not remove any
	 * other node in the shared set of this node.
	 * All of the exceptions defined for remove() apply to this function. In
	 * addition, a RepositoryException is thrown if this node cannot be removed
	 * without removing another node in the shared set of this node.
	 *
	 * If this node is not shared this method removes only this node.
	 *
	 * @return void
	 * @throws \F3\PHPCR\Version\VersionException if the parent node of this item is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the removal of this item and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\NodeType\ConstraintViolationException if removing the specified item would violate a node type or implementation-specific constraint and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 * @see removeShare()
	 * @see Item::remove()
	 * @see SessionInterface::removeItem
	 */
	public function removeSharedSet();

	/**
	 * A special kind of remove() that removes this node, but does not remove any
	 * other node in the shared set of this node.
	 * All of the exceptions defined for remove() apply to this function. In
	 * addition, a RepositoryException is thrown if this node cannot be removed
	 * without removing another node in the shared set of this node.
	 *
	 * If this node is not shared this method removes only this node.
	 *
	 * @return void
	 * @throws \F3\PHPCR\Version\VersionException if the parent node of this item is versionable and checked-in or is non-versionable but its nearest versionable ancestor is checked-in and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\Lock\LockException if a lock prevents the removal of this item and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\NodeType\ConstraintViolationException if removing the specified item would violate a node type or implementation-specific constraint and this implementation performs this validation immediately instead of waiting until save.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 * @see removeSharedSet()
	 * @see Item::remove()
	 * @see SessionInterface::removeItem
	 */
	public function removeShare();

	/**
	 * Causes the lifecycle state of this node to undergo the specified transition.
	 * This method may change the value of the jcr:currentLifecycleState property,
	 * in most cases it is expected that the implementation will change the value
	 * to that of the passed transition parameter, though this is an
	 * implementation-specific issue. If the jcr:currentLifecycleState property
	 * is changed the change is persisted immediately, there is no need to call
	 * save.
	 *
	 * @param string $transition a state transition
	 * @return void
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException  if this implementation does not support lifecycle actions or if this node does not have the mix:lifecycle mixin.
	 * @throws \F3\PHPCR\InvalidLifecycleTransitionException if the lifecycle transition is not successful.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function followLifecycleTransition($transition);

	/**
	 * Returns the list of valid state transitions for this node.
	 *
	 * @return array a string array.
	 * @throws \F3\PHPCR\UnsupportedRepositoryOperationException  if this implementation does not support lifecycle actions or if this node does not have the mix:lifecycle mixin.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getAllowedLifecycleTransitions();
}

?>