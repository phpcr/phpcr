# PHPCR Tutorial

This is an introduction into the PHP content repository basically with code examples.

## Introduction

In the following chapters, we will show how to use the API. But first, you need a very brief overview of the core elements of PHPCR. After reading this tutorial, you should browse through the API documentation to get an idea what operations you can do on each of those elements. See the conclusions for links if you want to have more background.

* Node, Property: An object model for data structured similar to XML. A node is like the xml element, the property like the xml attribute. Properties are acquired from their nodes or directly from the session by their path. Nodes are acquired from parent nodes or from the session by their path. Both are Item, sharing the methods of that base interface. Names can be namespaced as in xml, and additionally may contain whitespaces or other not xml-legal characters.
* Session: The authenticated connection to one workspace in the repository. Repository and workspace are immutable inside the Session. The session is the main interface to interact with the actual data. Sessions are acquired from a repository
* Repository: Linking to one storage location with possibly many workspaces. Repositories are created with the help of the repository factory.
* RepositoryFactory: Create repository instances for your implementation with implementation specific parameters.
* Workspace: Provides general operations on the workspace of the Session it is acquired from.


### Bootstrapping

    // factory (the *only* implementation specific part)
    $factoryclass = '\Jackalope\RepositoryFactoryJackrabbit';
    // the parameters would typically live in a configuration file
    // see your implementation for required and optional parameters
    $parameters = array('jackalope.jackrabbit_uri' => 'http://localhost:8080/server');

    // end of implementation specific configuration
    // from here on, the whole code does not need to be changed when using different implementations

    $factory = new $factoryclass();
    $repository = $factory->getRepository($parameters);
    if (null == $repository) {
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

    $node = $session->getNode('/foo/bar/ding/dong');
    echo $node->getName(); // will be 'dong'
    echo $node->getPath(); // will be '/foo/bar/ding/dong'

#### Reading properties

    // get the php value of a property (type automatically determined from stored information)
    echo $node->getPropertyValue('my property');

    // get the Property object to operate on
    $property = $node->getProperty('my property');
    echo 'Size of '.$property->getPath().' is '.$property->getLength();

    // read a binary property
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
    foreach($node->getPropertiesValues() as $name => $value) {
        echo "$name: $value\n";
    }
    // get the properties of this node with a name starting with 'a'
    foreach($node->getPropertiesValues("a*")) {
        echo "$name: $value\n";
    }


#### Traversing the hierarchy

    // getting a single node by path relative to the node
    $othernode = $node->getNode('../baz'); // /foo/bar/ding/baz

    // get all child nodes
    foreach($node->getNodes() as $name => $node) {
        if ($node->hasProperties()) {
            echo "$name has properties\n";
        } else {
            echo "$name does not have properties\n";
        }
    }

    // get child nodes with the name starting with 'a'
    foreach($node->getNodes('a*') as $name => $node) {
        echo "$name\n";
    }

    // get child nodes with the name starting with 'a' or ending with 'b' or named 'my node'
    foreach($node->getNodes(array('a*', '*b', 'my node')) as $name => $node) {
        echo "$name\n";
    }

    // get the parent node
    $parent = $node->getParent(); // /foo/bar/ding

    // build a breadcrumb of the node ancestry
    $i = 0;
    $breadcrumb = array();

    // note this code doesn't handle graphs
    do {
        $i++;
        $parent = $node->getAncestor($i);
        $breadcrumb[$parent->getPath()] = $parent->getPropertyValue('label');
    } while ($parent != $node);

#### Node and property references

Nodes can be referenced by unique id (if they are mix:referenceable) or by path. getValue returns the referenced node instance.
Properties can only be referenced by path because they can not have a unique id.

    // get a referenced node
    $othernode = $node->getPropertyValue('reference'); // will work if the property is of type reference, weakreference, path or name

    // get it from a property
    $property = $node->getProperty('reference');
    $othernode = $property->getNode(); // will also work if the property is a string that happens to denote a path

    // get a referenced property
    $otherproperty = $node->getPropertyValue('propref'); // propref has to be a path or name

#### Shareable nodes

Optional feature, not yet implemented in Jackalope.

Graph structure instead of a tree, nodes can have more than one parent.

#### Same name siblings

Optional feature, not fully tested in Jackalope.

Nodes with the same parent can have the same name. They are distinguished by an index, as in xpath.

#### Orderable child nodes

When reading, Jackalope preserves the order in which the nodes have been added.



### Query: Search the database

    // get the query interface from the workspace
    $workspace = $session->getWorkspace();
    $queryManager = $workspace->getQueryManager();

    $sql = "SELECT * FROM [nt:unstructured]
        WHERE [nt:unstructured].[my:property] = 'bar'
        ORDER BY [nt:unstructured].title";
    $query = $queryManager->createQuery($sql, 'JCR-SQL2');
    $query->setLimit(10);
    $query->setOffset(10);
    $queryResult = $query->execute();

    foreach ($queryResult->getNodes() as $path => $node) {
        echo $node->getName();
    }

    TODO: more advanced example?


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
    $targetnode = $session->getNode('/path/to/node');

    // make sure the target node is referenceable.
    $targetnode->addMixin('mix:referenceable');
    // depending on the implementation, you might need to save the session at
    // this point to have the identifier generated

    // add a reference property to the node. because the property value is a
    // Node, PHPCR will automatically detect that you want a reference
    $node->setProperty('my reference', $targetnode);

    $session->save();

#### Moving and deleting nodes

    // move the node ding from its parent /foo/bar to the new parent /other/place
    // the target parent must already exist, it is not automatically created
    $session->move('/foo/bar/ding', '/other/place');

    // for this session, everything that was under /foo/bar/ding is now at /other/place
    // once the session is saved, the move is persisted and visible in other sessions

    // immediatly move the node in the persistent storage
    $workspace = $session->getWorkspace();
    $workspace->move('/foo/bar/ding', '/other/place');

    // copy a node and its children (only on workspace, not in session)
    $workspace->copy('/src/path/node', '/targ/path');

    // delete a node
    $session->removeItem('/foo/bar');

#### Orderable child nodes

Optional feature. Jackalope preserves the order but the API methods to change the order of nodes are not yet implemented.


### Versioning

Versioning is used to track changes in nodes with the possibility to get back to older versions.

    $node->setProperty('foo', 'fafa');
    // mark the node as versionable
    $node->addMixin('mix:versionable');

    // version operations are done through the VersionManager
    $versionManager = $session->getWorkspace()->getVersionManager();

    // put the versionable node into edit mode
    $versionManager->checkout($node->getPath());
    $node->setProperty('foo', 'bar'); // need a change to see something
    // create a new version of the node with our changes
    $version = $versionManager->checkin($node->getPath());
    // Version extends the Node interface. The version is the node with additional functionality

    // walk back the versions
    $oldversion = $version->getLinearPredecessor();
    echo $version->getPropertyValue('foo'); // bar
    echo $oldversion->getPropertyValue('foo'); // fafa

    // get the full version history
    $history = $versionManager->getVersionHistory($node->getPath());
    foreach ($history->getAllVersions() as $node) {
        echo $node->getPropertyValue('foo');
    }

    // restore an old version
    $current = $versionManager->getBaseVersion($node->getPath());
    $oldversion = $current->getLinearPredecessor();
    $versionManager->restore(true, $oldversion);


### Transactions

The PHPCR API in itself uses a transaction model by only persisting changes on session save. If you need transactions over more than one save operation or including workspace operations that are dispatched immediatly, you can use transactions.

    // get the transaction manager. TODO: should be on workspace
    $transactionManager = $session->getTransactionManager();
    // start a transaction
    $transactionManager->begin();
    $session->removeNode('/some/path/to/node');
    $node->addNode('insideTransaction');
    $session->save(); // wrote to the backend but not yet visible to other sessions
    $workspace->move('/foo/bar/ding', '/new/path'); // will only move the new node if session has been saved. still not visible to other sessions
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

    $file = fopen('/tmp/dump.xml');

    // dump the tree at /foo/bar into a document view file
    $session->exportDocumentView('/foo/bar', $file, true /* skip binary properties */, false /* recursivly output the child nodes as well */);

    // export the tree at /foo/bar into a system view xml file
    $session->exportSystemView('/foo/bar', $file, false /* do not skip binary properties */, false);


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

Browse through the <a href="http://phpcr.github.com/doc/html/index.html">API documentation</a> to see what each of the core elements mentioned in the introduction can do.

To fully understand the concepts behind the content repository API, we suggest reading
<a href="http://www.day.com/maven/javax.jcr/javadocs/jcr-2.0/index.html">the Java content repository</a> specification and
then the <a href="https://github.com/phpcr/phpcr/blob/master/doc/JCR_TO_PHPCR.txt">simplifications we did for PHP</a>.


### Not yet implemented

A couple of other advanced functionalities are defined by the API. They are not yet implemented in any PHPCR implementation. This document will be updated once there is an implementation for them.

* Permissions and capabilities
* Observation
* Access control management
* Locking
* Lifecycle managment
* Retention and hold

