<?php
declare(encoding = 'utf-8');

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
 * Utility class to locate mixins in the NodeTyeManager.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_NodeMixinUtil {

    /**
     * @return the name of a mixin node type that can be added by the requested
     *         <code>node</code>
     */
    public static function getAddableMixinName($session, $node) {

        $manager = $session->getWorkspace()->getNodeTypeManager();
        $mixins = $manager->getMixinNodeTypes();

        while ($mixins->hasNext()) {
            $name = $mixins->nextNodeType()->getName();
            if ($node->canAddMixin($name)) {
                return $name;
            }
        }
        return null;
    }

    /**
     * @return a string that is not the name of a mixin type
     */
    public static function getNonExistingMixinName($session) {

        $manager = $session->getWorkspace()->getNodeTypeManager();
        $mixins = $manager->getMixinNodeTypes();

        while ($mixins->hasNext()) {
            $s = 'X' . $mixins->nextNodeType()->getName();
        }

        return str_replace(':', '', $s);
    }


}

?>