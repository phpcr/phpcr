<?php

namespace PHPCR;

/**
 * Definition of an Exception to be thrown in case of a namespace issue within
 * a session.
 *
 * Exception thrown by SessionInterface::setNamespacePrefix()
 * if the specified uri is not registered in the NamespaceRegistry.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class NamespaceException extends RepositoryException
{
}
