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

namespace PHPCR\Security;

/**
 * A privilege represents the capability of performing a particular set of
 * operations on items in the JCR repository.
 *
 * Each privilege is identified by a JCR name. JCR defines a set of standard
 * privileges in the jcr namespace. Implementations may add additional
 * privileges in namespaces other than jcr.
 *
 * A privilege may be an aggregate privilege. Aggregate privileges are sets of
 * other privileges. Granting, denying, or testing an aggregate privilege is
 * equivalent to individually granting, denying, or testing each privilege it
 * contains. The privileges contained by an aggregate privilege may themselves
 * be aggregate privileges if the resulting privilege graph is acyclic.
 *
 * A privilege may be an abstract privilege. Abstract privileges cannot
 * themselves be granted or denied, but can be composed into aggregate
 * privileges which are granted or denied.
 *
 * A privilege can be both aggregate and abstract.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface PrivilegeInterface
{
    /**#@+
     * @var string
     */

    /**
     * A constant representing jcr:read (in extended form), the privilege to
     * retrieve a node and get its properties and their values.
     *
     * @api
     */
    const JCR_READ = "{http://www.jcp.org/jcr/1.0}read";

    /**
     * A constant representing jcr:modifyProperties (in extended form), the
     * privilege to create, modify and remove the properties of a node.
     *
     * @api
     */
    const JCR_MODIFY_PROPERTIES = "{http://www.jcp.org/jcr/1.0}modifyProperties";

    /**
     * A constant representing jcr:addChildNodes (in extended form), the
     * privilege to create child nodes of a node.
     *
     * @api
     */
    const JCR_ADD_CHILD_NODES = "{http://www.jcp.org/jcr/1.0}addChildNodes";

    /**
     * A constant representing jcr:removeNode (in extended form), the privilege
     * to remove a node.
     *
     * In order to actually remove a node requires jcr:removeNode on that node
     * and jcr:removeChildNodes on the parent node.
     *
     * The distinction is provided in order to reflect implementations that
     * internally model "remove" as a "delete" instead of a "unlink". A
     * repository that uses the "delete" model can have jcr:removeChildNodes in
     * every access control policy, so that removal is effectively controlled
     * by jcr:removeNode.
     *
     * @api
     */
    const JCR_REMOVE_NODE = "{http://www.jcp.org/jcr/1.0}removeNode";

    /**
     * A constant representing jcr:removeChildNodes (in extended form), the
     * privilege to remove child nodes of a node.
     *
     * In order to actually remove a node requires jcr:removeNode on that node
     * and jcr:removeChildNodes on the parent node.
     *
     * The distinction is provided in order to reflect implementations that
     * internally model "remove" as a "unlink" instead of a "delete". A
     * repository that uses the "unlink" model can have jcr:removeNode in every
     * access control policy, so that removal is effectively controlled by
     * jcr:removeChildNodes.
     *
     * @api
     */
    const JCR_REMOVE_CHILD_NODES = "{http://www.jcp.org/jcr/1.0}removeChildNodes";

    /**
     * A constant representing jcr:write (in extended form), an aggregate
     * privilege that contains:
     *
     * - jcr:modifyProperties
     * - jcr:addChildNodes
     * - jcr:removeNode
     * - jcr:removeChildNodes
     *
     * @api
     */
    const JCR_WRITE = "{http://www.jcp.org/jcr/1.0}write";

    /**
     * A constant representing jcr:readAccessControl (in extended form), the
     * privilege to get the access control policy of a node.
     *
     * @api
     */
    const JCR_READ_ACCESS_CONTROL = "{http://www.jcp.org/jcr/1.0}readAccessControl";

    /**
     * A constant representing jcr:modifyAccessControl (in extended form), the
     * privilege to modify the access control policies of a node.
     *
     * @api
     */
    const JCR_MODIFY_ACCESS_CONTROL = "{http://www.jcp.org/jcr/1.0}modifyAccessControl";

    /**
     * A constant representing jcr:lockManagement (in extended form), the
     * privilege to lock and unlock a node.
     *
     * @api
     */
    const JCR_LOCK_MANAGEMENT = "{http://www.jcp.org/jcr/1.0}lockManagement";

    /**
     * A constant representing jcr:versionManagment (in extended form), the
     * privilege to perform versioning operations on a node.
     *
     * @api
     */
    const JCR_VERSION_MANAGEMENT = "{http://www.jcp.org/jcr/1.0}versionManagement";

    /**
     * A constant representing jcr:nodeTypeManagement (in extended form), the
     * privilege to add and remove mixin node types and change the primary node
     * type of a node.
     *
     * @api
     */
    const JCR_NODE_TYPE_MANAGEMENT = "{http://www.jcp.org/jcr/1.0}nodeTypeManagement";

    /**
     * A constant representing jcr:retentionManagement (in extended form), the
     * privilege to perform retention management operations on a node.
     *
     * @api
     */
    const JCR_RETENTION_MANAGEMENT = "{http://www.jcp.org/jcr/1.0}retentionManagement";

    /**
     * A constant representing jcr:lifecycleManagement (in extended form), the
     * privilege to perform lifecycle operations on a node.
     *
     * @api
     */
    const JCR_LIFECYCLE_MANAGEMENT = "{http://www.jcp.org/jcr/1.0}lifecycleManagement";

    /**
     * A constant representing jcr:all (in extended form), an aggregate
     * privilege that contains all predefined privileges.
     *
     * - jcr:read
     * - jcr:write
     * - jcr:readAccessControl
     * - jcr:modifyAccessControl
     * - jcr:lockManagement
     * - jcr:versionManagement
     * - jcr:nodeTypeManagement
     * - jcr:retentionManagement
     * - jcr:lifecycleManagement
     *
     * It should, in addition, include all implementation-defined privileges.
     *
     * @api
     */
    const JCR_ALL = "{http://www.jcp.org/jcr/1.0}all";

    /**#@-*/

    /**
     * Returns the name of this privilege.
     *
     * @return string the name of this privilege.
     *
     * @api
     */
    function getName();

    /**
     * Returns whether this privilege is an abstract privilege.
     *
     * @return boolean true if this privilege is an abstract privilege; false
     *      otherwise.
     *
     * @api
     */
    function isAbstract();

    /**
     * Returns whether this privilege is an aggregate privilege.
     *
     * @return boolean true if this privilege is an aggregate privilege; false
     *      otherwise.
     *
     * @api
     */
    function isAggregate();

    /**
     * If this privilege is an aggregate privilege, returns the privileges
     * directly contained by the aggregate privilege. Otherwise returns an empty
     * array.
     *
     * @return array an array of Privileges
     *
     * @api
     */
    function getDeclaredAggregatePrivileges();

    /**
     * If this privilege is an aggregate privilege, returns the privileges it
     * contains, the privileges contained by any aggregate privileges among
     * those, and so on (the transitive closure of privileges contained by this
     * privilege). Otherwise returns an empty array.
     *
     * @return array an array of Privileges
     *
     * @api
     */
    function getAggregatePrivileges();
}
