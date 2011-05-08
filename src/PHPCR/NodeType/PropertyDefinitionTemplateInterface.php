<?php
/**
 * Interface description of how to implement a property definition template.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */

namespace PHPCR\NodeType;

/**
 * The PropertyDefinitionTemplate interface extends PropertyDefinition with the
 * addition of write methods, enabling the characteristics of a child property
 * definition to be set, after which the PropertyDefinitionTemplate is added to
 * a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in PropertyDefinition for
 * the default values assumed when a new empty PropertyDefinitionTemplate is created
 * (as opposed to one extracted from an existing NodeType).
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface PropertyDefinitionTemplateInterface extends \PHPCR\NodeType\PropertyDefinitionInterface {

    /**
     * Sets the name of the property.
     *
     * @param string $name The name of the property definition template.
     * @return void
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the property.
     *
     * @param boolean $autoCreated Flag to set the ability to be automatically created.
     * @return void
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the property.
     *
     * @param boolean $mandatory The mandatory status of the property.
     * @return void
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the property.
     *
     * @param integer $opv an int constant member of OnParentVersionAction.
     * @return void
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the property.
     *
     * @param boolean $protectedStatus The protection status of the property.
     * @return void
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the required type of the property.
     *
     * @param integer $type An integer constant member of PropertyType.
     * @return void
     * @api
     */
    public function setRequiredType($type);

    /**
     * Sets the value constraints of the property.
     *
     * @param array $constraints List of constrains registered on the property.
     * @return void
     * @api
     */
    public function setValueConstraints(array $constraints);

    /**
     * Sets the default value (or values, in the case of a multi-value property)
     * of the property.
     *
     * @param array $defaultValues A List of values in the correct type for this property.
     * @return void
     * @api
     */
    public function setDefaultValues(array $defaultValues);

    /**
     * Sets the multi-value status of the property.
     *
     * @param boolean $multiple The status of the ability to store multiple values.
     * @return void
     * @api
     */
    public function setMultiple($multiple);

    /**
     * Sets the queryable status of the property.
     *
     * @param array operators An array of String constants {@link PropertyDefinition::getAvailableQueryOperators()}.
     * @return void
     * @api
     */
    public function setAvailableQueryOperators(array $operators);

    /**
     * Sets the full-text-searchable status of the property.
     *
     * @param boolean $fullTextSearchable The status of the ability to be fulltext-searchable..
     * @return void
     * @api
     */
    public function setFullTextSearchable($fullTextSearchable);

    /**
     * Sets the query-orderable status of the property.
     *
     * @param boolean $queryOrderable The status of the ability being query-orderable.
     * @return void
     * @api
     */
    public function setQueryOrderable($queryOrderable);

}
