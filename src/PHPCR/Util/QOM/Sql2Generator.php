<?php

namespace PHPCR\Util\QOM;

use PHPCR\Query\QOM;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;

/**
 * Generate SQL2 statements
 *
 * TODO: is eval... the best name for the functions here?
 */
class Sql2Generator
{
    /**
     * Query ::= 'SELECT' columns
     *     'FROM' Source
     *     ['WHERE' Constraint]
     *     ['ORDER BY' orderings]
     *
     * @param string $source
     * @param string $columns
     * @param string $constraint
     * @param string $ordering 
     * @return string
     */
    public function evalQuery($source, $columns, $constraint = '', $orderings = '')
    {
        $sql2 = "SELECT $columns FROM $source";

        if ($constraint) {
            $sql2 .= " WHERE $constraint";
        }

        if ($orderings) {
            $sql2 .= " ORDER BY $orderings";
        }

        return $sql2;
    }

    /**
     * Selector ::= nodeTypeName ['AS' selectorName]
     * nodeTypeName ::= Name
     * 
     * @param string $nodeTypeName The node type of the selector. If it does not contain starting and ending brackets ([]) they will be added automatically
     * @param string $selectorName
     * @return string 
     */
    public function evalSelector($nodeTypeName, $selectorName = null)
    {
        $sql2 = $nodeTypeName;
        if (substr($sql2, 0, 1) !== '[' && substr($sql2, -1) !== ']') {
            $sql2 = '[' . $sql2 . ']';
        }

        $name = $selectorName;
        if (! is_null($name)) {
            $sql2 .= ' AS ' . $name;
        }

        return $sql2;
    }

    /**
     * Join ::= left [JoinType] 'JOIN' right 'ON' JoinCondition
     *    // If JoinType is omitted INNER is assumed.
     * left ::= Source
     * right ::= Source
     * 
     * @param string $left
     * @param string $right
     * @param string $joinCondition
     * @param string $joinType
     * @return string 
     */
    public function evalJoin($left, $right, $joinCondition, $joinType = '')
    {
        return "$left {$joinType}JOIN $right ON $joinCondition";
    }

    /**
     * JoinType ::= Inner | LeftOuter | RightOuter
     * Inner ::= 'INNER'
     * LeftOuter ::= 'LEFT OUTER'
     * RightOuter ::= 'RIGHT OUTER'
     * 
     * @param string $joinType
     * @return string 
     */
    public function evalJoinType($joinType)
    {
        switch ($joinType) {
            case Constants::JCR_JOIN_TYPE_INNER:
                return 'INNER ';
            case Constants::JCR_JOIN_TYPE_LEFT_OUTER:
                return 'LEFT OUTER ';
            case Constants::JCR_JOIN_TYPE_RIGHT_OUTER:
                return 'RIGHT OUTER ';
        }

        return '';
    }

    /**
     * EquiJoinCondition ::= selector1Name'.'property1Name '='
     *                       selector2Name'.'property2Name
     *   selector1Name ::= selectorName
     *   selector2Name ::= selectorName
     *   property1Name ::= propertyName
     *   property2Name ::= propertyName
     *
     * @param string $sel1Name
     * @param string $prop1Name
     * @param string $sel2Name
     * @param string $prop2Name
     * @return string
     */
    public function evalEquiJoinCondition($sel1Name, $prop1Name, $sel2Name, $prop2Name)
    {
        return $sel1Name . '.' . $prop1Name . '=' . $sel2Name . '.' . $prop2Name;
    }

    /**
     * SameNodeJoinCondition ::=
     *   'ISSAMENODE(' selector1Name ','
     *                  selector2Name
     *                  [',' selector2Path] ')'
     *   selector2Path ::= Path
     *
     * @param string $sel1Name
     * @param string $sel2Name
     * @param string $sel2path
     * @return string
     */
    public function evalSameNodeJoinCondition($sel1Name, $sel2Name, $sel2Path = null)
    {
        $sql2 = "ISSAMENODE($sel1Name, $sel2Name";
        $sql2 .= ! is_null($sel2Path) ? ', ' . $sel2Path : '';
        $sql2 .= ')';

        return $sql2;
    }

