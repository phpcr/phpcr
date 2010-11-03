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
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @api
 */
final class OnParentVersionAction {

	/**
	 * The COPY action constant.
	 * @api
	 */
	const COPY = 1;

	/**
	 * The VERSION action constant.
	 * @api
	 */
	const VERSION = 2;

	/**
	 * The INITIALIZE action constant.
	 * @api
	 */
	const INITIALIZE = 3;

	/**
	 * The COMPUTE action constant.
	 * @api
	 */
	const COMPUTE = 4;

	/**
	 * The IGNORE action constant.
	 * @api
	 */
	const IGNORE = 5;

	/**
	 * The ABORT action constant.
	 * @api
	 */
	const ABORT = 6;

	/**
	 * The name of the COPY on-version action, as used in serialization.
	 * @api
	 */
	const ACTIONNAME_COPY = 'COPY';

	/**
	 * The name of the VERSION on-version action, as used in serialization.
	 * @api
	 */
	const ACTIONNAME_VERSION = 'VERSION';

	/**
	 * The name of the INITIALIZE on-version action, as used in serialization.
	 * @api
	 */
	const ACTIONNAME_INITIALIZE = 'INITIALIZE';

	/**
	 * The name of the COMPUTE on-version action, as used in serialization.
	 * @api
	 */
	const ACTIONNAME_COMPUTE = 'COMPUTE';

	/**
	 * The name of the IGNORE on-version action, as used in serialization.
	 * @api
	 */
	const ACTIONNAME_IGNORE = 'IGNORE';

	/**
	 * The name of the ABORT on-version action, as used in serialization.
	 * @api
	 */
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
	 * @api
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
			default:
				throw new \InvalidArgumentException('Unknown action (' . $action . ') given.', 1257170242);
		}
	}

	/**
	 * Returns the numeric constant value of the on-version action with the
	 * specified name.
	 *
	 * @param string $name the name of the on-version action
	 * @return int the numeric constant value
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @api
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
			default:
				throw new \InvalidArgumentException('Unknown name (' . $name . ') given.', 1257170243);
		}
	}
}

?>