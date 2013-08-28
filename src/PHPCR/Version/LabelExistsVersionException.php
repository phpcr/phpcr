<?php

namespace PHPCR\Version;

/**
 * Exception thrown by VersionHistoryInterface::addVersionLabel() if moveLabel
 * is set to false and an attempt is made to add a label that already exists in
 * the VersionHistory.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class LabelExistsVersionException extends VersionException
{
}
