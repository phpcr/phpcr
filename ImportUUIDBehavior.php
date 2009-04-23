<?php
// $Id: ImportUUIDBehavior.class.php 549 2005-08-26 02:06:01Z tswicegood $

/**
 * This file contains {@link Credentials} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://jcp.org/aboutJava/communityprocess/final/jsr170/index.html JSR-170}
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
 * The possible actions specified by the <i>uuidBehavior</i>
 * parameter in {@link Workspace::importXML()}, {@link Session::importXML()},
 * {@link Workspace::getImportContentHandler()} and 
 * {@link Session::getImportContentHandler()}.
 *
 * @package phpContentRepository
 */
abstract class phpCR_ImportUUIDBehavior {
    const IMPORT_UUID_CREATE_NEW                 = 0;
    const IMPORT_UUID_COLLISION_REMOVE_EXISTING  = 1;
    const IMPORT_UUID_COLLISION_REPLACE_EXISTING = 2;
    const IMPORT_UUID_COLLISION_THROW            = 3;
}

?>