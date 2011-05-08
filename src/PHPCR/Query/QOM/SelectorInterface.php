<?php
/**
 * Interface to describe the contract to implement a selector class.
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

namespace PHPCR\Query\QOM;

/**
 * Selects a subset of the nodes in the repository based on node type.
 *
 * A selector selects every node in the repository, subject to access control
 * constraints, that satisfies at least one of the following conditions:
 *
 * - the node's primary node type is nodeType
 * - the node's primary node type is a subtype of nodeType
 * - the node has a mixin node type that is nodeType
 * - the node has a mixin node type that is a subtype of nodeType
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface SelectorInterface extends SourceInterface {

    /**
     * Gets the name of the required node type.
     *
     * @return string the node type name; non-null
     * @api
     */
    public function getNodeTypeName();

    /**
     * Gets the selector name.
     * A selector's name can be used elsewhere in the query to identify the selector.
     *
     * @return string the selector name; non-null
     * @api
     */
    public function getSelectorName();

}
