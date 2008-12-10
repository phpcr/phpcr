<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Security;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Security
 * @version $Id$
 */

/**
 * An NamedAccessControlPolicy is an opaque access control policy that is described
 * by a JCR name and optionally a description. NamedAccessControlPolicy are
 * immutable and can therefore be directly applied to a node without additional
 * configuration step.
 *
 * @package PHPCR
 * @subpackage Security
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface NamedAccessControlPolicyInterface extends \F3\PHPCR\Security\AccessControlPolicyInterface {

	/**
	 * Returns the name of the access control policy, which is JCR name and should
	 * be unique among the choices applicable to any particular node.
	 *
	 * @return string the name of the access control policy. A JCR name.
	 * @throws \F3\PHPCR\RepositoryException - if an error occurs.
	 */
	public function getName();

}
?>