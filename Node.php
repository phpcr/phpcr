<?php
// $Id: Node.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link Node} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 */


/**
 * The {@link Node} interface represents a {@link Node} in the hierarchy that
 * makes up the repository.
 *
 * @package phpContentRepository
 */
interface phpCR_Node extends phpCR_Item
{
	/**
	 * Creates a new {@link Node} at relPath. The new {@link Node} will only be
	 * persisted in the workspace when save() and if the structure
	 * of the new {@link Node} (its child {@link Node}s and properties) meets the constraint
	 * criteria of the parent {@link Node}'s {@link NodeType}.
	 * 
	 * If relPath implies intermediary {@link Node}s that do not
	 * exist then a PathNotFoundException is thrown.
	 *
	 * If an {@link Item} already exists at relPath then an
	 * ItemExistsException is thrown.
	 * 
	 * If an attempt is made to add a {@link Node} as a child of a
	 * {@link Property} then a ConstraintViolationException is
	 * thrown immediately (not on {@link save()}).
	 * 
	 * Since $this signature does not allow explicit {@link NodeType} assignment, the
	 * new {@link Node}'s {@link NodeType}s (primary and mixin, if applicable) will be
	 * determined immediately (not on save) by the NodeDefinitions
	 * in the {@link NodeType}s of its parent. If there is no NodeDefinition
	 * corresponding to the name specified for $this new {@link Node}, then a
	 * ConstraintViolationException is thrown immediately (not on
	 * {@link save()}).
	 *
	 * If a $primaryNodeTypeName is specified and is not recognized,
	 * then a {@link NoSuchNodeTypeException} is thrown
	 *
	 * @param string 
	 *    The path of the new {@link Node} to be created.
	 * @param string|null
	 *    The name of the primary {@link NodeType} of the new {@link Node}.
	 *    (Optional)
	 * @return object
	 *	A {@link Node} object
	 *
	 * @throws {@link ItemExistsException}
	 *    If an item at the specified path already exists, same-name siblings 
	 *    are not allowed and this implementation performs this validation 
	 *    immediately instead of waiting until {@link save()}.
	 * @throws {@link PathNotFoundException}
	 *    If the specified path implies intermediary {@link Node}s that do not
	 *    exist or the last element of <i>$relPath</i> has an index, and
	 *    this implementation performs this validation immediately instead of 
	 *    waiting until {@link save()}.
	 * @throws {@link NoSuchNodeTypeException}
	 *    If the specified node type is not recognized and this implementation 
	 *    performs this validation immediately instead of waiting until
	 *    {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If a node type or implementation-specific constraint is violated or
	 *    if an attempt is made to add a node as the child of a property and 
	 *    this implementation performs this validation immediately instead of 
	 *    waiting until {@link save()}.
	 * @throws {@link VersionException}
	 *    If the node to which the new child is being added is versionable and
	 *    checked-in or is non-versionable but its nearest versionable ancestor 
	 *    is checked-in and this implementation performs this validation 
	 *    immediately instead of waiting until {@link save()}.
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the node and this implementation 
	 *    performs this validation immediately instead of waiting until
	 *    {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If the last element of <i>$relPath</i> has an index or if
	 * another error occurs.
	 */
	public function addNode($relPath, $primaryNodeTypeName = null);
	
	
	/**
	 * If this node supports child node ordering, this method inserts the child 
	 * node at <i>$srcChildRelPath</i> before its sibling, the child node
	 * at <i>$destChildRelPath</i>, in the child node list.
	 *
	 * To place the node <i>$srcChildRelPath</i> at the end of the list,
	 * a <i>destChildRelPath</i> of <i>NULL</i> is used.
	 *
	 * Note that (apart from the case where <i>$destChildRelPath</i> is
	 * <i>NULL</i>) both of these arguments must be relative paths of 
	 * depth one, in other words they are the names of the child nodes, 
	 * possibly suffixed with an index.
	 *
	 * If <i>$srcChildRelPath</i> and <i>$destChildRelPath</i> are 
	 * the same, then no change is made.
	 *
	 * @param string
	 *    The relative path to the child node (that is, name plus possible 
	 *    index) to be moved in the ordering
	 * @param string
	 *    The the relative path to the child node (that is, name plus possible
	 *    index) before which the node <i>$srcChildRelPath</i> will be 
	 *    placed.
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If ordering is not supported.
	 * @throws {@link ConstraintViolationException}
	 *    If an implementation-specific ordering restriction is violated and
	 *    this implementation performs this validation immediately instead of
	 *    waiting until {@link save()}.
	 * @throws {@link ItemNotFoundException}
	 *    If either parameter is not the relative path of a child node of this 
	 *    node.
	 * @throws {@link VersionException}
	 *    If this node is versionable and checked-in or is non-versionable 
	 *    but its nearest versionable ancestor is checked-in and this 
	 *    implementation performs this validation immediately instead of
	 *    waiting until {@link save()}..
	 * @throws {@link LockException}
	 *    If a lock prevents the re-ordering and this implementation performs 
	 *    this validation immediately instead of waiting until {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function orderBefore($srcChildRelPath, $destChildRelPath);
	
	
	/**
	 * Sets the specified {@link Property} to the specified value. If the 
	 * {@link Property} does not yet exist, it is created. 
	 *
	 * If $type is NULL, the {@link PropertyType} will
	 * be that specified by the {@link NodeType} of $this 
	 * {@link Node} (the one on which $this method is being called). 
	 *
	 * If the {@link NodeType} of the parent {@link Node} does not specify a
	 * specific {@link PropertyType} for the {@link Property} being set, then the
	 * {@link PropertyType} of the supplied {@link Value} object is used.
	 *
	 * If the {@link Property} already exists (has previously been set) it 
	 * assumes the new value. If the {@link NodeType} of the parent {@link Node}
	 * does not specify a specific {@link PropertyType} for the {@link Property}
	 * being set, then the {@link Property} will also assume the new type 
	 * (if different).
	 *
	 * To erase a {@link Property}, use {@link remove()}.
	 *
	 * To persist the addition or change of a {@link Property} to the workspace
	 * {@link save()} must be called on $this {@link Node} (the 
	 * parent of the {@link Property} being set) or a higher-order ancestor of 
	 * the {@link Property}.
	 *
	 * @param string 
	 *   The name of a {@link Property} of $this {@link Node}
	 * @param mixed 
	 *   The value to be assigned
	 * @param int|null 
	 *   The type of the {@link Property} (Optional: NULL if not
	 *   specified).
	 * @return object
	 *	A {@link Property} object
	 *
	 * @throws {@link ValueFormatException}
	 *    If <i>$value</i> cannot be converted to the specified type or
	 *    if the property already exists and is multi-valued.
	 * @throws {@link VersionException}
	 *    If this node is versionable and checked-in or is non-versionable but
	 *    its nearest versionable ancestor is checked-in and this implementation
	 *    performs this validation immediately instead of waiting until
	 *    {@link save()}.
	 * @throws {@link LockException}
	 *    If a lock prevents the setting of the property and this implementation
	 *    performs this validation immediately instead of waiting until
	 *    {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If the change would violate a node-type or other constraint and this
	 *    implementation performs this validation immediately instead of 
	 *    waiting until {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function setProperty($name, $value, $type = null);
	
	
	/**
	 * Returns the {@link Node} at $relPath relative to 
	 * $this {@link Node}.
	 *
	 * The properties and child {@link Node}s of the returned {@link Node} can 
	 * then be read (and if permissions allow) changed and written. However, any 
	 * changes made to $this {@link Node}, its properties or its
	 * child {@link Node}s (and their properties and child {@link Node}s, etc.) 
	 * will only be persisted to the repository upon calling {@link save()}.
	 * 
	 * Within the scope of a single {@link Ticket} object, if a {@link Node} has
	 * been acquired with {@link getNode()}, any subsequent call of 
	 * {@link getNode()} re-acquiring the same {@link Node} will return a 
	 * reference to same object, not a new copy.  PHP NOTE: As PHP does not 
	 * maintain a constant state, this should not be much of an issue.
	 *
	 * @param string
	 *   The relative path of the {@link Node} to retrieve.
	 * @return object 
	 *   The {@link Node} at $relPath.
	 * @throws {@link PathNotFoundException}
	 *   If no {@link Node} exists at the  specified path.
	 * @throws {@link RepositoryException}
	 *   If another error occurs.
	 */
	public function getNode($relPath);
	
	
	/**
	 * Returns a {@link NodeIterator} over all child {@link Node}s of
	 * $this {@link Node}.
	 *
	 * If $namePattern is specified, $this only returns
	 * those {@link Node}s which make that pattern.  The pattern may be a full 
	 * name or a partial name with one or more wildcard characters 
	 * ("*"), or a disjunction ("|" or 
	 * "OR")
	 *
	 * Example:
	 * $N.getNodes("jcr:*" | myapp:report")
	 *
	 * Would return a {@link NodeIterator} holding all of the child {@link Node}s 
	 * of $N that are either called myapp:report or 
	 * begin with the prefix jcr:.  The pattern does not represent 
	 * paths, that is, it may not contain / characters.
	 *
	 * Does not include properties of $this {@link Node}. 
	 * The same {@link save()} and re-acquisition semantics apply as with 
	 * {@link getNode()}.
	 *
	 * @param string
	 *   A name pattern.
	 * @return object
	 *   A {@link NodeIterator} over all child {@link Node}s of $this 
	 *   {@link Node}.
	 * @throws {@link RepositoryException}
	 *   If an unexpected error occurs.
	 */
	public function getNodes($namePattern = null);
	
	
	/**
	 * Returns the {@link Property} at $relPath relative to 
	 * $this {@link Node}. 
	 *
	 * The same {@link save()} and re-acquisition semantics apply as with 
	 * {@link getNode()}.
	 *
	 * @param string
	 *   The relative path of the {@link Property} to retrieve.
	 * @return object
	 *	A {@link Property} object
	 *
	 * @throws {@link PathNotFoundException}
	 *   If no {@link Property} exists at the specified path.
	 * @throws {@link RepositoryException}
	 *   If another error occurs.
	 */
	public function getProperty($relPath);
	
	
	/**
	 * Returns a {@link PropertyIterator} that contains all of the properties of 
	 * $this {@link Node}.
	 *
	 * If $namePattern is specified, only return those 
	 * {@link Property}s that match the specified pattern.  
	 * $namePattern works identically to that {@link getNodes()}.
	 *
	 * Does not include child {@link Node}s of $this
	 * {@link Node}.
	 * 
	 * The same {@link save()} and re-acquisition semantics apply as with 
	 * {@link getNode()}.
	 *
	 * @return object
	 *	A {@link PropertyIterator} object
	 *
	 * @throws {@link RepositoryException}
	 *   If an error occurs.
	 */
	public function getProperties($namePattern = null);
	
	
	/**
	 * Returns the deepest primary child {@link Item} accessible via a chain of
	 * primary child {@link Item}s from $this {@link Node}.
	 *
	 * A {@link Node}'s type can specifiy a maximum of one of its child 
	 * {@link Item}s (child {@link Node} or {@link Property}) as its primary
	 * child {@link Item}.
	 *
	 * This method traverses the chain of primary child {@link Item}s of 
	 * $this {@link Node} until it either encounters a 
	 * {@link Property} or a {@link Node} that does not have a primary child 
	 * {@link Item}. It then returns that {@link Property} or {@link Node}. If 
	 * $this {@link Node} itself (the one that $this 
	 * method is being called on) has no primary child {@link Item} then 
	 * $this method throws a {@link ItemNotFoundException}. 
	 *
	 * The same {@link save()} and re-acquisition semantics apply as with 
	 * {@link getNode()}.
	 *
	 * @return object
	 *   The deepest primary child {@link Item} accessible from $this 
	 *   {@link Node} via a chain of primary child {@link Item}s.
	 * @throws {@link ItemNotFoundException}
	 *   If $this {@link Node} does not have a primary child {@link Item}.
	 * @throws {@link RepositoryException}
	 *   If another error occurs.
	 */
	public function getPrimaryItem();
	
	

