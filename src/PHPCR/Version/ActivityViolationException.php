<?php
/**
 * Definition of the exception to be thrown in case of an acitivty issue on a node.
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
 * @subpackage exceptions
 */

declare(ENCODING = 'utf-8');
namespace PHPCR;

/**
 * Exception will be thrown by Node.checkout and Node.checkpoint if an activity
 * A is present on the current session and any of the following conditions is met:
 *
 * - There already is a node in another workspace that has a checked-out node
 *   for the version history of N whose jcr:activity references A.
 * - There is a version in the version history of N that is not a predecessor
 *   of N but whose jcr:activity references A.
 *
 * @package phpcr
 * @subpackage exceptions
 * @api
 */
class ActivityViolationException extends \PHPCR\Version\VersionException {
}
