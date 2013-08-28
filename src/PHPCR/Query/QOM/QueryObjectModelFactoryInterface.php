<?php

namespace PHPCR\Query\QOM;

/**
 * A QueryObjectModelFactory creates instances of the JCR query object model.
 *
 * Refer to QueryObjectModelInterface for a description of the query object
 * model.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
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
     * @param SourceInterface          $source     the Selector or the node-tuple Source
     * @param ConstraintInterface|null $constraint the constraint, null to have no constraint
     * @param array                    $orderings  zero (empty array) or more instances of Ordering
     * @param array                    $columns    the array of Column definitions to return in the
     *                                             result. empty array is equivalent to the * in
     *                                             SQL2, meaning some fields.
     *
     * @return QueryObjectModelInterface the query
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test and the parameters given fail that test. See the
     *      individual QOM factory methods for the validity criteria of each
     *      query element.
     * @throws \PHPCR\RepositoryException if another error occurs.
     *
     * @api
     */
    public function createQuery(SourceInterface $source,
                         ConstraintInterface $constraint = null,
                         array $orderings = array(),
                         array $columns = array());

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
     * @param string $selectorName the selector name
     * @param string $nodeTypeName the name of the required node type
     *
     * @return SelectorInterface the selector
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function selector($selectorName, $nodeTypeName);

    /**
     * Performs a join between two node-tuple sources.
     *
     * The query is invalid if $left is the same source as $right.
     *
     * @param SourceInterface        $left          the left node-tuple source
     * @param SourceInterface        $right         the right node-tuple source
     * @param string                 $joinType      one of QueryObjectModelConstants.JCR_JOIN_TYPE_*
     * @param JoinConditionInterface $joinCondition the join condition
     *
     * @return JoinInterface the join
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function join(SourceInterface $left, SourceInterface $right,
                         $joinType, JoinConditionInterface $joinCondition);

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
     * @param string $selector1Name the name of the first selector
     * @param string $property1Name the property name in the first selector
     * @param string $selector2Name the name of the second selector
     * @param string $property2Name the property name in the second selector
     *
     * @return EquiJoinConditionInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function equiJoinCondition($selector1Name, $property1Name, $selector2Name, $property2Name);

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
     * @param string $selector1Name the name of the first selector
     * @param string $selector2Name the name of the second selector
     * @param string $selector2Path the path relative to the second selector
     *
     * @return SameNodeJoinConditionInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function sameNodeJoinCondition($selector1Name, $selector2Name, $selector2Path = null);

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
     * @param string $childSelectorName  the name of the child selector
     * @param string $parentSelectorName the name of the parent selector
     *
     * @return ChildNodeJoinConditionInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     *
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function childNodeJoinCondition($childSelectorName, $parentSelectorName);

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
     *      selector
     * @param string $ancestorSelectorName the name of the ancestor selector
     *
     * @return DescendantNodeJoinConditionInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function descendantNodeJoinCondition($descendantSelectorName, $ancestorSelectorName);

    /**
     * Performs a logical conjunction of two other constraints.
     *
     * @param ConstraintInterface $constraint1 the first constraint
     * @param ConstraintInterface $constraint2 the second constraint
     *
     * @return AndInterface the And constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function andConstraint(ConstraintInterface $constraint1,
                         ConstraintInterface $constraint2);

    /**
     * Performs a logical disjunction of two other constraints.
     *
     * @param ConstraintInterface $constraint1 the first constraint
     * @param ConstraintInterface $constraint2 the second constraint
     *
     * @return OrInterface the Or constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     *
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function orConstraint(ConstraintInterface $constraint1,
                        ConstraintInterface $constraint2);

    /**
     * Performs a logical negation of another constraint.
     *
     * @param ConstraintInterface $constraint the constraint to be negated
     *
     * @return NotInterface the Not constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function notConstraint(ConstraintInterface $constraint);

    /**
     * Filters node-tuples based on the outcome of a binary operation.
     *
     * @param DynamicOperandInterface $operand1 the first operand
     * @param string                  $operator the operator; one of QueryObjectModelConstants.JCR_OPERATOR_*
     * @param StaticOperandInterface  $operand2 the second operand
     *
     * @return \PHPCR\Query\QOM\ComparisonInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function comparison(DynamicOperandInterface $operand1, $operator,
                               StaticOperandInterface $operand2);

    /**
     * Tests the existence of a property in the specified or default selector.
     *
     * The query is invalid if:
     *
     * - $propertyName is not a syntactically valid JCR name
     * - $selectorName is not the name of a selector in the query
     *
     * @param string $selectorName the selector name
     * @param string $propertyName the property name
     *
     * @return PropertyExistenceInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function propertyExistence($selectorName, $propertyName);

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
     * @param string      $selectorName the selector name
     * @param string|null $propertyName the property name, or null to search all
     *      full-text indexed properties of the node (or node subgraph, in some
     *      implementations);
     * @param string $fullTextSearchExpression the full-text search expression
     *
     * @return FullTextSearchInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function fullTextSearch($selectorName, $propertyName, $fullTextSearchExpression);

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
     * @param string $selectorName the selector name
     * @param string $path         an absolute path
     *
     * @return \PHPCR\Query\QOM\SameNodeInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException         if the operation otherwise fails
     *
     * @api
     */
    public function sameNode($selectorName, $path);

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
     * @param string $selectorName the selector name
     * @param string $path         an absolute path
     *
     * @return \PHPCR\Query\QOM\ChildNodeInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function childNode($selectorName, $path);

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
     * @param string $selectorName the selector name
     * @param string $path         an absolute path
     *
     * @return DescendantNodeInterface the constraint
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function descendantNode($selectorName, $path);

    /**
     * Evaluates to the value (or values, if multi-valued) of a property in the
     * specified or default selector.
     *
     * The query is invalid if:
     * - $selectorName is not the name of a selector in the query
     * - $propertyName is not a syntactically valid JCR name
     *
     * @param string $selectorName the selector name
     * @param string $propertyName the property name
     *
     * @return PropertyValueInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException         if the operation otherwise fails
     *
     * @api
     */
    public function propertyValue($selectorName, $propertyName);

    /**
     * Evaluates to the length (or lengths, if multi-valued) of a property.
     *
     * @param PropertyValueInterface $propertyValue the property value for
     *      which to compute the length
     *
     * @return LengthInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function length(PropertyValueInterface $propertyValue);

    /**
     * Evaluates to a NAME value equal to the prefix-qualified name of a node
     * in the specified or default selector.
     *
     * The query is invalid if $selectorName is not the name of a selector in
     * the query.
     *
     * @param string $selectorName the selector name
     *
     * @return NodeNameInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function nodeName($selectorName);

    /**
     * Evaluates to a NAME value equal to the local (unprefixed) name of a node
     * in the specified or default selector.
     *
     * The query is invalid if $selectorName is not the name of a selector in
     * the query.
     *
     * @param string $selectorName the selector name
     *
     * @return NodeLocalNameInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException         if the operation otherwise fails
     *
     * @api
     */
    public function nodeLocalName($selectorName);

    /**
     * Evaluates to a DOUBLE value equal to the full-text search score of a
     * node in the specified or default selector.
     *
     * The query is invalid if $selectorName is not the name of a selector in
     * the query.
     *
     * @param string $selectorName the selector name
     *
     * @return FullTextSearchScoreInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function fullTextSearchScore($selectorName);

    /**
     * Evaluates to the lower-case string value (or values, if multi-valued) of
     * an operand.
     *
     * @param DynamicOperandInterface $operand the operand whose value is
     *      converted to a lower-case string
     *
     * @return LowerCaseInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function lowerCase(DynamicOperandInterface $operand);

    /**
     * Evaluates to the upper-case string value (or values, if multi-valued) of
     * an operand.
     *
     * @param DynamicOperandInterface $operand the operand whose value is
     *      converted to a upper-case string
     *
     * @return UpperCaseInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function upperCase(DynamicOperandInterface $operand);

    /**
     * Evaluates to the value of a bind variable.
     *
     * The query is invalid if $bindVariableName is not a valid JCR prefix.
     *
     * @param string $bindVariableName the bind variable name
     *
     * @return BindVariableValueInterface the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function bindVariable($bindVariableName);

    /**
     * Evaluates to a literal value.
     *
     * The query is invalid if no value is bound to $literalValue.
     *
     * @param mixed $literalValue the value
     *
     * @return mixed the operand
     *
     * @throws \PHPCR\Query\InvalidQueryException if a particular validity test
     *      is possible on this method, the implementation chooses to perform
     *      that test (and not leave it until later) on createQuery, and the
     *      parameters given fail that test
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function literal($literalValue);

    /**
     * Orders by the value of the specified operand, in ascending order.
     *
     * The query is invalid if $operand does not evaluate to a scalar value.
     *
     * @param DynamicOperandInterface $operand the operand by which to order
     *
     * @return OrderingInterface the ordering
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException         if the operation otherwise fails
     *
     * @api
     */
    public function ascending(DynamicOperandInterface $operand);

    /**
     * Orders by the value of the specified operand, in descending order.
     *
     * The query is invalid if $operand does not evaluate to a scalar value.
     *
     * @param DynamicOperandInterface $operand the operand by which to order
     *
     * @return OrderingInterface the ordering
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query is invalid
     * @throws \PHPCR\RepositoryException         if the operation otherwise fails
     *
     * @api
     */
    public function descending(DynamicOperandInterface $operand);

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
     * @param string      $selectorName the selector name
     * @param string|null $propertyName the property name, or null to include a
     *      column for each single-value non-residual property of the
     *      selector's node type
     * @param string|null $columnName   the column name; must be null if
     *      propertyName is null, otherwise must be the the column name for
     *      this property.
     *
     * @return ColumnInterface the column
     *
     * @throws \PHPCR\Query\InvalidQueryException if the query has no default
     *      selector or is otherwise invalid
     * @throws \PHPCR\RepositoryException if the operation otherwise fails
     *
     * @api
     */
    public function column($selectorName, $propertyName = null, $columnName = null);
}
