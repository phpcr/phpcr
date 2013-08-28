# PHP Content Repository PHPCR [![Build Status](https://secure.travis-ci.org/phpcr/phpcr.png)](http://travis-ci.org/phpcr/phpcr)

This repository contains interfaces for the PHPCR standard.

The [JSR-283](http://jcp.org/en/jsr/summary?id=283) specification defines an
API for a Content Repository (CR). The PHP Content Repository Interfaces aims
to provide that API in PHP. PHPCR is part of JSR-333, the next version of the
Java Content Repository.

There is a bunch of information here: http://phpcr.github.io


# Documentation

## Introduction

PHP content repository is an API. That is, it defines a standardized way how to
access and manipulate content. As with any general API, the main goal is to
[decouple the backend from the frontend](http://bergie.iki.fi/blog/decoupling_content_management/).
If you code against the PHPCR API, your code should run with all PHPCR
implementations. David Nuescheler, the lead of JCR, provides the following
[advantages of using a content repository](http://www.slideshare.net/uncled/introduction-to-jcr).

* Functional Definition of a “Content Repository”
* Common Vocabulary!
* No longer learn (dozens of) (ugly) proprietary APIs
* Write (mostly) portable code, for Document Management, Web Content Management, Source Code Control
* Compare Repository Functionality
* No more information silos and vendor Lock-in Content-Centric Infrastructure

PHPCR is adapted from the Java Content Repository (JCR) standard because that
is a widely used and well thought through standard. There exist a couple of
implementations for PHPCR that you can use. See below for a list of known
implementations.

## Further reading

* [Tutorial](https://github.com/phpcr/phpcr-docs/blob/master/tutorial/Tutorial.md)
* [API Reference](http://phpcr.github.com/doc/html/index.html)


# Port Status

The PHPCR is following the Java Content Repository JCR API closely where
appropriate. In the points where Java and PHP differ, we tried to follow the
logic of PHP while keeping the spirit of the original API. The API has the same
expressiveness as the Java API.
Most of the JSR-283/JSR-333 documentation and code examples should be usable as-is.

Main differences between PHPCR and JCR are

* PHP has no method overloading. Same-name methods that differ only by
  parameter number and/or type have been merged into one method.
* PHP is weak typed, which makes the Value interface and the large number of
  almost-identical iterators obsolete.

An exhaustive list of the differences between PHPCR and JCR is in the file
doc/JCR_TO_PHPCR.txt


# Tests

## Unit tests

As PHPCR is an API definition, there is not much to test on it without an
implementation. Nonetheless, there are a few concrete classes that do have
unit tests. Simply run them with phpunit -c tests/

## API Tests

An API test suite for the functionality of PHPCR is available at
https://github.com/phpcr/phpcr-api-tests/
All implementations have to test against this test suite to make sure they
are interchangeable with each other.


# Implementations

*Jackalope separates the content repository logic from the storage backend. Several backend drivers are currently being developed.*

* [Jackalope-Jackrabbit](https://jackalope.github.com/): Mapping requests to a java Jackrabbit instance. To day the most feature complete implementation.
* [Jackalope-DoctrineDBAL](https://jackalope.github.com/): Storing data in a relational database using the Doctrine Database Abstraction Layer.
* [Jackalope-MongoDB](https://github.com/chirimoya/jackalope/tree/MongoDB): Storing data in a MongoDB database.
* Jackalope-Midgard1 (not online afaik): Read access to the midgard 1.0 server.
* [Midgard2](https://github.com/bergie/phpcr-midgard2): PHPCR interfaces for the midgard2 content repository.

* [phpcr-utils](https://github.com/phpcr/phpcr-utils): A couple of utility classes and console commands to work with phcpr, independent of the implementation.

If you work on your own implementation, please let us know so we can add it
here right away. Even if its not yet working, others might want to join in and
help.

## Dependencies

PHPCR provides a composer.json for [Composer](http://packagist.org/about-composer)
and is available through [Packagist](http://packagist.org/).

# History

The API was originally ported from Java to PHP by Karsten Dambekalns
with the help of others for the typo3/flow3 project.

A first attempt at a port of JSR-170 to php has been made by
[SimPCoRe](http://www.simpcore.org/), but it seems no applications have been
published. That version never tried to provide an API, but just implemented the
Java interfaces literally.
