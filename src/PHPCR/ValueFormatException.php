<?php
/**
 * Definition of the exception to be thrown in case a value of the wrong type was assigned to a property.
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

namespace PHPCR;

/**
 * Exception thrown when an attempt is made to assign a value to a property
 * that has an invalid format, given the type of the property. Also thrown
 * if an attempt is made to read the value of a property using a type-specific
 * read method of a type into which it is not convertible.
 *
 * @package phpcr
 * @subpackage exceptions
 * @api
 */
class ValueFormatException extends \PHPCR\RepositoryException {
}
