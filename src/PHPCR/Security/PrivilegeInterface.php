<?php

namespace PHPCR\Security;

use PHPCR\NamespaceRegistryInterface as NS;

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
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface PrivilegeInterface
{
    /**
     * A constant representing jcr:read (in extended form), the privilege to
     * retrieve a node and get its properties and their values.
     *
     * @api
     */
    const JCR_READ = '{'.NS::NAMESPACE_JCR.'}read';

    /**
     * A constant representing jcr:modifyProperties (in extended form), the
     * privilege to create, modify and remove the properties of a node.
     *
     * @api
     */
    const JCR_MODIFY_PROPERTIES = '{'.NS::NAMESPACE_JCR.'}modifyProperties';

    /**
     * A constant representing jcr:addChildNodes (in extended form), the
     * privilege to create child nodes of a node.
     *
     * @api
     */
    const JCR_ADD_CHILD_NODES = '{'.NS::NAMESPACE_JCR.'}addChildNodes';

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
    const JCR_REMOVE_NODE = '{'.NS::NAMESPACE_JCR.'}removeNode';

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
    const JCR_REMOVE_CHILD_NODES = '{'.NS::NAMESPACE_JCR.'}removeChildNodes';

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
    const JCR_WRITE = '{'.NS::NAMESPACE_JCR.'}write';

    /**
     * A constant representing jcr:readAccessControl (in extended form), the
     * privilege to get the access control policy of a node.
     *
     * @api
     */
    const JCR_READ_ACCESS_CONTROL = '{'.NS::NAMESPACE_JCR.'}readAccessControl';

    /**
     * A constant representing jcr:modifyAccessControl (in extended form), the
     * privilege to modify the access control policies of a node.
     *
     * @api
     */
    const JCR_MODIFY_ACCESS_CONTROL = '{'.NS::NAMESPACE_JCR.'}modifyAccessControl';

    /**
     * A constant representing jcr:lockManagement (in extended form), the
     * privilege to lock and unlock a node.
     *
     * @api
     */
    const JCR_LOCK_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}lockManagement';

    /**
     * A constant representing jcr:versionManagement (in extended form), the
     * privilege to perform versioning operations on a node.
     *
     * @api
     */
    const JCR_VERSION_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}versionManagement';

    /**
     * A constant representing jcr:nodeTypeManagement (in extended form), the
     * privilege to add and remove mixin node types and change the primary node
     * type of a node.
     *
     * @api
     */
    const JCR_NODE_TYPE_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}nodeTypeManagement';

    /**
     * A constant representing jcr:retentionManagement (in extended form), the
     * privilege to perform retention management operations on a node.
     *
     * @api
     */
    const JCR_RETENTION_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}retentionManagement';

    /**
     * A constant representing jcr:lifecycleManagement (in extended form), the
     * privilege to perform lifecycle operations on a node.
     *
     * @api
     */
    const JCR_LIFECYCLE_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}lifecycleManagement';

    /**
     * A constant representing <code>jcr:workspaceManagement</code> (in expanded
     * form), the privilege to create and remove workspaces in the repository.
     */
    const JCR_WORKSPACE_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}workspaceManagement';

    /**
     * A constant representing <code>jcr:nodeTypeDefinitionManagement</code> (in expanded
     * form), the privilege to register, unregister and change the definitions
     * of node type in the repository.
     */
    const JCR_NODE_TYPE_DEFINITION_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}nodeTypeDefinitionManagement';

    /**
     * A constant representing <code>jcr:namespaceManagement</code> (in expanded
     * form), the privilege to register, unregister and modify namespace definitions.
     */
    const JCR_NAMESPACE_MANAGEMENT = '{'.NS::NAMESPACE_JCR.'}namespaceManagement';

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
     * - jcr:workspaceManagement
     * - jcr:nodeTypeDefinitionManagement
     * - jcr:namespaceManagement
     *
     * It should, in addition, include all implementation-defined privileges.
     *
     * @api
     */
    const JCR_ALL = '{'.NS::NAMESPACE_JCR.'}all';

    /**
     * Returns the name of this privilege.
     *
     * @return string the name of this privilege.
     *
     * @api
     */
    public function getName();

    /**
     * Returns whether this privilege is an abstract privilege.
     *
     * @return bool true if this privilege is an abstract privilege; false
     *      otherwise.
     *
     * @api
     */
    public function isAbstract();

    /**
     * Returns whether this privilege is an aggregate privilege.
     *
     * @return bool true if this privilege is an aggregate privilege; false
     *      otherwise.
     *
     * @api
     */
    public function isAggregate();

    /**
     * If this privilege is an aggregate privilege, returns the privileges
     * directly contained by the aggregate privilege. Otherwise returns an empty
     * array.
     *
     * @return PrivilegeInterface[]
     *
     * @api
     */
    public function getDeclaredAggregatePrivileges();

    /**
     * If this privilege is an aggregate privilege, returns the privileges it
     * contains, the privileges contained by any aggregate privileges among
     * those, and so on (the transitive closure of privileges contained by this
     * privilege). Otherwise returns an empty array.
     *
     * @return PrivilegeInterface[]
     *
     * @api
     */
    public function getAggregatePrivileges();
}
