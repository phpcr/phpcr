<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR::Query::QOM;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 */

/**
 * Performs a logical disjunction of two other constraints.
 *
 * To satisfy the Or constraint, the node-tuple must either:
 *  satisfy constraint1 but not constraint2, or
 *  satisfy constraint2 but not constraint1, or
 *  satisfy both constraint1 and constraint2.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface OrInterface extends F3::PHPCR::Query::QOM::ConstraintInterface {

	/**
	 * Gets the first constraint.
	 *
	 * @return F3::PHPCR::Query::QOM::ConstraintInterface the constraint; non-null
	 */
	public function getConstraint1();

	/**
	 * Gets the second constraint.
	 *
	 * @return F3::PHPCR::Query::QOM::ConstraintInterface the constraint; non-null
	 */
	public function getConstraint2();

}

?>