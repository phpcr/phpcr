<?php
// $Id: ValueFactory.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link ValueFactory} which is part of the PHP Content Repository 
 * (phpCR), a derivative of the Java Content Repository JSR-170, and is
 * licensed under the Apache License, Version 2.0.
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
 * The {@link ValueFactory} object provides methods for the creation 
 * {@link Value} objects that can then be used to set properties.
 *
 * @see Value
 *
 * @package phpContentRepository
 */
interface phpCR_ValueFactory 
{
	/**
	 * Returns a {@link Value} object one of the {@link PropertyType} constants
	 * with the specified <i>$value</i>.
	 *
	 * If <i>$type</i> is specified, this should attempt to convert it
	 * prior to returning.  <i>$type</i>, if specified, should be a valid
	 * {@link PropertyType}.
	 *
	 * @param mixed
	 * @param int|null
	 * @return object
	 *	A {@link Value} object
	 *
	 * @throws {@link ValueFormatException}
	 *    If the specified <i>$value</i> cannot be converted to the 
	 *    specifed <i>$type</i>.
	 */
	public function createValue($value, $type = null);
}

?>