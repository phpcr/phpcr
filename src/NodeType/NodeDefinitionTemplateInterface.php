<?php
declare(ENCODING = 'utf-8');
namespace PHPCR\NodeType;

/*                                                                        *
 * This file was ported from the Java JCR API to PHP by                   *
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.          *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version. Alternatively, you may use the Simplified   *
 * BSD License.                                                           *
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
 * The NodeDefinitionTemplate interface extends NodeDefinition with the addition
 * of write methods, enabling the characteristics of a child node definition to
 * be set, after which the NodeDefinitionTemplate is added to a NodeTypeTemplate.
 *
 * See the corresponding get methods for each attribute in NodeDefinition for the
 * default values assumed when a new empty NodeDefinitionTemplate is created (as
 * opposed to one extracted from an existing NodeType).
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @api
 */
interface NodeDefinitionTemplateInterface extends \PHPCR\NodeType\NodeDefinitionInterface {

    /**
     * Sets the name of the node.
     *
     * @param string $name a String.
     * @return void
     * @api
     */
    public function setName($name);

    /**
     * Sets the auto-create status of the node.
     *
     * @param boolean $autoCreated a boolean.
     * @return void
     * @api
     */
    public function setAutoCreated($autoCreated);

    /**
     * Sets the mandatory status of the node.
     *
     * @param boolean $mandatory a boolean.
     * @return void
     * @api
     */
    public function setMandatory($mandatory);

    /**
     * Sets the on-parent-version status of the node.
     *
     * @param integer $opv an int constant member of OnParentVersionAction.
     * @return void
     * @api
     */
    public function setOnParentVersion($opv);

    /**
     * Sets the protected status of the node.
     *
     * @param boolean $protectedStatus a boolean.
     * @return void
     * @api
     */
    public function setProtected($protectedStatus);

    /**
     * Sets the names of the required primary types of this node.
     *
     * @param array $requiredPrimaryTypeNames a String array.
     * @return void
     * @api
     */
    public function setRequiredPrimaryTypeNames(array $requiredPrimaryTypeNames);

    /**
     * Sets the name of the default primary type of this node.
     *
     * @param string $defaultPrimaryTypeName a String.
     * @return void
     * @api
     */
    public function setDefaultPrimaryTypeName($defaultPrimaryTypeName);

    /**
     * Sets the same-name sibling status of this node.
     *
     * @param boolean $allowSameNameSiblings a boolean.
     * @return void
     * @api
     */
    public function setSameNameSiblings($allowSameNameSiblings);

}
