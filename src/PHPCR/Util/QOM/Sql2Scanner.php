<?php

namespace PHPCR\Util\QOM;

/**
 * Split an SQL2 statement into string tokens. Allows lookup and fetching of tokens.
 */
class Sql2Scanner
{
    /**
     * @var string
     */
    protected $sql2;

    /**
     * @var array
     */
    protected $tokens;

    /**
     * @var int
     */
    protected $curpos = 0;

    /**
     * Construct a scanner with the given SQL2 statement
     *
     * @param string $sql2 
     */
    public function __construct($sql2)
    {
        $this->sql2 = $sql2;
        $this->tokens = $this->scan($sql2);
    }

    /**
     * Get the next token without removing it from the queue. 
     * Return an empty string when there are no more tokens.
     *
     * @return string
     */
    public function lookupNextToken($offset = 0)
    {
        if ($this->curpos + $offset < count($this->tokens)) {
            return $this->tokens[$this->curpos + $offset];
        }
        return '';
    }

    /**
     * Get the next token and remove it from the queue. 
     * Return an empty string when there are no more tokens.
     *
     * @return string
     */
    public function fetchNextToken()
    {
        $token = $this->lookupNextToken();
        if ($token !== '') {
            $this->curpos += 1;
        }
        return $token;
    }

    /**
     * Expect the next token to be the given one and throw an exception if it's 
     * not the case. The equality test is done case sensitively/insensitively 
     * depending on the second parameter.
     *
     * @param string $token The expected token
     * @param boolean $case_insensitive 
     */
    public function expectToken($token, $case_insensitive = true)
    {
        $nextToken = $this->fetchNextToken();
        if (! $this->tokenIs($nextToken, $token, $case_insensitive)) {
            throw new \Exception("Syntax error: Expected $token, found $nextToken");
        }
    }

    /**
     * Expect the next tokens to be the one given in the array of tokens and 
     * throws an exception if it's not the case.
     * @see expectToken
     *
     * @param array $tokens
     * @param boolean $case_insensitive 
     */
    public function expectTokens($tokens, $case_insensitive = true)
    {
        foreach($tokens as $token) {
            $this->expectToken($token, $case_insensitive);
        }
    }

    /**
     * Test the equality of two tokens
     *
     * @param string $token
     * @param string $value
     * @param boolean $case_insensitive
     * @return boolean
     */
    public function tokenIs($token, $value, $case_insensitive = true)
    {
        if ($case_insensitive) {
            $test = strtoupper($token) === strtoupper($value);
        } else {
            $test = $token === $value;
        }
        return $test;
    }

    /**
     * Scan a SQL2 string a extract the tokens
     *
     * @param string $sql2
     * @return array
     */
    protected function scan($sql2)
    {
        $tokens = array();
        $token = strtok($sql2, ' ');
        while ($token !== false) {

            $this->tokenize($tokens, $token);
            $token = strtok(' ');
        }
        return $tokens;
    }

    /**
     * Tokenize a string returned by strtok to split the string at '.', ',', '(', '='
     * and ')' characters.
     *
     * @param array $tokens
     * @param string $token
     */
    protected function tokenize(&$tokens, $token)
    {
        $buffer = '';
        for ($i = 0; $i < strlen($token); $i++) {
            $char = substr($token, $i, 1);
            if (in_array($char, array('.', ',', '(', ')', '='))) {
                if ($buffer !== '') {
                    $tokens[] = $buffer;
                    $buffer = '';
                }
                $tokens[] = $char;
            } else {
                $buffer .= $char;
            }
        }

        if ($buffer !== '') {
            $tokens[] = $buffer;
        }
    }
}