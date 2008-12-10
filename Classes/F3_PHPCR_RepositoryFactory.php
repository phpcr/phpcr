<?php
declare(ENCODING = 'utf-8');
namespace F3\PHPCR;

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
 * @version $Id$
 */

/**
 * RepositoryFactory is a factory class for Repository implementations.
 *
 * A concrete implementation of this class must have a zero-argument constructor.
 * Repository factories may be installed in an instance of the Java platform as extensions,
 * that is, jar files placed into any of the usual extension directories. Factories may
 * also be made available by adding them to the applet or application class path or by
 * some other platform-specific means. Repository factories are looked up via the current
 * thread's context class loader.
 *
 * A repository factory should identify itself with a factory-configuration file named
 * javax.jcr.RepositoryFactory in the resource directory META-INF/services. The file
 * should contain a list of fully-qualified concrete repository-factory class names, one
 * per line. A line is terminated by any one of a line feed ('\n'), a carriage return
 * ('\r'), or a carriage return followed immediately by a line feed. Space and tab
 * characters surrounding each name, as well as blank lines, are ignored. The comment
 * character is '#' ('#'); on each line all characters following the first comment
 * character are ignored. The file must be encoded in UTF-8.
 *
 * If a particular concrete repository factory class is named in more than one configuration
 * file, or is named in the same configuration file more than once, then the duplicates will
 * be ignored. The configuration file naming a particular factory need not be in the same jar
 * file or other distribution unit as the factory itself. The factory must be accessible from
 * the same class loader that was initially queried to locate the configuration file; this is
 * not necessarily the class loader that loaded the file.
 *
 * Parameters are passed to the connect() and getRepository() methods
 * in an array of key/value pairs. The keys are not specified by JCR and will be
 * implementation specific.
 * However, vendors should use keys that are namespace qualified in the
 * Java package style to distinguish their key names. For example
 * an address parameter might be com.vendor.address.
 *
 * Examples how to obtain repository instances
 *
 * Use repository factory based on parameters (the parameters below are examples):
 *    $parameters = array('com.vendor.address' => 'vendor://localhost:9999/myrepo');
 *    $repo = \F3\PHPCR\RepositoryFactory::getRepository($parameters);
 *
 * Get a default repository available in this environment:
 *    $repo = \F3\PHPCR\RepositoryFactory::getRepository();
 *
 * Manually instantiate a specific repository factory and connect to the repository:
 *    $parameters = array('com.vendor.address' => 'vendor://localhost:9999/myrepo');
 *    $factory = new \F3\TYPO3CR\RepositoryFactory();
 *    $repo = $factory->connect($parameters);
 *
 * @package PHPCR
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
abstract class RepositoryFactory {

	/**
	 * Attempts to establish a connection to a repository described by the given
	 * parameters.
	 *
	 * Parameters are passed in an array of key/value pairs. The keys are not
	 * specified by JCR and will be implementation specific.
	 * However, vendors should use keys that are namespace qualified in the
	 * Java package style to distinguish their key names. For example
	 * an address parameter might be com.vendor.address.
	 *
	 * The implementation should return null if it does not understand
	 * the given parameters. The implementation may also return null if a default
	 * repository instance is requested (indicated by null parameters) and this
	 * factory is not able to identify a default repository.
	 *
	 * @param array $parameters
	 * @return \F3\PHPCR\RepositoryInterface
	 * @throws \F3\PHPCR\RepositoryException If an implementation is the right factory but has trouble connecting to the repository.
	 */
	abstract public function connect(array $parameters);

	/**
	 * Attempts to establish a connection to a repository using the given parameters.
	 * If no parameters are given, the first found default repository is returned.
	 *
	 * Parameters are passed in an array of key/value pairs. The keys are not
	 * specified by JCR and will be implementation specific.
	 * However, vendors should use keys that are namespace qualified in the
	 * Java package style to distinguish their key names. For example
	 * an address parameter might be com.vendor.address.
	 *
	 * @param array|NULL $parameters string key/value pairs as repository arguments or NULL if a client wishes to connect to a default repository.
	 * @return \F3\PHPCR\RepositoryInterface
	 * @throws \F3\PHPCR\RepositoryException if getRepository fails or if no suitable (default) repository is found.
	 */
	abstract public function getRepository(array $parameters = NULL);

}

?>