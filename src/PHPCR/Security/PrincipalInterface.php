<?php

namespace PHPCR\Security;

/**
 * As there are no ACL standard interfaces in PHP this interface provides the
 * Principal interface similar to the java.security.Principal
 *
 * The Principal is any entity that can be assigned privileges. E.g. a person,
 * a role, a computer.
 *
 * The reason to have this interface is that the PHPCR implementation needs to
 * store the principals and use them on later requests.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface PrincipalInterface
{
    /**
     * Returns the name of this principal.
     *
     * @return string name of this principal
     */
    public function getName();
}
