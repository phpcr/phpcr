<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
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
 * @package phpcr
 * @subpackage exceptions
 * @api
 */
class InvalidItemStateException extends \PHPCR\RepositoryException
{
}
