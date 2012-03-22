# PHPCR Tutorial

This is an introduction into the PHP content repository. You will mostly see code examples. It should work with any PHPCR implementation. We propose using the [Symfony Cmf Sandbox](https://github.com/symfony-cmf/cmf-sandbox) to get started.


## Installing the Cmf Sandbox

Just follow the README of the sandbox repository and run the fixtures import command to have some sample data.

TODO: port the fixtures loading command to PHPCR and don't mention the cmf sandbox anymore.

Look for the folder jackalope-jackrabbit in the vendor folder of the project directory.


## Installing Jackalope standalone

Jackalope can of course be set up without Symfony: [Installation guide](https://github.com/jackalope/jackalope/wiki/Downloads).
The issue is that you won't be able to load the tutorial test data.


## Browser to see what is in the repository

We recommend installing the [PhpcrBrowser](https://github.com/symfony-cmf/phpcrbrowser) so that you can see what data you currently have in your repository.


# In a nutshell

The shortest self-contained example should output a line with 'value':

    <?php
    require("/path/to/jackalope-jackrabbit/src/autoload.dist.php");

    $factoryclass = '\Jackalope\RepositoryFactoryJackrabbit';
    $parameters = array('jackalope.jackrabbit_uri' => 'http://localhost:8080/server');
    // end of implementation specific configuration

    $factory = new $factoryclass();
    $repository = $factory->getRepository($parameters);
    $credentials = new \PHPCR\SimpleCredentials('admin','admin');
    $session = $repository->login($credentials, 'default');
    $root = $session->getRootNode();
    $node = $root->addNode('test', 'nt:unstructured');
    $node->setProperty('prop', 'value');
    $session->save();
    // maybe in a follow up request...
    $node = $session->getNode('/test');
    echo $node->getPropertyValue('prop');

Still with us? Good, lets get in a bit deeper...

## Introduction

In the following chapters, we will show how to use the API. But first, you need a very brief overview of the core elements of PHPCR. After reading this tutorial, you should browse through the API documentation to get an idea what operations you can do on each of those elements. See the conclusions for links if you want to have more background.

* Node, Property: An object model for data structured similar to XML. A node is like the xml element, the property like the xml attribute. Properties are acquired from their nodes or directly from the session by their path. Nodes are acquired from parent nodes or from the session by their path. Both are Item, sharing the methods of that base interface. Names can be namespaced as in xml, and additionally may contain whitespaces or other not xml-legal characters.
* Session: The authenticated connection to one workspace in the repository. Repository and workspace are immutable inside the Session. The session is the main interface to interact with the actual data. Sessions are acquired from a repository
* Repository: Linking to one storage location with possibly many workspaces. Repositories are created with the help of the repository factory.
* RepositoryFactory: Create repository instances for your implementation with implementation specific parameters.
* Workspace: Provides general operations on the workspace of the Session it is acquired from.


TODO: Not every implementation has to support all chapters of the specification. We will add a section about capability testing to show you how to write portable code.


### Bootstrapping

You will need to make sure your php classes are available. Usually this means activating an autoloader. Jackalope follows the PSR-0 standard.
You can either add the code folders to your autoloading or use the provided file src/autoload.dist.php

Once you have autoloading set up, bootstrap jackalope-jackrabbit like this:

    // factory (the *only* implementation specific part)
    $factoryclass = '\Jackalope\RepositoryFactoryJackrabbit';
    // the parameters would typically live in a configuration file
    // see your implementation for required and optional parameters
    $parameters = array('jackalope.jackrabbit_uri' => 'http://localhost:8080/server');

    // end of implementation specific configuration
    // from here on, the whole code does not need to be changed when using different implementations

    $factory = new $factoryclass();
    $repository = $factory->getRepository($parameters);
    if (null === $repository) {
        var_dump($parameters);
        die('There where missing parameters, the factory could not create a repository');
    }

    // the login parameters would typically live in a configuration file

    $workspacename = 'default';
    $user = 'admin';
    $pass = 'admin';

    // create credentials and log in to get a session
    $credentials = new \PHPCR\SimpleCredentials($user, $pass);
    try {
        $session = $repository->login($credentials, $workspacename);
    } catch(\PHPCR\LoginException $e) {
        die('Invalid credentials: '.$e->getMessage());
    } catch(\PHPCR\NoSuchWorkspaceException $e) {
        die("No workspace $workspacename: ".$e->getMessage());
    }

    // if we get here, we have a session object that can be used to read and write the repository


### Reading data and traversal

You can wrap any code into try catch blocks. See the [API doc](http://phpcr.github.com/doc/html/index.html) for what exceptions to expect on which calls. With PHPCR being ported from Java, there is a lot of Exceptions defined.
But as this is PHP, you don't have to catch them. As long as your content is as the code expects, it won't matter.

    $node = $session->getNode('/cms/content/static/home');
    echo $node->getName(); // will be 'home'
    echo $node->getPath(); // will be '/cms/content/static/home'

#### Reading properties

    // get the php value of a property (type automatically determined from stored information)
    echo $node->getPropertyValue('title');

    // get the Property object to operate on
    $property = $node->getProperty('content');
    echo 'Size of '.$property->getPath().' is '.$property->getLength();

    // read a binary property. TODO: have binary data in demo content
    $property = $node->getProperty('jcr:data');

    $data = $property->getString(); // read binary into string
    echo "Text (size ".$property->getLength()."):\n";
    echo $data;

    $stream = $property->getBinary(); // get binary stream
    fpassthru($stream);
    fclose($stream);

    fpassthru($node->getPropertyValue('jcr:data')); // the above in short if you just want to dump the file

    /* note: the backend stores the property types. When getting properties, they are returned
     * in the same type, unless you use one of the explicit PropertyInterface::getXX methods.
     * For that case, type conversion is attempted and an exception thrown if this is not possible.
     *
     * See the API doc for a list of all supported types.
     */

    // get all properties of this node
    foreach ($node->getPropertiesValues() as $name => $value) {
        echo "$name: $value\n";
    }
    // get the properties of this node with a name starting with 'a'
    foreach ($node->getPropertiesValues("a*") as $name => $value) {
        echo "$name: $value\n";
    }


#### Traversing the hierarchy

    // getting a single node by path relative to the node
    $othernode = $node->getNode('../projects'); // /cms/content/static/projects

    // get all child nodes. the $node is Iterable, the iterator being all children
    $node = $session->getNode('/cms/content/static');
    foreach ($node as $name => $child) {
        if ($child->hasProperties()) {
            echo "$name has properties\n";
        } else {
            echo "$name does not have properties\n";
        }
    }

    // get child nodes with the name starting with 'c'
    foreach ($node->getNodes('c*') as $name => $child) {
        echo "$name\n";
    }

    // get child nodes with the name starting with 'h' or ending with 'e' or named 'projects'
    foreach ($node->getNodes(array('h*', '*e', 'projects')) as $name => $child) {
        echo "$name\n";
    }

    // get the parent node
    $parent = $node->getParent(); // /cms/content

    // build a breadcrumb of the node ancestry
    $i = 0;
    $breadcrumb = array();

    // note this code doesn't handle graphs
    do {
        $i++;
        $parent = $node->getAncestor($i);
        $breadcrumb[$parent->getPath()] = $parent->getPropertyValue('title');
    } while ($parent != $node);

#### Node and property references

Nodes can be referenced by unique id (if they are mix:referenceable) or by path. getValue returns the referenced node instance.
Properties can only be referenced by path because they can not have a unique id.

    $node = $session->getNode('/cms/navigation/main/company');
    // get a referenced node.
    $othernode = $node->getPropertyValue('reference'); // will work if the property is of type reference, weakreference, path or name

    // get it from a property
    $property = $node->getProperty('reference');
    $othernode = $property->getNode(); // will also work if the property is a string that happens to denote a path

    // get a referenced property. TODO: have a property reference in the fixtures
    $otherproperty = $node->getPropertyValue('propref'); // propref has to be a path or name


#### Shareable nodes

Optional feature, not yet implemented in Jackalope.

Graph structure instead of a tree, nodes can have more than one parent.


#### Same name siblings

Optional feature, not fully tested in Jackalope.

Nodes with the same parent can have the same name. They are distinguished by an index, as in xpath.


### Query: Search the database

    // get the query interface from the workspace
    $workspace = $session->getWorkspace();
    $queryManager = $workspace->getQueryManager();

    $sql = "SELECT * FROM [nt:unstructured]
        WHERE [nt:unstructured].[title] = 'The Company'
        ORDER BY [nt:unstructured].title";
    $query = $queryManager->createQuery($sql, 'JCR-SQL2');
    $query->setLimit(10);
    $query->setOffset(10);
    $queryResult = $query->execute();

    foreach ($queryResult->getNodes() as $path => $node) {
        echo $node->getName();
    }

#### Without building nodes

There can be a little performance boost if you do not need to fetch the nodes
but just want to access one value of each node.

    foreach ($queryResult as $path => $row) {
        echo $path . ' scored ' . $row->getScore();

        $row->getValue('a-value-you-know-exists');
    }

Large search results can be dangerous for performance. See below for some
performance tips.


#### Using Query Object Model (QOM) for building complex queries

PHPCR provides two languages to build complex queries. SQL2 and Query Object Model (QOM). While SQL2 expresses a query in a syntax similar to SQL, QOM expresses the query as a tree of PHPCR objects.

In this section we will cover QOM. See the [JCR docs](http://phpcr.github.com/doc/html/index.html) for an exposition of both languages.

You can access the QueryObjectModelFactory from the session:

    $qomFactory = $mySession->getWorkspace()->getQueryManager()->getQOMFactory();

The QOM factory has a method to build a QOM query given four parameters, and [provides methods](http://phpcr.github.com/doc/html/phpcr/query/qom/queryobjectmodelfactoryinterface.html) to build these four parameters:

    $queryObjectModel = $QOMFactory->createQuery(SourceInterface source, ConstraintInterface constraint, array orderings, array columns);

`source` is made out of one or more selectors. Each selector selects a subset of nodes. Queries with more than one selector have joins. A query with two selectors will have a join, a query with three selectors will have two joins, and so on.

`constraint` filters the set of node-tuples to be retrieved. Constraint may be combined in a tree of constraints to perform a more complex filtering. Examples of constraints are:

* Absolute or relative paths: nodes descendant of a path, nodes children of a path, nodes reachable by a path.
* Name of the node.
* Value of a property.
* Length of a property.
* Existence of a property.
* Full text search.

`orderings` determine the order in which the filtered node-tuples will appear in the query results. The relative order of two node-tuples is determined by evaluating the specified orderings, in list order, until encountering an ordering for which one node-tuple precedes the other.

`columns` are the columns to be included in the tabular view of query results. If no columns are specified, the columns available in the tabular view are implementation determined. In Jackalope include, for each selector, a column for each single-valued non-residual property of the selector's node type.

The simplest case is to select all `[nt:unstructured]` nodes:

   $source = $qomFactory->selector('[nt:unstructured]');
   $query = $qomFactory->createQuery($source, null, array(), array());


#### The Query Builder: a fluent interface for QOM

Sometimes you may prefer to build a query in several steps. For that reason, the phpcr-utils library provides a fluent wrapper for QOM: the QueryBuilder. It works with any PHPCR implementation.

An example of query built with QueryBuilder:

    use PHPCR\Query\QOM\QueryObjectModelConstantsInterface;
    use PHPCR\Util\QOM\QueryBuilder;

    $qf = $qomFactory;
    $qb = new QueryBuilder($qomFactory);
    //add the source
    $qb->from($qomFactory->selector('nt:unstructured'))
        //some composed constraint
        ->andWhere($qf->comparison($qf->propertyValue('phpcr:someproperty'),
            QueryObjectModelConstantsInterface::JCR_OPERATOR_EQUAL_TO,
            $qf->literal('a-value-you-know-exists')))
        //orderings
        ->orderBy($qf->propertyValue('phpcr:anotherproperty'))
        //set an offset
        ->setFirstResult(15)
        //and the maximum number of node-tuples to retrieve
        ->setMaxResults(25);
    $result = $qb->execute();


### Writing data

With PHPCR, you never use 'new'. The node works as a factory to create new nodes and properties. This has the nice side effect that you can not add a node where there is no parent.

Everything you do on the Session, Node and Property objects is only visible locally in this session until you save the session.

    // add a new node as child of $node
    $newnode = $node->addNode('new node', 'nt:unstructured'); // until we have shown node types, just use nt:unstructured as type

    // set a property on the new node
    $newproperty = $newnode->setProperty('my property', 'my value');

    // persist the changes permanently. now they also become visible in other sessions
    $session->save();


    // have a reference
    $targetnode = $session->getNode('/cms/content/static/home');

    // make sure the target node is referenceable.
    $targetnode->addMixin('mix:referenceable');
    // depending on the implementation, you might need to save the session at
    // this point to have the identifier generated

    // add a reference property to the node. because the property value is a
    // Node, PHPCR will automatically detect that you want a reference
    $node->setProperty('my reference', $targetnode);

    $session->save();


#### Moving and deleting nodes

    // move the node company and all its children from its parent /cms/navigation/main to
    // the new parent /cms/navigation/main/projects
    // the target parent must already exist, it is not automatically created
    $session->move('/cms/navigation/main/company', '/cms/navigation/main/projects');

    // for this session, everything that was at /cms/navigation/main/company is now under /cms/navigation/main/projects
    // i.e. /cms/navigation/main/projects/company/team
    // once the session is saved, the move is persisted and visible in other sessions

    // immediatly move the node in the persistent storage
    $workspace = $session->getWorkspace();
    $workspace->move('/cms/navigation/main/company', '/cms/navigation/main/projects');

    // copy a node and its children (only on workspace, not in session)
    $workspace->copy('/cms/navigation/main/company', '/cms/navigation/main/projects');

    // delete a node
    $session->removeItem('/cms/navigation/main/company');


#### Orderable child nodes

While moving is about changing the parent of a node, ordering is used to set the
position inside the child list. Preserving and altering order is an optional
feature of PHPCR.

The only method needed is Node::orderBefore

    $node->addNode('first');
    $node->addNode('second'); // new nodes are added to the end of the list
    // order is: first, second

    // ordering is done on the parent node. the first argument is the name of
    // the child node to be reordered, the second the name of the node to moved
    // node is placed before
    $node->orderBefore('second', 'first');
    // now the order is: second, first


### Versioning

Versioning is used to track changes in nodes with the possibility to get back to older versions.

A node with the mixin type mix:versionable or mix:simpleVersionable can be
versioned. Versioned nodes have a version history, containing the root version
and all versions created. Each version contains the meta data (previous
versions, next versions and creation date) and provides a snapshot of the node
at that point, called "frozen node".

    $node->setProperty('foo', 'fafa');
    // mark the node as versionable
    $node->addMixin('mix:versionable');

    // version operations are done through the VersionManager
    $versionManager = $session->getWorkspace()->getVersionManager();

    // put the versionable node into edit mode
    $versionManager->checkout($node->getPath());
    $node->setProperty('foo', 'bar'); // need a change to see something
    $session->save(); // you can only create versions of saved nodes
    // create a new version of the node with our changes
    $version = $versionManager->checkin($node->getPath());
    // Version extends the Node interface. The version is the node with additional functionality

    // walk back the versions
    $oldversion = $version->getLinearPredecessor();
    // the version objects are just the meta data. call getFrozenNode on them
    // to get a snapshot of the data when the version was created
    echo $version->getName() . ': ' . $version->getFrozenNode()->getPropertyValue('foo'); // 1.0: bar
    echo $oldversion->getName() . ': ' . $oldversion->getFrozenNode()->getPropertyValue('foo'); // jcr:rootVersion: fafa

    // get the full version history
    $history = $versionManager->getVersionHistory($node->getPath());
    foreach ($history->getAllFrozenNodes() as $node) {
        echo $node->getPropertyValue('foo');
    }

    // restore an old version
    $node->setProperty('foo', 'different');
    $session->save(); // restoring is only possible if the session is clean
    $current = $versionManager->getBaseVersion($node->getPath());
    $versionManager->restore(true, $current);
    echo $node->getProperty('foo'); // fafa


### Locking

In PHPCR, you can lock nodes to prevent concurrency issues. There is two basic types of locks:

* Session based locks are only kept until your session ends and released automatically on logout.
* If a lock is not session based, it is identified by a lock token and stays in place until it times out

Note that jackalope currently only implements session based locks.

    // get the lock manager
    $workspace = $session->getWorkspace();
    $lockManager = $workspace->getLockManager();
    var_dump($lockManager->isLocked('/cms/navigation')); // should be false
    $lockManager->lock('/cms/navigation', true, true); // lock child nodes as well, release when session closed
    // now only this session may change the node /cms/navigation and its descendants
    var_dump($lockManager->isLocked('/cms/navigation')); // should be true
    var_dump($lockManager->isLocked('/cms/navigation/main')); // should be true because we locked deep

    $lock = $lockManager->getLock('/cms/navigation');
    var_dump($lock->isLockOwningSession()); // true, this is our lock, not somebody else's
    var_dump($lock->getSecondsRemaining()); // PHP_INT_MAX because this lock has no timeout
    var_dump($lock->isLive()); // true

    $node = $lock->getNode(); // this gets us node /cms/navigation
    $node === $lockManager->getLock('/cms/navigation/main')->getNode(); // getnode always returns the lock owning node

    $lockManager->unlock('/cms/navigation'); // we could also let $session->logout() unlock when using session based lock
    var_dump($lockManager->isLocked('/cms/navigation')); // false
    var_dump($lock->isLive()); // false


### Transactions

The PHPCR API in itself uses a transaction model by only persisting changes on session save. If you need transactions over more than one save operation or including workspace operations that are dispatched immediatly, you can use transactions.

Note that Jackalope does not support transactions.

    // get the transaction manager.
    $workspace = $session->getWorkspace()
    $transactionManager = $workspace->getTransactionManager();
    // start a transaction
    $transactionManager->begin();
    $session->removeNode('/cms/navigation/main/company');
    $node->addNode('insideTransaction');
    $session->save(); // wrote to the backend but not yet visible to other sessions
    $workspace->move('/cms/navigation', '/new'); // will only move the new node if session has been saved. still not visible to other sessions
    $transactionManager->commit(); // now everything become persistent and visible to others

    // you can abort a transaction
    try {
        ...
    } catch(\Exception $e) {
        if ($transactionManager->inTransaction()) {
            $transactionManager->rollback();
        }
        ...
    }


### Import and export data

There are two formats:
* The *document view* translates the data into a XML document with node names as xml elements and properties as attributes and thus very readable. Type information is lost, and illegal XML characters are encoded.
* The *system view* is a more strict XML document defining the exact structure of the repository with all type information. However, it is more verbose.

In Jackalope, we only implemented exporting so far.

    $file = fopen('/tmp/dump.xml', '+w');

    // dump the tree at /foo/bar into a document view file
    $session->exportDocumentView('/cms', $file, true /* skip binary properties */, false /* recursivly output the child nodes as well */);

    // export the tree at /foo/bar into a system view xml file
    $session->exportSystemView('/cms', $file, false /* do not skip binary properties */, false);


### Observation

Observation enables an application to receive notifications of persistent changes to a workspace.
JCR defines a general event model and specific APIs for asynchronous and journaled observation.
A repository may support asynchronous observation, journaled observation or both.

Note that Jackrabbit supports the full observation API but Jackalope currently only implements event journal reading.

Write operations in Jackalope will generate journal entries as expected.

    use PHPCR\Observation\EventInterface; // Contains the constants for event types

    // Get the observation manager
    $workspace = $session->getWorkspace()
    $observationManager = $workspace->getObservationManager();

    // Get the unfiltered event journal and go through its content
    $journal = $observationManager->getEventJournal();
    $journal->skipTo(strtotime('-1 day'); // Skip all the events prior to yesterday
    foreach ($journal as $event) {
        // Do something with $event (it's a Jackalope\Observation\Event instance)
        echo $event->getType() . ' - ' . $event->getPath()
    }

    // Filtering and using the journal as an iterator
    // You can filter the event journal on several criteria, here we keep events for node and properties added
    $journal = $observationManager->getEventJournal(EventInterface::NODE_ADDED | EventInterface::PROPERTY_ADDED);

    while ($journal->valid()) {
        $event = $journal->current();
        // Do something with $event
        $journal->next();
    }


### Node Types

PHPCR supports node types. Node types define what properties and children a node can or must have. The JCR specification explains exhaustivly what node types exist and what they are required to have or not.

In a nutshell:
* nt:unstructured does not define any required properties but allows any property or child.
* nt:file and nt:folder are built-in node types useful to map a file structure in the repository. (With jackalope-jackrabbit, files and folders are exposed over webdav)
* for your own things, use nt:unstructured and PHPCR will behave like a NoSQL database
* if you need to store additional properties or children on existing node types like files, note that while a node can have only one primary type, every node can have any mixin types. Define a mixin type declaring your additional properties, register it with PHPCR and addMixin it to the nodes that need it.


## Performance considerations

While PHPCR can perform reasonably well, you should be careful. You are working with an object model mapping interlinked data. Implementations are supposed to lazy load data only when necessary. But you should take care to only request what you actually need.

The implementations will also use some sort of storage backend (Jackrabbit, (no)SQL database, ...). There might be a huge performance impact in configuring that storage backend optimally. Look into your implementation documentation if there are recommendations how to optimize storage.

One thing *not* to worry about is requesting the same node with Session::getNode or Node::getNode/s several times. You always get the same object instance back without overhead.


### Only request what you need

Remember that you can filter nodes on Node::getNodes if you only need a list of specific nodes or all nodes in some namespace.

The values of binary properties can potentially have a huge size and should only loaded when really needed. If you just need the size, you can get the property instance and do a $property->getSize() instead of filesize($node->getPropertyValue). Any decent implementation will not preload the binary stream when you access the property object.

When getting the properties from a node, you can use Node::getPropertiesValues(filter, false). This allows the implementation to avoid instantiating Property objects for the property values (and saves you coding). The second boolean parameter tells wheter to dereference reference properties. If you do not need the referenced objects, pass false and you will get the UUID or path strings instead of node objects.(If you need one of them, you can still get it with Session::getNodeByIdentifier. But then the implementation will certainly not be able to optimize if you get several referenced nodes.)


### But request in one call as much as possible of what you need

If you need to get several nodes where you know the paths, use Session::getNodes with an array of those nodes to get all of them in one batch, saving round trip time to the storage backend.

Also use Node::getNodes with a list of nodes rather than repeatedly calling Node::getNode.


### Search

TODO: intelligent filtering criteria to do as little in-memory operations to apply criteria.

If you do not need the node objects but just some value, query for that value and use the result Row to avoid instantiating Node objects alltogether. If you need the Node objects, help PHPCR to optimize by using QueryResult::getNodes and iterating over the nodes instead of getting the rows, iterating over them and calling getNode on each row. (Actually, if you first do the getNodes(), you can then iterate over the rows and get the individual nodes and still use the special row methods as the implementation should have prefetched data on the getNodes.)


## Conclusions

We hope this tutorial helps to get you started. If you miss anything, have suggestions or questions, please contact us on jackalope-dev@googlegroups.com or #jackalope on irc.freenode.net

### Further reading

Browse through the [API documentation](http://phpcr.github.com/doc/html/index.html) to see what each of the core elements mentioned in the introduction can do.

To fully understand the concepts behind the content repository API, we suggest reading [the Java content repository specification](http://www.day.com/specs/jcr/2.0/index.html) and
then the [simplifications we did for PHP](https://github.com/phpcr/phpcr/blob/master/doc/JCR_TO_PHPCR.txt).


### Not yet implemented

A couple of other advanced functionalities are defined by the API. They are not yet implemented in any PHPCR implementation. This document will be updated once there is an implementation for them.

* Permissions and capabilities
* Access control management
* Lifecycle managment
* Retention and hold
