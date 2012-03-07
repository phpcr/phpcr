<?php

/**
 * This file is part of the PHPCR API.
 *
 * This file in particular is derived from the Java UserTransaction Interface
 * of the package javax.transaction. For more information about the Java
 * interface have a look at
 * http://download.oracle.com/javaee/6/api/javax/transaction/package-summary.html
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
 */

namespace PHPCR\Transaction;

/**
 * RollbackException exception is thrown when the transaction has been rolled back instead of committed.
 *
 * @author Johannes Stark <starkj@gmx.de>
 * @package phpcr
 * @subpackage exceptions
 * @api
 */
class RollbackException extends \PHPCR\RepositoryException
{
}
