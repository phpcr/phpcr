<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR;

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
 * The Binary interface allows repositories to provide implementations that
 * handle JCR BINARY values in the most efficient manner, given the specifics
 * of their internal handling of the binary data.
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface BinaryInterface {

	/**
	 * Returns a stream representation of this value.
	 * Each call to <code>getStream()</code> returns a new stream.
	 * The API consumer is responsible for calling <code>close()</code>
	 * on the returned stream.
	 *
	 * @return resource A stream representation of this value.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getStream();

	/**
	 * Reads successive bytes from the specified position in this Binary into
	 * the passed string until the end of the Binary is encountered.
	 *
	 * @param string $bytes the buffer into which the data is read.
	 * @param integer $position the position in this Binary from which to start reading bytes.
	 * @return integer the number of bytes read into the buffer
	 * @throws \RuntimeException if an I/O error occurs.
	 * @throws \InvalidArgumentException if offset is negative.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function read(&$bytes, $position);

	/**
	 * Returns the size of this Binary value in bytes.
	 *
	 * @return integer the size of this value in bytes.
	 * @throws \F3\PHPCR\RepositoryException if another error occurs.
	 */
	public function getSize();

}

?>