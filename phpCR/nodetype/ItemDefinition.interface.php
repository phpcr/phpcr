<?php
// $Id: ItemDefinition.interface.php 464 2005-08-20 19:41:57Z tswicegood $

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
 * Superinterface of {@link NodeDefinition} and {@link PropertyDefinition}.
 *
 * @package phpContentRepository
 * @package NodeTypes
 */
interface phpCR_ItemDefinition 
{
	/**
	 * Gets the node type that contains the declaration of <i>this</i>
	 * {@link ItemDefinition}.
	 *
	 * @return object
	 *	A {@link NodeType} object
	 */
	public function getDeclaringNodeType();
	
	
	/**
	 * Gets the name of the child item. 
	 *
	 * If <i>"*"</i>, this {@link ItemDefinition} defines a residual set 
	 * of child items. That is, t defines the characteristics of all those 
	 * child items with names apart from the names explicitly used in other 
	 * child item definitions.
	 *
	 * @return string
	 *	Denoting the name or <i>"*"</i>.
	 */
	public function getName();
	
	
	/**
	 * Reports whether the item is to be automatically created when its 
	 * parent node is created.
	 *
	 * If <i>true</i>, then this {@link ItemDefinition} will necessarily 
	 * not be a residual set definition but will specify an actual item name
	 * (in other words getName() will not return "*").
	 *
	 * @return boolean
	 */
	public function isAutoCreated();
	
	
	/**
	 * Reports whether the item is mandatory. A mandatory item is one that,
	 * if its parent node exists, must also exist.
	 *
	 * This means that a mandatory single-value property must have a value
	 * (since there is no such thing a <i>NULL</i> value). In the case of 
	 * multi-value properties this means that the property must exist, though
	 * it can have zero or more values.
	 *
	 * An attempt to save a node that has a mandatory child item without first
	 * creating that child item  will throw a 
	 * {@link ConstraintViolationException} on {@link Node::save()}.
	 *
	 * @return boolean
	 */
	public function isMandatory();
	
	
	/**
	 * Gets the on-parent-version status of the child item. 
	 *
	 * This governs what to do if the parent node of this child item is
	 * versioned; an {@link OnParentVersionAction}.
	 *
	 * @return int
	 */
	public function getOnParentVersion();
	
	
	/**
	 * Reports whether the child item is protected. 
	 *
	 * In level 2 implementations, a protected item is one that cannot be
	 * removed (except by removing its parent) or modified through the the
	 * standard write methods of this API (that is, {@link Item::remove()},
	 * {@link Node::addNode()}, {@link Node::setProperty()} and 
	 * {@link Property::setValue()}).
	 *
	 * A protected node may be removed or modified (in a level 2 
	 * implementation), however, through some mechanism not defined by this
	 * specification or as a side-effect of operations other than the standard 
	 * write methods of the API.
	 *
	 * @return boolean
	 */
	public function isProtected();
}

?>