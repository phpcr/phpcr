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

namespace PHPCR\Lock;

/**
 * Exception thrown when a lock-related error occurs.
 *
 * @author Karsten Dambekalns <karsten@typo3.org>
 * @package phpcr
 * @subpackage exceptions
 * @api
 */
class LockException extends \PHPCR\RepositoryException
{
    /**
     * Absolute path of the node that caused the error, in normalized, standard
     * form, that is, each path segment must be a JCR name in qualified form,
     * the path must have no trailing slash, no self or parent segments and no
     * [1] indexes.
     * @var string
     */
    protected $failureNodePath;

    /**
     * If a path is passed it must be an absolute path in normalized, standard form,
     * that is, each path segment must be a JCR name in qualified form, the path
     * must have no trailing slash, no self or parent segments and no [1]
     * indexes.
     *
     * @param string $message The exception message
     * @param integer $code The exception error code
     * @param string $failureNodePath the absolute path of the node that caused the error or  null if the implementation
     *                                chooses not to, or cannot, return a path.
     *
     * @api
     */
    public function __construct($message, $code = 0, $failureNodePath = null)
    {
        parent::__construct($message, $code);
        $this->failureNodePath = $failureNodePath;
    }

    /**
     * Returns the absolute path of the node that caused the error or null
     * if the implementation chooses not to, or cannot, return a path.
     *
     * @return string path of the node that caused the error
     *
     * @api
     */
    public function getFailureNodePath()
    {
        return $this->failureNodePath;
    }

}
