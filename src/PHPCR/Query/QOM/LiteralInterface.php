<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to a literal value.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface LiteralInterface extends StaticOperandInterface
{
    /**
     * Gets the value of the literal.
     *
     * @return string the literal value
     *
     * @api
     */
    public function getLiteralValue();
}
