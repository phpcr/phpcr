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
 * RepositoryFactory is an interface for factory class implementations for
 * Repositories.
 *
 * Examples how to obtain repository instances
 *
 * <pre>
 *    $parameters = array('com.vendor.address' => 'vendor://localhost:9999/myrepo');
 *    $repository = \SomeRepository\RepositoryFactory::getRepository($parameters);
 * </pre>
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface RepositoryFactoryInterface
{
    /**
     * Attempts to establish a connection to a repository using the given
     * parameters.
     *
     * Parameters are passed in an array of key/value pairs. The keys are not
     * specified by JCR and are implementation specific.
     * However, vendors should use keys that are namespace qualified in the
     * php style to distinguish their key names. For example an address
     * parameter might be jackalope.jackrabbit_url.
     *
     * The implementation must return null if it does not understand
     * the given parameters. The implementation may also return null if a
     * default repository instance is requested (indicated by null parameters)
     * and this factory is not able to identify a default repository. An
     * implementation should throw an RepositoryException if it is the right
     * factory but has trouble connecting to the repository.
     *
     * @param array|null $parameters string key/value pairs as repository
     *      arguments or null if a client wishes to connect to a default
     *      repository.
     *
     * @return \PHPCR\RepositoryInterface a repository instance or null if this
     *      implementation does not understand the passed parameters
     *
     * @throws \PHPCR\RepositoryException if no suitable repository is found or
     *      another error occurs.
     *
     * @api
     */
    static function getRepository(array $parameters = null);

    /**
     * Get the list of configuration options that can be passed to
     * RepositoryFactoryInterface::getRepository()
     *
     * The description string should include whether the key is mandatory or
     * optional.
     *
     * @return array hash map of configuration key => english description
     *
     * @api
     */
    static function getConfigurationKeys();
}
