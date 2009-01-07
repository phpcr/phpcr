<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Retention;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
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
 * @package PHPCR
 * @subpackage Retention
 * @version $Id$
 */

/**
 * A RetentionPolicy is an object with a name and an optional description.
 *
 * @package PHPCR
 * @subpackage Retention
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface RetentionPolicyInterface {

	/**
	 * Returns the name of the retention policy. A JCR name.
	 *
	 * @return string the name of the access control policy. A JCR name.
	 * @throws \F3\PHPCR\RepositoryException if an error occurs.
	 */
	public function getName();

}
?>