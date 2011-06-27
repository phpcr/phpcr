<?php

namespace PHPCR\Util\QOM;

use PHPCR\Query\QOM;
use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;

/**
 * Parse SQL2 statements and output a corresponding QOM objects tree
 * 
 * TODO: finish implementation
 */
class Sql2ToQomQueryConverter
{
    /**
     * @var \PHPCR\Query\QOM\QueryObjectModelFactoryInterface
     */
    protected $factory;

    /**
     * @var \PHPCR\Query\QOM\Sql2Converter\Scanner;
     */
    protected $scanner;

    public function __construct(QOM\QueryObjectModelFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * 6.7.1. Query
     * Parse an SQL2 query and return the corresponding QOM QueryObjectModel
     *
     * @param string $sql2
     * @return \PHPCR\Query\QOM\QueryObjectModelInterface;
     */
    public function parse($sql2)
    {
        $this->scanner = new Sql2Scanner($sql2);
        $source = null;
        $columns = array();
        $constraint = null;
        $orderings = array();

        while($this->scanner->lookupNextToken() !== '') {

            switch(strtoupper($this->scanner->lookupNextToken())) {
                case 'FROM':
                    $source = $this->parseSource();
                    break;
                case 'SELECT':
                    $columns = $this->parseColumns();
                    break;
                case 'ORDER':
                    // Ordering, check there is a BY
                    $this->scanner->expectTokens(array('ORDER', 'BY'));
                    $orderings = $this->parseOrderings();
                    break;
                case 'WHERE':
                    $this->scanner->expectToken('WHERE');
                    $constraint = $this->parseConstraint();
                    break;
                default:
                    // Exit loop for debugging
                    break(2);
            }
        }

        $query = $this->factory->createQuery($source, $constraint, $orderings, $columns);;

        return $query;
    }

    /**
     * 6.7.2. Source
     * Parse an SQL2 source definition and return the corresponding QOM Source
     *
     * @return \PHPCR\Query\QOM\SourceInterface
     */
    protected function parseSource()
    {
        $this->scanner->expectToken('FROM');

        $selector = $this->parseSelector();

        $next = $this->scanner->lookupNextToken();
        if (in_array(strtoupper($next), array('JOIN', 'INNER', 'RIGHT', 'LEFT'))) {
            return $this->parseJoin($selector);
        }

        return $selector;
    }

    /**
     * 6.7.3. Selector
     * Parse an SQL2 selector and return a QOM\Selector
     *
     * @return \PHPCR\Query\QOM\SelectorInterface
     */
    protected function parseSelector()
    {
        $token = $this->scanner->fetchNextToken();
        if ($this->scanner->lookupNextToken() === 'AS') {
            $this->scanner->fetchNextToken(); // Consume the AS
            $selectorName = $this->parseName();
            return $this->factory->selector($token, $selectorName);
        }

        return $this->factory->selector($token);
    }

    /**
     * 6.7.4. Name
     * 
     * @return string
     */
    protected function parseName()
    {
        // TODO: check it's the correct way to parse a JCR name
        return $this->scanner->fetchNextToken();
    }

    /**
     * 6.7.5. Join
     * 6.7.6. Join type
     * Parse an SQL2 join source and return a QOM\Join
     * 
     * @param string $leftSelector the left selector as it has been read by parseSource
     * return \PHPCR\Query\QOM\JoinInterface
     */
    protected function parseJoin($leftSelector)
    {
        // TODO: check everything is correct
        $joinType = $this->parseJoinType();
        $right = $this->parseSelector();
        $joinCondition = $this->parseJoinCondition();

        return $this->factory->join($leftSelector, $right, $joinType, $joinCondition);
    }

    /**
     * 6.7.6. Join type
     *
     * @return string
     */
    protected function parseJoinType()
    {
        $joinType = Constants::JCR_JOIN_TYPE_INNER;
        $token = $this->scanner->fetchNextToken();

        switch ($token) {
            case 'JOIN':
                // Token already fetched, nothing to do
                break;
            case 'INNER':
                $this->scanner->fetchNextToken();
                break;
            case 'LEFT':
                $this->scanner->expectTokens(array('OUTER', 'JOIN'));
                $joinType = Constants::JCR_JOIN_TYPE_LEFT_OUTER;
                break;
            case 'RIGHT':
                $this->scanner->expectTokens(array('OUTER', 'JOIN'));
                $joinType = Constants::JCR_JOIN_TYPE_RIGHT_OUTER;
                break;
            default:
                throw new \Exception('Syntax error: Expected JOIN, INNER JOIN, RIGHT JOIN or LEFT JOIN');
        }

        return $joinType;
    }

    /**
     * 6.7.7. JoinCondition
     * Parse an SQL2 join condition and return a QOM\Joincondition
     *
     * @return \PHPCR\Query\QOM\JoinConditionInterface
     */
    protected function parseJoinCondition()
    {
        $this->scanner->expectToken('ON');

        $token = $this->scanner->lookupNextToken();
        if ($this->scanner->tokenIs($token, 'ISSAMENODE')) {

            return $this->parseSameNodeJoinCondition();

        } elseif ($this->scanner->tokenIs($token, 'ISCHILDNODE')) {

            return $this->parseChildNodeJoinCondition();

        } elseif ($this->scanner->tokenIs($token, 'ISDESCENDANTNODE')) {

            return $this->parseDescendantNodeJoinCondition();
        }

        return $this->parseEquiJoin();
    }

    /**
     * 6.7.8. EquiJoinCondition
     * Parse an SQL2 equijoin condition and return a QOM\EquiJoinCondition
     *
     * @return \PHPCR\Query\QOM\EquiJoinConditionInterface
     */
    protected function parseEquiJoin()
    {
        $selector1 = $this->scanner->fetchNextToken();
        $this->scanner->expectToken('.');
        $prop1 = $this->scanner->fetchNextToken();
        $this->scanner->expectToken('=');
        $selector2 = $this->scanner->fetchNextToken();
        $this->scanner->expectToken('.');
        $prop2 = $this->scanner->fetchNextToken();

        return $this->factory->equiJoinCondition($selector1, $prop1, $selector2, $prop2);
    }

    /**
     * 6.7.9 SameNodeJoinCondition
     * Parse an SQL2 same node join condition and return a QOM\SameNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\SameNodeJoinConditionInterface
     */
    protected function parseSameNodeJoinCondition()
    {
        $path = null;
        $this->scanner->expectTokens(array('ISSAMENODE', '('));
        $selector1 = $this->scanner->fetchNextToken();
        $this->scanner->expectToken(',');
        $selector2 = $this->scanner->fetchNextToken();

        $token = $this->scanner->lookupNextToken();
        if ($this->scanner->tokenIs($token, ',')) {
            $this->scanner->fetchNextToken(); // consume the coma
            $path = $this->scanner->fetchNextToken();
        }
        $this->scanner->expectToken(')');

        return $this->factory->sameNodeJoinCondition($selector1, $selector2, $path);
    }

    /**
     * 6.7.10 ChildNodeJoinCondition
     * Parse an SQL2 child node join condition and return a QOM\ChildNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\ChildNodeJoinConditionInterface
     */
    protected function parseChildNodeJoinCondition()
    {
        $this->scanner->expectTokens(array('ISCHILDNODE', '('));
        $child = $this->scanner->fetchNextToken();
        $this->scanner->expectToken(',');
        $parent = $this->scanner->fetchNextToken();
        $this->scanner->expectToken(')');

        return $this->factory->childNodeJoinCondition($child, $parent);
    }

    /**
     * 6.7.11 DescendantNodeJoinCondition
     * Parse an SQL2 descendant node join condition and return a QOM\DescendantNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\DescendantNodeJoinConditionInterface
     */
    protected function parseDescendantNodeJoinCondition()
    {
        $this->scanner->expectTokens(array('ISDESCENDANTNODE', '('));
        $child = $this->scanner->fetchNextToken();
        $this->scanner->expectToken(',');
        $parent = $this->scanner->fetchNextToken();
        $this->scanner->expectToken(')');

        return $this->factory->descendantNodeJoinCondition($child, $parent);
    }

    /**
     * 6.7.12 Constraint
     * 6.7.13 And
     * 6.7.14 Or
     *
     * @return \PHPCR\Query\QOM\ConstraintInterface
     */
    protected function parseConstraint()
    {
        $constraint = null;
        $token = $this->scanner->lookupNextToken();

        if ($this->scanner->tokenIs($token, 'NOT')) {
            // NOT
            $constraint = $this->parseNot();
        } elseif ($this->scanner->tokenIs($token, '(')) {
            // Grouping with parenthesis
            $this->scanner->expectToken('(');
            $constraint = $this->parseConstraint();
            $this->scanner->expectToken(')');
        } elseif ($this->scanner->tokenIs($token, 'CONTAINS')) {
            // Full Text Search
            $constraint = $this->parseFullTextSearch();
        } elseif ($this->scanner->tokenIs($token, 'ISSAMENODE')) {
            // SameNode
            $constraint = $this->parseSameNode();
        } elseif ($this->scanner->tokenIs($token, 'ISCHILDNODE')) {
            // ChildNode
            $constraint = $this->parseChildNode();
        } elseif ($this->scanner->tokenIs($token, 'ISDESCENDANTNODE')) {
            // DescendantNode
            $constraint = $this->parseDescendantNode();
        } else {
            // Is it a property existence?
            $next1 = $this->scanner->lookupNextToken(1);
            if ($this->scanner->tokenIs($next1, 'IS')) {
                $constraint = $this->parsePropertyExistence();
            } elseif ($this->scanner->tokenIs($next1, '.')) {
                $next2 = $this->scanner->lookupNextToken(3);
                if ($this->scanner->tokenIs($next2, 'IS')) {
                    $constraint = $this->parsePropertyExistence();
                }
            }

            if ($constraint === null) {
               // It's not a property existence neither, then it's a comparison
               $constraint = $this->parseComparison();
            }
        }

        // No constraint read, 
        if ($constraint === null) {
            throw new \Exception("Syntax error: constraint expected");
        }

        // Is it a composed contraint?
        $token = $this->scanner->lookupNextToken();
        if (in_array(strtoupper($token), array('AND', 'OR'))) {
            $this->scanner->fetchNextToken();
            $constraint2 = $this->parseConstraint();
            if ($this->scanner->tokenIs($token, 'AND')) {
                return $this->factory->_and($constraint, $constraint2);
            } else {
                return $this->factory->_or($constraint, $constraint2);
            }
        }

        return $constraint;
    }

    /**
     * 6.7.15 Not
     *
     * @return \PHPCR\Query\QOM\NotInterface
     */
    protected function parseNot()
    {
        $this->scanner->expectToken('NOT');
        return $this->factory->not($this->parseConstraint());
    }

    /**
     * 6.7.16 Comparison
     *
     * @return \PHPCR\Query\QOM\ComparisonInterface
     */
    protected function parseComparison()
    {
        $op1 = $this->parseDynamicOperand();

        if (is_null($op1)) {
            throw new \Exception("Syntax error: dynamic operator expected");
        }

        $operator = $this->parseOperator();
        $op2 = $this->parseStaticOperand();

        return $this->factory->comparison($op1, $operator, $op2);
    }

    /**
     * 6.7.17 Operator
     *
     * @return \PHPCR\Query\QOM\OperatorInterface
     */
    protected function parseOperator()
    {
        $token = $this->scanner->fetchNextToken();
        switch (strtoupper($token)) {
            case '=':
                return Constants::JCR_OPERATOR_EQUAL_TO;
            case '<>':
                return Constants::JCR_OPERATOR_NOT_EQUAL_TO;
            case '<':
                return Constants::JCR_OPERATOR_LESS_THAN;
            case '<=':
                return Constants::JCR_OPERATOR_LESS_THAN_OR_EQUAL_TO;
            case '>':
                return Constants::JCR_OPERATOR_GREATER_THAN;
            case '>=':
                return Constants::JCR_OPERATOR_GREATER_THAN_OR_EQUAL_TO;
            case 'LIKE':
                return Constants::JCR_OPERATOR_LIKE;
            default:
                throw new \Exception("Syntax error: operator expected");
        }
    }

    /**
     * 6.7.18 PropertyExistence
     *
     * @return \PHPCR\Query\QOM\PropertyExistenceInterface
     */
    protected function parsePropertyExistence()
    {
        $prop = $this->scanner->fetchNextToken();
        $selector = null;
        $token = $this->scanner->lookupNextToken();
        if ($this->scanner->tokenIs($token, '.')) {
            $this->scanner->expectToken('.');
            $selector = $prop;
            $prop = $this->scanner->fetchNextToken();
        }

        $this->scanner->expectToken('IS');
        $token = $this->scanner->lookupNextToken();
        if ($this->scanner->tokenIs($token, 'NULL')) {
            $this->scanner->fetchNextToken();
            return $this->factory->not($this->factory->propertyExistence($prop, $selector));
        }

        $this->scanner->expectTokens(array('NOT', 'NULL'));

        return $this->factory->propertyExistence($prop, $selector);
    }

    /**
     * 6.7.19 FullTextSearch
     *
     * @return \PHPCR\Query\QOM\FullTextSearchInterface
     */
    protected function parseFullTextSearch()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.20 SameNode
     */
    protected function parseSameNode()
    {
        $this->scanner->expectTokens(array('ISSAMENODE', '('));
        $selector = null;
        $path = $this->scanner->fetchNextToken();
        if ($this->scanner->tokenIs($this->scanner->lookupNextToken(), ',')) {
            $selector = $path;
            $this->scanner->expectToken(',');
            $path = $this->scanner->fetchNextToken();
        }
        $this->scanner->expectToken(')');
        return $this->factory->sameNode($path, $selector);
    }

    /**
     * 6.7.21 ChildNode
     */
    protected function parseChildNode()
    {
        $this->scanner->expectTokens(array('ISCHILDNODE', '('));
        $selector = null;
        $path = $this->scanner->fetchNextToken();
        if ($this->scanner->tokenIs($this->scanner->lookupNextToken(), ',')) {
            $selector = $path;
            $this->scanner->expectToken(',');
            $path = $this->scanner->fetchNextToken();
        }
        $this->scanner->expectToken(')');
        return $this->factory->childNode($path, $selector);
    }

    /**
     * 6.7.22 DescendantNode
     */
    protected function parseDescendantNode()
    {
        $this->scanner->expectTokens(array('ISDESCENDANTNODE', '('));
        $selector = null;
        $path = $this->scanner->fetchNextToken();
        if ($this->scanner->tokenIs($this->scanner->lookupNextToken(), ',')) {
            $selector = $path;
            $this->scanner->expectToken(',');
            $path = $this->scanner->fetchNextToken();
        }
        $this->scanner->expectToken(')');
        return $this->factory->descendantNode($path, $selector);
    }

    /**
     * Parse an SQL2 static operand
     * 6.7.35 BindVariable
     * 6.7.36 Prefix
     *
     * @return \PHPCR\Query\QOM\StaticOperandInterface
     */
    protected function parseStaticOperand()
    {
        $token = $this->scanner->lookupNextToken();
        if (substr($token, 0, 1) === '$') {
            return $this->factory->bindVariable(substr($token, 1));
        }
        return $this->parseLiteral();
    }

    /**
     * 6.7.26 DynamicOperand
     * 6.7.28 Length
     * 6.7.29 NodeName
     * 6.7.30 NodeLocalName
     * 6.7.31 FullTextSearchScore
     * 6.7.32 LowerCase
     * 6.7.33 UpperCase
     * Parse an SQL2 dynamic operand
     *
     * @return \PHPCR\Query\QOM\DynamicOperandInterface
     */
    protected function parseDynamicOperand()
    {

        $token = $this->scanner->lookupNextToken();
        if ($this->scanner->tokenIs($token, 'LENGTH'))
        {
            $this->scanner->fetchNextToken();
            $this->scanner->expectToken('(');
            $val = $this->parsePropertyValue();
            $this->scanner->expectToken(')');
            return $this->factory->length($val);
        }
        elseif ($this->scanner->tokenIs($token, 'NAME'))
        {
            $this->scanner->fetchNextToken();
            $this->scanner->expectToken('(');

            $token = $this->scanner->fetchNextToken();
            if ($this->scanner->tokenIs($token, ')')) {
                return $this->factory->nodeName();
            }

            $this->scanner->expectToken(')');
            return $this->factory->nodeName($token);
        }
        elseif ($this->scanner->tokenIs($token, 'LOCALNAME'))
        {
            $this->scanner->fetchNextToken();
            $this->scanner->expectToken('(');

            $token = $this->scanner->fetchNextToken();
            if ($this->scanner->tokenIs($token, ')')) {
                return $this->factory->nodeLocalName();
            }

            $this->scanner->expectToken(')');
            return $this->factory->nodeLocalName($token);
        }
        elseif ($this->scanner->tokenIs($token, 'SCORE'))
        {
            $this->scanner->fetchNextToken();
            $this->scanner->expectToken('(');

            $token = $this->scanner->fetchNextToken();
            if ($this->scanner->tokenIs($token, ')')) {
                return $this->factory->fullTextSearchScore();
            }

            $this->scanner->expectToken(')');
            return $this->factory->fullTextSearchScore($token);
        }
        elseif ($this->scanner->tokenIs($token, 'LOWER'))
        {
            $this->scanner->fetchNextToken();
            $this->scanner->expectToken('(');
            $op = $this->parseDynamicOperand();
            $this->scanner->expectToken(')');
            return $this->factory->lowerCase($op);
        }
        elseif ($this->scanner->tokenIs($token, 'UPPER'))
        {
            $this->scanner->fetchNextToken();
            $this->scanner->expectToken('(');
            $op = $this->parseDynamicOperand();
            $this->scanner->expectToken(')');
            return $this->factory->upperCase($op);
        }

        return $this->parsePropertyValue();
    }

    /**
     * 6.7.27 PropertyValue
     * Parse an SQL2 property value
     *
     * @return \PHPCR\Query\QOM\PropertyValueInterface
     */
    protected function parsePropertyValue()
    {
        $token = $this->scanner->fetchNextToken();
        if ($this->scanner->lookupNextToken() === '.') {
            $this->scanner->fetchNextToken();
            return $this->factory->propertyValue($this->scanner->fetchNextToken(), $token);
        }
        return $this->factory->propertyValue($token);
    }

    /**
     * 6.7.34 Literal
     * Parse an SQL2 literal value
     *
     * @return \PHPCR\Query\QOM\LiteralInterface
     */
    protected function parseLiteral()
    {
        $token = $this->scanner->fetchNextToken();
        if (substr($token, 0, 1) === '\'') {
            if (substr($token, -1) !== '\'') {
                throw new \Exception("Syntax error: unterminated string");
            }
            $token = substr($token, 1, strlen($token) - 2);
        }
        return $this->factory->literal($token);
    }

    /**
     * 6.7.37 Ordering
     */
    protected function parseOrderings()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.38 Order
     */
    protected function parseOrdering()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.39 Column
     * Parse an SQL2 columns definition and return an array of QOM\Column
     *
     * @return array of array
     */
    protected function parseColumns()
    {
        $this->scanner->expectToken('SELECT');

        // Wildcard
        if ($this->scanner->lookupNextToken() === '*') {
            $this->scanner->fetchNextToken();
            return array();
        }

        $columns = array();
        $hasNext = true;

        // Column list
        while ($hasNext) {

            $columns[] = $this->parseColumn();

            // Are there more columns?
            if ($this->scanner->lookupNextToken() !== ',') {
                $hasNext = false;
            } else {
                $this->scanner->fetchNextToken();
            }

        }

        return $columns;
    }

    /**
     * Parse a single SQL2 column definition and return a QOM\Column
     *
     * @return \PHPCR\Query\QOM\ColumnInterface
     */
    protected function parseColumn()
    {
        $propertyName = '';
        $columnName = null;
        $selectorName = null;

        $token = $this->scanner->fetchNextToken();

        // selector.property
        if ($this->scanner->lookupNextToken() !== '.') {
            $propertyName = $token;
        } else {
            $selectorName = $token;
            $this->scanner->fetchNextToken(); // Consume the '.'
            $propertyName = $this->scanner->fetchNextToken();
        }

        // AS name
        if (strtoupper($this->scanner->lookupNextToken()) === 'AS') {
            $this->scanner->fetchNextToken();
            $columnName = $this->scanner->fetchNextToken();
        }

        return $this->factory->column($propertyName, $columnName, $selectorName);
    }
}
