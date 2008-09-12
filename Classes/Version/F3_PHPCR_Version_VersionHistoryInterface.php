<?php
declare(ENCODING = 'utf-8');
namespace F3::PHPCR::Version;

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
 * @subpackage Version
 * @version $Id$
 */

/**
 * A VersionHistory object wraps an nt:versionHistory node. It provides
 * convenient access to version history information.
 *
 * @package PHPCR
 * @subpackage Version
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface VersionHistoryInterface extends F3::PHPCR::NodeInterface {

	/**
	 * Returns the identifier of the versionable node for which this is the
	 * version history.
	 *
	 * @return string the identifier of the versionable node for which this is the version history.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getVersionableIdentifier();

	/**
	 * Returns the root version of this version history.
	 *
	 * @return F3::PHPCR::Version::VersionInterface a Version object.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getRootVersion();

	/**
	 * Returns an iterator over all the versions within this version history. The
	 * order of the returned objects will not necessarily correspond to the order
	 * of versions in terms of the successor relation. To traverse the version
	 * graph one must traverse the jcr:successors REFERENCE properties starting
	 * with the root version. A version history will always have at least one
	 * version, the root version. Therefore, this method will always return an
	 * iterator of at least size 1.
	 *
	 * @return F3::PHPCR::Version::VersionIteratorInterface a VersionIterator object.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getAllVersions();

	/**
	 * Returns an iterator over all the frozen nodes of all the versions of
	 * this version history. Under simple versioning the order of the returned
	 * nodes will be the order of their creation. Under full versioning the
	 * order is implementation-dependent.
	 *
	 * @return F3::PHPCR::NodeIteratorInterface a NodeIterator object.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getAllFrozenNodes();

	/**
	 * Retrieves a particular version from this version history by version name.
	 *
	 * @param string $versionName a version name
	 * @return F3::PHPCR::Version::VersionInterface a Version object.
	 * @throws F3::PHPCR::Version::VersionException if the specified version is not in this version history.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getVersion($versionName);

	/**
	 * Retrieves a particular version from this version history by version label.
	 *
	 * @param string $label a version label
	 * @return F3::PHPCR::Version::VersionInterface a Version object.
	 * @throws F3::PHPCR::Version::VersionException if the specified label is not in this version history.
	 * @throws F3::PHPCR::RepositoryException if an error occurs.
	 */
	public function getVersionByLabel($label);

	/**
	 * Adds the specified label to the specified version. This corresponds to
	 * adding a reference property with a name specified by the label parameter
	 * to the jcr:versionLabels sub node of the nt:versionHistory node. The
	 * reference property points to the nt:version node that represents the
	 * specified version.
	 * Note that this change is made immediately; there is no need to call save.
	 * In fact, since the the version storage is read-only with respect to normal
	 * repository methods, save does not even function in this context.
	 *
	 * Within a particular version history, a given label may appear a maximum of
	 * once. If the specified label is already assigned to a version in this
	 * history and moveLabel is true then the label is removed from its current
	 * location and added to the version with the specified versionName. If m
	 * oveLabel is false, then an attempt to add a label that already exists in
	 * this version history will throw a LabelExistVersionException.
	 *
	 * A VersionException is thrown if the named version is not in this
	 * VersionHistory or if it is the root version (jcr:rootVersion) or if the
	 * label specified is not a valid JCR NAME.
	 *
	 * @param string $versionName the name of the version to which the label is to be added.
	 * @param string $label the label to be added.
	 * @param boolean $moveLabel if true, then if label is already assigned to a version in this version history, it is moved to the new version specified; if false, then attempting to assign an already used label will throw a VersionException.
	 * @return void
	 * @throws F3::PHPCR::Version::LabelExistsVersionException if moveLabel is false, and an attempt is made to add a label that already exists in this version history
	 * @throws F3::PHPCR::Version::VersionException if the specified version does not exist in this version history or if the specified version is the root version (jcr:rootVersion).
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function addVersionLabel($versionName, $label, $moveLabel);

	/**
	 * Removes the specified label from among the labels of this version history.
	 * This corresponds to removing a property from the jcr:versionLabels child node
	 * of the nt:versionHistory node that represents this version history.
	 * Note that this change is made immediately; there is no need to call save.
	 * In fact, since the the version storage is read-only with respect to normal
	 * repository methods, save does not even function in this context.
	 *
	 * @param string $label a version label
	 * @return void
	 * @throws F3::PHPCR::Version::VersionException if the name label does not exist in this version history.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function removeVersionLabel($label);

	/**
	 * Returns true if the given version has the given label. If no $version is given
	 * returns true if any version in the history has the given label.
	 *
	 * @param string $label a version label
	 * @param F3::PHPCR::Version::VersionInterface $version a Version object
	 * @return boolean a boolean.
	 * @throws F3::PHPCR::Version::VersionException if the specified version is not of this version history.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function hasVersionLabel($label, $version = NULL);

	/**
	 * Returns all version labels of the given version - empty array if none.
	 * If a $version is given returns all version labels of the history or an empty
	 * array if there are none.
	 *
	 * @param VersionInterface $version a Version object
	 * @return array a string array containing all the labels of the (given) version (history)
	 * @throws F3::PHPCR::Version::VersionException if the specified version is not in this version history.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function getVersionLabels($version = NULL);

	/**
	 * Removes the named version from this version history and automatically
	 * repairs the version graph. If the version to be removed is V, V's
	 * predecessor set is P and V's successor set is S, then the version graph
	 * is repaired s follows:
	 * * For each member of P, remove the reference to V from its successor list
	 *   and add references to each member of S.
	 * * For each member of S, remove the reference to V from its predecessor
	 *   list and add references to each member of P.
	 *
	 * Note that this change is made immediately; there is no need to call save.
	 * In fact, since the the version storage is read-only with respect to normal
	 * repository methods, save does not even function in this context.
	 *
	 * @param string $versionName the name of a version in this version history.
	 * @return void
	 * @throws F3::PHPCR::ReferentialIntegrityException if the specified version is currently the target of a REFERENCE property elsewhere in the repository (not necessarily in this workspace) and the current Session has read access to that REFERENCE property.
	 * @throws F3::PHPCR::AccessDeniedException if the current Session does not have permission to remove the specified version or if the specified version is currently the target of a REFERENCE property elsewhere in the repository (not just in this workspace) and the current Session does not have read access to that REFERENCE property.
	 * @throws F3::PHPCR::UnsupportedRepositoryOperationException if this operation is not supported by the implementation.
	 * @throws F3::PHPCR::Version::VersionException if the named version is not in this version history.
	 * @throws F3::PHPCR::RepositoryException if another error occurs.
	 */
	public function removeVersion($versionName);
}

?>