<?php

/**
 * This file is part of the PHPCR API
 *
 * This file in particular is derived from the Principal interface
 * of the package java.security. For more information about the Java
 * interface have a look at
 * http://docs.oracle.com/javase/6/docs/api/index.html?java/security/Principal.html
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
 * As there are no acl standard interfaces in PHP this interface provides the
 * Principal interface similar to the java.security.Principal
 *
 * The Principal is any entity that can be assigned privileges. E.g. a person,
 * a role, a computer.
 *
 * The reason to have this interface is that the phpcr implementation needs to
 * store the principals and use them on later requests.
 */
interface PrincipalInterface
{
    /**
     * The hash code must be the same for the same principal.
     *
     * However it should be unique inside your application for different
     * principals.
     *
     * @return string a hashcode for this principal.
     */
    function hashCode();
}