<?php

namespace PHPCR;

/**
 * A RepositoryManager represents a management view of the Session's Repository
 * instance.
 *
 * This is useful for applications that embed a JCR repository and need a way
 * to manage the lifecycle of that Repository instance. Each RepositoryManager
 * object is associated one-to-one with a Session object and is defined by the
 * authorization settings of that session object.
 *
 * The RepositoryManager object can be acquired using a {@link Session} by
 * calling $session->getWorkspace()->getRepositoryManager()< on a session
 * object. Likewise, the repository being managed can be found for a given
 * RepositoryManager object by calling
 * $mgr->getWorkspace()->getSession()->getRepository().
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 *
 * @since JCR 2.1
 */
interface RepositoryManagerInterface
{
    /**
    * Return the Workspace object through which this repository manager was
    * created.
    *
    * @return WorkspaceInterface
    */
    public function getWorkspace();

    /**
     * Closes the repository by preventing the creation of new sessions and
     * freeing all resources. The $closeSessionsImmediately parameter dictates
     * whether existing sessions should be closed immediately or allowed to
     * close naturally.
     *
     * Either way, this method always blocks until all sessions are closed and
     * the repository has completely terminated.
     *
     * Some repository implementations may not allow repositories to be closed,
     * while other implementations might allow closing only for certain
     * configurations (e.g., repositories embedded within an application). An
     * implementation will throw an UnsupportedRepositoryOperationException if
     * the particular repository cannot be closed, or an AccessDeniedException
     * when the repository can be closed but the session does not have the
     * authority to do so.
     *
     * @param boolean $closeSessionsImmediately true if all existing sessions
     *      should be closed immediately, or false if they are to be allowed to
     *      close naturally.
     *
     * @throws AccessDeniedException if the caller does not have authorization
     *      to close the repository.
     * @throws UnsupportedRepositoryOperationException if the repository
     *      implementation does not support or allow the repository to be
     *      closed.
     * @throws RepositoryException if an error occurred while shutting down the
     *      repository.
     */
    public function closeRepository($closeSessionsImmediately);
}
