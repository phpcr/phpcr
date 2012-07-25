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
 * The possible actions specified by the onParentVersion attribute in a
 * property definition within a node type definition.
 *
 * This interface defines the following actions:
 *
 * - COPY
 * - VERSION
 * - INITIALIZE
 * - COMPUTE
 * - IGNORE
 * - ABORT
 *
 * Every item (node or property) in the repository has a status indicator that
 * governs what happens to that item when its parent node is versioned. This
 * status is defined by the onParentVersion attribute in the PropertyDefinition
 * or NodeDefinition that applies to the item in question.
 *
 * @author Karsten Dambekalns <karsten@typo3.org>
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
final class OnParentVersionAction
{

    /**#@+
     * @var integer
     */

    /**
     * The COPY action constant.
     *
     * @api
     */
    const COPY = 1;

    /**
     * The VERSION action constant.
     *
     * @api
     */
    const VERSION = 2;

    /**
     * The INITIALIZE action constant.
     *
     * @api
     */
    const INITIALIZE = 3;

    /**
     * The COMPUTE action constant.
     *
     * @api
     */
    const COMPUTE = 4;

    /**
     * The IGNORE action constant.
     *
     * @api
     */
    const IGNORE = 5;

    /**
     * The ABORT action constant.
     *
     * @api
     */
    const ABORT = 6;

    /**#@-*/
    /**#@+
     * @var string
     */

    /**
     * The name of the COPY on-version action, as used in serialization.
     *
     * @api
     */
    const ACTIONNAME_COPY = 'COPY';

    /**
     * The name of the VERSION on-version action, as used in serialization.
     *
     * @api
     */
    const ACTIONNAME_VERSION = 'VERSION';

    /**
     * The name of the INITIALIZE on-version action, as used in serialization.
     *
     * @api
     */
    const ACTIONNAME_INITIALIZE = 'INITIALIZE';

    /**
     * The name of the COMPUTE on-version action, as used in serialization.
     *
     * @api
     */
    const ACTIONNAME_COMPUTE = 'COMPUTE';

    /**
     * The name of the IGNORE on-version action, as used in serialization.
     *
     * @api
     */
    const ACTIONNAME_IGNORE = 'IGNORE';

    /**
     * The name of the ABORT on-version action, as used in serialization.
     *
     * @api
     */
    const ACTIONNAME_ABORT = 'ABORT';

    /**#@-*/

    // @codeCoverageIgnoreStart
    /**
     * Make instantiation impossible...
     *
     * @return void
     */
    private function __construct()
    {
    }
    // @codeCoverageIgnoreEnd

    /**
     * Returns the name of the specified action, as used in serialization.
     *
     * @param integer $action the on-version action
     *
     * @return string the name of the specified action
     *
     * @api
     */
    static public function nameFromValue($action)
    {
        switch (intval($action)) {
            case self::COPY :
                return self::ACTIONNAME_COPY;
                break;
            case self::VERSION :
                return self::ACTIONNAME_VERSION;
                break;
            case self::INITIALIZE :
                return self::ACTIONNAME_INITIALIZE;
                break;
            case self::COMPUTE :
                return self::ACTIONNAME_COMPUTE;
                break;
            case self::IGNORE :
                return self::ACTIONNAME_IGNORE;
                break;
            case self::ABORT :
                return self::ACTIONNAME_ABORT;
                break;
            default:
                throw new \InvalidArgumentException('Unknown action (' . $action . ') given.', 1257170242);
        }
    }

    /**
     * Returns the numeric constant value of the on-version action with the
     * specified name.
     *
     * @param string $name the name of the on-version action
     *
     * @return int the numeric constant value
     *
     * @api
     */
    static public function valueFromName($name)
    {
        switch ($name) {
            case self::ACTIONNAME_COPY :
                return self::COPY;
                break;
            case self::ACTIONNAME_VERSION :
                return self::VERSION;
                break;
            case self::ACTIONNAME_INITIALIZE :
                return self::INITIALIZE;
                break;
            case self::ACTIONNAME_COMPUTE :
                return self::COMPUTE;
                break;
            case self::ACTIONNAME_IGNORE :
                return self::IGNORE;
                break;
            case self::ACTIONNAME_ABORT :
                return self::ABORT;
                break;
            default:
                throw new \InvalidArgumentException('Unknown name (' . $name . ') given.', 1257170243);
        }
    }
}
