<?php
/**
 * Interface to describe the contract to implement a repository factory.
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

namespace PHPCR;

/**
 * RepositoryFactory is an interface for factory class implementations for
 * Repositories.
 *
 * Examples how to obtain repository instances
 *
 * Use repository factory based on parameters (the parameters below are examples):
 *    $parameters = array('com.vendor.address' => 'vendor://localhost:9999/myrepo');
 *    $repo = \SomeRepository\RepositoryFactory::getRepository($parameters);
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface RepositoryFactoryInterface {

    /**
     * Attempts to establish a connection to a repository using the given
     * parameters.
     *
     * Parameters are passed in an array of key/value pairs. The keys are not
     * specified by JCR and are implementation specific.
     * However, vendors should use keys that are namespace qualified in the
     * Java package style to distinguish their key names. For example
     * an address parameter might be com.vendor.address.
     *
     * The implementation must return null if it does not understand
     * the given parameters. The implementation may also return null if a default
     * repository instance is requested (indicated by null parameters) and this
     * factory is not able to identify a default repository. An implementation
     * should throw an RepositoryException if it is the right factory but has
     * trouble connecting to the repository.
     *
     * @param array|null $parameters string key/value pairs as repository arguments or null if a client wishes
     *                               to connect to a default repository.
     * @return \PHPCR\RepositoryInterface a repository instance or null if this implementation does
     *                                    not understand the passed parameters
     * @throws \PHPCR\RepositoryException if no suitable repository is found or another error occurs.
     * @api
     */
    public function getRepository(array $parameters = null);

    /**
     * Get the list of configuration options that can be passed to getRepository
     *
     * The description string should include whether the key is mandatory or
     * optional.
     *
     * @return array hash map of configuration key => english description
     */
    public function getConfigurationKeys();

}
