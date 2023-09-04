<?php

namespace PHPCR\Retention;

use PHPCR\RepositoryException;

/**
 * Hold represents a hold that can be applied to an existing node in order to
 * prevent the node from being modified or removed. The format and interpretation
 * of the name are not specified. They are application-dependent.
 *
 * If isDeep() is true, the hold applies to the node and its entire subgraph.
 * Otherwise the hold applies to the node and its properties only.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface HoldInterface
{
    /**
     * Returns true if this Hold is deep.
     *
     * @return bool true if this Hold is deep
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function isDeep();

    /**
     * Returns the name of this Hold. A JCR name.
     *
     * @return string the name of this Hold. A JCR name.
     *
     * @throws RepositoryException if an error occurs
     *
     * @api
     */
    public function getName();
}
