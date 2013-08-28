<?php

namespace PHPCR;

/**
 * Shall be thrown in case of invalid login credentials.
 *
 * Exception thrown by RepositoryInterface::login() and
 * SessionInterface::impersonate() if the specified credentials are invalid.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class LoginException extends RepositoryException
{
}
