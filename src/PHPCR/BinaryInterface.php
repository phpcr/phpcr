<?php
/**
 * Interface description of an object containing a binary value.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */

declare(ENCODING = 'utf-8');
namespace PHPCR;

/**
 * A Binary object holds a JCR property value of type BINARY.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface BinaryInterface
{
    /**
     * Returns a stream representation of this value.
     *
     * Each call to getStream() returns a new stream.
     * The API consumer is responsible for calling close() on the returned
     * stream.
     *
     * @return resource A stream representation of this value.
     * @throws \BadMethodCallException if dispose() has already been called on this Binary
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getStream();

    /**
     * Reads successive bytes from the specified position in this Binary into
     * the passed string until $limit or the end of the Binary is encountered
     * (whichever comes first).
     *
     * @param integer $bytes how many bytes to read, unlimited by default
     * @return string bytes
     * @throws \RuntimeException if an I/O error occurs.
     * @throws \InvalidArgumentException if offset is negative.
     * @throws \BadMethodCallException if dispose() has already been called on this Binary
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function read($bytes);

    /**
     * Returns the size of this Binary value in bytes.
     *
     * @return integer the size of this value in bytes.
     * @throws \BadMethodCallException if dispose() has already been called on this Binary
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getSize();

    /**
     * Releases all resources associated with this Binary object and informs the
     * repository that these resources may now be reclaimed.
     *
     * An application should call this method when it is finished with the
     * Binary object.
     *
     * @return void
     * @api
     */
    public function dispose();

    /**
     * Returns the entire binary data
     *
     * @return string
     */
    public function __toString();
}
