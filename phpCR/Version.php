<?php
// $Id: Version.interface.php 399 2005-08-13 19:38:08Z tswicegood $
/**
 * This file contains {@link Version} which is part of the PHP Content
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
 * A {@link Version} object wraps an nt:version {@link Node}.
 *
 * It provides convenient access to version information.
 *
 * @package phpContentRepository
 * @package Version
 */
interface phpCR_Version
{
   /**
    * Returns the version name of this version.
    *
    * This corresponds to the value of the jcr:versionName
    * {@link Property} in the nt:version {@link Node} that
    * represents this version.
    *
    * @return string
    *
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function getVersionName();

   /**
    * Returns the version date of this version.
    *
    * This corresponds to the value of the jcr:versionDate
    * {@link Property} in the nt:version {@link Node} that
    * represents this version.
    *
    * <b>PHP Note</b>: As PHP does not offer a Calendar class as a core part
    * of its distribution, this can be returned as a string.  It must be
    * formatted according to the
    * {@link http://www.w3.org/TR/NOTE-datetime ISO8601 specifications}.  At
    * some future point, phpCR may offer a simple Calendar object to encapsulate
    * this return on.
    *
    * If you choose to implement your own Calendar object, the object should
    * contain a method toString() which should return a properly formatted
    * ISO8601 date/time.
    *
    * @return string
    *   An ISO8601 date/time of when this was last updated.
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function getCreated();


   /**
    * Returns the version labels of this version.
    *
    * This corresponds to the values of the jcr:versionName
    * {@link Property} in the nt:version {@link Node} that
    * represents this version.
    *
    * @return string
    *
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function getVersionLabels();


   /**
    * Adds a version label to this version.
    *
    * This corresponds to the values of the jcr:versionLabels
    * multi-value {@link Property} in the nt:version {@link Node}
    * that represents this version.
    *
    * @param string
    *   A version label
    *
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function addVersionLabel($label);


   /**
    * Removes the specified label from among the labels of this version.
    *
    * This corresponds to removing a value from the
    * jcr:versionLabels multi-value {@link Property} in the
    * nt:version {@link Node} that represents this version.
    *
    * @param string
    *   A version label
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function removeVersionLabel($label);


   /**
    * Returns the successor versions of this version.
    *
    * This corresponds to returning all the nt:version
    * {@link Node}s referenced by the jcr:successors multi-value
    * {@link Property} in the nt:version {@link Node} that
    * represents this version.
    *
    * @return array
    *   A {@link Version} array.
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function getSuccessors();


   /**
    * Returns the predecessor versions of this version.
    *
    * This corresponds to returning all the nt:version
    * {@link Node}s whose jcr:successors {@link Property} includes
    * a reference to the nt:version {@link Node} that represents
    * this version.
    *
    * @return array
    *   A {@link Version} array.
    * @throws {@link RepositoryException}
    *   If an error occurs.
    */
    public function getPredecessors();


   /**
    * Adds the specified $v as a successor of this version.
    *
    * This is used to create a "merge" within the version graph (not to be
    * confused with the {@link Node::merge()} method which operates on
    * {@link Workspace} {@link Node}s). A {@link Workspace}
    * {@link Node::merge()} may be used to produce the appropriate {@link Node}
    * to be checked-in and then added as a successor to more than one existing
    * version, using this {@link addSuccessor()} method, thus performing both
    * the semantic and the version graph parts of the full "merge" operation.
    *
    * This method corresponds to adding a reference to an
    * nt:version {@link Node} to the jcr:successors
    * multi-value {@link Property} of the nt:version {@link Node}
    * that represents this version.
    *
    * @param object
    *   A {@link Version} object.
    *
    * @throws {@link VersionException}
    *   If $v is not already in the same version history as this
    *   {@link Node} or if adding $v as  a successor would create
    *   a cycle in the version history.
    * @throws {@link RepositoryException}
    *   If any other error occurs.
    */
    public function addSuccessor(phpCR_Version $v);


   /**
    * Removes $v from the successors of this version.
    *
    * This method corresponds to removing a reference to an
    * nt:version {@link Node} from the jcr:successors
    * multi-value {@link Property} of the nt:version {@link Node}
    * that represents this version.
    *
    * @param object
    *   A {@link Version} object.
    *
    * @throws {@link VersionException}
    *   If $v is not currently a direct successor of this
    *   {@link Node}.
    * @throws RepositoryException if an error occurs.
    */
    public function removeSuccessor(phpCR_Version $v);
}

?>