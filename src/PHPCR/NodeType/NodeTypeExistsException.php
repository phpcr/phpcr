<?php

namespace PHPCR\NodeType;

/**
 * Exception thrown when an attempt is made to register a node type that
 * already exists, and allowUpdate has not been set to true.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class NodeTypeExistsException extends \PHPCR\RepositoryException
{
}
