<?php
// $Id: OnParentVersionAction.class.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link VetoableEventListener} which is part of the PHP 
 * Content Repository (phpCR), a derivative of the Java Content Repository 
 * JSR-170, and is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/liCENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 * @package Version
 */


/**
 * Require the necessary file(s)
 */
require_once dirname(__FILE__) . '/../phpCR.library.php';
require_once PHPCR_PATH . '/exceptions/IllegalArgumentException.exception.php';


/**
 * The possible actions specified by the {@link onParentVersion} attribute
 * in a property definition within a node type definition.
 *
 * This interface defines the following actions:
 * <ul>
 *    <li>{@link COPY}</li>
 *    <li>{@link VERSION}</li>
 *    <li>{@link INITIALIZE}</li>
 *    <li>{@link COMPUTE}</li>
 *    <li>{@link IGNORE}</li>
 *    <li>{@link ABORT}</li>
 * </ul>
 *
 * Every item (node or property) in the repository has a status indicator that
 * governs what happens to that item when its parent node is versioned. This
 * status is defined by the {@link onParentVersion} attribute in
 * the {@link PropertyDefinition} or {@link NodeDefinition} that applies to the
 * item in question.
 *
 * @package phpContentRepository
 * @package Version
 */
abstract class phpCR_OnParentVersionAction 
{

	/**
	 * The action constants.
	 */
	const COPY       = 1;
	const VERSION    = 2;
	const INITIALIZE = 3;
	const COMPUTE    = 4;
	const IGNORE     = 5;
	const ABORT      = 6;

	/**
	 * The names of the defined on-version actions,
	 * as used in serialization.
	 */
	const ACTIONNAME_COPY       = "COPY";
	const ACTIONNAME_VERSION    = "VERSION";
	const ACTIONNAME_INITIALIZE = "INITIALIZE";
	const ACTIONNAME_COMPUTE    = "COMPUTE";
	const ACTIONNAME_IGNORE     = "IGNORE";
	const ACTIONNAME_ABORT      = "ABORT";

	

	/**
	 * Returns the name of the specified $action, as used in serialization.
	 *
	 * @param int
	 *   The on-version action.  See class constants.
	 * @return string
	 *   The name of the specified $action
	 *
	 * @throws {@link IllegalArgumentException}
	 *   If $action is not a valid on-version action.
	 */
	static public function nameFromValue($action) 
	{
		assert('is_int($action)');
		
		switch ($action) {
		case self::COPY:
			return self::ACTIONNAME_COPY;
			break;
		
		case self::VERSION:
			return self::ACTIONNAME_VERSION;
			break;
		
		case self::INITIALIZE:
			return self::ACTIONNAME_INITIALIZE;
			break;
		
		case self::COMPUTE:
			return self::ACTIONNAME_COMPUTE;
			break;
		
		case self::IGNORE:
			return self::ACTIONNAME_IGNORE;
			break;
		
		case self::ABORT:
			return self::ACTIONNAME_ABORT;
			break;
		
		default:
			throw new IllegalArgumentException("unknown on-version action: " + $action);
			break;
		}
	}
	
	
	/**
	 * Returns the numeric constant value of the on-version action with the
	 * specified name.
	 *
	 * @param string
	 *   The name of the on-version action
	 * @return int
	 *   The numeric constant value
	 *
	 * @throws {@link IllegalArgumentException}
	 *   If $name is not a valid on-version action name.
	 */
	static public function valueFromName($name) 
	{
		switch ($name) {
		case self::ACTIONNAME_COPY :
			return self::COPY;
			break;
		
		case self::ACTIONNAME_VERSION :
			return self::VERSION;
			break;
		
		case self::ACTIONNAME_INITIALIZE :
		   return self::INITIALIZE;
		   break;
		
		case self::ACTIONNAME_COMPUTE :
		   return self::COMPUTE;
		   break;
			
		case self::ACTIONNAME_IGNORE :
		   return self::IGNORE;
		   break;
		
		case self::ACTIONNAME_ABORT :
		   return self::ABORT;
		   break;
		
		default :
		   throw new IllegalArgumentException("unknown on-version action: " + $name);
		   break;
		}
	}
}

?>