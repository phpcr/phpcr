<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\NodeType;

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
 * @subpackage NodeType
 * @version $Id$
 */

/**
 * Superclass of NodeDefinition and PropertyDefinition.
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface ItemDefinitionInterface {

	/**
	 * Gets the node type that contains the declaration of this ItemDefinition.
	 * In implementations that support node type registration an ItemDefinition
	 * object may be acquired (in the form of a NodeDefinitionTemplate or
	 * PropertyDefinitionTemplate) that is not attached to a live NodeType. In
	 * such cases this method returns null.
	 *
	 * @return \F3\PHPCR\NodeType\NodeTypeInterface a NodeType object.
	 */
	public function getDeclaringNodeType();

	/**
	 * Gets the name of the child item. If "*", this ItemDefinition defines a
	 * residual set of child items. That is, it defines the characteristics of
	 * all those child items with names apart from the names explicitly used in
	 * other child item definitions.
	 *
	 * In implementations that support node type registration, if this
	 * ItemDefinition object is actually a newly-created empty
	 * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
	 * will return null.
	 *
	 * @return string a String denoting the name or "*".
	 */
	public function getName();

	/**
	 * Reports whether the item is to be automatically created when its parent
	 * node is created. If true, then this ItemDefinition will necessarily not
	 * be a residual set definition but will specify an actual item name (in
	 * other words getName() will not return "*").
	 *
	 * An autocreated item non-protected item must be created immediately when
	 * its parent node is created in the transient session space. Creation of
	 * autocreated non-protected items is never delayed until save.
	 *
	 * An autocreated protected item should be created immediately when its
	 * parent node is created in the transient session space. Creation of
	 * autocreated protected items should not be delayed until save, though
	 * doing so does not violate JCR compliance.
	 *
	 * In implementations that support node type registration, if this
	 * ItemDefinition object is actually a newly-created empty
	 * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
	 * will return false.
	 *
	 * @return boolean a boolean.
	 */
	public function isAutoCreated();

	/**
	 * Reports whether the item is mandatory. A mandatory item is one that, if
	 * its parent node exists, must also exist.
	 * This means that a mandatory single-value property must have a value (since
	 * there is no such thing a null value). In the case of multi-value properties
	 * this means that the property must exist, though it can have zero or more
	 * values.
	 *
	 * An attempt to save a node that has a mandatory child item without first
	 * creating that child item will throw a ConstraintViolationException on save.
	 *
	 * In implementations that support node type registration, if this
	 * ItemDefinition object is actually a newly-created empty
	 * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
	 * will return false.
	 *
	 * An item definition cannot be both residual and mandatory.
	 *
	 * @return boolean a boolean
	 */
	public function isMandatory();

	/**
	 * Gets the OnParentVersion status of the child item. This governs what occurs
	 * (in implementations that support versioning) when the parent node of this
	 * item is checked-in. One of:
	 *  OnParentVersionAction.COPY
	 *  OnParentVersionAction.VERSION
	 *  OnParentVersionAction.IGNORE
	 *  OnParentVersionAction.INITIALIZE
	 *  OnParentVersionAction.COMPUTE
	 *  OnParentVersionAction.ABORT
	 *
	 * In implementations that support node type registration, if this
	 * ItemDefinition object is actually a newly-created empty
	 * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
	 * will return OnParentVersionAction.COPY.
	 *
	 * @return integer a int constant member of OnParentVersionAction.
	 */
	public function getOnParentVersion();

	/**
	 * Reports whether the child item is protected. In level 2 implementations,
	 * a protected item is one that cannot be removed (except by removing its
	 * parent) or modified through the the standard write methods of this API
	 * (that is, Item.remove, Node.addNode, Node.setProperty and Property.setValue).
	 *
	 * A protected node may be removed or modified (in a level 2 implementation),
	 * however, through some mechanism not defined by this specification or as a
	 * side-effect of operations other than the standard write methods of the API.
	 *
	 * In implementations that support node type registration, if this
	 * ItemDefinition object is actually a newly-created empty
	 * PropertyDefinitionTemplate or NodeDefinitionTemplate, then this method
	 * will return false.
	 *
	 * @return booleana boolean.
	 */
	public function isProtected();

}

?>