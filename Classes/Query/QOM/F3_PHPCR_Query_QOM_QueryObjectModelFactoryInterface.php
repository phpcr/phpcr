<?php
declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 */

/**
 * A QueryObjectModelFactory creates instances of the JCR query object model.
 *
 * Refer to QueryObjectModelInterface for a description of the query object model.
 *
 * @package PHPCR
 * @subpackage Query
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
interface F3_PHPCR_Query_QOM_QueryObjectModelFactoryInterface extends F3_PHPCR_Query_QOM_QueryObjectModelConstantsInterface {

	/**
	 * Creates a query with one or more selectors.
	 * If source is a selector, that selector is the default selector of the query. Otherwise the query does not have a default selector.
	 *
	 * @param mixed $source the Selector or the node-tuple Source; non-null
	 * @param F3_PHPCR_Query_QOM_ConstraintInterface $constraint the constraint, or null if none
	 * @param array $orderings zero or more orderings; null is equivalent to a zero-length array
	 * @param array $columns the columns; null is equivalent to a zero-length array
	 * @return F3_PHPCR_Query_QOM_QueryObjectModelInterface the query; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function createQuery($selectorOrSource, F3_PHPCR_Query_QOM_ConstraintInterface $constraint, array $orderings, array $columns);

	/**
	 * Selects a subset of the nodes in the repository based on node type.
	 *
	 * @param string $nodeTypeName the name of the required node type; non-null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_SelectorInterface the selector; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function selector($nodeTypeName, $selectorName = NULL);

	/**
	 * Performs a join between two node-tuple sources.
	 *
	 * @param F3_PHPCR_Query_QOM_SourceInterface $left the left node-tuple source; non-null
	 * @param F3_PHPCR_Query_QOM_SourceInterface $right the right node-tuple source; non-null
	 * @param integer $joinType either QueryObjectModelConstants.JOIN_TYPE_INNER, QueryObjectModelConstants.JOIN_TYPE_LEFT_OUTER, QueryObjectModelConstants.JOIN_TYPE_RIGHT_OUTER
	 * @param F3_PHPCR_Query_QOM_JoinConditionInterface $join Condition the join condition; non-null
	 * @return F3_PHPCR_Query_QOM_JoinInterface the join; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function join(F3_PHPCR_Query_QOM_SourceInterface $left, F3_PHPCR_Query_QOM_SourceInterface $right, $joinType, F3_PHPCR_Query_QOM_JoinConditionInterface $joinCondition);

	/**
	 * Tests whether the value of a property in a first selector is equal to the value of a property in a second selector.
	 *
	 * @param string $selector1Name the name of the first selector; non-null
	 * @param string $property1Name the property name in the first selector; non-null
	 * @param string $selector2Name the name of the second selector; non-null
	 * @param string $property2Name the property name in the second selector; non-null
	 * @return F3_PHPCR_Query_QOM_EquiJoinConditionInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function equiJoinCondition($selector1Name, $property1Name, $selector2Name, $property2Name);

	/**
	 * Tests whether a first selector's node is the same as a node identified by relative path from a second selector's node.
	 *
	 * @param string $selector1Name the name of the first selector; non-null
	 * @param string $selector2Name the name of the second selector; non-null
	 * @param string $selector2Path the path relative to the second selector; non-null
	 * @return F3_PHPCR_Query_QOM_SameNodeJoinConditionInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function sameNodeJoinCondition($selector1Name, $selector2Name, $selector2Path = NULL);

	/**
	 * Tests whether a first selector's node is a child of a second selector's node.
	 *
	 * @param string $childSelectorName the name of the child selector; non-null
	 * @param string $parentSelectorName the name of the parent selector; non-null
	 * @return F3_PHPCR_Query_QOM_ChildNodeJoinConditionInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function childNodeJoinCondition($childSelectorName, $parentSelectorName);

	/**
	 * Tests whether a first selector's node is a descendant of a second selector's node.
	 *
	 * @param string $descendantSelectorName the name of the descendant selector; non-null
	 * @param string $ancestorSelectorName the name of the ancestor selector; non-null
	 * @return F3_PHPCR_Query_QOM_DescendantNodeJoinConditionInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function descendantNodeJoinCondition($descendantSelectorName, $ancestorSelectorName);

	/**
	 * Performs a logical conjunction of two other constraints.
	 *
	 * @param F3_PHPCR_Query_QOM_ConstraintInterface $constraint1 the first constraint; non-null
	 * @param F3_PHPCR_Query_QOM_ConstraintInterface $constraint2 the second constraint; non-null
	 * @return F3_PHPCR_Query_QOM_AndInterface the And constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function _and(F3_PHPCR_Query_QOM_ConstraintInterface $constraint1, F3_PHPCR_Query_QOM_ConstraintInterface $constraint2);

	/**
	 * Performs a logical disjunction of two other constraints.
	 *
	 * @param F3_PHPCR_Query_QOM_ConstraintInterface $constraint1 the first constraint; non-null
	 * @param F3_PHPCR_Query_QOM_ConstraintInterface $constraint2 the second constraint; non-null
	 * @return F3_PHPCR_Query_QOM_OrInterface the Or constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function _or(F3_PHPCR_Query_QOM_ConstraintInterface $constraint1, F3_PHPCR_Query_QOM_ConstraintInterface $constraint2);

	/**
	 * Performs a logical negation of another constraint.
	 *
	 * @param F3_PHPCR_Query_QOM_ConstraintInterface $constraint the constraint to be negated; non-null
	 * @return F3_PHPCR_Query_QOM_NotInterface the Not constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function not(F3_PHPCR_Query_QOM_ConstraintInterface $constraint);

	/**
	 * Filters node-tuples based on the outcome of a binary operation.
	 *
	 * @param F3_PHPCR_Query_QOM_DynamicOperandInterface $operand1 the first operand; non-null
	 * @param integer $operator the operator; either QueryObjectModelConstants.OPERATOR_EQUAL_TO, QueryObjectModelConstants.OPERATOR_NOT_EQUAL_TO, QueryObjectModelConstants.OPERATOR_LESS_THAN, QueryObjectModelConstants.OPERATOR_LESS_THAN_OR_EQUAL_TO, QueryObjectModelConstants.OPERATOR_GREATER_THAN, QueryObjectModelConstants.OPERATOR_GREATER_THAN_OR_EQUAL_TO, or QueryObjectModelConstants.OPERATOR_LIKE
	 * @param F3_PHPCR_Query_QOM_StaticOperandInterface $operand2 the second operand; non-null
	 * @return F3_PHPCR_Query_QOM_ComparisonInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function comparison(F3_PHPCR_Query_QOM_DynamicOperandInterface $operand1, $operator, F3_PHPCR_Query_QOM_StaticOperandInterface $operand2);

	/**
	 * Tests the existence of a property in the specified or default selector.
	 *
	 * @param string $propertyName the property name; non-null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_PropertyExistenceInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function propertyExistence($propertyName, $selectorName = NULL);

	/**
	 * Performs a full-text search against the specified or default selector.
	 *
	 * @param string $propertyName the property name, or null to search all full-text indexed properties of the node (or node subtree, in some implementations);
	 * @param string $fullTextSearchExpression the full-text search expression; non-null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_FullTextSearchInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function fullTextSearch($propertyName, $fullTextSearchExpression, $selectorName = NULL);

	/**
	 * Tests whether a node in the specified or default selector is reachable by a specified absolute path.
	 *
	 * @param string $selectorName the selector name; non-null
	 * @param string $path an absolute path; non-null
	 * @return F3_PHPCR_Query_QOM_SameNodeInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function sameNode($path, $selectorName = NULL);

	/**
	 * Tests whether a node in the specified or default selector is a child of a node reachable by a specified absolute path.
	 *
	 * @param string $path an absolute path; non-null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_ChildNodeInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function childNode($path, $selectorName = NULL);

	/**
	 * Tests whether a node in the specified or default selector is a descendant of a node reachable by a specified absolute path.
	 *
	 * @param string $path an absolute path; non-null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_DescendantNodeInterface the constraint; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function descendantNode($path, $selectorName = NULL);

	/**
	 * Evaluates to the value (or values, if multi-valued) of a property in the specified or default selector.
	 *
	 * @param string $propertyName the property name; non-null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_PropertyValueInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function propertyValue($propertyName, $selectorName = NULL);

	/**
	 * Evaluates to the length (or lengths, if multi-valued) of a property.
	 *
	 * @param F3_PHPCR_Query_QOM_PropertyValueInterface $propertyValue the property value for which to compute the length; non-null
	 * @return F3_PHPCR_Query_QOM_LengthInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function length(F3_PHPCR_Query_QOM_PropertyValueInterface $propertyValue);

	/**
	 * Evaluates to a NAME value equal to the prefix-qualified name of a node in the specified or default selector.
	 *
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_NodeNameInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function nodeName($selectorName = NULL);

	/**
	 * Evaluates to a NAME value equal to the local (unprefixed) name of a node in the specified or default selector.
	 *
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_NodeLocalNameInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function nodeLocalName($selectorName = NULL);

	/**
	 * Evaluates to a DOUBLE value equal to the full-text search score of a node in the specified or default selector.
	 *
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_FullTextSearchScoreInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function fullTextSearchScore($selectorName = NULL);

	/**
	 * Evaluates to the lower-case string value (or values, if multi-valued) of an operand.
	 *
	 * @param F3_PHPCR_Query_QOM_DynamicOperandInterface $operand the operand whose value is converted to a lower-case string; non-null
	 * @return F3_PHPCR_Query_QOM_LowerCaseInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function lowerCase(F3_PHPCR_Query_QOM_DynamicOperandInterface $operand);

	/**
	 * Evaluates to the upper-case string value (or values, if multi-valued) of an operand.
	 *
	 * @param F3_PHPCR_Query_QOM_DynamicOperandInterface $operand the operand whose value is converted to a upper-case string; non-null
	 * @return F3_PHPCR_Query_QOM_UpperCaseInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function upperCase(F3_PHPCR_Query_QOM_DynamicOperandInterface $operand);

	/**
	 * Evaluates to the value of a bind variable.
	 *
	 * @param string $bindVariableName the bind variable name; non-null
	 * @return F3_PHPCR_Query_QOM_BindVariableValueInterface the operand; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function bindVariable($bindVariableName);

	/**
	 * Orders by the value of the specified operand, in ascending order.
	 *
	 * @param F3_PHPCR_Query_QOM_DynamicOperandInterface $operand the operand by which to order; non-null
	 * @return F3_PHPCR_Query_QOM_OrderingInterface the ordering
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function ascending(F3_PHPCR_Query_QOM_DynamicOperandInterface $operand);

	/**
	 * Orders by the value of the specified operand, in descending order.
	 *
	 * @param F3_PHPCR_Query_QOM_DynamicOperandInterface $operand the operand by which to order; non-null
	 * @return F3_PHPCR_Query_QOM_OrderingInterface the ordering
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query is invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function descending(F3_PHPCR_Query_QOM_DynamicOperandInterface $operand);

	/**
	 * Identifies a property in the specified or default selector to include in the tabular view of query results.
	 * The column name is the property name if not given.
	 *
	 * @param string $propertyName the property name, or null to include a column for each single-value non-residual property of the selector's node type
	 * @param string $columnName the column name; must be null if propertyName is null
	 * @param string $selectorName the selector name; non-null
	 * @return F3_PHPCR_Query_QOM_ColumnInterface the column; non-null
	 * @throws F3_PHPCR_Query_InvalidQueryException if the query has no default selector or is otherwise invalid
	 * @throws F3_PHPCR_RepositoryException if the operation otherwise fails
	 */
	public function column($propertyName, $columnName = NULL, $selectorName = NULL);

}

?>