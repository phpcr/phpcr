<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR\Version;

/*                                                                        *
 * This script belongs to the FLOW3 package "PHPCR".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 */

/**
 * The possible actions specified by the onParentVersion attribute in a
 * property definition within a node type definition.
 *
 * This interface defines the following actions:
 *
 * COPY
 * VERSION
 * INITIALIZE
 * COMPUTE
 * IGNORE
 * ABORT
 *
 * Every item (node or property) in the repository has a status indicator that
 * governs what happens to that item when its parent node is versioned. This
 * status is defined by the onParentVersion attribute in the PropertyDefinition
 * or NodeDefinition that applies to the item in question.
 *
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
final class OnParentVersionAction {

	/**
	 * The action constants.
	 */
	const COPY = 1;
	const VERSION = 2;
	const INITIALIZE = 3;
	const COMPUTE = 4;
	const IGNORE = 5;
	const ABORT = 6;

	/**
	 * The names of the defined on-version actions, as used in serialization.
	 */
	const ACTIONNAME_COPY = 'COPY';
	const ACTIONNAME_VERSION = 'VERSION';
	const ACTIONNAME_INITIALIZE = 'INITIALIZE';
	const ACTIONNAME_COMPUTE = 'COMPUTE';
	const ACTIONNAME_IGNORE = 'IGNORE';
	const ACTIONNAME_ABORT = 'ABORT';

	/**
	 * Make instantiation impossible...
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	private function __construct() {}

	/**
	 * Returns the name of the specified action, as used in serialization.
	 *
	 * @param integer $action the on-version action
	 * @return string the name of the specified action
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	static public function nameFromValue($action) {
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
		}
	}

	/**
	 * Returns the numeric constant value of the on-version action with the
	 * specified name.
	 *
	 * @param string $name the name of the on-version action
	 * @return int the numeric constant value
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	static public function valueFromName($name) {
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
		}
	}
}

?>