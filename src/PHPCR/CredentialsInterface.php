<?php

namespace PHPCR;

/**
 * Interface for all credentials that may be passed to the Repository::login()
 * method.
 *
 * Serves as a marker interface that all repositories must implement when
 * providing a credentials class. See {@link SimpleCredentials} and
 * {@link GuestCredentials} for examples of such a class.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface CredentialsInterface
{
}
