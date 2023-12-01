Changelog
=========

2.1.9
-----

* **2023-12-01**: Fix test class name to match the filename as phpunit 10 no longer accepts the mismatch.

2.1.8
-----

* **2023-09-04**: Improve phpdoc to work nicely with static code analysers: Generics, param and return types.
  There are no BC break because this is "only" documentation, but code analysers and other code quality tools might now report if you use the API incorrectly. 

2.1.7
-----

* **2023-02-18**: Adjust documentation links in README

2.1.6
-----

* **2020-10-06**: Allow PHP 8

2.1.5
-----

* **2019-12-11**: Use namespaced phpunit classes in tests

2.1.4
-----

* **2017-02-08**: fixed a regression of 2.1.3 that broke with php 5.6 (#96)

2.1.3
-----

* **2017-01-30**: Dropped support for PHP versions older than 5.6
* **2017-01-30**: Bugfix: Mixin namespace was incorrect in NodeTypeInterface (http://www.jcp.org/mix/1.0 instead of http://www.jcp.org/jcr/mix/1.0)
