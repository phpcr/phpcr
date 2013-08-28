<?php

namespace PHPCR\Observation;

/**
 * The ObservationManager object.
 *
 * Acquired via WorkspaceInterface::getObservationManager(). Provides the event
 * journal and allows to register and unregister event listeners.
 *
 * <strong>Note</strong>: Event listeners will need some sort of polling
 * mechanism that is specific to your implementation. Consult your PHPCR
 * implementation documentation to learn how to use event listeners.
 * Alternatively, you can simply use getEventJournal to find events.
 *
 * The \Traversable interface enables the implementation to be addressed with
 * <b>foreach</b>. ObservationManager has to implement either \IteratorAggregate
 * or \Iterator.
 * The iterator is equivalent to <b>getRegisteredEventListeners()</b> returning
 * a list of all registered event listeners. The iterator keys have no
 * significant meaning.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface ObservationManagerInterface extends \Traversable
{
    /**
     * Adds an event listener that listens for the events specified by the
     * passed {@link EventFilterInterface}.
     *
     * In addition to the EventFilter, the set of events reported will be
     * further filtered by the access rights of the current Session.
     *
     * See {@link EventFilter} for a description of the filtering parameters
     * available.
     *
     * The filter of an already-registered EventListener can be changed at
     * runtime by re-registering the same EventListener object (i.e. the same
     * actual Java object) with a new filter. The implementation must ensure
     * that no events are lost during the changeover.
     *
     * In addition to the filters placed on a listener above, the scope of
     * observation support, in terms of which parts of a workspace are
     * observable, may also be subject to implementation-specific restrictions.
     * For example, in some repositories observation of changes in the
     * jcr:system subgraph may not be supported.
     *
     * @param EventListenerInterface $listener
     * @param EventFilterInterface   $filter
     *
     * @throws \PHPCR\RepositoryException If an error occurs.
     *
     * @since JCR 2.1
     *
     * @api
     */
    public function addEventListener(EventListenerInterface $listener, EventFilterInterface $filter);

    /**
     * Deregisters an event listener.
     *
     * A listener may be deregistered while it is being executed. The deregistration
     * method will block until the listener has completed executing. An exception to
     * this rule is a listener which deregisters itself from within the onEvent
     * method. In this case, the deregistration method returns immediately, but
     * deregistration will effectively be delayed until the listener completes.
     *
     * @param EventListenerInterface $listener The listener to deregister.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     *
     * @api
     */
    public function removeEventListener(EventListenerInterface $listener);

    /**
     * Returns all event listeners that have been registered through this session.
     *
     * If no listeners have been registered, an empty iterator is returned.
     *
     * @return \Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Values are the EventListenerInterface instances. Keys have no meaning.
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function getRegisteredEventListeners();

    /**
     * Sets the user data information that will be returned by EventInterface::getUserData().
     *
     * @param string $userData the user data
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @api
     */
    public function setUserData($userData);

    /**
     * Retrieves the event journal for this workspace.
     *
     * If journaled observation is not supported for this workspace, null is
     * returned.
     *
     * Events returned in the EventJournal instance will be filtered according
     * to the parameters set on the EventFilter that is passed to this method.
     *
     * Additionally, the current session's access restrictions as well as any
     * additional restrictions specified through implementation-specific
     * configuration will also affect the set of returned events.
     *
     * @param EventFilterInterface $filter
     *
     * @return EventJournalInterface an EventJournal (or null).
     *
     * @throws \PHPCR\RepositoryException if an error occurs
     *
     * @since JCR 2.1
     *
     * @api
     */
    public function getEventJournal(EventFilterInterface $filter);

    /**
     * Creates an EventFilter that can then be configured and passed to the
     * method addEventListener.
     *
     * @return EventFilterInterface
     *
     * @since JCR 2.1
     *
     * @api
     */
    public function createEventFilter();
}
