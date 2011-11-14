<?php

namespace PHPCR\Util\QOM;

use PHPCR\Query\QOM;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;

/**
 * Convert a QOM query into an SQL2 statement
 */
class QomToSql2QueryConverter
{
    /**
     * @var \PHPCR\Util\QOM\Sql2Generator
     */
    protected $generator;

    public function __construct(Sql2Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Query ::= 'SELECT' columns
     *     'FROM' Source
     *     ['WHERE' Constraint]
     *     ['ORDER BY' orderings]
     *
     * @param \PHPCR\Query\QOM\QueryObjectModelInterface $query
     * @return string
     */
    public function convert(QOM\QueryObjectModelInterface $query)
    {
        $columns = $this->convertColumns($query->getColumns());
        $source = $this->convertSource($query->getSource());
        $constraint = '';
        $orderings = '';

        if ($query->getConstraint() !== null) {
            $constraint = $this->convertConstraint($query->getConstraint());
        }

        if (count($query->getOrderings())) {
            $orderings = $this->convertOrderings($query->getOrderings());
        }

        return $this->generator->evalQuery($source, $columns, $constraint, $orderings);
    }

    /**
     * Source ::= Selector | Join
     *
     * @param \PHPCR\Query\QOM\SourceInterface $source
     * @return string
     */
    protected function convertSource(QOM\SourceInterface $source)
    {
        if ($source instanceof QOM\SelectorInterface) {

            return $this->convertSelector($source);

        } elseif ($source instanceof QOM\JoinInterface) {

            return $this->convertJoin($source);
        }

        throw new \InvalidArgumentException("Invalid Source");
    }

    /**
     * Selector ::= nodeTypeName ['AS' selectorName]
     * nodeTypeName ::= Name
     *
     * @param \PHPCR\Query\QOM\SelectorInterface $selector
     * @return string
     */
    protected function convertSelector(QOM\SelectorInterface $selector)
    {
        return $this->generator->evalSelector($selector->getNodeTypeName(), $selector->getSelectorName());
    }

    /**
     * Join ::= left [JoinType] 'JOIN' right 'ON' JoinCondition
     *    // If JoinType is omitted INNER is assumed.
     * left ::= Source
     * right ::= Source
     *
     * JoinType ::= Inner | LeftOuter | RightOuter
     * Inner ::= 'INNER'
     * LeftOuter ::= 'LEFT OUTER'
     * RightOuter ::= 'RIGHT OUTER'
     * 
     * @param \PHPCR\Query\QOM\JoinInterface $join 
     * @return string 
     */
    protected function convertJoin(QOM\JoinInterface $join)
    {
        $left = $this->convertSource($join->getLeft());
        $right = $this->convertSource($join->getRight());
        $condition = $this->convertJoinCondition($join->getJoinCondition());
        return $this->generator->evalJoin($left, $right, $condition, $this->generator->evalJoinType($join->getJoinType()));
    }

    /**
     * JoinCondition ::= EquiJoinCondition |
     *             SameNodeJoinCondition |
     *             ChildNodeJoinCondition |
     *             DescendantNodeJoinCondition
     *
     * @param \PHPCR\Query\QOM\JoinConditionInterface $condition 
     * @return string
     */
    protected function convertJoinCondition(QOM\JoinConditionInterface $condition)
    {
        $sql2 = '';

        if ($condition instanceof QOM\EquiJoinConditionInterface)
        {
            $sql2 = $this->convertEquiJoinCondition($condition);
        }
        elseif ($condition instanceof QOM\SameNodeJoinConditionInterface)
        {
            $sql2 = $this->convertSameNodeJoinCondition($condition);
        }
        elseif ($condition instanceof QOM\ChildNodeJoinConditionInterface)
        {
            $sql2 = $this->convertChildNodeJoinCondition($condition);
        }
        elseif ($condition instanceof QOM\DescendantNodeJoinConditionInterface)
        {
            $sql2 = $this->convertDescendantNodeJoinCondition($condition);
        }
        else
        {
            // This should not happen, but who knows...
            throw new \InvalidArgumentException("Invalid operand");
        }

        return $sql2;
    }

    /**
     * EquiJoinCondition ::= selector1Name'.'property1Name '='
     *                       selector2Name'.'property2Name
     *   selector1Name ::= selectorName
     *   selector2Name ::= selectorName
     *   property1Name ::= propertyName
     *   property2Name ::= propertyName
     *
     * @param \PHPCR\Query\QOM\EquiJoinConditionInterface $condition 
     * @return string
     */
    protected function convertEquiJoinCondition(QOM\EquiJoinConditionInterface $condition)
    {
        return $this->generator->evalEquiJoinCondition(
            $condition->getSelector1Name(),
            $condition->getProperty1Name(),
            $condition->getSelector2Name(), 
            $condition->getProperty2Name());
    }

    /**
     * SameNodeJoinCondition ::=
     *   'ISSAMENODE(' selector1Name ','
     *                  selector2Name
     *                  [',' selector2Path] ')'
     *   selector2Path ::= Path
     *
     * @param \PHPCR\Query\QOM\SameNodeJoinConditionInterface $condition 
     * @return string
     */
    protected function convertSameNodeJoinCondition(QOM\SameNodeJoinConditionInterface $condition)
    {
        return $this->generator->evalSameNodeJoinCondition(
            $condition->getSelector1Name(),
            $condition->getSelector2Name(),
            ! is_null($condition->getSelector2Path()) ? $this->convertPath($condition->getSelector2Path()) : null);
    }

    /**
     * ChildNodeJoinCondition ::=
     *   'ISCHILDNODE(' childSelectorName ','
     *                  parentSelectorName ')'
     *   childSelectorName ::= selectorName
     *   parentSelectorName ::= selectorName
     *
     * @param \PHPCR\Query\QOM\ChildNodeJoinConditionInterface $condition 
     * @return string
     */
    protected function convertChildNodeJoinCondition(QOM\ChildNodeJoinConditionInterface $condition)
    {
        return $this->generator->evalChildNodeJoinCondition(
            $condition->getChildSelectorName(),
            $condition->getParentSelectorName());
    }

    /**
     * DescendantNodeJoinCondition ::=
     *   'ISDESCENDANTNODE(' descendantSelectorName ','
     *                       ancestorSelectorName ')'
     *   descendantSelectorName ::= selectorName
     *   ancestorSelectorName ::= selectorName
     *
     * @param \PHPCR\Query\QOM\DescendantNodeJoinConditionInterface $condition 
     * @return string
     */
    protected function convertDescendantNodeJoinCondition(QOM\DescendantNodeJoinConditionInterface $condition)
    {
        return $this->generator->evalDescendantNodeJoinCondition(
            $condition->getDescendantSelectorName(),
            $condition->getAncestorSelectorName());
    }

    /**
     * Constraint ::= And | Or | Not | Comparison |
     *          PropertyExistence | FullTextSearch |
     *          SameNode | ChildNode | DescendantNode
     *
     * And ::= constraint1 'AND' constraint2
     * Or ::= constraint1 'OR' constraint2
     * Not ::= 'NOT' Constraint
     *
     * SameNode ::= 'ISSAMENODE(' [selectorName ','] Path ')'
     *        // If only one selector exists in this query, explicit
     *           specification of the selectorName is optional
     * 
     * ChildNode ::= 'ISCHILDNODE(' [selectorName ','] Path ')'
     *        // If only one selector exists in this query, explicit
     *           specification of the selectorName is optional
     *
     * DescendantNode ::= 'ISDESCENDANTNODE(' [selectorName ','] Path ')'
     *        // If only one selector exists in this query, explicit
     *           specification of the selectorName is optional
     *
     * @param \PHPCR\Query\QOM\ConstraintInterface $constraint 
     * @return string
     */
    protected function convertConstraint(QOM\ConstraintInterface $constraint)
    {
        if ($constraint instanceof QOM\AndInterface)
        {
            return $this->generator->evalAnd(
                $this->convertConstraint($constraint->getConstraint1()),
                $this->convertConstraint($constraint->getConstraint2()));
        }
        elseif ($constraint instanceof QOM\OrInterface)
        {
            return $this->generator->evalOr(
                $this->convertConstraint($constraint->getConstraint1()),
                $this->convertConstraint($constraint->getConstraint2()));
        }
        elseif ($constraint instanceof QOM\NotInterface)
        {
            return $this->generator->evalNot($this->convertConstraint($constraint->getConstraint()));
        }
        elseif ($constraint instanceof QOM\ComparisonInterface)
        {
            return $this->convertComparison($constraint);
        }
        elseif ($constraint instanceof QOM\PropertyExistenceInterface)
        {
            return $this->convertPropertyExistence($constraint);
        }
        elseif ($constraint instanceof QOM\FullTextSearchInterface)
        {
            return $this->convertFullTextSearch($constraint);
        }
        elseif ($constraint instanceof QOM\SameNodeInterface)
        {
            return $this->generator->evalSameNode(
                $this->convertPath($constraint->getPath()),
                $constraint->getSelectorName());
        }
        elseif ($constraint instanceof QOM\ChildNodeInterface)
        {
            return $this->generator->evalChildNode(
                $this->convertPath($constraint->getParentPath()),
                $constraint->getSelectorName());
        }
        elseif ($constraint instanceof QOM\DescendantNodeInterface)
        {
            return $this->generator->evalDescendantNode(
                $this->convertPath($constraint->getAncestorPath()),
                $constraint->getSelectorName());
        }

        // This should not happen, but who knows...
        throw new \InvalidArgumentException("Invalid operand: " . get_class($constraint));
    }

    /**
     * Comparison ::= DynamicOperand Operator StaticOperand
     *
     * Operator ::= EqualTo | NotEqualTo | LessThan |
     *        LessThanOrEqualTo | GreaterThan |
     *        GreaterThanOrEqualTo | Like
     * EqualTo ::= '='
     * NotEqualTo ::= '<>'
     * LessThan ::= '<'
     * LessThanOrEqualTo ::= '<='
     * GreaterThan ::= '>'
     * GreaterThanOrEqualTo ::= '>='
     * Like ::= 'LIKE'
     *
     * @param \PHPCR\Query\QOM\ComparisonInterface $comparison 
     * @return string
     */
    protected function convertComparison(QOM\ComparisonInterface $comparison)
    {
        $operand1 = $this->convertDynamicOperand($comparison->getOperand1());
        $operand2 = $this->convertStaticOperand($comparison->getOperand2());
        $operator = $this->generator->evalOperator($comparison->getOperator());

        return $this->generator->evalComparison($operand1, $operator, $operand2);
    }

    /**
     * PropertyExistence ::=
     *   selectorName'.'propertyName 'IS NOT NULL' |
     *   propertyName 'IS NOT NULL'    If only one
     *                                 selector exists in
     *                                 this query
     *
     *   Note: The negation, 'NOT x IS NOT NULL'
     *      can be written 'x IS NULL'
     *
     * @param \PHPCR\Query\QOM\PropertyExistenceInterface $constraint 
     * @return string
     */
    protected function convertPropertyExistence(QOM\PropertyExistenceInterface $constraint)
    {
        return $this->generator->evalPropertyExistence(
            $constraint->getSelectorName(),
            $constraint->getPropertyName());
    }

    /**
     * FullTextSearch ::=
     *       'CONTAINS(' ([selectorName'.']propertyName |
     *                    selectorName'.*') ','
     *                    FullTextSearchExpression ')'
     *                      // If only one selector exists in this query,
     *                         explicit specification of the selectorName
     *                         preceding the propertyName is optional 
     *
     * @param \PHPCR\Query\QOM\FullTextSearchInterface $constraint 
     * @return string
     */
    protected function convertFullTextSearch(QOM\FullTextSearchInterface $constraint)
    {
        $searchExpression = $this->convertFullTextSearchExpression($constraint->getFullTextSearchExpression());
        return $this->generator->evalFullTextSearch($constraint->getSelectorName(), $searchExpression, $constraint->getPropertyName());
    }

    /**
     * FullTextSearchExpression ::= BindVariable | ''' FullTextSearchLiteral '''
     *
     * @param string $expr
     * @return string
     */
    protected function convertFullTextSearchExpression($literal)
    {
        if ($literal instanceof QOM\BindVariableValue)
        {
            return $this->convertBindVariable($literal);
        }
        elseif ($literal instanceof QOM\Literal)
        {
            return $this->convertLiteral($literal);
        }

        return "'$literal'";
    }

    /**
     * DynamicOperand ::= PropertyValue | Length | NodeName |
     *              NodeLocalName | FullTextSearchScore |
     *              LowerCase | UpperCase
     *
     * Length ::= 'LENGTH(' PropertyValue ')'
     * NodeName ::= 'NAME(' [selectorName] ')'              // If only one selector exists
     * NodeLocalName ::= 'LOCALNAME(' [selectorName] ')'    // If only one selector exists
     * FullTextSearchScore ::= 'SCORE(' [selectorName] ')'  // If only one selector exists
     * LowerCase ::= 'LOWER(' DynamicOperand ')'
     * UpperCase ::= 'UPPER(' DynamicOperand ')'
     *
     * @param \PHPCR\Query\QOM\DynamicOperandInterface $operand
     * @return string
     */
    protected function convertDynamicOperand(QOM\DynamicOperandInterface $operand)
    {
        if ($operand instanceof QOM\PropertyValueInterface)
        {
            return $this->convertPropertyValue($operand);
        }
        elseif ($operand instanceof QOM\LengthInterface)
        {
            return $this->generator->evalLength($this->convertPropertyValue($operand->getPropertyValue()));
        }
        elseif ($operand instanceof QOM\NodeNameInterface)
        {
            return $this->generator->evalNodeName($operand->getSelectorName());
        }
        elseif ($operand instanceof QOM\NodeLocalNameInterface)
        {
            return $this->generator->evalNodeLocalName($operand->getSelectorName());
        }
        elseif ($operand instanceof QOM\FullTextSearchScoreInterface)
        {
            return $this->generator->evalFullTextSearchScore($operand->getSelectorName());
        }
        elseif ($operand instanceof QOM\LowerCaseInterface)
        {
            $operand = $this->convertDynamicOperand($operand->getOperand());
            return $this->generator->evalLower($operand);
        }
        elseif ($operand instanceof QOM\UpperCaseInterface)
        {
            $operand = $this->convertDynamicOperand($operand->getOperand());
            return $this->generator->evalUpper($operand);
        }

        // This should not happen, but who knows...
        throw new \InvalidArgumentException("Invalid operand");
    }

    /**
     * PropertyValue ::= [selectorName'.'] propertyName     // If only one selector exists
     *
     * @param \PHPCR\Query\QOM\PropertyValueInterface $value 
     * @return string
     */
    protected function convertPropertyValue(QOM\PropertyValueInterface $operand)
    {
        return $this->generator->evalPropertyValue(
            $operand->getPropertyName(),
            $operand->getSelectorName());
    }

    /**
     * StaticOperand ::= Literal | BindVariableValue
     * 
     * Literal ::= CastLiteral | UncastLiteral
     * CastLiteral ::= 'CAST(' UncastLiteral ' AS ' PropertyType ')'
     *
     * PropertyType ::= 'STRING' | 'BINARY' | 'DATE' | 'LONG' | 'DOUBLE' |
     *                  'DECIMAL' | 'BOOLEAN' | 'NAME' | 'PATH' |
     *                  'REFERENCE' | 'WEAKREFERENCE' | 'URI'
     * UncastLiteral ::= UnquotedLiteral | ''' UnquotedLiteral ''' | '“' UnquotedLiteral '“'
     * UnquotedLiteral ::= // String form of a JCR Value
     *
     * BindVariableValue ::= '$'bindVariableName
     * bindVariableName ::= Prefix
     *
     * @param \PHPCR\Query\QOM\StaticOperandInterface $operand 
     * @return string
     */
    protected function convertStaticOperand(QOM\StaticOperandInterface $operand)
    {
        if ($operand instanceof QOM\BindVariableValueInterface)
        {
            return $this->convertBindVariable($operand->getBindVariableName());
        }
        elseif ($operand instanceof QOM\LiteralInterface)
        {
            return $this->convertLiteral($operand->getLiteralValue());
        }

        // This should not happen, but who knows...
        throw new \InvalidArgumentException("Invalid operand");
    }

    /**
     * orderings ::= Ordering {',' Ordering}
     * Ordering ::= DynamicOperand [Order]
     * Order ::= Ascending | Descending
     * Ascending ::= 'ASC'
     * Descending ::= 'DESC'
     *
     * @param array $orderings 
     * @return string
     */
    protected function convertOrderings(array $orderings)
    {
        $list = array(); 
        foreach ($orderings as $ordering) {

            $order = $this->generator->evalOrder($ordering->getOrder());
            $operand = $this->convertDynamicOperand($ordering->getOperand());
            $list[] = $this->generator->evalOrdering($operand, $order);
        }

        return $this->generator->evalOrderings($list);
    }

    /**
     * columns ::= (Column ',' {Column}) | '*'
     * Column ::= ([selectorName'.']propertyName
     *             ['AS' columnName]) |
     *            (selectorName'.*')    // If only one selector exists
     * selectorName ::= Name
     * propertyName ::= Name
     * columnName ::= Name
     * 
     * @param array $columns 
     * @return string
     */
    protected function convertColumns(array $columns)
    {
        $list = array();
        foreach ($columns as $column) {
            $selector = $column->getSelectorName();
            $property = $column->getPropertyName();
            $colname = $column->getColumnName();
            $list[] = $this->generator->evalColumn($selector, $property, $colname);
        }
        return $this->generator->evalColumns($list);
    }

    protected function convertPath($path)
    {
        return $this->generator->evalPath($path);
    }

    protected function convertBindVariable($var)
    {
        return $this->generator->evalBindVariable($var);
    }

    protected function convertLiteral($literal)
    {
        return $this->generator->evalLiteral($literal);
    }

}
