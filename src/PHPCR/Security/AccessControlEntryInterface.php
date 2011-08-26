<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

namespace PHPCR\Security;

/**
 * An AccessControlEntry represents the association of one or more Privilege
 * objects with a specific Principal.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. AccessControlEntry has to implement either \RecursiveIterator
 * or \Iterator.
 * The iterator is equivalent to <b>getPrivileges()</b> returning a list of
 * PrivilegeInterface. The iterator keys have no significant meaning.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface AccessControlEntryInterface extends \Traversable
{
    /**
     * Returns the principal associated with this access control entry.
     *
     * @return java.security.Principal a Principal.
     *
     * @todo find replacement for java.security.Principal
     *
     * @api
     */
    function getPrincipal();

    /**
     * Returns the privileges associated with this access control entry.
     *
     * @return array an array of Privileges.
     *
     * @api
     */
    function getPrivileges();
}
