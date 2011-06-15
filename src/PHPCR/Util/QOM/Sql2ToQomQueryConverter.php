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
                    $this->scanner->expectToken('BY');
                    $orderings = $this->parseOrderings();
                    break;
                case 'WHERE':
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
            return $this->parseJoin();
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
            $nodeTypeName = $this->parseName();
            return $this->factory->selector($nodeTypeName, $token);
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
        $joinType = $this->parseJoinType();

        $this->scanner->expectToken('ON');

        $left = $this->factory->selector($leftSelector);
        $right = $this->factory->selector($this->scanner->fetchNextToken());
        $joinCondition = $this->parseJoinCondition();

        return $this->factory->join($left, $right, $joinType, $joinCondition);
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
                $this->scanner->expectToken('OUTER');
                $joinType = Constants::JCR_JOIN_TYPE_LEFT_OUTER;
                break;
            case 'RIGHT':
                $this->scanner->expectToken('OUTTER');
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
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.9 SameNodeJoinCondition
     * Parse an SQL2 same node join condition and return a QOM\SameNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\SameNodeJoinConditionInterface
     */
    protected function parseSameNodeJoinCondition()
    {
        $this->assertNextTokenIs('ISSAMENODE');

        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.10 ChildNodeJoinCondition
     * Parse an SQL2 child node join condition and return a QOM\ChildNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\ChildNodeJoinConditionInterface
     */
    protected function parseChildNodeJoinCondition()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.11 DescendantNodeJoinCondition
     * Parse an SQL2 descendant node join condition and return a QOM\DescendantNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\DescendantNodeJoinConditionInterface
     */
    protected function parseDescendantNodeJoinCondition()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.12 Constraint
     *
     * @return \PHPCR\Query\QOM\ConstraintInterface
     */
    protected function parseConstraint()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.13 And
     *
     * @return \PHPCR\Query\QOM\AndInterface
     */
    protected function parseAnd()
    {
        $c1 = $this->scanner->fetchNextToken();
        $this->expectToken('AND');
        $c2 = $this->scanner->fetchNextToken();
        return $this->factory->and($c1, $c2);
    }

    /**
     * 6.7.14 Or
     *
     * @return \PHPCR\Query\QOM\OrInterface
     */
    protected function parseOr()
    {
        $c1 = $this->scanner->fetchNextToken();
        $this->expectToken('OR');
        $c2 = $this->scanner->fetchNextToken();
        return $this->factory->_or($c1, $c2);
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
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.17 Operator
     *
     * @return \PHPCR\Query\QOM\OperatorInterface
     */
    protected function parseOperator()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.18 PropertyExistence
     *
     * @return \PHPCR\Query\QOM\PropertyExistenceInterface
     */
    protected function parsePropertyExistence()
    {
        throw new \Exception('Not implemented');
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
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.21 ChildNode
     */
    protected function parseChildNode()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.22 DescendantNode
     */
    protected function parseDescendantNode()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.23 Path
     */
    protected function parsePath()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 6.7.24 Operand
     */
    protected function parseOperand()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Parse an SQL2 static operand
     *
     * @return \PHPCR\Query\QOM\StaticOperandInterface
     */
    protected function parseStaticOperand()
    {
        $token = $this->scanner->lookupNextToken();
        if ($this->scanner->tokenIs($token, '$')) {
            return $this->parseBindVariable();
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

        $token = $this->scanner->fetchNextToken();
        if ($this->scanner->tokenIs($token, 'LENGTH'))
        {
            $this->scanner->expectToken('(');
            $val = $this->parsePropertyValue();
            $this->scanner->expectToken(')');
            return $this->factory->length($val);
        }
        elseif ($this->scanner->tokenIs($token, 'NAME'))
        {
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
            $this->scanner->expectToken('(');
            $op = $this->parseDynamicOperand();
            $this->scanner->expectToken(')');
            return $this->factory->lowerCase($op);
        }
        elseif ($this->scanner->tokenIs($token, 'UPPER'))
        {
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
            return $this->factory->propertyValue($this->fetchNextToken(), $token);
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
        if ($this->scanner->tokenIs($token, 'CAST')) 
        {
            // CAST does not seem to be implemented in PHPCR
            throw new \Exception('Not implemented');
        }
        elseif ($token === '\'' || $token === '"')
        {
            // TODO: maybe the parsing of string should be moved to the scanner
            $delimiter = $token;
            $buffer = '';
            $token = $this->scanner->fetchNextToken();
            while ($token !== $delimiter) {
                if ($token === '') {
                    throw new \Exception("Unterminated string");
                }
                if ($buffer !== '') {
                    // TODO: here we loose the real delimiter, if any
                    $buffer .= ' ';
                }
                $buffer .= $token;
            }
            return $this->factory->literal($buffer);
        }
        return $this->scanner->fetchNextToken();
    }

    /**
     * 6.7.35 BindVariable
     * 6.7.36 Prefix
     * Parse an SQL2 bind variable
     *
     * @return \PHPCR\Query\QOM\BindVariableInterface
     */
    protected function parseBindVariable()
    {
        $this->scanner->expectToken('$');
        $token = $this->scanner-fetchNextToken();
        return $this->factory->bindVariable($token);
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
