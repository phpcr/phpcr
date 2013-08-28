<?php

namespace PHPCR\Observation;

/**
 * An EventJournal is an extended Iterator that provides the additional
 * method skipTo(). All elements in this iterator are of type EventInterface.
 *
 * When interacting with the journal, you should first call skipTo or you risk
 * loading a large amount of events.
 *
 * <b>PHPCR Note:</b> This is the only iterator interface we kept, as it adds
 * additional value (performance). This journal is not countable on purpose.
 * There is a potentially high number of events in the system and counting them
 * could be very expensive.
 * seek() is an alias of skipTo()
 * rewind() should only rewind to the last point set in skipTo, not the
 * beginning of the whole journal.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface EventJournalInterface extends \SeekableIterator
{
    /**
     * Skip all elements of the iterator earlier than date.
     *
     * If an attempt is made to skip past the last element of the iterator, no
     * exception is thrown but the subsequent next() will fail.
     *
     * @param integer $date Value that represents the offset in milliseconds
     *                      from the epoch. Keep in mind that typical PHP time
     *                      functions will give you seconds, not milliseconds.
     *
     * @api
     */
    public function skipTo($date);
}
