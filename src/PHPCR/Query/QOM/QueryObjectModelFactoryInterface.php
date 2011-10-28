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

namespace PHPCR\Query\QOM;

/**
 * A QueryObjectModelFactory creates instances of the JCR query object model.
 *
 * Refer to QueryObjectModelInterface for a description of the query object
 * model.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface QueryObjectModelFactoryInterface extends QueryObjectModelConstantsInterface
{
    /**
     * Creates a query with one or more selectors.
     *
     * If source is a selector, that selector is the default selector of the
     * query. Otherwise the query does not have a default selector.
     *
     * If the query is invalid, this method throws an InvalidQueryException.
     * See the individual QOM factory methods for the validity criteria of each
     * query element.
     *
     * @param \PHPCR\Query\QOM\SourceInterface $source the Selector or the
     *      node-tuple Source; non-null
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint the constraint,
     *      or null if none
     * @param array $orderings zero (empty array) or more instances of Ordering
     * @param array $columns the array of Column definitions to return in the
     *      result. empty array is equivalent to the * in SQL2, meaning some
     *      fields.
     *
     * @return \PHPCR\Query\QOM\QueryObjectModelInterface the query; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test and the parameters given fail that test. See the
     *      individual QOM factory methods for the validity criteria of each
     *      query element.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    function createQuery(\PHPCR\Query\QOM\SourceInterface $source,
                         \PHPCR\Query\QOM\ConstraintInterface $constraint = null,
                         array $orderings,
                         array $columns);

    /**
     * Selects a subset of the nodes in the repository based on node type.
     *
     * The query is invalid if $nodeTypeName or $selectorName is not a
     * syntactically valid JCR name.
     *
     * The query is invalid if $selectorName is identical to the name of
     * another selector in the query.
     *
     * If $nodeTypeName is a valid JCR name but not the name of a node type
     * available in the repository, the query is valid but the selector selects
     * no nodes.
     *
     * @param string $nodeTypeName the name of the required node type; non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\SelectorInterface the selector; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function selector($nodeTypeName, $selectorName = null);

    /**
     * Performs a join between two node-tuple sources.
     *
     * The query is invalid if $left is the same source as $right.
     *
     * @param \PHPCR\Query\QOM\SourceInterface $left the left node-tuple
     *      source; non-null
     * @param \PHPCR\Query\QOM\SourceInterface $right the right node-tuple
     *      source; non-null
     * @param string $joinType one of QueryObjectModelConstants.JCR_JOIN_TYPE_*
     * @param \PHPCR\Query\QOM\JoinConditionInterface $joinCondition the join
     *      condition; non-null
     *
     * @return \PHPCR\Query\QOM\JoinInterface the join; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function join(\PHPCR\Query\QOM\SourceInterface $left, \PHPCR\Query\QOM\SourceInterface $right,
                         $joinType, \PHPCR\Query\QOM\JoinConditionInterface $joinCondition);

    /**
     * Tests whether the value of a property in a first selector is equal to
     * the value of a property in a second selector.
     *
     * The query is invalid if:
     *
     * - $selector1 is not the name of a selector in the query, or
     * - $selector2 is not the name of a selector in the query, or
     * - $selector1 is the same as $selector2, or
     * - $property1 is not a syntactically valid JCR name, or
     * - $property2 is not a syntactically valid JCR name, or
     * - the value of $property1 is not the same property type as the value of
     *   $property2, or
     * - $property1 is a multi-valued property, or
     * - $property2 is a multi-valued property, or
     * - $property1 is a BINARY property, or
     * - $property2 is a BINARY property.
     *
     * @param string $selector1Name the name of the first selector; non-null
     * @param string $property1Name the property name in the first selector;
     *      non-null
     * @param string $selector2Name the name of the second selector; non-null
     * @param string $property2Name the property name in the second selector;
     *       non-null
     *
     * @return \PHPCR\Query\QOM\EquiJoinConditionInterface the constraint;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function equiJoinCondition($selector1Name, $property1Name, $selector2Name, $property2Name);

    /**
     * Tests whether a first selector's node is the same as a node identified
     * by relative path from a second selector's node.
     *
     * The query is invalid if:
     *
     * - $selector1 is not the name of a selector in the query, or
     * - $selector2 is not the name of a selector in the query, or
     * - $selector1 is the same as $selector2, or
     * - $selector2Path is not a syntactically valid relative path.
     *   <b>Note:</b>
     *   however, that if the path is syntactically valid but does not identify
     *   a node visible to the current session, the query is valid but the
     *   constraint is not satisfied.
     *
     * @param string $selector1Name the name of the first selector; non-null
     * @param string $selector2Name the name of the second selector; non-null
     * @param string $selector2Path the path relative to the second selector;
     *      non-null
     *
     * @return \PHPCR\Query\QOM\SameNodeJoinConditionInterface the constraint;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function sameNodeJoinCondition($selector1Name, $selector2Name, $selector2Path = null);

    /**
     * Tests whether a first selector's node is a child of a second selector's
     * node.
     *
     * The query is invalid if:
     *
     * - $childSelector is not the name of a selector in the query
     * - $parentSelector is not the name of a selector in the query
     * - $childSelector is the same as $parentSelector
     *
     * @param string $childSelectorName the name of the child selector;
     *      non-null
     * @param string $parentSelectorName the name of the parent selector;
     *      non-null
     *
     * @return \PHPCR\Query\QOM\ChildNodeJoinConditionInterface the constraint;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     *
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function childNodeJoinCondition($childSelectorName, $parentSelectorName);

    /**
     * Tests whether a first selector's node is a descendant of a second
     * selector's node.
     *
     * The query is invalid if:
     *
     * - $descendantSelector is not the name of a selector in the query
     * - $ancestorSelector is not the name of a selector in the query
     * - $descendantSelector is the same as $ancestorSelector
     *
     * @param string $descendantSelectorName the name of the descendant
     *      selector; non-null
     * @param string $ancestorSelectorName the name of the ancestor selector;
     *      non-null
     *
     * @return \PHPCR\Query\QOM\DescendantNodeJoinConditionInterface the
     *      constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function descendantNodeJoinCondition($descendantSelectorName, $ancestorSelectorName);

    /**
     * Performs a logical conjunction of two other constraints.
     *
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint1 the first
     *      constraint; non-null
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint2 the second
     *      constraint; non-null
     *
     * @return \PHPCR\Query\QOM\AndInterface the And constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function andConstraint(\PHPCR\Query\QOM\ConstraintInterface $constraint1,
                         \PHPCR\Query\QOM\ConstraintInterface $constraint2);

    /**
     * Performs a logical disjunction of two other constraints.
     *
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint1 the first
     *      constraint; non-null
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint2 the second
     *      constraint; non-null
     *
     * @return \PHPCR\Query\QOM\OrInterface the Or constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     *
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function orConstraint(\PHPCR\Query\QOM\ConstraintInterface $constraint1,
                        \PHPCR\Query\QOM\ConstraintInterface $constraint2);

    /**
     * Performs a logical negation of another constraint.
     *
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint the constraint
     *      to be negated; non-null
     *
     * @return \PHPCR\Query\QOM\NotInterface the Not constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function notConstraint(\PHPCR\Query\QOM\ConstraintInterface $constraint);

    /**
     * Filters node-tuples based on the outcome of a binary operation.
     *
     * @param \PHPCR\Query\QOM\DynamicOperandInterface $operand1 the first
     *      operand; non-null
     * @param string $operator the operator; one of
     *      QueryObjectModelConstants.JCR_OPERATOR_*
     * @param \PHPCR\Query\QOM\StaticOperandInterface $operand2 the second
     *      operand; non-null
     *
     * @return \PHPCR\Query\QOM\ComparisonInterface the constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function comparison(\PHPCR\Query\QOM\DynamicOperandInterface $operand1, $operator,
                               \PHPCR\Query\QOM\StaticOperandInterface $operand2);

    /**
     * Tests the existence of a property in the specified or default selector.
     *
     * The query is invalid if:
     *
     * - $propertyName is not a syntactically valid JCR name
     * - $selectorName is not the name of a selector in the query
     *
     * @param string $propertyName the property name; non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\PropertyExistenceInterface the constraint;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function propertyExistence($propertyName, $selectorName = null);

    /**
     * Performs a full-text search against the specified or default selector.
     *
     * The query is invalid if:
     *
     * - $selectorName is not the name of a selector in the query
     * - $propertyName is specified but is not a syntactically valid JCR name
     * - $fullTextSearchExpression does not conform to the full text search
     *   grammar
     *
     * If $propertyName is specified but, for a node-tuple, the selector node
     * does not have a property named $propertyName, the query is valid but the
     * constraint is not satisfied.
     *
     * @param string $propertyName the property name, or null to search all
     *      full-text indexed properties of the node (or node subgraph, in some
     *      implementations);
     * @param string $fullTextSearchExpression the full-text search expression;
     *      non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\FullTextSearchInterface the constraint;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function fullTextSearch($propertyName, $fullTextSearchExpression, $selectorName = null);

    /**
     * Tests whether a node in the specified or default selector is reachable
     * by a specified absolute path.
     *
     * The query is invalid if:
     *
     * - $selectorName is not the name of a selector in the query
     * - $path is not a syntactically valid absolute path.
     *   <b>Note:</b>
     *   however, that if the path is syntactically valid but does not identify a
     *   node in the repository (or the node is not visible to this session,
     *   because of access control constraints), the query is valid but the
     *   constraint is not satisfied.
     *
     * @param string $path an absolute path; non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\SameNodeInterface the constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function sameNode($path, $selectorName = null);

    /**
     * Tests whether a node in the specified or default selector is a child of
     * a node reachable by a specified absolute path.
     *
     * The query is invalid if:
     *
     * - $selectorName is not the name of a selector in the query
     * - $path is not a syntactically valid absolute path
     *   <b>Note:</b>
     *   however, that if the path is syntactically valid but does not identify a
     *   node in the repository (or the node is not visible to this session,
     *   because of access control constraints), the query is valid but the
     *   constraint is not satisfied.
     *
     * @param string $path an absolute path; non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\ChildNodeInterface the constraint; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function childNode($path, $selectorName = null);

    /**
     * Tests whether a node in the specified or default selector is a
     * descendant of a node reachable by a specified absolute path.
     *
     * The query is invalid if:
     *
     * - $selectorName is not the name of a selector in the query
     * - $path is not a syntactically valid absolute path
     *   <b>Note:</b>
     *   however, that if the path is syntactically valid but does not identify a
     *   node in the repository (or the node is not visible to this session,
     *   because of access control constraints), the query is valid but the
     *   constraint is not satisfied.
     *
     * @param string $path an absolute path; non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\DescendantNodeInterface the constraint;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function descendantNode($path, $selectorName = null);

    /**
     * Evaluates to the value (or values, if multi-valued) of a property in the
     * specified or default selector.
     *
     * The query is invalid if:
     * - $selectorName is not the name of a selector in the query
     * - $propertyName is not a syntactically valid JCR name
     *
     * @param string $propertyName the property name; non-null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\PropertyValueInterface the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function propertyValue($propertyName, $selectorName = null);

    /**
     * Evaluates to the length (or lengths, if multi-valued) of a property.
     *
     * @param \PHPCR\Query\QOM\PropertyValueInterface $propertyValue the
     *      property value for which to compute the length; non-null
     *
     * @return \PHPCR\Query\QOM\LengthInterface the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function length(\PHPCR\Query\QOM\PropertyValueInterface $propertyValue);

    /**
     * Evaluates to a NAME value equal to the prefix-qualified name of a node
     * in the specified or default selector.
     *
     * The query is invalid if $selectorName is not the name of a selector in
     * the query.
     *
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\NodeNameInterface the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function nodeName($selectorName = null);

    /**
     * Evaluates to a NAME value equal to the local (unprefixed) name of a node
     * in the specified or default selector.
     *
     * The query is invalid if $selectorName is not the name of a selector in
     * the query.
     *
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\NodeLocalNameInterface the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function nodeLocalName($selectorName = null);

    /**
     * Evaluates to a DOUBLE value equal to the full-text search score of a
     * node in the specified or default selector.
     *
     * The query is invalid if $selectorName is not the name of a selector in
     * the query.
     *
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\FullTextSearchScoreInterface the operand;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function fullTextSearchScore($selectorName = null);

    /**
     * Evaluates to the lower-case string value (or values, if multi-valued) of an operand.
     *
     * @param \PHPCR\Query\QOM\DynamicOperandInterface $operand the operand
     *      whose value is converted to a lower-case string; non-null
     *
     * @return \PHPCR\Query\QOM\LowerCaseInterface the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function lowerCase(\PHPCR\Query\QOM\DynamicOperandInterface $operand);

    /**
     * Evaluates to the upper-case string value (or values, if multi-valued) of
     * an operand.
     *
     * @param \PHPCR\Query\QOM\DynamicOperandInterface $operand the operand
     *      whose value is converted to a upper-case string; non-null
     *
     * @return \PHPCR\Query\QOM\UpperCaseInterface the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function upperCase(\PHPCR\Query\QOM\DynamicOperandInterface $operand);

    /**
     * Evaluates to the value of a bind variable.
     *
     * The query is invalid if $bindVariableName is not a valid JCR prefix.
     *
     * @param string $bindVariableName the bind variable name; non-null
     *
     * @return \PHPCR\Query\QOM\BindVariableValueInterface the operand;
     *      non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function bindVariable($bindVariableName);

    /**
     * Evaluates to a literal value.
     *
     * The query is invalid if no value is bound to $literalValue.
     *
     * @param mixed $literalValue the value
     *
     * @return mixed the operand; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implemention chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function literal($literalValue);

    /**
     * Orders by the value of the specified operand, in ascending order.
     *
     * The query is invalid if $operand does not evaluate to a scalar value.
     *
     * @param \PHPCR\Query\QOM\DynamicOperandInterface $operand the operand by
     *      which to order; non-null
     *
     * @return \PHPCR\Query\QOM\OrderingInterface the ordering
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function ascending(\PHPCR\Query\QOM\DynamicOperandInterface $operand);

    /**
     * Orders by the value of the specified operand, in descending order.
     *
     * The query is invalid if $operand does not evaluate to a scalar value.
     *
     * @param \PHPCR\Query\QOM\DynamicOperandInterface $operand the operand by
     *      which to order; non-null
     *
     * @return \PHPCR\Query\QOM\OrderingInterface the ordering
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function descending(\PHPCR\Query\QOM\DynamicOperandInterface $operand);

    /**
     * Identifies a property in the specified or default selector to include in
     * the tabular view of query results.
     * The column name is the property name if not given.
     *
     * The query is invalid if:
     *
     * - $selectorName is not the name of a selector in the query
     * - $propertyName is specified but it is not a syntactically valid JCR name
     * - $propertyName is specified but does not evaluate to a scalar value
     * - $propertyName is specified but $columnName is omitted
     * - $propertyName is omitted but $columnName is specified
     * - the columns in the tabular view are not uniquely named, whether those
     *   column names are specified by $columnName (if $propertyName is
     *   specified) or generated as described above (if $propertyName is
     *   omitted).
     *
     * If $propertyName is specified but, for a node-tuple, the selector node
     * does not have a property named $propertyName, the query is valid and the
     * column has null value.
     *
     * @param string $propertyName the property name, or null to include a
     *      column for each single-value non-residual property of the
     *      selector's node type
     * @param string $columnName the column name; must be null if propertyName
     *      is null
     * @param string $selectorName the selector name; non-null
     *
     * @return \PHPCR\Query\QOM\ColumnInterface the column; non-null
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query has no default
     *      selector or is otherwise invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    function column($propertyName, $columnName = null, $selectorName = null);
}
