<?php
/**
 * Interface description of an implementation of a version history class.
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
namespace PHPCR\Version;

/**
 * A VersionHistory object wraps an nt:versionHistory node. It provides
 * convenient access to version history information.
 *
 * Note: As this extends NodeInterface, foreach still iterates over the
 * children and not over versions. If you want to use a foreach, you can use
 * getAllVersions() to retrieve an iterator over versions.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface VersionHistoryInterface extends \PHPCR\NodeInterface {

    /**
     * Returns the identifier of the versionable node for which this is the
     * version history.
     *
     * @return string the identifier of the versionable node for which this is the version history.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getVersionableIdentifier();

    /**
     * Returns the root version of this version history.
     *
     * @return \PHPCR\Version\VersionInterface a Version object.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getRootVersion();

    /**
     * This method returns an iterator over all the versions in the line of
     * descent from the root version to that base version within this history
     * that is bound to the workspace through which this VersionHistory was
     * accessed.
     *
     * Within a version history H, B is the base version bound to workspace W
     * if and only if there exists a versionable node N in W whose version
     * history is H and B is the base version of N.
     *
     * The line of descent from version V1 to V2, where V2 is a successor of V1,
     * is the ordered list of versions starting with V1 and proceeding through
     * each direct successor to V2.
     *
     * The versions are returned in order of creation date, from oldest to newest.
     *
     * Note that in a simple versioning repository the behavior of this method is
     * equivalent to returning all versions in the version history in order from
     * oldest to newest.
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Values are the VersionInterface instances. Keys have no meaning.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getAllLinearVersions();

    /**
     * Returns an iterator over all the versions within this version history.
     * If the version graph of this history is linear then the versions are
     * returned in order of creation date, from oldest to newest. Otherwise the
     * order of the returned versions is implementation-dependent.
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Values are the VersionInterface instances. Keys have no meaning.
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getAllVersions();

    /**
     * This method returns all the frozen nodes of all the versions in this
     * verison history in the same order as getAllLinearVersions().
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Values are the NodeInterface instances.
     *
     * @todo is there a version id to be used as key?
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getAllLinearFrozenNodes();

    /**
     * Returns an iterator over all the frozen nodes of all the versions of
     * this version history. Under simple versioning the order of the returned
     * nodes will be the order of their creation. Under full versioning the
     * order is implementation-dependent.
     *
     * @return Iterator implementing <b>SeekableIterator</b> and <b>Countable</b>.
     *                  Values are the NodeInterface instances.
     *
     * @todo is there a version id to be used as key?
     *
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getAllFrozenNodes();

    /**
     * Retrieves a particular version from this version history by version name.
     *
     * @param string $versionName a version name
     * @return \PHPCR\Version\VersionInterface a Version object.
     *
     * @throws \PHPCR\Version\VersionException if the specified version is not in this version history.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getVersion($versionName);

    /**
     * Retrieves a particular version from this version history by version label.
     *
     * @param string $label a version label
     * @return \PHPCR\Version\VersionInterface a Version object.
     *
     * @throws \PHPCR\Version\VersionException if the specified label is not in this version history.
     * @throws \PHPCR\RepositoryException if an error occurs.
     * @api
     */
    public function getVersionByLabel($label);

    /**
     * Adds the specified label to the specified version.
     *
     * The label must be a JCR name in either qualified or extended form
     * and therefore must conform to the syntax restriction that apply to
     * such names. In particular a colon (:) should not be used unless
     * it is intended as a prefix delimiter in a qualified name.
     *
     * Adding a version label to a version corresponds to
     * adding a reference property with a name specified by the label parameter
     * to the jcr:versionLabels sub node of the nt:versionHistory node. The
     * reference property points to the nt:version node that represents the
     * specified version.
     *
     * This is a workspace-write method and therefore the change is made
     * immediately.
     *
     * Within a particular version history, a given label may appear a maximum of
     * once. If the specified label is already assigned to a version in this
     * history and moveLabel is true then the label is removed from its current
     * location and added to the version with the specified versionName. If m
     * oveLabel is false, then an attempt to add a label that already exists
     * will fail.
     *
     * A VersionException is thrown if the named version is not in this
     * VersionHistory or if it is the root version (jcr:rootVersion) or if the
     * label specified is not a valid JCR NAME.
     *
     * @param string $versionName the name of the version to which the label is to be added.
     * @param string $label the label to be added, a JCR name in either extended or qualified form.
     * @param boolean $moveLabel if true, then if label is already assigned to a version in this version history,
     *                           it is moved to the new version specified; if false, then attempting to assign an
     *                           already used label will throw a LabelExistsVersionException.
     * @return void
     *
     * @throws \PHPCR\Version\LabelExistsVersionException if moveLabel is false, and an attempt is made to add a
     *                                                    label that already exists in this version history
     * @throws \PHPCR\Version\VersionException if the specified version does not exist in this version history
     *                                         or if the specified version is the root version (jcr:rootVersion).
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function addVersionLabel($versionName, $label, $moveLabel);

    /**
     * Removes the specified label from among the labels of this version history.
     * The label must be a JCR name in either qualified or extended form.
     * This corresponds to removing a property from the jcr:versionLabels child node
     * of the nt:versionHistory node that represents this version history.
     *
     * This is a workspace-write method and therefore the change is made
     * immediately.
     *
     * @param string $label a version label. A JCR name in either extended or qualified form.
     * @return void
     *
     * @throws \PHPCR\Version\VersionException if the name label does not exist in this version history.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function removeVersionLabel($label);

    /**
     * Returns true if the given version has the given label. If no $version is given
     * returns true if any version in the history has the given label.
     * The label must be a JCR name in either qualified or extended form.
     *
     * <b>Note:</b> The Java API defines this with multiple differing signatures.
     *
     * @param string $label a version label. A JCR name in either extended or qualified form.
     * @param \PHPCR\Version\VersionInterface $version a Version object
     * @return boolean a boolean.
     *
     * @throws \PHPCR\Version\VersionException if the specified version is not of this version history.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function hasVersionLabel($label, $version = null);

    /**
     * Returns all version labels of the given version - empty array if none.
     *
     * If a $version is given returns all version labels of the history or an empty
     * array if there are none.
     *
     * <b>Note:</b> The Java API defines this with multiple differing signatures.
     *
     * @param VersionInterface $version a Version object
     * @return array a string array containing all the labels of the (given) version (history)
     *
     * @throws \PHPCR\Version\VersionException if the specified version is not in this version history.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function getVersionLabels($version = null);

    /**
     * Removes the named version from this version history and automatically
     * repairs the version graph. If the version to be removed is V, V's
     * predecessor set is P and V's successor set is S, then the version graph
     * is repaired s follows:
     * - For each member of P, remove the reference to V from its successor list
     *   and add references to each member of S.
     * - For each member of S, remove the reference to V from its predecessor
     *   list and add references to each member of P.
     *
     * <b>Note</b> that this change is made immediately; there is no need to call save.
     * In fact, since the the version storage is read-only with respect to normal
     * repository methods, save does not even function in this context.
     *
     * @param string $versionName the name of a version in this version history.
     * @return void
     *
     * @throws \PHPCR\ReferentialIntegrityException if the specified version is currently the target of a
     *                                              REFERENCE property elsewhere in the repository
     *                                              (not necessarily in this workspace) and the current Session
     *                                              has read access to that REFERENCE property.
     * @throws \PHPCR\AccessDeniedException if the current Session does not have permission to remove the
     *                                      specified version or if the specified version is currently the
     *                                      target of a REFERENCE property elsewhere in the repository
     *                                      (not just in this workspace) and the current Session does not have
     *                                      read access to that REFERENCE property.
     * @throws \PHPCR\UnsupportedRepositoryOperationException if this operation is not supported by the implementation.
     * @throws \PHPCR\Version\VersionException if the named version is not in this version history.
     * @throws \PHPCR\RepositoryException if another error occurs.
     * @api
     */
    public function removeVersion($versionName);
}
