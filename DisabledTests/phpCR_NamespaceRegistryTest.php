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
 * <code>NamespaceRegistryTest</code> tests whether the repository registers and
 * unregisters namespaces correctly. This is a level 2 feature.
 * <p/>
 * NOTE: Implementations are free to not support unregistering. In other words:
 * Even a repository that supports namespaces may always legally throw an
 * exception when you try to unregister.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_NamespaceRegistryTest extends phpCR_Test {

    /** The system namespace prefixes */
    private $SYSTEM_PREFIXES = array('jcr', 'nt', 'mix', 'sv');

    /** Default value of test prefix */
    private $TEST_PREFIX = 'tst';

    /** Default value of test namespace uri */
    private $TEST_URI = 'www.apache.org/jackrabbit/test/namespaceRegistryTest';

    /** The namespace registry of the superuser session */
    private $nsr;

    /** The namespace prefix we use for the tests */
    private $namespacePrefix;

    /** The namespace uri we use for the tests */
    private $namespaceUri;

	public function setUp() {
		parent::setUp();
        $this->nsr = $this->session->getWorkspace()->getNamespaceRegistry();

        $this->namespacePrefix = $this->getUnusedPrefix();
        $this->namespaceUri = $this->getUnusedURI();
	}

	public function tearDown() {
		try {
            if (in_array($this->namespacePrefix, $this->nsr->getPrefixes())) {
                $this->nsr->unregisterNamespace($this->namespacePrefix);
            }
        } catch (phpCR_NamespaceException $e) {
        	// Jackrabbit does not support this, it throws
        	// javax.jcr.NamespaceException: unregistering namespaces is not supported.
            //$this->fail('Unable to unregister name space with prefix ' . $this->namespacePrefix);
        }

        parent::tearDown();
	}

    /**
     * Trying to register a system namespace must throw a NamespaceException
     */
    public function testRegisterNamespaceExceptions() {
        try {
            $this->nsr->registerNamespace('jcr', $this->namespaceUri);
            $this->fail('Trying to register the namespace \'jcr\' must throw a NamespaceException.');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
        try {
            $this->nsr->registerNamespace('nt', $this->namespaceUri);
            $this->fail('Trying to register the namespace \'nt\' must throw a NamespaceException.');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
        try {
            $this->nsr->registerNamespace('mix', $this->namespaceUri);
            $this->fail('Trying to register the namespace \'mix\' must throw a NamespaceException.');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
        try {
            $this->nsr->registerNamespace('sv', $this->namespaceUri);
            $this->fail('Trying to register the namespace \'sv\' must throw a NamespaceException.');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
    }

    /**
     * Trying to register 'xml' or anything that starts with 'xml' as a
     * namespace must throw a repository exception
     */
    public function testRegisterNamespaceXmlExceptions() {
        try {
            $this->nsr->registerNamespace('xml', $this->namespaceUri);
            $this->fail('Trying to register the namespace \'xml\' must throw a NamespaceException.');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
        try {
            $this->nsr->registerNamespace('xml' . rand(1, 99999), $this->namespaceUri);
            $this->fail('Trying to register a namespace that starts with \'xml\' must throw a NamespaceException.');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
    }

    /**
     * Tries to register a namespace.
     */
    public function testRegisterNamespace() {
        $this->nsr->registerNamespace($this->namespacePrefix, $this->namespaceUri);

        $this->assertEquals($this->namespacePrefix, $this->nsr->getPrefix($this->namespaceUri), 'Namespace prefix was not registered.');
        $this->assertEquals($this->namespaceUri, $this->nsr->getURI($this->namespacePrefix), 'Namespace URI was not registered.');

    }

    /**
     * Tests whether unregistering a system namespace or an undefined namespace
     * throws the expected exception.
     */
    public function testUnregisterNamespaceExceptions() {
        // Attempting to unregister a built-in namespace
        // must throw a NamespaceException.
        foreach ($this->SYSTEM_PREFIXES as $sysPrefix) {
            try {
            	$this->nsr->unregisterNamespace($sysPrefix);
            	$this->fail('Trying to unregister ' . $sysPrefix . ' must fail');
            } catch (phpCR_NamespaceException $e) {
                // expected behaviour
            }
        }

        // An attempt to unregister a namespace that is not currently registered
        // must throw a NamespaceException.
        try {
            $this->nsr->unregisterNamespace('ThisNamespaceIsNotCurrentlyRegistered');
            $this->fail('Trying to unregister an unused prefix must fail');
        } catch (phpCR_NamespaceException $e) {
            // expected behaviour
        }
    }

    //------------------------< internal >--------------------------------------

    /**
     * Returns a namespace prefix that currently not used in the namespace
     * registry.
     * @return an unused namespace prefix.
     */
    private function getUnusedPrefix() {
        $prefixes = $this->nsr->getPrefixes();
        $prefix = $this->TEST_PREFIX;
        $i = 0;
        while (in_array($prefix, $prefixes)) {
            $prefix .= $i++;
        }
        return $prefix;
    }

    /**
     * Returns a namespace URI that currently not used in the namespace
     * registry.
     * @return an unused namespace URI.
     */
    private function getUnusedURI() {
        $uris = $this->nsr->getURIs();
        $uri = $this->TEST_URI;
        $i = 0;
        while (in_array($uri, $uris)) {
            $uri.= $i++;
        }
        return $uri;
    }
}

?>