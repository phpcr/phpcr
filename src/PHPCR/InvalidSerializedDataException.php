<?php

namespace PHPCR;

/**
 * Exception to be thrown by the deserialization methods of Session.
 *
 * This exception shall be thrown by the deserialization methods of Session if
 * the serialized data being input has an invalid format.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class InvalidSerializedDataException extends RepositoryException
{
}
