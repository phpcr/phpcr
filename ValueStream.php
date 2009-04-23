<?php
// $Id: ValueStream.class.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link ValueStream} which has been designed to be used 
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
require_once PHPCR_PATH . '/ValueStreamRegistry.class.php';


/**
 * This serves to create a variable stream for the {@link Value::getStream()}
 * style methods.
 *
 * This was taken from the
 * {@link http://www.php.net/manual/en/function.stream-wrapper-register.php PHP Manual}
 * and modified to execute correctly under PHP 5.0.x and store its values in
 * the {@link ValueStreamRegistry} instead of the GLOBALS scope.  
 *
 * See the manual page for a full explaination of what's going on here.
 *
 * @see Value::getStream(), ValueStreamRegistry
 *
 * @package phpContentRepository
 */
class phpCR_ValueStream 
{
    private $_position;
    private $_varname;
    
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $url = parse_url($path);
        $this->_varname = $url["host"];
        $this->_position = 0;
        
        return true;
    }
    
    public function stream_read($count)
    {
        $registry = ValueStreamRegistry::getInstance();
        $valueName = $this->_varname;
        
        $ret = T3_PHP6_Functions::substr($registry->$valueName, $this->_position, $count);
        $this->_position += T3_PHP6_Functions::strlen($ret);
        return $ret;
    }
    
    public function stream_write($data)
    {
        $registry = ValueStreamRegistry::getInstance();
        $valueName = $this->_varname;
        
        $left = T3_PHP6_Functions::substr($registry->$valueName, 0, $this->_position);
        $right = T3_PHP6_Functions::substr($registry->$valueName, $this->_position + T3_PHP6_Functions::strlen($data));
        $registry->$valueName = $left . $data . $right;
        $this->_position += T3_PHP6_Functions::strlen($data);
        return T3_PHP6_Functions::strlen($data);
    }
    
    public function stream_tell()
    {
        return $this->_position;
    }
    
    public function stream_eof()
    {
        $registry = ValueStreamRegistry::getInstance();
        $valueName = $this->_varname;
        
        return $this->_position >= T3_PHP6_Functions::strlen($registry->$valueName);
    }
    
    
    public function stream_seek($offset, $whence)
    {
        $registry = ValueStreamRegistry::getInstance();
        $valueName = $this->_varname;
        
        switch ($whence) {
        case SEEK_SET:
           if ($offset < T3_PHP6_Functions::strlen($registry->$valueName) && $offset >= 0) {
               $this->_position = $offset;
               return true;
           } else {
               return false;
           }
           break;
          
        case SEEK_CUR:
           if ($offset >= 0) {
               $this->_position += $offset;
               return true;
           } else {
               return false;
           }
           break;
          
        case SEEK_END:
            if (T3_PHP6_Functions::strlen($registry->$valueName) + $offset >= 0) {
                $this->_position = T3_PHP6_Functions::strlen($registry->$valueName) + $offset;
                return true;
            } else {
                return false;
            }
            break;
          
        default:
            return false;
        }
    }
}

# Disabled that for now until we really need it - currently it causes problems. robert 20.12.06
#stream_wrapper_register("Value", "phpCR_ValueStream")
#    or die("Failed to register protocol");

?>