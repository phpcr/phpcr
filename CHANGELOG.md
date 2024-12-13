Changelog
=========

2.1.14
------

* **2024-12-13**: Improve PHPDoc for QueryResultInterface to specify instead of describe return types.

2.1.13
------

* **2024-07-03**: Drop support for PHP 7.0 and 5.6 to allow `?` in parameters to avoid warning with PHP 8.3 and prepare for PHP 9.

2.1.12
------

* **2024-07-03**: Revert BC breaks with nullable parameters as those are not supported in PHP 7.0.

2.1.11
------

* **2024-04-09**: Fixed `PHPCR\Query\QOM\QueryObjectModelFactoryInterface::literal` phpdoc return type.
* **2024-04-08**: Code style fixes for PHP 8.3.

2.1.10
------

* **2023-12-02**: PHPDoc fixes with phpstan.

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
