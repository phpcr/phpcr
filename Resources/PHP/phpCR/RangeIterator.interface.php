<?php
// $Id: RangeIterator.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link RangeIterator} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170,  
 * and is licensed under the Apache License, Version 2.0.
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
 * Extends Iterator with the {@link skip()}, {@link getSize()}
 * and {@link getPosition()} methods. 
 * 
 * This is the base interface of all type-specific iterators in 
 * {@link phpContentRepository} and its subpackages.
 *
 * {@link Item} is the base interface of {@link Node} and {@link Property}.
 *
 * @see NodeIterator, PropertyIterator
 *
 * @package phpContentRepository
 */
interface phpCR_RangeIterator extends Iterator
{
	/**
	 * Skip a number of elements in the iterator.
	 *
	 * @param int
	 *   The non-negative number of elements to skip 
	 * @throws {@link NoSuchElementException}
	 *   If skipped past the last element in the iterator.
	 */
	public function skip($skipNum);
	
	
	/**
	 * Returns the number of elements in the iterator.
	 *
	 * If this information is unavailable, returns -1.
	 *
	 * @return int
	 */
	public function getSize();
	
	
	/**
	 * Returns the current position within the iterator. 
	 *
	 * The number returned is the 0-based index of the next element in the 
	 * iterator, i.e. the one that will be returned on the subsequent 
	 * {@link next()} call.
	 *
	 * Note that this method does not check if there is a next element,
	 * i.e. an empty iterator will always return 0.
	 *
	 * @return int
	 */
	public function getPosition();
}

?>