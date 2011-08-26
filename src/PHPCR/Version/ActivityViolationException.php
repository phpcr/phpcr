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

namespace PHPCR\Version;

/**
 * Exception will be thrown by NodeInterface::checkout() and
 * NodeInterface::checkpoint() if an activity A is present on the current
 * session and any of the following conditions is met:
 *
 * - There already is a node in another workspace that has a checked-out node
 *   for the version history of N whose jcr:activity references A.
 * - There is a version in the version history of N that is not a predecessor
 *   of N but whose jcr:activity references A.
 *
 * @package phpcr
 * @subpackage exceptions
 * @api
 */
class ActivityViolationException extends \PHPCR\Version\VersionException
{
}
