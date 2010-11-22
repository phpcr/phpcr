<?php
/**
 * Interface description of an implementation of a hold.
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
namespace PHPCR\Retention;

/**
 * Hold represents a hold that can be applied to an existing node in order to
 * prevent the node from being modified or removed. The format and interpretation
 * of the name are not specified. They are application-dependent.
 *
 * If isDeep() is true, the hold applies to the node and its entire subgraph.
 * Otherwise the hold applies to the node and its properties only.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface HoldInterface {

    /**
     * Returns true if this Hold is deep.
     *
     * @return boolean TRUE if this Hold is deep.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function isDeep();

    /**
     * Returns the name of this Hold. A JCR name.
     *
     * @return string the name of this Hold. A JCR name.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getName();

}
