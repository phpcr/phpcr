<?php
// $Id$

/**
 * This file contains {@link NodeTypeManager} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170,  
 * and is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *	Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *	Version 2.0
 * @package phpContentRepository
 * @package NodeTypes
 */

/**
 * Allows for the retrieval of {@link NodeType}s.
 *
 * Accessed via {@link Workspace::getNodeTypeManager()}.
 *
 * @package phpContentRepository
 * @package NodeTypes
 */
interface phpCR_NodeTypeManager 
{
	/**
	 * Returns the named {@link NodeType}.
	 *
	 * @param string
	 *   The name of an existing {@link NodeType}.
	 * @return object
	 *   A {@link NodeType} object.
	 *
	 * @throws {@link NoSuchNodeTypeException}
	 *   If no {@link NodeType} by the given name exists.
	 * @throws {@link RepositoryException}
	 *	If any other error occurs.
	 */
	public function getNodeType($nodeTypeName);
	
	
	/**
	 * Returns an iterator over all available {@link NodeType}s (primary and
	 * mixin).
	 *
	 * @return object
	 *   A {@link NodeTypeIterator} object.
	 *
	 * @throws {@link RepositoryException}
	 *   If an error occurs.
	 */
	public function getAllNodeTypes();
	
	
	/**
	 * Returns an iterator over all available primary {@link NodeType}s.
	 *
	 * @return object
	 *   A {@link NodeTypeIterator} object.
	 *
	 * @throws {@link RepositoryException}
	 *   If an error occurs.
	 */
	public function getPrimaryNodeTypes();
	
	
	/**
	 * Returns an iterator over all available mixin {@link NodeType}s.
	 *
	 * If none are available, an empty iterator is returned.
	 *
	 * @return object
	 *	A {@link NodeTypeIterator} object.
	 *
	 * @throws {@link RepositoryException}
	 *   If an error occurs.
	 */
	public function getMixinNodeTypes();
}

?>