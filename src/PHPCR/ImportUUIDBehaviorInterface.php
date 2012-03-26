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

namespace PHPCR;

/**
 * The possible actions specified by the uuidBehavior parameter in
 *
 * - WorkspaceInterface::importXML()
 * - SessionInterface::importXML()
 *
 * If we implement a content handler, the UUID would also be relevant for
 *
 * - WorkspaceInterface::getImportContentHandler()
 * - SessionInterface::getImportContentHandler()
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface ImportUUIDBehaviorInterface
{
    /**
     * When importing remove existing item upon collision.
     * @api
     */
    const IMPORT_UUID_COLLISION_REMOVE_EXISTING = 1;

    /**
     * When importing replace existing item upon collision.
     * @api
     */
    const IMPORT_UUID_COLLISION_REPLACE_EXISTING = 2;

    /**
     * When importing throw exception upon collision.
     * @api
     */
    const IMPORT_UUID_COLLISION_THROW = 3;

    /**
     * When importing create new UUIDs.
     * @api
     */
    const IMPORT_UUID_CREATE_NEW = 0;
}
