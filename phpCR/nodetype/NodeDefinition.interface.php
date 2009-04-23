<?php
// $Id: NodeDefinition.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link ItemDefinition} which is part of the PHP
 * Content Repository (phpCR), a derivative of the Java Content Repository 
 * JSR-170,  and is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *	Version 2.0
 * @package phpContentRepository
 * @package NodeTypes
 */


/**
 * A node definition. Used in node type definitions.
 *
 * @see NodeType::getChildNodeDefinitions(), Node::getDefinition()
 *
 * @package phpContentRepository
 * @package NodeTypes
 */
interface phpCR_NodeDefinition extends phpCR_ItemDefinition 
{
	/**
	 * Gets the minimum set of primary node types that the child node must have.
	 *
	 * Returns an array to support those implementations with multiple inheritance.
	 * This method never returns an empty array. If this node definition places no
	 * requirements on the primary node type, then this method will return an array
	 * containing only the {@link NodeType} object representing <i>nt:base</i>,
	 * which is the base of all primary node types and therefore constitutes the least
	 * restrictive node type requirement. Note that any particular node instance still
	 * has only one assigned primary node type, but in multiple-inheritance-supporting
	 * implementations the <i>RequiredPrimaryTypes</i> attribute can be used to
	 * restrict that assigned node type to be a subtype of <i>all</i> of a specified set
	 * of node types.
	 *
	 * @return array
	 */
	public function getRequiredPrimaryTypes();
	
	
	/**
	 * Gets the default primary node type that will be assigned to the child
	 * node if it is created without an explicitly specified primary node type.
	 *
	 * This node type must be a subtype of (or the same type as) the node types
	 * returned by {@link getRequiredPrimaryTypes()}.
	 *
	 * If <i>NULL</i> is returned this indicates that no default primary
	 * type is specified and that therefore an attempt to create this node without
	 * specifying a node type will throw a {@link ConstraintViolationException}.
	 *
	 * @return object
	 *	A {@link NodeType} object.
	 */
	public function getDefaultPrimaryType();
	
	
	/**
	 * Reports whether this child node can have same-name siblings. In other
	 * words, whether the parent node can have more than one child node of this
	 * name.
	 *
	 * @return boolean
	 */
	public function allowsSameNameSiblings();
}

?>