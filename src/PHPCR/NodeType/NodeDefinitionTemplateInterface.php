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
interface NodeDefinitionTemplateInterface extends NodeDefinitionInterface
{
    /**
     * Sets the name of the node.
     *
     * @param string $name the name of the node
     *
     * @return void
     *
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the node.
     *
     * @param bool $autoCreated the status the autocreate attribute of the
     *                          node shall have
     *
     * @return void
     *
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the node.
     *
     * @param bool $mandatory the status of the mandatory attribute
     *
     * @return void
     *
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the node.
     *
     * @param int $opv an integer constant member of OnParentVersionAction
     *
     * @return void
     *
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the node.
     *
     * @param bool $protectedStatus the status of the protected attribute
     *
     * @return void
     *
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the names of the required primary types of this node.
     *
     * @param string[] $requiredPrimaryTypeNames list of primary type names to be
     *                                           registered
     *
     * @return void
     *
     * @api
     */
    public function setRequiredPrimaryTypeNames(array $requiredPrimaryTypeNames);

    /**
     * Sets the name of the default primary type of this node.
     *
     * @param string $defaultPrimaryTypeName the name of a primary type name to
     *                                       be registered
     *
     * @return void
     *
     * @api
     */
    public function setDefaultPrimaryTypeName($defaultPrimaryTypeName);

    /**
     * Sets the same-name sibling status of this node.
     *
     * @param bool $allowSameNameSiblings Whether same-name siblings of this
     *                                    node should be allowed
     *
     * @return void
     *
     * @api
     */
    public function setSameNameSiblings($allowSameNameSiblings);
}
