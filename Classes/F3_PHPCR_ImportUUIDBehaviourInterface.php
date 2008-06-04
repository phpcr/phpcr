<?php
declare(ENCODING = 'utf-8');

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
 * @version $Id$
 */

/**
 * The possible actions specified by the uuidBehavior parameter in
 * Workspace->importXML(), Session->importXML(),
 * Workspace->getImportContentHandler() and
 * Session->getImportContentHandler().
 * *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_ImportUUIDBehaviourInterface {

	/**
	 * The supported behaviors.
	 */
	const IMPORT_UUID_COLLISION_REMOVE_EXISTING = 1;
	const IMPORT_UUID_COLLISION_REPLACE_EXISTING = 2;
	const IMPORT_UUID_COLLISION_THROW = 3;
	const IMPORT_UUID_CREATE_NEW = 0;

}

?>