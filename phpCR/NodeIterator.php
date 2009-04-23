<?php
// $Id: NodeIterator.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link NodeIterator} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170, and 
 * is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 */


/**
 * Allows easy iteration through a list of {@link Node}s with {@link nextNode()} 
 * as well as a {@link skip()} method inherited from {@link RangeIterator}.
 *
 * @package phpContentRepository
 */
interface phpCR_NodeIterator extends phpCR_RangeIterator 
{
	/**
	 * Returns the next {@link Node} in the iteration.
	 *
	 * @return object
	 *
	 * @throws {@link NoSuchElementException}
	 *   If iteration has no more {@link Node}s.
	 */
	public function nextNode();
}

?>