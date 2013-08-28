<?php

namespace PHPCR\Security;

/**
 * A NamedAccessControlPolicy is an opaque access control policy that is
 * described by a JCR name and optionally a description.
 *
 * NamedAccessControlPolicy are immutable and can therefore be directly applied
 * to a node without additional configuration step.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NamedAccessControlPolicyInterface extends AccessControlPolicyInterface
{
    /**
     * Returns the name of the access control policy, which is JCR name and
     * should be unique among the choices applicable to any particular node.
     *
     * @return string the name of the access control policy. A JCR name.
     *
     * @throws \PHPCR\RepositoryException - if an error occurs.
     *
     * @api
     */
    public function getName();
}
