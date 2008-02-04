<?php
// $Id: ValueStreamRegistry.class.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link ValueStreamRegistry} which has been designed to be used 
 * with the PHP Content Repository (phpCR), a derivative of the Java Content 
 * Repository JSR-170,  and is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code available at
 * {@link http://www.php.net/manual/en/function.stream-wrapper-register.php}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright Copyright &copy; 2004-2005, Domain51, United States
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 */


/**
 * Require the necessary file(s)
 */
require_once dirname(__FILE__) . '/phpCR.library.php';


/**
 * This serves as Registry for storing stream values of {@link ValueStream}.
 *
 * This implements a registry pattern. 
 *
 * @see Value::getStream(), ValueStream
 *
 * @package phpContentRepository
 */
class phpCR_ValueStreamRegistry
{
   /**
    * Stores all of the values that have been added via {@link __set()}
    *
    * @var array
    */
    private $_registry = array();
    
    
   /**
    * Private to keep from being instantiated except by itself.
    *
    * @see getInstance()
    */
    final private function __construct()
    {
        
    }
    
    
   /**
    * Returns a value stored in this Registry by the name of $key
    *
    * @param string
    *   The name of the value to return
    * @return mixed|null
    *   Returns the value that is set or NULL if it is not set.
    */
    public function __get($key)
    {
        return isset($this->_registry[$key]) ? $this->_registry[$key] : null;
    }
    
    
   /**
    * Sets a given $key to a particular $value
    *
    * @param string
    *   The name to set
    * @param mixed
    *   The value to set
    */
    public function __set($key, $value)
    {
        $this->_registry[$key] = $value;
    }
    
    
   /**
    * Returns the current count of values stored in this registry.
    *
    * This is used by {@link BaseValue::getStream()} to determine the number of
    * the next stream.
    *
    * @see BaseValue::getStream()
    * @return int
    */
    public function count()
    {
        return count($this->_registry);
    }
    
    
   /**
    * Returns an instance of this class.
    *
    * Only one instance will be instantiated, and that instance will be returned
    * on all subsequent calls.
    *
    * @return object
    *   A {@link ValueStreamRegistry} instance.
    */
    static public function getInstance()
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new ValueStreamRegistry();
        }
        
        return $instance;
    }
}

?>