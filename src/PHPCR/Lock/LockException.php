<?php

namespace PHPCR\Lock;
use PHPCR\RepositoryException;

/**
 * Exception thrown when a lock-related error occurs.
 *
 * @author Karsten Dambekalns <karsten@typo3.org>
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class LockException extends RepositoryException
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
     * @param string  $message         The exception message
     * @param integer $code            The exception error code
     * @param string  $failureNodePath the absolute path of the node that caused the error or  null if the implementation
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
