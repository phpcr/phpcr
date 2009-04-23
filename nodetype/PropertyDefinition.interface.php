<?php
// $Id$
/**
 * This file contains {@link PropertyDefinition} which is part of the PHP Content 
 * Repository (phpCR), a derivative of the Java Content Repository JSR-170,  
 * and is licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation 
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, 
 *    Version 2.0
 * @package phpContentRepository
 * @package NodeTypes
 */

/**
 * A {@link Property} definition. Used in {@link Node} type definitions.
 *
 * @package phpContentRepository
 * @package NodeTypes
 */
interface phpCR_PropertyDefinition 
{
	/**
	 * Gets the required type of the {@link Property}. One of:
	 * <ul>
	 *   <li>{@link PropertyType::STRING}</li>
	 *   <li>{@link PropertyType::DATE}</li>
	 *   <li>{@link PropertyType::BINARY}</li>
	 *   <li>{@link PropertyType::DOUBLE}</li>
	 *   <li>{@link PropertyType::LONG}</li>
	 *   <li>{@link PropertyType::BOOLEAN}</li>
	 *   <li>{@link PropertyType::SOFTLINK}</li>
	 *   <li>{@link PropertyType::REFERENCE}</li>
	 *   <li>{@link PropertyType::UNDEFINED}</li>
	 * </ul>
	 *
	 * {@link PropertyType::UNDEFINED} is returned if this {@link Property} may
	 * be of any type.
	 *
	 * @return int
	 */
	public function getRequiredType();
	
	
	/**
	 * Gets the constraint string. This string describes the constraints
	 * that exist on future values of the {@link Property}.
	 *
	 * Reporting of value constraints is optional. An implementation
	 * is free to return NULL to this call, indicating that value
	 * constraint information is unavailable (though a constraint may still
	 * exist).
	 *
	 * If a string is returned then it is interpreted in different ways
	 * depending on the type specified for this {@link Property}. The following
	 * describes the value constraint syntax for each {@link Property} type:
	 *
	 * <dl>
	 *   <dt>{@link PropertyType::STRING}</dt>
	 *   <dd>The constraint string is a regular expression pattern. For example 
	 *	   the regular expression ".*" means any string".  See
	 *	   {@link http://www.php.net/preg_match} for full explanations of 
	 *	   regular expressions inside PHP.</dd>
	 *
	 *   <dt>{@link PropertyType::REFERENCE}</dt>
	 *   <dd>The constraint string is a comma separated list of {@link NodeType}
	 *	   names. For example "nt:authored, mynt:newsArticle".</dd>
	 *
	 *   <dt>{@link PropertyType::BOOLEAN}</dt>
	 *   <dd>Either TRUE or FALSE.</dd>
	 * </dl>
	 *
	 * The remaining types all have value constraints in the form of inclusive
	 * or exclusive ranges: i.e., "[min, max]",
	 * "(min, max)", "(min, 
	 * max]" or "[min, max)". 
	 * Where "[" and "]" indicate "inclusive", while
	 * "(" and ")" indicate "exclusive". 
	 *
	 * A missing min or max value
	 * indicates no bound in that direction. For example [,5]
	 * means no minimum but a maximum of 5 (inclusive).
	 * The syntax and meaning of the min and 
	 * max values themselves differs between types as 
	 * follows:
	 *
	 * <dl>
	 *   <dt>{@link PropertyType::BINARY}</dt>
	 *   <dd>min and max specify the 
	 *	   allowed size range of the binary value in bytes.</dd>
	 *
	 *   <dt>{@link PropertyType::DATE}</dt>
	 *   <dd>min and max are dates
	 *	   specifiying the allowed date range. The date strings must be in the
	 *	   ISO8601-compliant format: 
	 *	   YYYY-MM-DDThh:mm:ss.sssTZD.</dd>
	 *
	 *   <dt>{@link PropertyType::LONG}, {@link PropertyType::INT}, 
	 *	   {@link PropertyType::FLOAT}, {@link PropertyType::DOUBLE}</dt>
	 *   <dd>min and max are 
	 *	   numbers.</dd>
	 * </dl>
	 *
	 * @return string|null
	 */
	public function getValueConstraint();
	
	
	/**
	 * Gets the default value(s) of the property. These are the values
	 * that the property defined by this {@link PropertyDefinition} will be
	 * assigned if it is automatically created (that is, if 
	 * {@link isAutoCreated()} returns TRUE).
	 *
	 * This method returns an array of {@link Value} objects. If the property is
	 * multi-valued, then this array represents the full set of values
	 * that the property will be assigned upon being auto-created.
	 * Note that this could be the empty array. If the property is single-valued,
	 * then the array returned will be of size 1.
	 *
	 * If NULL is returned, then the property has no fixed default value.
	 * This does not exclude the possibility that the property still assumes some
	 * value automatically, but that value may be parameterized (for example,
	 * "the current date") and hence not expressable as a single fixed value.
	 * In particular, this <i>must</i> be the case if {@link isAutoCreated()}
	 * returns TRUE and this method returns NULL.
	 *
	 * @return array
	 */
	public function getDefaultValues();
	
	
	/**
	 * Reports whether this {@link Property} can have multiple values.
	 *
	 * {@link isMultiple()} flag is special in that a given node type may
	 * have two property definitions that are identical in every respect except
	 * for the their {@link isMultiple} status. For example, a node type
	 * can specify two string properties both called <i>X</i>, one of
	 * which is multi-valued and the other not.
	 *
	 * @return bool
	 */
	public function isMultiple();
}

?>