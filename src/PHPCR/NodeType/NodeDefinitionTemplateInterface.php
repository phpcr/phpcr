<?php

namespace PHPCR\NodeType;

/**
 * The NodeDefinitionTemplate interface extends NodeDefinition with the addition
 * of write methods, enabling the characteristics of a child node definition to
 * be set, after which the NodeDefinitionTemplate is added to a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in NodeDefinition for the
 * default values assumed when a new empty NodeDefinitionTemplate is created (as
 * opposed to one extracted from an existing NodeType).
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeDefinitionTemplateInterface extends \PHPCR\NodeType\NodeDefinitionInterface
{
    /**
     * Sets the name of the node.
     *
     * @param string $name The name of the node.
     *
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the node.
     *
     * @param boolean $autoCreated The status the autocreate attribute of the
     *      node shall have.
     *
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the node.
     *
     * @param boolean $mandatory The status of the mandatory attribute.
     *
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the node.
     *
     * @param integer $opv An integer constant member of OnParentVersionAction.
     *
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the node.
     *
     * @param boolean $protectedStatus The status of the protected attribute.
     *
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the names of the required primary types of this node.
     *
     * @param array $requiredPrimaryTypeNames List of primary type names to be
     *      registered.
     *
     * @api
     */
    public function setRequiredPrimaryTypeNames(array $requiredPrimaryTypeNames);

    /**
     * Sets the name of the default primary type of this node.
     *
     * @param string $defaultPrimaryTypeName The name of a primary type name to
     *      be registered.
     *
     * @api
     */
    public function setDefaultPrimaryTypeName($defaultPrimaryTypeName);

    /**
     * Sets the same-name sibling status of this node.
     *
     * @param boolean $allowSameNameSiblings Whether same-name siblings of this
     *      node should be allowed
     *
     * @api
     */
    public function setSameNameSiblings($allowSameNameSiblings);
}
