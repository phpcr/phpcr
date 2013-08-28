<?php

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
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
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
