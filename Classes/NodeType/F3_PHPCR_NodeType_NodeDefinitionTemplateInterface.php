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
 * The NodeDefinitionTemplate interface extends NodeDefinition with the addition
 * of write methods, enabling the characteristics of a child node definition to
 * be set, after which the NodeDefinitionTemplate is added to a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in NodeDefinition for the
 * default values assumed when a new empty NodeDefinitionTemplate is created (as
 * opposed to one extracted from an existing NodeType).
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface NodeDefinitionTemplateInterface extends \F3\PHPCR\NodeType\NodeDefinitionInterface {

	/**
	 * Sets the name of the node.
	 *
	 * @param string $name a String.
	 * @return void
	 */
	public function setName($name);

	/**
	 * Sets the auto-create status of the node.
	 *
	 * @param boolean $autoCreated a boolean.
	 * @return void
	 */
	public function setAutoCreated($autoCreated);

	/**
	 * Sets the mandatory status of the node.
	 *
	 * @param boolean $mandatory a boolean.
	 * @return void
	 */
	public function setMandatory($mandatory);

	/**
	 * Sets the on-parent-version status of the node.
	 *
	 * @param integer $opv an int constant member of OnParentVersionAction.
	 * @return void
	 */
	public function setOnParentVersion($opv);

	/**
	 * Sets the protected status of the node.
	 *
	 * @param boolean $protectedStatus a boolean.
	 * @return void
	 */
	public function setProtected($protectedStatus);

	/**
	 * Sets the names of the required primary types of this node.
	 *
	 * @param array $requiredPrimaryTypeNames a String array.
	 * @return void
	 */
	public function setRequiredPrimaryTypeNames(array $requiredPrimaryTypeNames);

	/**
	 * Sets the name of the default primary type of this node.
	 *
	 * @param string $defaultPrimaryTypeName a String.
	 * @return void
	 */
	public function setDefaultPrimaryTypeName($defaultPrimaryTypeName);

	/**
	 * Sets the same-name sibling status of this node.
	 *
	 * @param boolean $allowSameNameSiblings a boolean.
	 * @return void
	 */
	public function setSameNameSiblings($allowSameNameSiblings);

}

?>