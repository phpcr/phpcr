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
 * An Iterator interface
 *
 * The methods next(), hasNext() and remove() as in java.util.Iterator
 * append() is something we though would be nice...
 * 
 * @package		phpCR
 * @version 	$Id$
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_phpCR_IteratorInterface extends Iterator {

	/**
	 * Returns the next element. Commented as PHP dows not allow overriding methods from extended interfaces...
	 * 
	 * @return mixed
	 * @throws F3_phpCR_NoSuchElementException if no next element exists
	 */
	//public function next();

	/**
	 * Returns true if the iteration has more elements.
	 * 
	 * This is an alias of valid().
	 * 
	 * @return boolean
	 */
	public function hasNext();

	/**
	 * Removes from the underlying collection the last element returned by the iterator.
	 * This method can be called only once per call to next. The behavior of an iterator
	 * is unspecified if the underlying collection is modified while the iteration is in
	 * progress in any way other than by calling this method.
	 * 
	 * @return void
	 * @throws IllegalStateException if the next method has not yet been called, or the remove method has already been called after the last call to the next method.
	 */
	public function remove();

	/**
	 * Append a new element to the iteration
	 * 
	 * @param mixed $element
	 * @return void
	 */
	public function append($element);
}
?>