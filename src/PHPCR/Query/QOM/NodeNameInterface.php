<?php

namespace PHPCR\Query\QOM;

/**
 * Evaluates to a NAME value equal to the namespace-qualified name of a node.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface NodeNameInterface extends DynamicOperandInterface
{
   /**
    * Gets the name of the selector against which to evaluate this operand.
    *
    * @return string the selector name
    *
    * @api
    */
   public function getSelectorName();
}
