<?php

namespace PHPCR\Transaction;

/**
 * RollbackException exception is thrown when the transaction has been rolled back instead of committed.
 *
 * @author Johannes Stark <starkj@gmx.de>
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class RollbackException extends \PHPCR\RepositoryException
{
}
