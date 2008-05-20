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
 * @package PHPCR
 * @version $Id$
 */

/**
 * A RangeIterator interface
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_RangeIteratorInterface extends F3_PHPCR_IteratorInterface {

	/**
	 * Skip a number of elements in the iterator.
	 *
	 * @param integer $skipNum the non-negative number of elements to skip
	 * @throws F3_PHPCR_NoSuchElementException if skipped past the last element in the iterator.
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

	/**
	 * Returns the number of subsequent next() calls that can be
	 * successfully performed on this iterator.
	 *
	 * This is the  number of items still available through this iterator. For
	 * example, for some node $n, $n->getNodes()->getSize() returns the number
	 * of child nodes of $n visible through the current Session that have not
	 * yet been returned.
	 *
	 * In some implementations precise information about the number of remaining
	 * elements may not be available. In such cases this method should return
	 * a reasonable upper bound on the number if such an estimate is available
	 * and -1 if it is not.
	 *
	 * @return integer
	 */
	public function getNumberRemaining();
}
?>