<?php

namespace PHPCR;

/**
 * Exception thrown when no Item exists at the specified path or when the
 * specified path implies intermediary Nodes that do not exist.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class PathNotFoundException extends RepositoryException
{
}
