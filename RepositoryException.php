<?php
// $Id: RepositoryException.exception.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link RepositoryException} which is part of the PHP
 * Content Repository (phpCR), a derivative of the Java Content Repository 
 * JSR-170,  and is licensed under the Apache License, Version 2.0.
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
 * Main exception thrown by classes in this package. May either contain
 * an error message or another exception wrapped inside this exception.
 *
 * @package phpContentRepository
 */
class phpCR_RepositoryException extends RuntimeException
{
	private $_parentException = null;
	
	/**
	 * Handle initialization.
	 *
	 * This one method handles what JCR does with four.  Since PHP doesn't 
	 * provide the ability to overload based on the parameters that are supplied,
	 * we have to make due.  Also, Exception::getMessage() can not be overriden,
	 * so the logic for determining the message must be included in __construct()
	 * prior to calling parent::__construct()
	 *
	 * This can take up to two parameters with four possible calls:
	 *
	 * 
	 *   throw new RepositoryException();
	 *   throw new RepositoryException('String Message');
	 *   throw new RepositoryException($parentException);
	 *   throw new RepositoryException('String Message', $parentException);
	 * 
	 *
	 * @param string|object
	 *    This can either be a message, or another derivative of Exception 
	 *    specifying the root Exception.  If an object is provided,
	 *    no second parameter can be made.
	 * @param object
	 *    If the first parameter is a string, this parameter can be a derivative
	 *    of an Exception specifying the root Exception
	 */
	public function __construct() {
		$args = func_get_args();
		$message = null;
		$e = null;
		
		if (count($args)) {
			assert('is_string($args[0]) || $args[0] instanceof Exception');
			if (is_string($args[0]) && isset($args[1])) {
				assert('$args[1] instanceof Exception');
				$e = $args[1];
			} 
			elseif ($args[0] instanceof Exception) {
				$e = $args[0];
			}
			
			if (!is_null($e)) {
				$this->_parentException = $e;
			}
			
			if (!is_null($e) && !is_string($args[0])) {
				$message = $e->getMessage();
			}
			elseif (is_string($args[0])) {
				$message = $args[0];
			}
			
			parent::__construct($message);
		}
		else {
			parent::__construct();
		}
	}
	
	
	public function getParentException() {
		return $this->_parentException;
	}
}

?>