<?php

namespace PHPCR;

/**
 * This exception shall be thrown in case of an issue of a state of an element.
 *
 * An element might either be a Node or Property.
 *
 * This exception is thrown by the write methods of Node and Property and by
 * SessionInterface::save() and SessionInterface::refresh if an attempted
 * change would conflict with a change to the persistent workspace made through
 * another Session.
 *
 * Also thrown by methods of Node and Property if that object represents an
 * item that has been removed from the workspace.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class InvalidItemStateException extends RepositoryException
{
}
