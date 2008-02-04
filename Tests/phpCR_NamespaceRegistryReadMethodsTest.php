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

require_once('phpCR_Test.php');

/**
 * <code>NamespaceRegistryReadMethodsTest</code> This class tests read method of the
 * NamespaceRegistry class and also the correct Exception throwing for methods
 * not supported in level 1.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class phpCR_NamespaceRegistryReadMethodsTest extends phpCR_Test {


    /** The built in namespace prefixes */
    private $BUILTIN_PREFIXES = array('jcr', 'nt', 'mix', 'sv', '');

    /** The built in namespace uris */
    private $BUILTIN_URIS = array();

    /** The NamespaceRegistry of the repository */
    private $nsr = NULL;

	public function setUp() {
		parent::setUp();

		$this->BUILTIN_URIS = array($this->NS_JCR_URI, $this->NS_NT_URI, $this->NS_MIX_URI, $this->NS_SV_URI, '');
        $this->nsr = $this->session->getWorkspace()->getNamespaceRegistry();
	}

	public function tearDown() {
		parent::tearDown();

		$this->nsr = NULL;
	}

    /**
     * Tests if {@link NamespaceRegistry#getPrefixes()} returns the
     * required namespace prefixes and if they are mapped to the correct URIs.
     */
    public function testGetNamespacePrefixes() {
        $prefixes = $this->nsr->getPrefixes();
        for ($i = 0; $i < count($this->BUILTIN_PREFIXES); $i++) {
            $prefix = $this->BUILTIN_PREFIXES[$i];
            $this->assertTrue(in_array($prefix, $prefixes), 'NamespaceRegistry does not contain built in prefix: ' + $prefix);
            $uri = $this->nsr->getURI($prefix);
            $this->assertEquals($this->BUILTIN_URIS[$i], $uri, 'Wrong namespace mapping for prefix: ' + $prefix);
        }
    }

    /**
     * Tests if {@link NamespaceRegistry#getURIs()} returns the
     * required namespace URIs and if they are mapped to the correct prefixes.
     */
    public function testGetNamespaceURIs() {
        $uris = $this->nsr->getURIs();
        for ($i = 0; $i < count($this->BUILTIN_URIS); $i++) {
            $uri = $this->BUILTIN_URIS[$i];
            $this->assertTrue(in_array($uri, $uris), 'NamespaceRegistry does not contain built in uri: ' + $uri);
            $prefix = $this->nsr->getPrefix($uri);
            $this->assertEquals($this->BUILTIN_PREFIXES[$i], $prefix, 'Wrong namespace mapping for uri: ' + $uri);
        }
    }

    /**
     * Tests if a {@link NamespaceException} is thrown when
     * {@link NamespaceRegistry#getURI(String)} is called for an
     * unknown prefix.
     */
    public function testGetURINamespaceException() {
        $prefixes = $this->nsr->getPrefixes();
        $prefix = 'myapp';
        $count = 0;
        while (in_array($prefix.$count, $prefixes)) {
            $count++;
        }

        $testPrefix = $prefix.$count;
        try {
            $this->nsr->getURI($testPrefix);
            $this->fail('NamespaceRegistry.getURI should throw a NamespaceException in case of an unmapped prefix.');
        } catch (phpCR_NamespaceException $e) {
            //ok
        }
    }

    /**
     * Tests if a {@link NamespaceException} is thrown when
     * {@link NamespaceRegistry#getPrefix(String)} is called for an
     * unknown URI.
     */
    public function testGetPrefixNamespaceException() {
        $uris = $this->nsr->getURIs();
        $uri = 'http://www.unknown-company.com/namespace';
        $count = 0;
        while (in_array($uri.$count, $uris)) {
            $count++;
        }

        $testURI = $uri.$count;
        try {
            $this->nsr->getPrefix($testURI);
            $this->fail('NamespaceRegistry->getPrefix should throw a NamespaceException in case of an unregistered URI.');
        } catch (phpCR_NamespaceException $e) {
            //ok
        }
    }

}

?>