    /**
     * ChildNodeJoinCondition ::=
     *   'ISCHILDNODE(' childSelectorName ','
     *                  parentSelectorName ')'
     *   childSelectorName ::= selectorName
     *   parentSelectorName ::= selectorName
     *
     * @param string $childSelectorName
     * @param string $parentSelectorName
     * @return string
     */
    public function evalChildNodeJoinCondition($childSelectorName, $parentSelectorName)
    {
        return "ISCHILDNODE($childSelectorName, $parentSelectorName)";
    }

    /**
     * DescendantNodeJoinCondition ::=
     *   'ISDESCENDANTNODE(' descendantSelectorName ','
     *                       ancestorSelectorName ')'
     *   descendantSelectorName ::= selectorName
     *   ancestorSelectorName ::= selectorName
     *
     * @param string $descendantSelectorName
     * @param string $ancestorselectorName
     * @return string
     */
    public function evalDescendantNodeJoinCondition($descendantSelectorName, $ancestorselectorName)
    {
        return "ISDESCENDANTNODE($descendantSelectorName, $ancestorselectorName)";
    }

    /**
     * And ::= constraint1 'AND' constraint2
     * 
     * @param string $constraint1
     * @param string $constraint2
     */
    public function evalAnd($constraint1, $constraint2)
    {
        return "$constraint1 AND $constraint2";
    }

    /**
     * Or ::= constraint1 'OR' constraint2
     *
     * @param string $constraint1
     * @param string $constraint2
     */
    public function evalOr($constraint1, $constraint2)
    {
        return "$constraint1 OR $constraint2";
    }

    /**
     * Not ::= 'NOT' Constraint
     *
     * @param string $constraint
     */
    public function evalNot($constraint)
    {
        return "NOT $constraint";
    }

    /**
     * SameNode ::= 'ISSAMENODE(' [selectorName ','] Path ')'
     *
     * @param string $path
     * @param string $selectorName 
     */
    public function evalSameNode($path, $selectorName = null)
    {
        $sql2 = 'ISSAMENODE(';
        $sql2 .= is_null($selectorName) ? $path : $selectorName . ', ' . $path;
        $sql2 .= ')';

        return $sql2;
    }

    /**
     * SameNode ::= 'ISCHILDNODE(' [selectorName ','] Path ')'
     *
     * @param string $path
     * @param string $selectorName 
     */
    public function evalChildNode($path, $selectorName = null)
    {
        $sql2 = 'ISCHILDNODE(';
        $sql2 .= is_null($selectorName) ? $path : $selectorName . ', ' . $path;
        $sql2 .= ')';

        return $sql2;
    }

    /**
     * SameNode ::= 'ISDESCENDANTNODE(' [selectorName ','] Path ')'
     *
     * @param string $path
     * @param string $selectorName 
     */
    public function evalDescendantNode($path, $selectorName = null)
    {
        $sql2 = 'ISDESCENDANTNODE(';
        $sql2 .= is_null($selectorName) ? $path : $selectorName . ', ' . $path;
        $sql2 .= ')';

        return $sql2;
    }

    /**
     * Comparison ::= DynamicOperand Operator StaticOperand
     *
     * @param string $operand1
     * @param string $operator
     * @param string $operand2 
     */
    public function evalComparison($operand1, $operator, $operand2)
    {
        return "$operand1 $operator $operand2";
    }

    /**
     * Operator ::= EqualTo | NotEqualTo | LessThan |
     *        LessThanOrEqualTo | GreaterThan |
     *        GreaterThanOrEqualTo | Like
     *
     * @param string $operator 
     */
    public function evalOperator($operator)
    {
        switch ($operator) {
            case Constants::JCR_OPERATOR_EQUAL_TO:
                return '=';
            case Constants::JCR_OPERATOR_GREATER_THAN:
                return '>';
            case Constants::JCR_OPERATOR_GREATER_THAN_OR_EQUAL_TO:
                return '>=';
            case Constants::JCR_OPERATOR_LESS_THAN:
                return '<';
            case Constants::JCR_OPERATOR_LESS_THAN_OR_EQUAL_TO:
                return '<=';
            case Constants::JCR_OPERATOR_LIKE:
                return 'LIKE';
            case Constants::JCR_OPERATOR_NOT_EQUAL_TO:
                return '<>';
        }

        return '';
    }

    public function evalPropertyExistence($selectorName, $propertyName)
    {
        return "$selectorName.$propertyName IS NOT NULL";
    }

