<?php

namespace PHPCR;

/**
 * RepositoryFactory is an interface for factory class implementations for
 * Repositories.
 *
 * Classes implementing this interface *MUST* have a zero-argument constructor.
 * All repository instantiation parameters must be expected as arguments to the
 * getRepository method.
 *
 * Examples how to obtain repository instances
 *
 * <pre>
 *    $parameters = array('com.vendor.address' => 'vendor://localhost:9999/myrepo');
 *    $factory = new \SomeRepository\RepositoryFactory;
 *    $repository = $factory->getRepository($parameters);
 * </pre>
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
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
     * @return RepositoryInterface a repository instance or null if this
     *      implementation does not understand the passed parameters
     *
     * @throws RepositoryException if no suitable repository is found or
     *      another error occurs.
     *
     * @api
     */
    public function getRepository(array $parameters = null);

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
    public function getConfigurationKeys();
}
