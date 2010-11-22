<?php
/**
 * Interface to describe the contract to implement a join class.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 * @subpackage interfaces
 */


declare(ENCODING = 'utf-8');
namespace PHPCR\Query\QOM;

/**
 * Performs a join between two node-tuple sources.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface JoinInterface extends \PHPCR\Query\QOM\SourceInterface {

    /**
     * Gets the left node-tuple source.
     *
     * @return \PHPCR\Query\QOM\SourceInterface the left source; non-null
     * @api
     */
    public function getLeft();

    /**
     * Gets the right node-tuple source.
     *
     * @return \PHPCR\Query\QOM\SourceInterface the right source; non-null
     * @api
     */
    public function getRight();

    /**
     * Gets the join type.
     *
     * @return string one of QueryObjectModelConstants.JCR_JOIN_TYPE_*
     * @api
     */
    public function getJoinType();

    /**
     * Gets the join condition.
     *
     * @return JoinCondition the join condition; non-null
     * @api
     */
    public function getJoinCondition();
}
