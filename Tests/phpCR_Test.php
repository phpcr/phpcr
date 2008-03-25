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
 * General test setups
 *
 * @package			TYPO3
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author 		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_Test extends F3_Testing_BaseTestCase {
	/**
	 * String encoding in a stream
	 */
	protected $UTF8 	= "UTF-8";
	/**
	 * Namespace URI for jcr prefix.
	 */
	protected $NS_JCR_URI = "http://www.jcp.org/jcr/1.0";

	/**
	 * Namespace URI for nt prefix.
	 */
	protected $NS_NT_URI = "http://www.jcp.org/jcr/nt/1.0";

	/**
	 * Namespace URI for mix prefix.
	 */
	protected $NS_MIX_URI = "http://www.jcp.org/jcr/mix/1.0";

	/**
	 * Namespace URI for sv prefix
	 */
	protected $NS_SV_URI = "http://www.jcp.org/jcr/sv/1.0";

	/**
	 * JCR Name jcr:primaryType using the namespace resolver of the current session.
	 */
	protected $jcrPrimaryType;

	/**
	 * JCR Name jcr:mixinTypes using the namespace resolver of the current session.
	 */
	protected $jcrMixinTypes;

	/**
	 * JCR Name jcr:predecessors using the namespace resolver of the current session.
	 */
	protected $jcrPredecessors;

	/**
	 * JCR Name jcr:successors using the namespace resolver of the current session.
	 */
	protected $jcrSuccessors;

	/**
	 * JCR Name jcr:created using the namespace resolver of the current session.
	 */
	protected $jcrCreated;

	/**
	 * JCR Name jcr:created using the namespace resolver of the current session.
	 */
	protected $jcrVersionHistory;

	/**
	 * JCR Name jcr:frozenNode using the namespace resolver of the current session.
	 */
	protected $jcrFrozenNode;

	/**
	 * JCR Name jcr:frozenUuid using the namespace resolver of the current session.
	 */
	protected $jcrFrozenUuid;

	/**
	 * JCR Name jcr:rootVersion using the namespace resolver of the current session.
	 */
	protected $jcrRootVersion;

	/**
	 * JCR Name jcr:baseVersion using the namespace resolver of the current session.
	 */
	protected $jcrBaseVersion;

	/**
	 * JCR Name jcr:uuid using the namespace resolver of the current session.
	 */
	protected $jcrUUID;

	/**
	 * JCR Name jcr:lockOwner using the namespace resolver of the current session.
	 */
	protected $jcrLockOwner;

	/**
	 * JCR Name jcr:lockIsDeep using the namespace resolver of the current session.
	 */
	protected $jcrlockIsDeep;

	/**
	 * JCR Name jcr:mergeFailed using the namespace resolver of the current session.
	 */
	protected $jcrMergeFailed;

	/**
	 * JCR Name jcr:system using the namespace resolver of the current session.
	 */
	protected $jcrSystem;

	/**
	 * JCR Name nt:base using the namespace resolver of the current session.
	 */
	protected $ntBase;

	/**
	 * JCR Name nt:version using the namespace resolver of the current session.
	 */
	protected $ntVersion;

	/**
	 * JCR Name nt:versionHistory using the namespace resolver of the current session.
	 */
	protected $ntVersionHistory;

	/**
	 * JCR Name nt:versionHistory using the namespace resolver of the current session.
	 */
	protected $ntVersionLabels;

	/**
	 * JCR Name nt:frozenNode using the namespace resolver of the current session.
	 */
	protected $ntFrozenNode;

	/**
	 * JCR Name mix:referenceable using the namespace resolver of the current session.
	 */
	protected $mixReferenceable;

	/**
	 * JCR Name mix:versionable using the namespace resolver of the current session.
	 */
	protected $mixVersionable;

	/**
	 * JCR Name mix:lockable using the namespace resolver of the current session.
	 */
	protected $mixLockable;

	/**
	 * JCR Name nt:query using the namespace resolver of the current session.
	 */
	protected $ntQuery;

	// definitions
	protected $finished		= false;
	protected $session 		= NULL;
	protected $repository 	= NULL;

	protected $testPath		= "testdata";
	protected $testRoot		= "/testdata";
	protected $testRootNode	= NULL;
	protected $testNode		= NULL;
	protected $testProp 	= NULL;
	protected $workspaceName= "default";

	protected $nodeName1	= "testNode1";
	protected $nodeName2	= "testNode2";
	protected $nodeName3	= "testNode3";

	protected $propName1	= "testProp1";
	protected $propName2	= "testProp2";

	protected $value1		= "testValue1";
	protected $value2		= "testValue2";

	/**
	 * @todo remove hardcoded dependency on phpCRJackrabbit
	 */
	protected function setUp() {
		$TYPO3 = new F3_FLOW3;
		$TYPO3->initialize();

		$this->repository = $TYPO3->getComponentManager()->getComponent('F3_phpCR_Repository');

		$this->readOnlyCredentials = new F3_phpCRJackrabbit_SimpleCredentials('anonymous', '');
		$this->superUserCredentials = new F3_phpCRJackrabbit_SimpleCredentials('typo3', 'password');

		if (!isset($GLOBALS['session'])) {
			$this->session 		= $this->getSuperUserSession();
			$GLOBALS['session'] = $this->session;
		} else {
			$this->session = $GLOBALS['session'];
		}

		// create a node, add a property and save it
		$this->testRootNode = $this->cleanUpTestRoot($this->session);
		$this->testNode		= $this->testRootNode->addNode($this->nodeName1);
		$this->testProp		= $this->testNode->setProperty($this->propName1, $this->value1);

		// setup some common names
		$this->jcrPrimaryType 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":primaryType";
		$this->jcrMixinTypes 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":mixinTypes";
		$this->jcrPredecessors 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":predecessors";
		$this->jcrSuccessors 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":successors";
		$this->jcrCreated 			= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":created";
		$this->jcrVersionHistory 	= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":versionHistory";
		$this->jcrFrozenNode 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":frozenNode";
		$this->jcrFrozenUuid 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":frozenUuid";
		$this->jcrRootVersion 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":rootVersion";
		$this->jcrBaseVersion 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":baseVersion";
		$this->jcrUUID 				= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":uuid";
		$this->jcrLockOwner 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":lockOwner";
		$this->jcrlockIsDeep 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":lockIsDeep";
		$this->jcrMergeFailed 		= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":mergeFailed";
		$this->jcrSystem 			= $this->session->getNamespacePrefix($this->NS_JCR_URI) . ":system";
		$this->ntBase 				= $this->session->getNamespacePrefix($this->NS_NT_URI) . ":base";
		$this->ntVersion 			= $this->session->getNamespacePrefix($this->NS_NT_URI) . ":version";
		$this->ntVersionHistory 	= $this->session->getNamespacePrefix($this->NS_NT_URI) . ":versionHistory";
		$this->ntVersionLabels 		= $this->session->getNamespacePrefix($this->NS_NT_URI) . ":versionLabels";
		$this->ntFrozenNode 		= $this->session->getNamespacePrefix($this->NS_NT_URI) . ":frozenNode";
		$this->mixReferenceable 	= $this->session->getNamespacePrefix($this->NS_MIX_URI) . ":referenceable";
		$this->mixVersionable 		= $this->session->getNamespacePrefix($this->NS_MIX_URI) . ":versionable";
		$this->mixLockable 			= $this->session->getNamespacePrefix($this->NS_MIX_URI) . ":lockable";
		$this->ntQuery 				= $this->session->getNamespacePrefix($this->NS_NT_URI) . ":query";

		// setup custom namespaces
		if ($this->isSupported(F3_phpCRJackrabbit_Repository::LEVEL_2_SUPPORTED)) {
			$nsReg = $this->session->getWorkspace()->getNamespaceRegistry();
			$uri = 'http://www.apache.org/jackrabbit/test';

			try {
				$nsReg->getPrefix($uri);
			} catch (phpCR_NamespaceException $e) {
				// not yet registered
				$nsReg->registerNamespace('test', $uri);
			}
			unset($nsReg);
		}
	}

	/**
	 * @todo remove hardcoded dependency on phpCRJackrabbit
	 */
	protected function tearDown() {
		try {
			if ($this->isSupported(F3_phpCRJackrabbit_Repository::LEVEL_2_SUPPORTED)) {
				$this->cleanUpTestRoot($this->session);
			}
		} catch (Exception $e) {
			$this->session->logout();
			unset($this->session);
			$this->fail("Exception in tearDown: " . $e);
		}

		if ($this->finished === TRUE) {
			$this->session->logout();
			$this->session = NULL;
			$GLOBALS['session'] = NULL;
		}
	}

	public function testNothing() {
		$this->finished = TRUE;
	}

	/**
	 * returns simple credential object for readonly session
	 *
	 * @return phpCR_SimpleCredentials
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getReadOnlyCredentials() {
		return $this->readOnlyCredentials;
	}

	/**
	 * Tries to login in to the repository and returns a readonly session object
	 *
	 * @param string $workspaceName Name of a workspace to log in to, if any
	 * @return phpCR_Session
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getReadOnlySession($workspaceName = NULL) {
		if ($workspaceName === NULL) {
			$session = $this->repository->login($this->getReadOnlyCredentials());
		} else {
			$session = $this->repository->login(NULL, $workspaceName);
		}
		return $session;
	}

	/**
	 * Returns the superuser credentials.
	 *
	 * @return phpCR_SimpleCredentials
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getSuperUserCredentials() {
		return $this->superUserCredentials;
	}

	/**
	 * Tries to login in to the repository and returns superuser session object
	 *
	 * @param string $workspaceName Name of a workspace to log in to, if any
	 * @return phpCR_Session
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getSuperUserSession($workspaceName = null) {
		return $this->repository->login($this->getSuperUserCredentials(), $workspaceName);
	}

	/**
	 * Returns the size of the RangeIterator iterator.
	 * Note, that the RangeIterator might get consumed, because
	 * {@link RangeIterator#getSize()} might return -1 (information unavailable).
	 *
	 * @param phpCR_RangeIterator $iterator 	a RangeIterator.
	 * @return integer the size of the iterator (number of elements).
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function getSize(phpCR_RangeIterator $iterator) {
		$size = $iterator->getSize();
		if ($size != -1) {
			return $size;
		}

		$size = 0;
		while ($iterator->hasNext()) {
			$iterator->next();
			$size++;
		}
		return $size;
	}

	/**
	 * Creates a <code>String</code> with a random sequence of characters
	 * using 'a' - 'z'.
	 *
	 * @param integer numChars number of characters.
	 * @return string the generated String.
	 */
	protected function createRandomString($numChars) {
		for ($i = 0; $i < $numChars; $i++) {
			$rand = mt_rand(1,26);
			$tmp .= (string)$rand;
		}
		return $tmp;
	}

	/**
	 * Returns <code>true</code> if this repository support a certain optional
	 * feature; otherwise <code>false</code> is returned. If there is no
	 * such <code>descriptorKey</code> present in the repository, this method
	 * also returns false.
	 *
	 * @param string $descriptorKey the descriptor key.
	 * @return boolean true if the option is supported.
	 * @throws RepositoryException if an error occurs.
	 */
	protected function isSupported($descriptorKey) {
		$value = $this->repository->getDescriptor($descriptorKey);
		return ($value == "true" ? true : false);
	}

	/**
	 * Reverts any pending changes made by <code>s</code> and deletes any nodes
	 * under {@link #testRoot}. If there is no node at {@link #testRoot} then
	 * the necessary nodes are created.
	 *
	 * @param phpCR_Session $session the session to clean up.
	 * @return phpCR_Node the that represents the test root.
	 * @throws RepositoryException if an error occurs.
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function cleanUpTestRoot(phpCR_Session $session) {
		// do a 'rollback'
		$session->refresh(false);
		$root = $session->getRootNode();

		if ($root->hasNode($this->testPath)) {
			// clean test root
			$testRootNode = $root->getNode($this->testPath);
			for ($children = $testRootNode->getNodes(); $children->hasNext();) {
				$child = $children->nextNode();
				$nodeDef = $child->getDefinition();
				if (!$nodeDef->isMandatory() && !$nodeDef->isProtected()) {
					try {
						$child->remove();
					} catch (phpCR_ConstraintViolationException $e) {
						$this->fail("unable to remove node: " . $child->getPath());
					}
				}
			}
		} else {
			// create nodes to testPath
			$names = split("/", $this->testPath);
			$currentNode = $root;
			$i=0;
			while ($i < count($names)) {
				$name = $names[$i++];
				if ($currentNode->hasNode($name)) {
					$currentNode = $currentNode->getNode($name);
				} else {
					$currentNode = $currentNode->addNode($name, 'nt:unstructured');
				}
			}
			$testRootNode = $currentNode;
		}
		$session->save();
		return $testRootNode;
	}
}
?>
