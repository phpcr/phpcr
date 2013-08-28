<?php

namespace PHPCR\Query\QOM;

/**
 * Selects a subset of the nodes in the repository based on node type.
 *
 * A selector selects every node in the repository, subject to access control
 * constraints, that satisfies at least one of the following conditions:
 *
 * - the node's primary node type is nodeType
 * - the node's primary node type is a subtype of nodeType
 * - the node has a mixin node type that is nodeType
 * - the node has a mixin node type that is a subtype of nodeType
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface SelectorInterface extends SourceInterface
{
    /**
     * Gets the name of the required node type.
     *
     * @return string the node type name
     *
     * @api
     */
    public function getNodeTypeName();

    /**
     * Gets the selector name.
     *
     * A selector's name can be used elsewhere in the query to identify the
     * selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelectorName();
}
