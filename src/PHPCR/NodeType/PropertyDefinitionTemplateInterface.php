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
interface PropertyDefinitionTemplateInterface extends PropertyDefinitionInterface
{
    /**
     * Sets the name of the property.
     *
     * @param string $name the name of the property definition template
     *
     * @return void
     *
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the property.
     *
     * @param bool $autoCreated flag to set the ability to be automatically
     *                          created
     *
     * @return void
     *
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the property.
     *
     * @param bool $mandatory the mandatory status of the property
     *
     * @return void
     *
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the property.
     *
     * @param int $opv an int constant member of OnParentVersionAction
     *
     * @return void
     *
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the property.
     *
     * @param bool $protectedStatus the protection status of the property
     *
     * @return void
     *
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the required type of the property.
     *
     * @param int $type an integer constant member of PropertyType
     *
     * @return void
     *
     * @api
     */
    public function setRequiredType($type);

    /**
     * Sets the value constraints of the property.
     *
     * @param string[] $constraints list of constrains registered on the property
     *
     * @return void
     *
     * @api
     */
    public function setValueConstraints(array $constraints);

    /**
     * Sets the default value (or values, in the case of a multi-value property)
     * of the property.
     *
     * @param array<mixed> $defaultValues a List of values in the correct type for
     *                                    this property
     *
     * @return void
     *
     * @api
     */
    public function setDefaultValues(array $defaultValues);

    /**
     * Sets the multi-value status of the property.
     *
     * @param bool $multiple the status of the ability to store multiple
     *                       values
     *
     * @return void
     *
     * @api
     */
    public function setMultiple($multiple);

    /**
     * Sets the queryable status of the property.
     *
     * @param string[] $operators an array of String constants
     *                            {@link PropertyDefinition::getAvailableQueryOperators()}
     *
     * @return void
     *
     * @api
     */
    public function setAvailableQueryOperators(array $operators);

    /**
     * Sets the full-text-searchable status of the property.
     *
     * @param bool $fullTextSearchable The status of the ability to be
     *                                 fulltext-searchable..
     *
     * @return void
     *
     * @api
     */
    public function setFullTextSearchable($fullTextSearchable);

    /**
     * Sets the query-orderable status of the property.
     *
     * @param bool $queryOrderable the status of the ability being
     *                             query-orderable
     *
     * @return void
     *
     * @api
     */
    public function setQueryOrderable($queryOrderable);
}
