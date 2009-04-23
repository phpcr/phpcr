<?php
// $Id: VersionHistory.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link VersionHistory} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170, and 
 * is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 * @package Version
 */

/**
 * A {@link VersionHistory} object wraps an <i>nt:versionHistory</i>
 * node. It provides convenient access to version history information.
 *
 * @package phpContentRepository
 * @package Version
 */
interface phpCR_VersionHistory extends phpCR_Node 
{
	/**
	 * Returns the UUID of the versionable node for which this is the version 
	 * history.
	 *
	 * @return string
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getVersionableUUID();
	
	
	/**
	 * Returns the root version of this version history.
	 *
	 * @return object
	 *	A {@link Version} object object.
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getRootVersion();
	
	
	/**
	 * Returns an iterator over all the versions within this version history.
	 *
	 * The order of the returned objects will not necessarily correspond to the
	 * order of versions in terms of the successor relation. To traverse the
	 * version graph one must traverse the <i>jcr:successor REFERENCE</i>
	 * properties starting with the root version. A version history will always
	 * have at least one version, the root version. Therefore, this method will
	 * always return an iterator of at least size 1.
	 *
	 * @return object
	 *	A {@link VersionIterator} object
	 *
 	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getAllVersions();
	
	
	/**
	 * Retrieves a particular version from this version history by
	 * <i>$versionName</i>.
	 *
	 * @param string
	 * @return object
	 *	A {@link Version} object
	 *
	 * @throws {@link VersionException}
	 *    If the specified version is not in this version history.
 	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getVersion($versionName);
	
	
	/**
	 * Retrieves a particular version from this version history by 
	 * <i>$label</i>.
	 *
	 * @param string
	 * @return object
	 *	A {@link Version} object
	 *
	 * @throws {@link VersionException}
	 *    If the specified <i>label</i> is not in this version history.
 	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getVersionByLabel($label);
	
	
	/**
	 * Adds the specified label to the specified version.
	 *
	 * This corresponds to adding a  value to the 
	 * <i>jcr:versionLabels</i> multi-value property of the 
	 * <i>nt:version</i> node that represents the specified version.
	 *
	 * Note that this change is made immediately; there is no need to call 
	 * {@link Item::save()}.  In fact, since the the version storage is 
	 * read-only with respect to normal repository methods, 
	 * {@link Item::save()} does not even function in this context.
	 *
	 * Within a particular version history, a given label may appear a maximum 
	 * of once.  If the specified label is already assigned to a version in 
	 * this history and <i>$moveLabel</i> is TRUE then the label is 
	 * removed from its current location and added to the version with the
	 * specified <i>$versionName</i>.
	 *
	 * @param string
	 *    The name of the version to which the label is to be added.
	 * @param string
	 *    The label to be added.
	 * @param boolean
	 *    If <i>true</i>, then if <i>$label</i> is already assigned
	 *    to a version in this version history, it is moved to the new version 
	 *    specified; if <i>false</i>, then attempting to assign an 
	 *    already used label will throw a {@link VersionException}.
	 *
	 * @throws {@link VersionException}
	 *    If an attempt is made to add an existing label to a version history
	 *    and <i>$moveLabel</i> is <i>false</i> or if the specifed 
	 *    version does not exist in this version history or if the specified
	 *    version is the root version (<i>jcr:rootVersion</i>).
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function addVersionLabel($versionName, $label, $moveLabel);
	
	
	/**
	 * Removes the specified label from among the labels of this version history.
	 *
	 * This corresponds to removing a property from the 
	 * <i>jcr:versionLabels</i> child node of the 
	 * <i>nt:versionHistory</i> node that represents this version history.
	 *
	 * Note that this change is made immediately; there is no need to call 
	 * {@link Item::save()}.  In fact, since the the version storage is
	 * read-only with respect to normal repository methods, {@link Item::save()}
	 * does not even function in this context.
	 *
	 * @param string
	 *    A version label
	 * @throws {@link VersionException}
	 *    If the name labvel does not exist in this version history.
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function removeVersionLabel($label);
	
	
	/**
	 * Returns <i>true</i> if any version in the history has the given 
	 * <i>$label</i>.
	 *
	 * If <pre>$version</pre> is supplied, this will only return TRUE if that
	 * version has the give <pre>$label</pre>.
	 *
	 * @param string
	 *    A version label
	 * @param Version|null
	 * @return boolean
	 *
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function hasVersionLabel($label, $version = null);
	
	
	/**
	 * Returns all version labels of the history or an empty array if there are
	 * none.
	 *
	 * If <pre>$version</pre> is supplied, it will return the labels of only
	 * that version.
	 *
	 * @param Version|null
	 * @return array
	 * @throws {@link RepositoryException}
	 *    If an error occurs.
	 */
	public function getVersionLabels($version = null);
	
	
	/**
	 * Removes the named version from this version history and automatically
	 * repairs the version graph.
	 *
	 * If the version to be removed is <i>V</i>, <i>V</i>'s
	 * predecessor set is <i>P</i> and <i>V</i>'s successor set is
	 * <i>S</i>, then the version graph is repaired s follows:
	 *
	 * <ul>
	 *    <li>
	 *        For each member of <i>P</i>, remove the reference to 
	 *        <i>V</i> from its successor list and add references to each 
	 *        member of <i>S</i>.
	 *    </li>
	 *    <li>
	 *        For each member of <i>S</i>, remove the reference to 
	 *        <i>V</i> from its predecessor list and add references to
	 *        each member of <i>P</i>.
	 *    </li>
	 * </ul>
	 *
	 * Note that this change is made immediately; there is no need to call 
	 * {@link Item::save()}.  In fact, since the the version storage is 
	 * read-only with respect to normal repository methods, {@link Item::save()} 
	 * does not even function in this context.
	 *
	 * @param string
	 *    The name of a version in this version history.
	 *
	 * @throws {@link ReferentialIntegrityException}
	 *    If the specified version is currently the target of a 
	 *    <i>REFERENCE</i> property elsewhere in the repository (not 
	 *    necessarily in this workspace) and the current {@link Session} has
	 *    read access to that <i>REFERENCE</i> property.
	 * @throws {@link AccessDeniedException}
	 *    If the current Session does not have permission to remove the 
	 *    specified version or if the specified version is currently the target 
	 *    of a <i>REFERENCE</i> property elsewhere in the repository 
	 *    (not just in this workspace) and the current {@link Session} does not
	 *    have read access to that <i>REFERENCE</i> property.
	 * @throws {@link UnsupportedRepositoryOperationException}
	 *    If this operation is not supported by the implementation.
	 * @throws {@link VersionException}
	 *    If the named version is not in this version history.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function removeVersion($versionName);
}

?>