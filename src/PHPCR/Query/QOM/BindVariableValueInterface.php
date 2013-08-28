<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to the value of a bind variable.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface BindVariableValueInterface extends StaticOperandInterface
{
    /**
     * Gets the name of the bind variable.
     *
     * @return string the bind variable name
     *
     * @api
     */
    public function getBindVariableName();
}
