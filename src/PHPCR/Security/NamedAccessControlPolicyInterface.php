<?php
/**
 * Interface description of an implementation of a named access control manager.
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

namespace PHPCR\Security;

/**
 * An NamedAccessControlPolicy is an opaque access control policy that is described
 * by a JCR name and optionally a description. NamedAccessControlPolicy are
 * immutable and can therefore be directly applied to a node without additional
 * configuration step.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NamedAccessControlPolicyInterface extends \PHPCR\Security\AccessControlPolicyInterface {

    /**
     * Returns the name of the access control policy, which is JCR name and should
     * be unique among the choices applicable to any particular node.
     *
     * @return string the name of the access control policy. A JCR name.
     *
     * @throws \PHPCR\RepositoryException - if an error occurs.
     * @api
     */
    public function getName();

}
