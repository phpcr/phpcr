<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR;

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
 * Exception thrown by methods of Item, Node and Workspace when an item is not found.
 *
 * @package PHPCR
 * @version $Id:F3::PHPCR::ItemNotFoundException.php 254 2007-07-09 06:34:07Z robert $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class ItemNotFoundException extends F3::PHPCR::RepositoryException {
}

?>