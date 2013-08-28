<?php

namespace PHPCR\Transaction;

/**
 * As there is no transaction standard in PHP this interface provides a
 * transaction interface similar to the
 * <a href="http://en.wikipedia.org/wiki/Java_Transaction_API">Java Transaction
 * API (JTA)</a>
 *
 * You can acquire the transaction manager from a session supporting
 * transactions with \PHPCR\SessionInterface::getTransactionManager()
 *
 * A transaction is started with begin() and only permanently persisted if
 * commit() is called. If commit() is not called until timeout, the lifetime
 * of your php script or if rollback() is called explicitly, no changes are
 * persisted.
 *
 * Remember that session changes are never persisted before you call
 * $session->save(). Transactions are only necessary if you want to be able
 * to rollback over more than one save operation.
 *
 * The usage looks like
 * <pre>
 *
 *    $tm = $session->getTransactionManager();
 *    $tm->begin();
 *    // do stuff with the session
 *    $session->save();
 *    // do more stuff
 *    if (problem) {
 *        $tm->rollback();
 *    } else {
 *        $session->save();
 *        $tm->commit();
 *    }
 * </pre>
 *
 * A transaction manager might support nested transactions, meaning you can
 * call begin() repeatedly without commit() in between (but have to commit
 * every transaction you started).
 *
 * Remember that in the context of PHPCR, the rollback operation will only
 * reset the transaction but keep the current session changes. If you want to
 * get rid of them too, use \PHPCR\SessionInterface::refresh()
 *
 * @see \PHPCR\SessionInterface::getTransactionManager()
 *
 * @author Johannes Stark <starkj@gmx.de>
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface UserTransactionInterface
{
    /**
     * Begin new transaction associated with current session.
     *
     * @throws \PHPCR\UnsupportedRepositoryOperationException Thrown if a
     *      transaction is already started and the transaction implementation
     *      or backend does not support nested transactions.
     *
     * @throws \PHPCR\RepositoryException Thrown if the transaction
     *      implementation encounters an unexpected error condition.
     */
    public function begin();

    /**
     * Commit the transaction associated with the current session to store it
     * persistently.
     *
     * @throws RollbackException Thrown to indicate that the transaction has
     *      been rolled back rather than committed.
     * @throws \PHPCR\AccessDeniedException Thrown to indicate that the
     *      session is not allowed to commit the transaction.
     * @throws \LogicException Thrown if the current
     *      session is not associated with a transaction.
     * @throws \PHPCR\RepositoryException Thrown if the transaction
     *      implementation encounters an unexpected error condition.
     */
    public function commit();

    /**
     * Obtain the status if the current session is inside of a transaction or
     * not.
     *
     * @return boolean
     *
     * @throws \PHPCR\RepositoryException Thrown if the transaction
     *      implementation encounters an unexpected error condition.
     */
    public function inTransaction();

    /**
     * Rollback the transaction associated with the current session.
     *
     * @throws \PHPCR\AccessDeniedException Thrown to indicate that the
     *      application is not allowed to roll back the transaction.
     * @throws \LogicException Thrown if the current session is not associated
     *      with a transaction.
     * @throws \PHPCR\RepositoryException Thrown if the transaction
     *      implementation encounters an unexpected error condition.
     */
    public function rollback();

    /**
     * Set a timeout for the transaction.
     *
     * Modify the timeout value that is associated with transactions started by
     * the current application with the begin() method. If not explicitly set,
     * the transaction service uses some default value for the transaction
     * timeout.
     *
     * @param int $seconds The value of the timeout in seconds. If the value is
     *      zero, the transaction service restores the default value. If the
     *      value is negative a RepositoryException is thrown.
     *
     * @throws \PHPCR\RepositoryException Thrown if the transaction
     *      implementation encounters an unexpected error condition.
     */
    public function setTransactionTimeout($seconds = 0);
}
