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
 * The Workspace object represents a "view" of an actual repository workspace
 * entity as seen through the authorization settings of its associated Session.
 * Each Workspace object is associated one-to-one with a Session object. The
 * Workspace object can be acquired by calling Session.getWorkspace() on the
 * associated Session object.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_WorkspaceInterface {

}

?>