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
     * @param  integer $date Value that represents the offset in milliseconds
     *                       from the epoch. Keep in mind that typical PHP time
     *                       functions will give you seconds, not milliseconds.
     *
     * @api
     */
    public function skipTo($date);
}
