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
     * Parse an SQL2 query and return the corresponding Qom QueryObjectModel
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
                    $this->parseOrderings();
                    break;
                case 'ŴHERE':
                    // Constraint
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
            // TODO: JOIN...
        }

        return $selector;
    }

    /**
     * Parse an SQL2 selector and return a QOM\Selector
     *
     * @return \PHPCR\Query\QOM\SelectorInterface
     */
    protected function parseSelector()
    {
        $token = $this->scanner->fetchNextToken();
        if ($this->scanner->lookupNextToken() === 'AS') {
            $this->scanner->fetchNextToken();
            $nodeTypeName = $this->scanner->fetchNextToken();
            return $this->factory->selector($nodeTypeName, $token);
        }

        return $this->factory->selector($token);
    }

    /**
     * Parse an SQL2 join source and return a QOM\Join
     * 
     * @param string $leftSelector the left selector as it has been read by parseSource
     * return \PHPCR\Query\QOM\JoinInterface
     */
    protected function parseJoin($leftSelector)
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

        $this->scanner->expectToken('ON');

        $left = $this->factory->selector($leftSelector);
        $right = $this->factory->selector($this->scanner->fetchNextToken());
        $joinCondition = $this->parseJoinCondition();

        return $this->factory->join($left, $right, $joinType, $joinCondition);
    }

    /**
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
     * Parse an SQL2 equijoin condition and return a QOM\EquiJoinCondition
     *
     * @return \PHPCR\Query\QOM\EquiJoinConditionInterface
     */
    protected function parseEquiJoin()
    {
        throw new \Exception('Not implemented');
    }

    /**
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
     * Parse an SQL2 child node join condition and return a QOM\ChildNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\ChildNodeJoinConditionInterface
     */
    protected function parseChildNodeJoinCondition()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Parse an SQL2 descendant node join condition and return a QOM\DescendantNodeJoinCondition
     *
     * @return \PHPCR\Query\QOM\DescendantNodeJoinConditionInterface
     */
    protected function parseDescendantNodeJoinCondition()
    {
        throw new \Exception('Not implemented');
    }

    /**
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

    protected function parseOrderings()
    {
        throw new \Exception('Not implemented');
    }

    protected function parseOrdering()
    {
        throw new \Exception('Not implemented');
    }

    /**
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
