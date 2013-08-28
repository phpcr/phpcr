<?php

namespace PHPCR\NodeType;

/**
 * The PropertyDefinitionTemplate interface extends PropertyDefinition with the
 * addition of write methods, enabling the characteristics of a child property
 * definition to be set, after which the PropertyDefinitionTemplate is added to
 * a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in PropertyDefinition for
 * the default values assumed when a new empty PropertyDefinitionTemplate is
 * created (as opposed to one extracted from an existing NodeType).
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface PropertyDefinitionTemplateInterface extends \PHPCR\NodeType\PropertyDefinitionInterface
{
    /**
     * Sets the name of the property.
     *
     * @param string $name The name of the property definition template.
     *
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the property.
     *
     * @param boolean $autoCreated Flag to set the ability to be automatically
     *      created.
     *
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the property.
     *
     * @param boolean $mandatory The mandatory status of the property.
     *
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the property.
     *
     * @param integer $opv an int constant member of OnParentVersionAction.
     *
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the property.
     *
     * @param boolean $protectedStatus The protection status of the property.
     *
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the required type of the property.
     *
     * @param integer $type An integer constant member of PropertyType.
     *
     * @api
     */
    public function setRequiredType($type);

    /**
     * Sets the value constraints of the property.
     *
     * @param array $constraints List of constrains registered on the property.
     *
     * @api
     */
    public function setValueConstraints(array $constraints);

    /**
     * Sets the default value (or values, in the case of a multi-value property)
     * of the property.
     *
     * @param array $defaultValues A List of values in the correct type for
     *      this property.
     *
     * @api
     */
    public function setDefaultValues(array $defaultValues);

    /**
     * Sets the multi-value status of the property.
     *
     * @param boolean $multiple The status of the ability to store multiple
     *      values.
     *
     * @api
     */
    public function setMultiple($multiple);

    /**
     * Sets the queryable status of the property.
     *
     * @param array $operators An array of String constants
     *      {@link PropertyDefinition::getAvailableQueryOperators()}.
     *
     * @api
     */
    public function setAvailableQueryOperators(array $operators);

    /**
     * Sets the full-text-searchable status of the property.
     *
     * @param boolean $fullTextSearchable The status of the ability to be
     *      fulltext-searchable..
     *
     * @api
     */
    public function setFullTextSearchable($fullTextSearchable);

    /**
     * Sets the query-orderable status of the property.
     *
     * @param boolean $queryOrderable The status of the ability being
     *      query-orderable.
     *
     * @api
     */
    public function setQueryOrderable($queryOrderable);
}
