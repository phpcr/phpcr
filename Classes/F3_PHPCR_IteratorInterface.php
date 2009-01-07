<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @version $Id$
 */

/**
 * An Iterator interface
 *
 * The methods next(), hasNext() and remove() as in java.util.Iterator
 * append() is something we thought would be nice...
 *
 * @package PHPCR
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
interface IteratorInterface extends \Iterator {

	/**
	 * Returns the next element. Commented as PHP dows not allow overriding methods from extended interfaces...
	 *
	 * @return mixed
	 * @throws OutOfBoundsException if no next element exists
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