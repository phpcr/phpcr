<?php
/**
 * Interface description of an implementation of a node template definition.
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

declare(ENCODING = 'utf-8');
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
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NodeDefinitionTemplateInterface extends \PHPCR\NodeType\NodeDefinitionInterface {

    /**
     * Sets the name of the node.
     *
     * @param string $name The name of the node.
     * @return void
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the node.
     *
     * @param boolean $autoCreated The status the autocreate attribute of the node shall have.
     * @return void
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the node.
     *
     * @param boolean $mandatory The status of the mandatory attribute.
     * @return void
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the node.
     *
     * @param integer $opv An integer constant member of OnParentVersionAction.
     * @return void
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the node.
     *
     * @param boolean $protectedStatus The status of the protected attribute.
     * @return void
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the names of the required primary types of this node.
     *
     * @param array $requiredPrimaryTypeNames List of primary type names to be registered.
     * @return void
     * @api
     */
    public function setRequiredPrimaryTypeNames(Array $requiredPrimaryTypeNames);

    /**
     * Sets the name of the default primary type of this node.
     *
     * @param string $defaultPrimaryTypeName The name of a primary type name to be registered.
     * @return void
     * @api
     */
    public function setDefaultPrimaryTypeName($defaultPrimaryTypeName);

    /**
     * Sets the same-name sibling status of this node.
     *
     * @param boolean $allowSameNameSiblings The status the same-name sibling attribute shel be set to.
     * @return void
     * @api
     */
    public function setSameNameSiblings($allowSameNameSiblings);

}
