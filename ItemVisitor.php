<?php
// $Id: ItemVisitor.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link ItemVisitor} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170,  
 * and is licensed under the Apache License, Version 2.0.
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
 * Different implementations of this interface can be written for different 
 * purposes. It is, for example, possible for the {@link visit()} method to 
 * call accept() on the children of the passed node and thus recurse through 
 * the tree performing some operation on each {@link Item}.
 *
 * @package phpContentRepository
 */
interface phpCR_ItemVisitor 
{
   /**
    * This method is called when the {@link ItemVisitor} is
    * passed to the accept method of an {@link Item}.
    *
    * If this method throws an exception the visiting process is aborted.
    *
    * @param object
	 *	A {@link Item} object
    *
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function visit(phpCR_Item $item);
}

?>