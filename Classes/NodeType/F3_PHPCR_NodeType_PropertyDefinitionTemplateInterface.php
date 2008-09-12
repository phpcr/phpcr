<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR::NodeType;

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
 * The PropertyDefinitionTemplate interface extends PropertyDefinition with the
 * addition of write methods, enabling the characteristics of a child property
 * definition to be set, after which the PropertyDefinitionTemplate is added to
 * a NodeTypeTemplate.

See the corresponding get methods for each attribute in PropertyDefinition for
the default values assumed when a new empty PropertyDefinitionTemplate is created
(as opposed to one extracted from an existing NodeType).
 *
 * @package PHPCR
 * @subpackage NodeType
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface PropertyDefinitionTemplateInterface extends F3::PHPCR::NodeType::PropertyDefinitionInterface {

	/**
	 * Sets the name of the property.
	 *
	 * @param string $name a String.
	 * @return void
	 */
	public function setName($name);

	/**
	 * Sets the auto-create status of the property.
	 *
	 * @param boolean $autoCreated a boolean.
	 * @return void
	 */
	public function setAutoCreated($autoCreated);

	/**
	 * Sets the mandatory status of the property.
	 *
	 * @param boolean $mandatory a boolean.
	 * @return void
	 */
	public function setMandatory($mandatory);

	/**
	 * Sets the on-parent-version status of the property.
	 *
	 * @param integer $opv an int constant member of OnParentVersionAction.
	 * @return void
	 */
	public function setOnParentVersion($opv);

	/**
	 * Sets the protected status of the property.
	 *
	 * @param boolean $protectedStatus a boolean.
	 * @return void
	 */
	public function setProtected($protectedStatus);

	/**
	 * Sets the required type of the property.
	 *
	 * @param integer $type an int constant member of PropertyType.
	 * @return void
	 */
	public function setRequiredType($type);

	/**
	 * Sets the value constraints of the property.
	 *
	 * @param array $constraints a String array.
	 * @return void
	 */
	public function setValueConstraints(array $constraints);

	/**
	 * Sets the default value (or values, in the case of a multi-value property)
	 * of the property.
	 *
	 * @param array $defaultValues a Value array.
	 * @return void
	 */
	public function setDefaultValues(array $defaultValues);

	/**
	 * Sets the multi-value status of the property.
	 *
	 * @param boolean $multiple a boolean.
	 * @return void
	 */
	public function setMultiple($multiple);

}

?>