    /**
     * FullTextSearch ::=
     *       'CONTAINS(' ([selectorName'.']propertyName |
     *                    selectorName'.*') ','
     *                    FullTextSearchExpression ')'
     * FullTextSearchExpression ::= BindVariable | ''' FullTextSearchLiteral '''
     *
     * @param \PHPCR\Query\QOM\FullTextSearchInterface $constraint 
     * @return string
     */
    public function evalFullTextSearch($selectorName, $searchExpression, $propertyName = null)
    {
        $sql2 = 'CONTAINS(';
        $sql2 .= is_null($propertyName) ? $selectorName . '.*' : $selectorName . '.' . $propertyName;
        $sql2 .= ', ' . $searchExpression . ')';

        return $sql2;
    }

    /**
     * Length ::= 'LENGTH(' PropertyValue ')'
     *
     * @param string $propertyValue
     * @return string 
     */
    public function evalLength($propertyValue)
    {
        return "LENGTH($propertyValue)";
    }

    /**
     * NodeName ::= 'NAME(' [selectorName] ')'
     *
     * @param string $selectorValue 
     */
    public function evalNodeName($selectorValue = null)
    {
        $selectorValue = is_null($selectorValue) ? '' : $selectorValue; 
        return "NAME($selectorValue)";
    }

    /**
     * NodeLocalName ::= 'LOCALNAME(' [selectorName] ')'
     *
     * @param string $selectorValue 
     */
    public function evalNodeLocalName($selectorValue = null)
    {
        $selectorValue = is_null($selectorValue) ? '' : $selectorValue; 
        return "LOCALNAME($selectorValue)";
    }

    /**
     * FullTextSearchScore ::= 'SCORE(' [selectorName] ')'
     *
     * @param string $selectorValue 
     */
    public function evalFullTextSearchScore($selectorValue = null)
    {
        $selectorValue = is_null($selectorValue) ? '' : $selectorValue; 
        return "SCORE($selectorValue)";
    }

    /**
     * LowerCase ::= 'LOWER(' DynamicOperand ')'
     *
     * @param string $operand
     */
    public function evalLower($operand)
    {
        return "LOWER($operand)";
    }

    /**
     * LowerCase ::= 'UPPER(' DynamicOperand ')'
     *
     * @param string $operand
     */
    public function evalUpper($operand)
    {
        return "UPPER($operand)";
    }

    /**
     * PropertyValue ::= [selectorName'.'] propertyName     // If only one selector exists
     *
     * @param string $propertyName
     * @param string $selectorName 
     */
    public function evalPropertyValue($propertyName, $selectorName = null)
    {
        $sql2 = ! is_null($selectorName) ? $selectorName . '.' : '';
        $sql2 .= $propertyName;
        return $sql2;
    }

    public function evalOrderings($orderings)
    {
        $sql2 = '';

        foreach ($orderings as $ordering) {

            if ($sql2 !== '') {
                $sql2 .= ', ';
            }

            $sql2 .= $ordering;
        }
        return $sql2;
    }

    public function evalOrdering($operand, $order)
    {
        return "$operand $order";
    }

    public function evalOrder($order)
    {
        switch ($order) {
            case Constants::JCR_ORDER_ASCENDING:
                return 'ASC';
            case Constants::JCR_ORDER_DESCENDING:
                return 'DESC';
        }
        return '';
    }

    public function evalColumns($columns)
    {
        if (count($columns) === 0) {
            return '*';
        }

        $sql2 = '';
        foreach ($columns as $column) {

            if ($sql2 !== '') {
                $sql2 .= ', ';
            }

            $sql2 .= $column;
        }

        return $sql2;
    }

    public function evalColumn($selector, $property = null, $colname = null)
    {
        $sql2 = '';
        if (! is_null($selector) && is_null($property) && is_null($colname)) {
            $sql2 .= $selector . '.*';
        } else {
            $sql2 .= ! is_null($selector) ? $selector . '.' : '';
            $sql2 .= $property;
            $sql2 .= ! is_null($colname) ? ' AS ' . $colname : '';
        }
        return $sql2;
    }

    /**
     *
     * @param string $path
     * @return string
     */
    public function evalPath($path)
    {
        if ($path) {
            $sql2 = $path;
            if (substr($path, 0,1) !== '[' && substr($path, -1) !== ']') {
                $sql2 = '[' . $sql2 . ']';
            }
            return $sql2;
        }
        return null;
    }

    public function evalBindVariable($var)
    {
        return '$' . $var;
    }

    public function evalLiteral($literal)
    {
        return "'$literal'";
    }
}
