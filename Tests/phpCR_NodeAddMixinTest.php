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
 * <code>NodeAddMixinTest</code> contains the test cases for the method
 * <code>Node.AddMixin(String)</code>.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_NodeAddMixinTest extends phpCR_Test {

    /**
     * Tests if <code>Node->addMixin(String mixinName)</code> adds the requested
     * mixin and stores it in property <code>jcr:mixinTypes</code>
     */
    public function testAddSuccessfully() {

        $node = $this->testRootNode->addNode($this->nodeName1, 'nt:unstructured');
        $mixinName = phpCR_NodeMixinUtil::getAddableMixinName($this->session, $node);

        if ($mixinName == null) {
            $this->fail('No testable mixin node type found');
        }

        $node->addMixin($mixinName);

        // test if mixin is written to property jcr:mixinTypes immediately
        $mixinValues = $node->getProperty($this->jcrMixinTypes)->getValues();
        if (count($mixinValues) != 1) {
            $this->fail('Mixin node must be added to property ' . $this->jcrMixinTypes . ' immediately.');
        }

        $this->assertEquals($mixinName, $mixinValues[0]->getString(), 'Mixin was not properly assigned to property ' . $this->jcrMixinTypes . ': ');


        // it is implementation-specific if a added mixin is available
        // before or after save therefore save before further tests
        $this->testRootNode->save();

        // test if added mixin is available by node.getMixinNodeTypes()
        $mixins = $node->getMixinNodeTypes();
        if (count($mixins) != 1) {
            $this->fail('Mixin node not added.');
        }

        $this->assertEquals($mixinName, $mixins[0]->getName(), 'Mixin was not properly assigned: ');

    }

    /**
     * Tests if <code>Node->addMixin(String mixinName)</code> throws a
     * <code>NoSuchNodeTypeException</code> if <code>mixinName</code> is not the
     * name of an existing mixin node type
     */
    public function testAddNonExisting() {
        $nonExistingMixinName = phpCR_NodeMixinUtil::getNonExistingMixinName($this->session);

        $node = $this->testRootNode->addNode($this->nodeName1);

        try {
            $node->addMixin($nonExistingMixinName);
            $this->fail('Node.addMixin(String mixinName) must throw a NoSuchNodeTypeException if mixinName is an unknown mixin type');
        } catch (phpCR_NoSuchNodeTypeException $e) {
            // success
        }
    }


    /**
     * Tests if <code>Node->addMixin(String mixinName)</code> throws a
     * <code>LockException</code> if <code>Node</code> is locked
     * <p/>
     * The test creates a node <code>nodeName1</code> of type
     * <code>testNodeType</code> under <code>testRoot</code> and locks the node
     * with the superuser session. Then the test tries to add a mixin to
     * <code>nodeName1</code>  with the readWrite <code>Session</code>.
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
        $pathRelToRoot = T3_PHP6_Functions::substr($node->getPath(), 1);

        // access node through another session to lock it
        $session2 = $this->getSuperUserSession();

        $node2 = $session2->getRootNode()->getNode($pathRelToRoot);
        $node2->lock(true, true);

        try {
            // implementation specific: either throw LockException upon
            // addMixin or upon save.
            $node->addMixin($mixinName);
            $node->save();
            $this->fail('Node.addMixin(String mixinName) must throw a LockException if the node is locked.');
        } catch (phpCR_LockException $e) {
            // success
        }

        // unlock to remove node at tearDown()
        $node2->unlock();
        $session2->logout();

    }

    /**
     * Tests if <code>Node.addMixin(String mixinName)</code> throws a
     * <code>VersionException</code> if <code>Node</code> is checked-in.
     * <p/>
     * The test creates a node <code>nodeName1</code> of type
     * <code>testNodeType</code> under <code>testRoot</code> and checks it in.
     * Then the test tries to add a mixin to <code>nodeName1</code>.
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

        try {
            $node->addMixin($mixinName);
            $this->fail('Node->addMixin(String mixinName) must throw a VersionException if the node is checked-in.');
        } catch (phpCR_VersionException $e) {
            // success
        }
    }

    /**
     * Tests if adding mix:referenceable automatically populates the jcr:uuid
     * value.
     */
    public function testAddMixinReferencable() {

        // check if repository supports references
        $this->checkMixReferenceable();

        // get session an create default node
        $node = $this->testRootNode->addNode($this->nodeName1, 'nt:unstructured');

        $node->addMixin($this->mixReferenceable);
        // implementation specific: mixin may take effect only upon save
        $this->testRootNode->save();

        // test if jcr:uuid is not null, empty or throws a exception
        // (format of value is not defined so we can only test if not empty)
        try {
            $uuid = $node->getProperty($this->jcrUUID)->getValue()->getString();
            // default value is null so check for null
            $this->assertNotNull($uuid, 'Acessing jcr:uuid after assginment of mix:referencable returned null');
            // check if it was not set to an empty string
            $this->assertTrue(T3_PHP6_Functions::strlen($uuid) > 0, 'Acessing jcr:uuid after assginment of mix:referencable returned an empty String!');
        } catch (phpCR_ValueFormatException $e) {
            // trying to access the uuid caused an exception
            $this->fail('Acessing jcr:uuid after assginment of mix:referencable caused an ValueFormatException!');
        }
    }


    /**
     * Checks if the repository supports the mixin mix:Referenceable otherwise a
     * {@link NotExecutableException} is thrown.
     */
    private function checkMixReferenceable() {
        try {
            $this->session->getWorkspace()->getNodeTypeManager()->getNodeType($this->mixReferenceable);
        } catch (phpCR_NoSuchNodeTypeException $e) {
            $this->fail('Repository does not support mix:referenceable');
        }
    }
}

?>