	/**
	 * Returns the UUID of $this {@link Node} as recorded in the
	 * {@link Node}'s jcr:UUID {@link Property}. 
	 *
	 * This method only works on {@link Node}s of mixin {@link Node} type 
	 * mix:referenceable. On nonreferenceable {@link Node}s, 
	 * $this method throws an 
	 * {@link UnsupportedRepositoryOperationException}.
	 *
	 * @return string
	 *   The UUID of $this {@link Node}
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *   If $this {@link Node} nonreferenceable.
	 * @throws {@link RepositoryException}
	 *   If another error occurs.
	 */
	public function getUUID();
	
	
	/**
	 * This method returns the index of this node within the ordered set of its
	 * same-name sibling nodes.
	 *
	 * This index is the one used to address same-name siblings using the 
	 * square-bracket notation, e.g., <i>/a[3]/b[4]</i>. Note that the
	 * index always starts at 1 (not 0), for compatibility with XPath. As a
	 * result, for nodes that do not have same-name-siblings, this method will 
	 * always return 1.
	 *
	 * @return int
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getIndex();
	
	
	/**
	 * Returns all <i>REFERENCE</i> properties that refer to this node.
	 *
	 * Some level 2 implementations may only return properties that have been
	 * saved (in a transactional setting this includes both those properties
	 * that have been saved but not yet committed, as well as properties that
	 * have been committed). Other level 2 implementations may additionally
	 * return properties that have been added within the current
	 * {@link Session} but are not yet saved.
	 *
	 * In implementations that support versioing, this method does not return
	 * <i>REFERENCE</i> propertiesthat are part of the frozen state of a
	 * version in version storage.
	 *
	 * If this node has no references, an empty iterator is returned.
	 *
	 * @return object
	 *	A {@link PropertyIterator} object
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs
	 */
	public function getReferences();
	
	
	/**
	 * Indicates whether a {@link Node} exists at $relPath
	 *
	 * Returns TRUE if a {@link Node} exists at 
	 * $relPath and FALSE otherwise.
	 *
	 * @param string
	 *   The path of a possible {@link Node}.
	 * @return bool
	 *   TRUE if a {@link Node} exists at relPath;
	 *   FALSE otherwise.
	 * @throws {@link RepositoryException}
	 *   If an unspecified error occurs.
	 */
	public function hasNode($relPath);
	
	
	/**
	 * Indicates whether a {@link Property} exists at $relPath.
	 *
	 * @param string
	 *   The path of a possible {@link Property}.
	 * @return bool
	 *   TRUE if a {@link Property} exists at $relPath;
	 *   FALSE otherwise.
	 * @throws {@link RepositoryException}
	 *   If an unspecified error occurs.
	 */
	public function hasProperty($relPath);
	
	
	/**
	 * Indicates whether $$this {@link Node} has child 
	 * {@link Node}s.
	 * 
	 * @return bool
	 *   TRUE if $this {@link Node} has one or more child 
	 *   {@link Node}s; FALSE otherwise.
	 * @throws {@link RepositoryException}
	 *   If an unspecified error occurs.
	 */
	public function hasNodes();
	
	
	/**
	 * Indicates whether $$this {@link Node} has 
	 * {@link Property}s.
	 *
	 * @return bool
	 *   TRUE if $this {@link Node} has one or more 
	 *   {@link Property}s; FALSE otherwise.
	 * @throws {@link RepositoryException}
	 *   If an unspecified error occurs.
	 */
	public function hasProperties();
	
	
	/**
	 * Returns the primary {@link NodeType} of $this {@link Node}.
	 *
	 * @return object
	 *   A {@link NodeType} object.
	 */
	public function getPrimaryNodeType();
	
	
	/**
	 * Returns an array of {@link NodeType} objects representing the mixin 
	 * {@link Node} types assigned to $this {@link Node}.
	 *
	 * @return array
	 *   An array of NodeType objects.
	 */
	public function getMixinNodeTypes();
	
	
	/**
	 * Indicates whether $this {@link Node} is of the specified 
	 * {@link NodeType}.
	 *
	 * This method provides a quick method for determining whether a particular 
	 * {@link Node} is of a particular {@link NodeType} without having to 
	 * manually search the inheritance hierarchy (which, in some implementations
	 * may be a multiple-inhertiance hierarchy, making a manual search even
	 * more complex). This method works for both primary {@link NodeType}s and
	 * mixin {@link NodeType}s.
	 *
	 * @param string
	 *   The name of a {@link NodeType}.
	 * @return bool
	 *   TRUE if $this {@link Node} is of the specified 
	 *   {@link NodeType} or a subtype of the specified {@link NodeType}; returns
	 *   FALSE otherwise.
	 * @throws {@link RepositoryException}
	 *   If an unspecified error occurs.
	 */
	public function isNodeType($nodeTypeName);
	
	
	/**
	 * Adds the specified mixin {@link NodeType} to this {@link Node}.
	 *
	 * Also adds <i>mixinName</i> to this node's <i>jcr:mixinTypes</i>
	 * property immediately. Semantically, the mixin node type assignment may take
	 * effect immediately and at the very least, it must take effect on {@link save()}.
	 *
	 * If a conflict with another assigned mixin or the main {@link NodeType} 
	 * results, an exception is thrown on {@link save()}. Adding a mixin 
	 * {@link NodeType} to a {@link Node} immediately adds the name of that type
	 * to the list held in that {@link Node}'s jcr:mixinTypes
	 * {@link Property}.
	 *
	 * @param string 
	 *   The mixin name
	 *
	 * @throws {@link NoSuchNodeTypeException}
	 *    If the specified <i>mixinName</i> is not recognized and this
	 *    implementation performs this validation immediately instead of 
	 *    waiting until {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If the specified mixin node type is prevented from being assigned.
	 * @throws {@link VersionException}
	 *    If this node is versionable and checked-in or is non-versionable but 
	 *    its nearest versionable ancestor is checked-in and this 
	 *    implementation performs this validation immediately instead of 
	 *    waiting until {@link save()}..
	 * @throws {@link LockException}
	 *    If a lock prevents the addition of the mixin and this implementation 
	 *    performs this validation immediately instead of waiting until 
	 *    {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function addMixin($mixinName);
	
	
	/**
	 * Removes the specified mixin node type from this node.
	 *
	 * Also removes <i>mixinName</i> from this node's
	 * <i>jcr:mixinTypes</i> property immediately. Semantically, the 
	 * mixin node type removal may take effect immediately and at the very 
	 * least, it must take effect on {@link save()}.
	 *
	 * @param string
	 *    The name of the mixin node type to be removed.
	 *
	 * @throws {@link NoSuchNodeTypeException}
	 *    If the specified <i>$mixinName</i> is not currently assigned to
	 *    this node and this implementation performs this validation 
	 *    immediately instead of waiting until {@link save()}.
	 * @throws {@link ConstraintViolationException}
	 *    If the specified mixin node type is prevented from being removed and
	 *    this implementation performs this validation immediately instead of 
	 *    waiting until {@link save()}.
	 * @throws {@link VersionException}
	 *    If this node is versionable and checked-in or is non-versionable but
	 *    its nearest versionable ancestor is checked-in and this implementation
	 *    performs this validation immediately instead of waiting until
	 *    {@link save()}.
	 * @throws {@link LockException}
	 *    If a lock prevents the removal of the mixin and this implementation 
	 *    performs this validation immediately instead of waiting until 
	 *    {@link save()}.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function removeMixin($mixinName);
	
	
	/**
	 * Returns <i>true</i> if the specified mixin node type, 
	 * <i>mixinName</i>, can be added to this node. Returns 
	 * <i>false</i> otherwise. 
	 *
	 * A result of <i>false</i> must be returned in each of the following 
	 * cases:
	 * <ul>
	 *    <li>
	 *        The mixin's definition conflicts with an existing primary or
	 *        mixin node type of this node.
	 *    </li>
	 *    <li>
	 *        This node is versionable and checked-in or is non-versionable and
	 *        its nearest versionable ancestor is checked-in.
	 *    </li>
	 *    <li>
	 *        This node is protected (as defined in this node's
	 *        <i>NodeDefinitioninition</i>, found in the node type of this 
	 *        node's parent).
	 *    </li>
	 *    <li>
	 *        An access control restriction would prevent the addition of the 
	 *        mixin.
	 *    </li>
	 *    <li>
	 *        A lock would prevent the addition of the mixin.
	 *    </li>
	 *    <li>
	 *        An implementation-specific restriction would prevent the addition
	 *        of the mixin.
	 *    </li>
	 * </ul>
	 *
	 * @param $string 
	 *    The name of the mixin to be tested.
	 * @return boolean
	 *
	 * @throws {@link NoSuchNodeTypeException}
	 *    If the specified mixin node type name is not recognized.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function canAddMixin($mixinName);
	
	
	/**
	 * Returns the definition of $this {@link Node}. 
	 *
	 * This method is actually a shortcut to searching through $this
	 * {@link Node}'s parent's {@link NodeType} (and its supertypes) for the 
	 * child {@link Node} definition applicable to $this
	 * {@link Node}.
	 *
	 * @return object 
	 *   A {@link NodeDefinition} object.
	 * @see NodeType::getChildNodeDefinitions()
	 */
	public function getDefinition();
	
	
	/**
	 * Creates a new version with a system generated version name and returns 
	 * that version (which will be the new base version of this node).
	 *
	 * Sets the <i>jcr:checkedOut</i> property to false thus putting the 
	 * node into the <i>checked-in</i> state. This means that this node and 
	 * its <i>connected non-versionable subtree</i> become read-only.  A node's
	 * connected non-versionable subtree is the set of non-versionable 
	 * descendant nodes reachable from that node through child links without 
	 * encountering any versionable nodes.  In other words, the read-only 
	 * status flows down from the checked-in node along every child link until 
	 * either a versionable node is encountered or an item with no children is
	 * encountered.
	 *
	 * Read-only status means that an item cannot be altered by the client 
	 * using standard API methods (addNode, setProperty, etc.). The only 
	 * exceptions to this rule are the {@link Node::restore()} (all signatures),
	 * {@link Workspace::restore()}, {@link Node::merge()} and
	 * {@link Node::update()} operations; these do not respect read-only status 
	 * due to check-in. 
	 *
	 * Note that <i>remove</i> of a read-only node is possible, as long 
	 * as its parent is not read-only (since removal is an alteration of the
	 * parent node).
	 *
	 * If this node is already checked-in, this method has no effect but 
	 * returns the current base version of this node.
	 *
	 * @return object
	 *	A {@link Version} object
	 *
	 * @throws {@link VersionException}
	 *    If jcr:predecessors does not contain at least one value or if
	 *    a child item of this node has an <i>OnParentVersion</i> status 
	 *    of <i>ABORT</i>.  This includes the case where an unresolved 
	 *    merge failure exists on this node, as indicated by the presence of a
	 *    <i>jcr:mergeFailed</i> property. 
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not versionable.
	 * @throws {@link InvalidItemStateException}
	 *    If unsaved changes exist on this node.
	 * @throws {@link LockException}
	 *    If a lock prevents the checkin.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function checkin();
	
	
	/**
	 * Sets this versionable node to checked-out status by setting its
	 * <i>jcr:isCheckedOut</i> property to true and adds to the
	 * <i>jcr:predecessors</i> (multi-value) property a reference to the 
	 * current base version (the same value as held in 
	 * <i>jcr:baseVersion</i>).
	 *
	 * This method puts the node into the <i>checked-out</i> state, making it
	 * and its connected non-versionable subtree no longer read-only (see 
	 * {@link checkin()} for an explanation of the term "connected 
	 * non-versionable subtree").
	 *
	 * If successful, these changes are persisted immediately, there is no need
	 * to call {@link save()}.
	 *
	 * If this node is already checked-out, this method has no effect.
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not versionable.
	 * @throws {@link LockException}
	 *    If a lock prevents the checkout.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function checkout();
		
	
	/**
	 * Completes the merge process with respect to this node and the specified <i>version</i>.
	 *
	 * When the {@link merge()} method is called on a node, every versionable node in that
	 * subtree is compared with its corresponding node in the indicated other workspace and
	 * a "merge test result" is determined indicating one of the following:
	 * <ol>
	 * <li>
	 * This node will be updated to the state of its correspondee (if the base version
	 * of the correspondee is more recent in terms of version history)
	 * </li>
	 * <li>
	 * This node will be left alone (if this node's base version is more recent in terms of
	 * version history).
	 * </li>
	 * <li>
	 * This node will be marked as having failed the merge test (if this node's base version
	 * is on a different branch of the version history from the base version of its
	 * corresponding node in the other workspace, thus preventing an automatic determination
	 * of which is more recent).
	 * </li>
	 * </ol>
	 * (See {@link merge()} for more details)
	 *
	 * In the last case the merge of the non-versionable subtree
	 * (the "content") of this node must be done by the application (for example, by
	 * providing a merge tool for the user).
	 *
	 * Additionally, once the content of the nodes has been merged, their version graph
	 * branches must also be merged. The JCR versioning system provides for this by
	 * keeping a record, for each versionable node that fails the merge test, of the
	 * base verison of the corresponding node that caused the merge failure. This record
	 * is kept in the <i>jcr:mergeFailed</i> property of this node. After a
	 * {@link merge()}, this property will contain one or more (if
	 * multiple merges have been performed) <i>REFERENCE</i>s that point
	 * to the "offending versions".
	 *
	 * To complete the merge process, the client calls {@link doneMerge()}
	 * passing the version object referred to be the <i>jcr:mergeFailed</i> property
	 * that the client wishes to connect to <i>this</i> node in the version graph.
	 * This has the effect of moving the reference to the indicated version from the
	 * <i>jcr:mergeFailed</i> property of <i>this</i> node to the
	 * <i>jcr:predecessors</i>.
	 *
	 * If the client chooses not to connect this node to a particular version referenced in
	 * the <i>jcr:mergeFailed</i> property, he calls {@link #cancelMerge(Version version)}.
	 * This has the effect of removing the reference to the specified <i>version</i> from
	 * <i>jcr:mergeFailed</i> <i>without</i> adding it to <i>jcr:predecessors</i>.
	 *
	 * Once the last reference in <i>jcr:mergeFailed</i> has been either moved to
	 * <i>jcr:predecessors</i> (with <i>doneMerge</i>) or just removed
	 * from <i>jcr:mergeFailed</i> (with <i>cancelMerge</i>) the <i>jcr:mergeFailed</i>
	 * property is automatically removed, thus enabling <i>this</i>
	 * node to be checked-in, creating a new version (note that before the <i>jcr:mergeFailed</i>
	 * is removed, its <i>OnParentVersion</i> setting of <i>ABORT</i> prevents checkin).
	 * This new version will have a predecessor connection to each version for which <i>doneMerge</i>
	 * was called, thus joining those branches of the version graph.
	 *
	 * If successful, these changes are persisted immediately,
	 * there is no need to call {@link save()}.
	 *
	 * A <i>VersionException</i> is thrown if the <i>version</i> specified is
	 * not among those referecned in this node's <i>jcr:mergeFailed</i> property.
	 *
	 * If there are unsaved changes pending on this node, an <i>InvalidItemStateException</i> is thrown.
	 *
	 * An <i>UnsupportedRepositoryOperationException</i> is thrown if this node is not versionable.
	 *
	 * A <i>RepositoryException</i> is thrown if another error occurs.
	 *
	 * @param object
	 *	A {@link Version} object
	 *    A version referred to by this node's <i>jcr:mergeFailed</i>
	 *    property.
	 * @throws {@link VersionException}
	 *    If the version specifed is not among those referenced in this node's
	 *    <i>jcr:mergeFailed</i> or if this node is currently checked-in.
	 * @throws {@link InvalidItemStateException}
	 *    If there are unsaved changes pending on this node.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not versionable.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function doneMerge(phpCR_Version $version);
	
	
	/**
	 * Cancels the merge process with respect to this node and specified 
	 * <i>$version</i>.
	 *
	 * See {@link doneMerge()} for a full explanation. Also see {@link merge()} 
	 * for more details.
	 *
	 * If successful, these changes are persisted immediately, there is no need 
	 * to call {@link save()}.
	 *
	 * @param version a version referred to by this node's
	 *    <i>jcr:mergeFailed</i> property.
	 * @throws {@link VersionException}
	 *    If the version specified is not among those referenced in this node's
	 *    <i>jcr:mergeFailed</i> or if this node is currently checked-in.
	 * @throws {@link InvalidItemStateException}
	 *    If there are unsaved changes pending on this node.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not versionable.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function cancelMerge(phpCR_Version $version);

	
	/**
	 * If this node does have a corresponding node in the workspace 
	 * <i>$srcWorkspaceName</i>, then this replaces this node and its 
	 * subtree with a clone of the corresponding node and its subtree.
	 *
	 * If this node does not have a corresponding node in the workspace
	 * <i>$srcWorkspaceName</i>, then the {@link update()} method
	 * has no effect.
	 *
	 * The <i>corresponding node</i> is defined as the node in <i>$srcWorkspace</i>
	 * with the same UUID as this node or, if this node has no UUID, the same
	 * path relative to the nearest ancestor that <i>does</i>  have a UUID,
	 * or the root node, whichever comes first. This is qualified by the requirment that
	 * referencable nodes only correspond with other referencables and non-referenceables
	 * with other non-referenceables.
	 *
	 * If the update succeeds the changes made are persisted immediately, there is
	 * no need to call {@link save()}.
	 *
	 * Note that {@link update()} does not respect the checked-in status of nodes.
	 * An {@link update()} may change a node even if it is currently checked-in
	 * (This fact is only relevant in an implementation that supports versioning).
	 *
	 * @param string 
	 *    The name of the source workspace.
	 *
	 * @throws {@link NoSuchWorkspaceException}
	 *    If <i>srcWorkspace</i> does not exist.
	 * @throws {@link InvalidItemStateException}
	 *    If this {@link Session} (not necessarily this {@link Node}) has 
	 *    pending unsaved changes.
	 * @throws {@link AccessDeniedException}
	 *    If the current session does not have sufficient rights to perform 
	 *    the operation.
	 * @throws {@link LockException}
	 *    If a lock prevents the update.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function update($scrWorkspaceName);
	
	
	/**
	 * This method can be thought of as a version-sensitive update (see 7.1.7
	 * Updating and Cloning Nodes across Workspaces in the specification).
	 *
	 * It recursively tests each versionable node in the subtree of this node
	 * against its corresponding node in <i>srcWorkspace</i> with respect 
	 * to the relation between their respective base versions and either 
	 * updates the node in question or not, depending on the outcome of the 
	 * test. For details see 8.2.10 Merge in the specification.
	 *
	 * If successful, the changes are persisted immediately, there is no need to
	 * call {@link save()}.
	 *
	 * This method returns a {@link NodeIterator} over all versionable nodes
	 * in the subtree that received a merge result of fail.
	 *
	 * If <i>$bestEffort</i> is false, this iterator will be empty
	 * (since if it merge returns successfully, instead of throwing an exception,
	 * it will be because no failures were encountered).
	 *
	 * If <i>$bestEffort</i> is <i>true</i>, this iterator will
	 * contain all nodes that received a fail during the course of this merge
	 * operation.
	 *
	 * @param string
	 *    The name of the source workspace.
	 * @param boolean
	 * @return object
	 *	A {@link NodeIterator} object
	 *    Iterator over all nodes that received a merge result of "fail" in the 
	 *    course of this operation.
	 *
	 * @throws {@link MergeException}
	 *    If <i>$bestEffort</i> is <i>false</i> and a failed merge
	 *    result is encountered.
	 * @throws {@link InvalidItemStateException}
	 *    If this session (not necessarily this node) has pending unsaved changes.
	 * @throws {@link NoSuchWorkspaceException}
	 *    If <i>srcWorkspace</i> does not exist.
	 * @throws {@link AccessDeniedException}
	 *    If the current session does not have sufficient rights to perform the operation.
	 * @throws {@link LockException}
	 *    If a lock prevents the merge.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function merge($srcWorkspace, $bestEffort);	
	
	
	/**
	 * Returns the absolute path of the node in the specified workspace that
	 * corresponds to <i>this</i> node.
	 *
	 * The <i>corresponding node</i> is defined as the node in <i>$srcWorkspace</i>
	 * with the same UUID as this node or, if this node has no UUID, the same
	 * path relative to the nearest ancestor that <i>does</i>  have a UUID,
	 * or the root node, whichever comes first. This is qualified by the requirement that
	 * referencable nodes only correspond with other referencables and non-referenceables
	 * with other non-referenceables.
	 *
	 * @param string
	 * @return string
	 *
	 * @throws {@link ItemNotFoundException}
	 *    If no corresponding node is found.
	 * @throws {@link NoSuchWorkspaceException}
	 *    If the workspace is unknown.
	 * @throws {@link AccessDeniedException}
	 *    If the current <i>session</i> has insufficent rights to perform this operation.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getCorrespondingNodePath($workspaceName);
	
	
	/**
	 * Returns true if this node is either
	 * <ul>
	 *    <li>versionable and currently checked-out,</li>
	 *    <li>non-versionable and its nearest versionable ancestor is checked-out or</li>
	 *    <li>non-versionable and it has no versionable ancestor.</li>
	 * </ul>
	 * Returns false if this node is either
	 * <ul>
	 *    <li>versionable and currently checked-in or</li>
	 *    <li>non-versionable and its nearest versionable ancestor is checked-in.</li>
	 * </ul>
	 *
	 * @return bool
	 *
	 * @throws {@link RepositoryException}
	 *   If another error occurs.
	 */
	public function isCheckedOut();
	
	
	/**
	 * Restores <i>this</i> node to the state defined by the version with
	 * the specified <i>versionName</i>.
	 *
	 * If successful, the change is persisted immediately and there is no
	 * need to call {@link save()}.
	 *
	 * A UUID collision occurs when a node exists <i>outside the subtree rooted at this node</i>
	 * with the same UUID as a node that would be introduced by the <i>restore</i>
	 * operation <i>into the subtree at this node</i>. The result in such a case is governed by
	 * the <i>$removeExisting</i> flag. If <i>removeExisting</i> is <i>true</i>,
	 * then the incoming node takes precedence, and the existing node (and its subtree) is removed.
	 * If <i>$removeExisting</i> is <i>false</i>, then a <i>ItemExistsException</i>
	 * is thrown and no changes are made. Note that this applies not only to cases where the restored
	 * node itself conflicts with an existing node but also to cases where a conflict occurs with any
	 * node that would be introduced into the workspace by the restore operation. In particular, conflicts
	 * involving subnodes of the restored node that have <i>OnParentVersion</i> settings of
	 * <i>COPY</i> or <i>VERSION</i> are also governed by the <i>$removeExisting</i> flag.
	 *
	 * @param string|{@link Version}
	 * @param boolean
	 * @param string
	 *
	 * @todo Update docs to reflect full version...
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not versionable.
	 * @throws {@link VersionException}
	 *    If the specified <i>version</i> is not part of this node's version history
	 *    or if an attempt is made to restore the root version (<i>jcr:rootVersion</i>).
	 * @throws {@link ItemExistsException}
	 *    If <i>removeExisting</i> is <i>false</i> and a UUID collision occurs.
	 * @throws {@link LockException}
	 *    If a lock prevents the restore.
	 * @throws {@link InvalidItemStateException}
	 *    If this {@link Session} (not necessarily this {@link Node}) has pending unsaved changes.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function restore($versionName, $removeExisting, $relPath = '');

	
	
	/**
	 * Restores the version of this node with the specified version label.
	 *
	 * If successful, the change is persisted immediately and there is no
	 * need to call {@link save()}.
	 *
	 *
	 * A UUID collision occurs when a node exists <i>outside the subtree rooted at this node</i>
	 * with the same UUID as a node that would be introduced by the <i>restoreByLabel</i>
	 * operation <i>into the subtree at this node</i>. The result in such a case is governed by
	 * the <i>removeExisting</i> flag. If <i>removeExisting</i> is <i>true</i>,
	 * then the incoming node takes precedence, and the existing node (and its subtree) is removed.
	 * If <i>removeExisting</i> is <i>false</i>, then a <i>ItemExistsException</i>
	 * is thrown and no changes are made. Note that this applies not only to cases where the restored
	 * node itself conflicts with an existing node but also to cases where a conflict occurs with any
	 * node that would be introduced into the workspace by the restore operation. In particular, conflicts
	 * involving subnodes of the restored node that have <i>OnParentVersion</i> settings of
	 * <i>COPY</i> or <i>VERSION</i> are also governed by the <i>removeExisting</i> flag.
	 *
	 * @param string
	 * @param boolean
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not verisonable.
	 * @throws {@link VersionException}
	 *    If the specified <i>versionLabel</i> does not exist in this 
	 *    node's version history.
	 * @throws {@link ItemExistsException}
	 *    If <i>removeExisting</i> is <i>false</i> and a UUID collision occurs.
	 * @throws {@link LockException}
	 *    If a lock prevents the restore.
	 * @throws {@link InvalidItemStateException}
	 *    If this {@link Session} (not necessarily this {@link Node}) has pending unsaved changes.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function restoreByLabel($versionLabel, $removeExisting);

	
	/**
	 * Returns the {@link VersionHistory} object of this node.
	 *
	 * This object provides access to the <i>nt:versionHistory</i>
	 * node holding this node's versions.
	 *
	 * @return object
	 *	A {@link VersionHistory} object
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this node is not versionable.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getVersionHistory();
	

	/**
	 * Returns the current base version of this versionable node.
	 *
	 * @return object
	 *	A {@link Version} object
	 *
	 * @throws UnsupportedRepositoryOperationException
	 *    If this node is not versionable.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getBaseVersion();
	
	
	/**
	 * Places a lock on this node. If successful, this node is said to <i>hold</i> the lock.
	 *
	 * If <i>isDeep</i> is <i>true</i> then the lock applies to
	 * this node and all its descendant nodes; if <i>false</i>, the lock 
	 * applies only to this, the holding node.
	 *
	 * If <i>isSessionScoped</i> is <i>true</i> then this lock will
	 * expire upon the expiration of the current session (either through an
	 * automatic or explicit {@link Session::logout()}); if <i>false</i>,
	 * this lock does not expire until explicitly unlocked or automatically 
	 * unlocked due to a implementation-specific limitation, such as a timeout.
	 *
	 * Returns a {@link Lock} object reflecting the state of the new lock and 
	 * including a lock token. See, in contrast, {@link Node::getLock()}, which 
	 * returns the {@link Lock} <i>without</i> the lock token.
	 *
	 * The lock token is also automatically added to the set of lock tokens 
	 * held by the current {@link Session}.
	 *
	 * If successful, then the property <i>jcr:lockOwner</i> is created 
	 * and set to the value of {@link Session::getUserID()} for the current
	 * session and the property <i>jcr:lockIsDeep</i> is set to the
	 * value passed in as <i>isDeep</i>. These changes are persisted 
	 * automatically; there is no need to call{@link save()}.
	 *
	 * Note that it is possible to lock a node even if it is checked-in (the 
	 * lock-related properties will be changed despite the checked-in status).
	 *
	 * If this node is not of mixin node type <i>mix:lockable</i> then an
	 * <i>LockException</i> is thrown.
	 *
	 * If this node is already locked (either because it holds a lock or a lock above it applies to it),
	 * a <i>LockException</i> is thrown.
	 *
	 * If <i>isDeep</i> is <i>true</i> and a descendant node of this node already holds a lock, then a
	 * <i>LockException</i> is thrown.
	 *
	 * If the current session does not have sufficient privileges to place the lock, an
	 * <i>AccessDeniedException</i> is thrown.
	 *
	 * @param boolean 
	 * @param boolean
	 * @return object
	 *	A {@link Lock} object
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this implementation does not support locking.
	 * @throws {@link LockException}
	 *    If this node is not <i>mix:lockable</i> or this node is already 
	 *    locked or <i>isDeep</i> is <i>true</i> and a descendant 
	 *    node of this node already holds a lock.
	 * @throws {@link AccessDeniedException}
	 *    If this session does not have permission to lock this node.
	 * @throws {@link InvalidItemStateException}
	 *    If this node has pending unsaved changes.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function lock($isDeep, $isSessionScoped);
	
	
	/**
	 * Returns the {@link Lock} object that applies to this node. This may be
	 * either a lock on this node itself or a deep lock on a node above this 
	 * node.
	 *
	 * If this {@link Session} (the one through which this {@link Node} was acquired)
	 * holds the lock token for this lock, then the returned {@link Lock} object contains
	 * that lock token (accessible through {@link Lock::getLockToken()}). If this {@link Session}
	 * does not hold the applicable lock token, then the returned {@link Lock} object will not
	 * contain the lock token (its {@link Lock::getLockToken()} method will return <i>NULL</i>).
	 *
	 * @return object
	 *	A {@link Lock} object
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this implementation does not support locking.
	 * @throws {@link LockException}
	 *    If no lock applies to this node.
	 * @throws {@link AccessDeniedException}
	 *    If the curent session does not have pernmission to get the lock.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getLock();
	
	
	/**
	 * Removes the lock on this node. Also removes the properties 
	 * <i>jcr:lockOwner</i> and <i>jcr:lockIsDeep</i> from this
	 * node.
	 *
	 * These changes are persisted automatically; there is no need to call
	 * {@link save()}.
	 *
	 * Note that it is possible to unlock a node even if it is checked-in (the
	 * lock-related properties will be changed despite the checked-in status).
	 *
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this implementation does not support locking.
	 * @throws {@link LockException}
	 *    If this node does not currently hold a lock or holds a lock for which this Session does not have the correct lock token
	 * @throws {@link AccessDeniedException}
	 *    If the current session does not have permission to unlock this node.
	 * @throws {@link InvalidItemStateException}
	 *    If this node has pending unsaved changes.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function unlock();

	/**
	 * Returns <i>true</i> if this node holds a lock; otherwise returns 
	 * <i>false</i>.
	 *
	 * To <i>hold</i> a lock means that this node has actually had a lock
	 * placed on it specifically, as opposed to just having a lock
	 * <i>apply</i> to it due to a deep lock held by a node above.
	 *
	 * @return boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function holdsLock();
	
	
	/**
	 * Returns <i>true</i> if this node is locked either as a result of a
	 * lock held by this node or by a deep lock on a node above this node; 
	 * otherwise returns <i>false</i>.
	 *
	 * @return boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function isLocked();
}


/**
 * Loads interface(s) that depend on {@link Node} being defined
 */
//require_once PHPCR_PATH . '/version/Version.interface.php';
//require_once PHPCR_PATH . '/version/VersionHistory.interface.php';
//require_once PHPCR_PATH . '/version/VersionIterator.interface.php';

?>