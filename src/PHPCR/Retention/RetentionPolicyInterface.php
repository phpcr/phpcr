<?php

namespace PHPCR\Retention;

/**
 * A RetentionPolicy is an object with a name and an optional description.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface RetentionPolicyInterface
{
    /**
     * Returns the name of the retention policy. A JCR name.
     *
     * @return string the name of the access control policy. A JCR name.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getName();
}
