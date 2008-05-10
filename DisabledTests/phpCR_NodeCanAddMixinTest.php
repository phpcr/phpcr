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

require_once('phpCR_Test.php');
require_once('phpCR_NodeMixinUtil.php');

/**
 * <code>NodeCanAddMixinTest</code> contains the test cases for the method
 * <code>Node->canAddMixin(String)</code>.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_NodeCanAddMixinTest extends phpCR_Test {

    /**
     * Tests if <code>Node->canAddMixin(String mixinName)</code> throws a
     * <code>LockException</code> if <code>Node</code> is locked
     */
    public function testLocked() {

        if (!$this->isSupported(phpCR_Repository::OPTION_LOCKING_SUPPORTED)) {
            $this->fail('Locking is not supported.');
        }

        // create a node that is lockable
        $node = $this->testRootNode->addNode($this->nodeName1, 'nt:unstructured');
        // or try to make it lockable if it is not
        if (!$node->isNodeType($this->mixLockable)) {
            if ($node->canAddMixin($this->mixLockable)) {
                $node->addMixin($this->mixLockable);
            } else {
                $this->fail('Node ' . $this->nodeName1 . ' is not lockable and does not allow to add mix:lockable');
            }
        }
        $this->testRootNode->save();

        $mixinName = phpCR_NodeMixinUtil::getAddableMixinName($this->session, $node);
        if ($mixinName == null) {
            $this->fail('No testable mixin node type found');
        }

        // remove first slash of path to get rel path to root
        $pathRelToRoot = F3_PHP6_Functions::substr($node->getPath(), 1);

        // access node through another session to lock it
        $session2 = $this->getSuperuserSession();

        $node2 = $session2->getRootNode()->getNode($pathRelToRoot);
        $node2->lock(true, true);

        $this->assertFalse($node->canAddMixin($mixinName), 'Node->canAddMixin(String mixinName) must return false if the node is locked.');

        $node2->unlock();
        $session2->logout();
    }

    /**
     * Tests if <code>Node->canAddMixin(String mixinName)</code> throws a
     * <code>VersionException</code> if <code>Node</code> is checked-in
     */
    public function testCheckedIn() {

        if (!$this->isSupported(phpCR_Repository::OPTION_VERSIONING_SUPPORTED)) {
            $this->fail('Versioning is not supported.');
        }

        // create a node that is versionable
        $node = $this->testRootNode->addNode($this->nodeName1, 'nt:unstructured');
        // or try to make it versionable if it is not
        if (!$node->isNodeType($this->mixVersionable)) {
            if ($node->canAddMixin($this->mixVersionable)) {
                $node->addMixin($this->mixVersionable);
            } else {
                $this->fail('Node ' . $this->nodeName1 . ' is not versionable and does not allow to add mix:versionable');
            }
        }
        $this->testRootNode->save();

        $mixinName = phpCR_NodeMixinUtil::getAddableMixinName($this->session, $node);
        if ($mixinName == null) {
            $this->fail('No testable mixin node type found');
        }

        $node->checkin();

        $this->assertFalse($node->canAddMixin($mixinName), 'Node->canAddMixin(String mixinName) must return false if the node is checked-in.');
    }

    /**
     * Tests if <code>Node->canAddMixin(String mixinName)</code> throws a
     * <code>NoSuchNodeTypeException</code> if <code>mixinName</code> is not the
     * name of an existing mixin node type
     */
    public function testNonExisting() {
        $nonExistingMixinName = phpCR_NodeMixinUtil::getNonExistingMixinName($this->session);

        $node = $this->testRootNode->addNode($this->nodeName1);

        try {
            $node->canAddMixin($nonExistingMixinName);
            $this->fail('Node->canAddMixin(String mixinName) must throw a NoSuchNodeTypeException if mixinName is an unknown mixin type');
        } catch (phpCR_NoSuchNodeTypeException $e) {
            // success
        }
    }

}

?>