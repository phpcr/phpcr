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

/*                                                                        *
 * Components configuration for the PHPCR package                         *
 *                                                                        */

/**
 * @package PHPCR
 * @version $Id$
 */

$c->F3_PHPCR_ItemInterface->scope = 'prototype';
$c->F3_PHPCR_NodeInterface->scope = 'prototype';
$c->F3_PHPCR_NodeIteratorInterface->scope = 'prototype';
$c->F3_PHPCR_PropertyInterface->scope = 'prototype';
$c->F3_PHPCR_PropertyIteratorInterface->scope = 'prototype';
$c->F3_PHPCR_ValueInterface->scope = 'prototype';
$c->F3_PHPCR_NodeType_NodeTypeInterface->scope = 'prototype';

?>