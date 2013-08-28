<?php

namespace PHPCR\Observation;

/**
 * An event listener.
 *
 * An EventListener can be registered via the ObservationManager object. Event
 * listeners are notified asynchronously, and see events after they occur and
 * the transaction is committed. An event listener only sees events for which
 * the session that registered it has sufficient access rights.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface EventListenerInterface
{
    /**
     * This method is called when a bundle of events is dispatched.
     *
     * @param \Traversable $events The event set received.
     *
     * @api
     */
    public function onEvent(\Traversable $events);
}
