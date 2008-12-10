<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Lock;

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
 * @subpackage Lock
 * @version $Id$
 */

/**
 * Exception thrown by Item.save() and Session.save() when persisting a
 * change would conflict with a lock.
 *
 * @package PHPCR
 * @subpackage Lock
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class LockException extends \F3\PHPCR\RepositoryException {
}

?>