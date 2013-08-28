<?php

namespace PHPCR\Version;

/**
 * Exception will be thrown by NodeInterface::checkout() and
 * NodeInterface::checkpoint() if an activity A is present on the current
 * session and any of the following conditions is met:
 *
 * - There already is a node in another workspace that has a checked-out node
 *   for the version history of N whose jcr:activity references A.
 * - There is a version in the version history of N that is not a predecessor
 *   of N but whose jcr:activity references A.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
class ActivityViolationException extends VersionException
{
}
