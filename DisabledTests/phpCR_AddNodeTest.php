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

/**
 * AddNodeTest contains the test cases for the method
 * Node.addNode(String, String).
 *
 * @package			TYPO3
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_AddNodeTest extends phpCR_Test {

	/**
	 * Tests if the name of the created node is correct.
	 */
	public function testName() {
		$this->assertEquals($this->nodeName1, $this->testNode->getName(), 'Test node did not have the expected node name.');
	}

	/**
	 * Tests if the node type of the created node is correct.
	 */
	public function testNodeType() {
		$n2 = $this->testRootNode->addNode($this->nodeName2, 'nt:unstructured');
		$ntName = $n2->getPrimaryNodeType()->getName();

		$this->assertEquals($ntName, 'nt:unstructured', 'Test node did not have the expected primary nodetype name.');
	}

	/**
	 * Tests if same name siblings have equal names or if same name
	 * siblings are not supported a ItemExistsException is thrown.
	 */
	public function testSameNameSiblings() {
		if ($this->testRootNode->getDefinition()->allowsSameNameSiblings()) {
			$n1 = $this->testRootNode->addNode($this->nodeName2, 'nt:unstructured');
			$n2 = $this->testRootNode->addNode($this->nodeName2, 'nt:unstructured');

			$this->assertEquals($n1->getName(), $n2->getName(), 'Names of same name siblings are not equal.');
		} else {
			$this->testRootNode->addNode($this->nodeName2, 'nt:unstructured');
			try {
				$this->testRootNode->addNode($this->nodeName2, 'nt:unstructured');
				$this->fail('Expected ItemExistsException. It seems that allowsSameNameSiblings() returns incorrect value!');
			} catch (phpCR_ItemExistsException $e) {
				// correct
			} catch (phpCR_RepositoryException $e) {
				$this->fail('Expected NoSuchNodeTypeException.');
			}
		}
	}

	/**
	 * Tests if addNode() throws a NoSuchNodeTypeException in case
	 * of an unknown node type.
	 */
	public function testUnknownNodeType() {
		try {
			$this->testRootNode->addNode($this->nodeName2, 'nt:unstructured_unknownSuffix');
			$this->fail('Expected NoSuchNodeTypeException, none thrown.');
		} catch (phpCR_NoSuchNodeTypeException $e) {
			// correct.
		} catch (phpCR_RepositoryException $e) {
			$this->fail('Expected NoSuchNodeTypeException.');
		}
	}

	/**
	 * Tests if the path of the created node is correct.
	 */
	public function testPath() {
		$n1 = $this->testRootNode->addNode($this->nodeName2, 'nt:unstructured');
		$expected = $this->testRootNode->getPath() . '/' . $this->nodeName2;

		$this->assertEquals($expected, $n1->getPath(), 'Wrong path for created node.');
	}

	/**
	 * Tests if addNode() throws a PathNotFoundException in case
	 * intermediary nodes do not exist.
	 */
	public function testPathNotFound() {
		try {
			$this->testRootNode->addNode('node-unkown/node-u1', 'nt:unstructured');
			$this->fail('Expected PathNotFoundException, none thrown.');
		} catch (phpCR_PathNotFoundException $e) {
			// correct.
		} catch (phpCR_RepositoryException $e) {
			$this->fail('Expected PathNotFoundException.');
		}
	}

	/**
	 * Tests if a ConstraintViolationException is thrown when one attempts
	 * to add a node at a path that references a property.
	 */
	public function testConstraintViolation() {
		try {
			$rootNode = $this->session->getRootNode();
			$propPath = $this->testPath . '/' . $this->jcrPrimaryType;
			$rootNode->addNode($propPath . '/' . $this->nodeName1, 'nt:unstructured');
			$this->fail('Expected ConstraintViolationException, none thrown.');
		} catch (phpCR_ConstraintViolationException $e) {
			// correct.
		} catch (phpCR_RepositoryException $e) {
			$this->fail('Expected ConstraintViolationException.');
		}
	}

	/**
	 * Tests if a RepositoryException is thrown in case the path
	 * for the new node contains an index.
	 */
	public function testRepositoryException() {
		try {
			$this->testRootNode->addNode($this->nodeName2 . '[1]');
			$this->fail('Expected RepositoryException, none thrown.');
		} catch (phpCR_RepositoryException $e) {
			// correct.
		}

		try {
			$this->testRootNode->addNode($this->nodeName2 . '[1]', 'nt:unstructured');
			$this->fail('Expected RepositoryException, none thrown.');
		} catch (phpCR_RepositoryException $e) {
			// correct.
		}
	}

	/**
	 * Creates a new node using {@link Node#addNode(String,String)}, saves using
	 * {@link javax.jcr.Node#save()} on parent node. Uses a second session to
	 * verify if the node have been saved.
	 */
	public function testAddNodeParentSave() {
		// get default workspace test root node using superuser session
		$defaultRootNode = $this->session->getItem($this->testRootNode->getPath());

		// add node
		$testNode = $defaultRootNode->addNode($this->nodeName2, 'nt:unstructured');

		// save new node
		$defaultRootNode->save();

		// use a different session to verify if the node is there
		$session = $this->getSuperUserSession();
		try {
			$session->getItem($testNode->getPath());
		} catch (phpCR_ItemNotFoundException $e) {
			$this->fail('Added node could not be found!');
		} catch (phpCR_RepositoryException $e) {
			$this->fail('Expected ItemNotFoundException.');
		}

		$testNode->remove();
		$session->logout();
	}

	/**
	 * Creates a new node using {@link Node#addNode(String, String)}, saves using
	 * {@link javax.jcr.Session#save()}. Uses a second session to verify if the
	 * node has been safed.
	 */
	public function testAddNodeSessionSave() {
		// get default workspace test root node using superuser session
		$defaultRootNode = $this->session->getItem($this->testRootNode->getPath());

		// add node
		$testNode = $defaultRootNode->addNode($this->nodeName2, 'nt:unstructured');

		// save new node
		$this->session->save();

		// use a different session to verify if the node is there
		$session = $this->getSuperUserSession();
		try {
			$session->getItem($testNode->getPath());
		} catch (phpCR_ItemNotFoundException $e) {
			$this->fail('Added node could not be found!');
		} catch (phpCR_RepositoryException $e) {
			$this->fail('Expected ItemNotFoundException.');
		}

		$testNode->remove();
		$session->logout();
	}

	/**
	 * Creates a new node using {@link Node#addNode(String, String)}, then tries
	 * to call {@link javax.jcr.Node#save()} on the new node.
	 * <br/><br/>
	 * This should throw an {@link RepositoryException}.
	 */
	public function testAddNodeRepositoryExceptionSaveOnNewNode() {
		// get default workspace test root node using superuser session
		$defaultRootNode = $this->session->getItem($this->testRootNode->getPath());

		// add a node
		$testNode = $defaultRootNode->addNode($this->nodeName2, 'nt:unstructured');

		try {
			// try to call save on newly created node
			$testNode->save();
			$this->fail('Calling Node->save() on a newly created node should throw RepositoryException');
		} catch (phpCR_RepositoryException $e) {
			// ok, works as expected.
		}
	}
}
?>
