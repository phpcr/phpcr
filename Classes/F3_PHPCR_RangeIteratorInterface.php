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
 * Extends Iterator with the skip, getSize and getPosition methods. The base
 * interface of all type-specific iterators in the JCR and its sub packages.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface RangeIteratorInterface extends \F3\PHPCR\IteratorInterface {

	/**
	 * Skip a number of elements in the iterator.
	 *
	 * @param integer $skipNum the non-negative number of elements to skip
	 * @throws OutOfBoundsException if skipped past the last element in the iterator.
	 */
	public function skip($skipNum);

	/**
	 * Returns the total number of of items available through this iterator.
	 *
	 * For example, for some node $n, $n->getNodes()->getSize() returns the
	 * number of child nodes of $n visible through the current Session.
	 *
	 * In some implementations precise information about the number of elements may
	 * not be available. In such cases this method must return -1. API clients will
	 * then be able to use RangeIterator->getNumberRemaining() to get an
	 * estimate on the number of elements.
	 *
	 * @return integer
	 */
	public function getSize();

	/**
	 * Returns the current position within the iterator. The number
	 * returned is the 0-based index of the next element in the iterator,
	 * i.e. the one that will be returned on the subsequent next() call.
	 *
	 * Note that this method does not check if there is a next element,
	 * i.e. an empty iterator will always return 0.
	 *
	 * @return integer
	 */
	public function getPosition();

}
?>