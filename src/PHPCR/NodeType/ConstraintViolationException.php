<?php

namespace PHPCR\NodeType;

/**
 * Exception thrown when an action would violate a constraint on repository
 * structure.
 *
 * For example, when an attempt is made to persistently add an item to a node
 * that would violate that node's node type.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class ConstraintViolationException extends \PHPCR\RepositoryException
{
}
