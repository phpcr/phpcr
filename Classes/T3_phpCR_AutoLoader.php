<?php
declare(ENCODING = 'utf-8');

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
 * Class Loader implementation which loads PHP files for the phpCR package
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class T3_phpCR_AutoLoader {

	/**
	 * @var array Names and relative paths (to phpCR package directory) of files containing classes
	 */
	protected $classFiles;

	/**
	 * Loads php files containing classes or interfaces found in the classes directory of
	 * the phpCR package.
	 *
	 * @param	string		$className: Name of the class/interface to find a php file for
	 * @return	boolean		void
	 * @author	Karsten Dambekalns <karsten@typo3.org>
	 */
	public function loadClass($className) {
		if(T3_PHP6_Functions::substr($className,0,5) !== 'phpCR') return FALSE;

		$path = dirname(__FILE__) . '/../';
		if(!defined('PHPCR_PATH')) {
			define('PHPCR_PATH', $path . 'Resources/PHP/phpCR/');
		}

		$className = ($className !== 'phpCR' ? T3_PHP6_Functions::substr($className,6) : $className);
		$this->getClassFiles($path);

		if (isset($this->classFiles[$className])) {
			require_once($path . 'Resources/PHP/phpCR/' . $this->classFiles[$className]);
		}
	}

	/**
	 * Returns the array of filenames of the class files
	 *
	 * @return	void
	 * @author  Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getClassFiles($path) {
		if (!is_array($this->classFiles)) {
			$this->classFiles = $this->buildArrayOfClassFiles($path);
		}
	}

	/**
	 * Builds and returns an array of class names => file names of all
	 * T3_*.php files in the package's Classes directory and its sub-
	 * directories.
	 *
	 * @return  array
	 * @author  Robert Lemke <robert@typo3.org>
	 */
	protected function buildArrayOfClassFiles($path, $subDirectory='') {
		$classFiles = array();
		$currentPath = $path . 'Resources/PHP/phpCR/' . $subDirectory;

		if (!is_dir($currentPath)) return array();

		try {
			$classesDirectoryIterator = new DirectoryIterator($currentPath);
			while ($classesDirectoryIterator->valid()) {
				$filename = $classesDirectoryIterator->getFilename();
				if ($filename{0} != '.') {
					if (is_dir($currentPath . $filename)) {
						$classFiles = array_merge($classFiles, $this->buildArrayOfClassFiles($path, $filename . '/'));
					} else {
						if (T3_PHP6_Functions::substr($filename, -4, 4) == '.php') {
							$className = str_replace(array('.interface','.exception','.class'),array('','',''),T3_PHP6_Functions::substr($filename, 0, -4));
							$classFiles[$className] = $subDirectory . $filename;
						}
					}
				}
				$classesDirectoryIterator->next();
			}

		} catch(Exception $exception) {
			throw new RuntimeException($exception->getMessage(), 1172759155, array('OriginalErrorCode' => $exception->getCode()));
		}
		return $classFiles;
	}
}

?>