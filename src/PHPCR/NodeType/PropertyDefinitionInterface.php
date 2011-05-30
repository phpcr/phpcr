<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

namespace PHPCR\NodeType;

/**
 * A property definition. Used in node type definitions.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface PropertyDefinitionInterface extends \PHPCR\NodeType\ItemDefinitionInterface
{
    /**
     * Gets the required type of the property.
     *
     * Possible property types of:
     * - PropertyType.STRING
     * - PropertyType.DATE
     * - PropertyType.BINARY
     * - PropertyType.DOUBLE
     * - PropertyType.DECIMAL
     * - PropertyType.LONG
     * - PropertyType.BOOLEAN
     * - PropertyType.NAME
     * - PropertyType.PATH
     * - PropertyType.URI
     * - PropertyType.REFERENCE
     * - PropertyType.WEAKREFERENCE
     * - PropertyType.UNDEFINED
     *
     * PropertyType.UNDEFINED is returned if this property may be of any type.
     *
     * In implementations that support node type registration, if this
     * PropertyDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate, then this method will return PropertyType.STRING.
     *
     * @return integer An integer constant member of PropertyType.
     * @api
     */
    function getRequiredType();

    /**
     * Gets the array of constraint strings.
     *
     * Each string in the array specifies a constraint on the value of the property.
     * The constraints are OR-ed together, meaning that in order to be valid, the
     * value must meet at least one of the constraints. For example, a constraint
     * array of ["constraint1", "constraint2", "constraint3"] has the interpretation:
     * "the value of this property must meet at least one of constraint1, constraint2
     * or constraint3".
     *
     * Reporting of value constraints is optional. An implementation may return
     * null, indicating that value constraint information is unavailable (though
     * a constraint may still exist).
     *
     * Returning an empty array, on the other hand, indicates that value constraint
     * information is available and that no constraints are placed on this value.
     *
     * In the case of multi-value properties, the constraint string array returned
     * applies to all the values of the property.
     *
     * The constraint strings themselves having differing formats and
     * interpretations depending on the type of the property in question. The
     * following describes the value constraint syntax for each property type:
     *
     * <b>STRING</b> and <b>URI</b>: The constraint string is a regular expression pattern. For
     * example the regular expression ".*" means "any string, including the empty
     * string". Whereas a simple literal string (without any RE-specific meta-
     * characters) like "banana" matches only the string "banana".
     *
     * <b>PATH</b>: The constraint string is a JCR path with an optional "*" character
     * after the last "/" character. For example, possible constraint strings for
     * a property of type PATH include:
     *
     * - "/myapp:products/myapp:televisions"
     * - "/myapp:products/myapp:televisions/"
     * - "/myapp:products/*"
     * - "myapp:products/myapp:televisions"
     * - "../myapp:televisions"
     * - "../myapp:televisions/*"
     *
     * The following principles apply:
     *  The "*" means "matches descendants" not "matches any subsequent path".
     *  For example, /a/* does not match /a/../c. The constraint must match the
     *  normalized path.
     *  Relative path constraint only match relative path values and absolute
     *  path constraints only match absolute path values.
     *  A trailing "/" has no effect (hence, 1 and 2, above, are equivalent).
     *  The trailing "*" character means that the value of the PATH property is
     *  restricted to the indicated subgraph (in other words any additional
     *  relative path can replace the "*"). For example, 3, above would allow
     *  /myapp:products/myapp:radios, /myapp:products/myapp:microwaves/X900,
     *  and so forth.
     *  A constraint without a "*" means that the PATH property is restricted
     *  to that precise path. For example, 1, above, would allow only the
     *  value /myapp:products/myapp:televisions.
     *  The constraint can indicate either a relative path or an absolute path
     *  depending on whether it includes a leading "/" character. 1 and 4,
     *  above for example, are distinct.
     *  The string returned must reflect the namespace mapping in the current
     *  Session (i.e., the current state of the namespace registry overlaid
     *  with any session-specific mappings). Constraint strings for PATH
     *  properties should be stored in fully-qualified form (using the actual
     *  URI instead of the prefix) and then be converted to prefix form
     *  according to the current mapping upon the
     *  PropertyDefinition.getValueConstraints call.
     *
     * <b>NAME</b>: The constraint string is a JCR name in prefix form. For example
     * "myapp:products". No wildcards or other pattern matching are supported.
     * As with PATH properties, the string returned must reflect the namespace
     * mapping in the current Session. Constraint strings for NAME properties
     * should be stored in fully-qualified form (using the actual URI instead of
     * the prefix) and then be converted to prefix form according to the current
     * mapping.
     *
     * <b>REFERENCE</b> and <b>WEAKREFERENCE</b>: The constraint string is a JCR name in prefix
     * form. This name is interpreted as a node type name and the REFERENCE or
     * WEAKREFERENCE property is restricted to referring only to nodes that have
     * at least the indicated node type. For example, a constraint of "mytype:document"
     * would indicate that the property in question can only refer to nodes that
     * have at least the node type mytype:document (assuming this was the only
     * constraint returned in the array, recall that the array of constraints are
     * to be ORed together). No wildcards or other pattern matching are supported.
     * As with PATH properties, the string returned must reflect the namespace
     * mapping in the current Session. Constraint strings for REFERENCE and
     * WEAKREFERENCE properties should be stored by the implementation in
     * fully-qualified form (using the actual URI instead of the prefix) and then
     * be converted to prefix form according to the current mapping.
     *
     * <b>BOOLEAN</b>: BOOLEAN properties will always report a value constraint
     * consisting of an empty array (meaning no constraint). In implementations
     * that support node type registration any value constraint set on BOOLEAN is
     * ignored and discarded.
     *
     * The remaining types all have value constraints in the form of inclusive
     * or exclusive ranges: i.e., "[min, max]", "(min, max)", "(min, max]" or
     * "[min, max)". Where "[" and "]" indicate "inclusive", while "(" and ")"
     * indicate "exclusive". A missing min or max value indicates no bound in
     * that direction. For example [,5] means no minimum but a maximum of 5
     * (inclusive) while [,] means simply that any value will suffice, The meaning
     * of the min and max values themselves differ between types as follows:
     *
     * <b>BINARY</b>: min and max specify the allowed size range of the binary value in bytes.
     * DATE: min and max are dates specifying the allowed date range. The date
     * strings must be in the ISO8601-compliant format: YYYY-MM-DDThh:mm:ss.sssTZD.
     * LONG, DOUBLE: min and max are numbers.
     *
     * In implementations that support node type registration, when specifying
     * that a DATE, LONG or DOUBLE is constrained to be equal to some disjunctive
     * set of constants, a string consisting of just the constant itself, "c" may
     * be used as a shorthand for the standard constraint notation of "[c, c]",
     * where c is the constant. For example, to indicate that particular LONG
     * property is constrained to be one of the values 2, 4, or 8, the constraint
     * string array {"2", "4", "8"} can be used instead of the standard notation,
     * {"[2,2]", "[4,4]", "[8,8]"}. However, even if this shorthand is used on
     * registration, the value returned by PropertyDefinition.getValueConstraints()
     * will always use the standard notation.
     *
     * Because constraints are returned as an array of disjunctive constraints,
     * in many cases the elements of the array can serve directly as a "choice list".
     * This may, for example, be used by an application to display options to
     * the end user indicating the set of permitted values.
     *
     * In implementations that support node type registration, if this
     * PropertyDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate, then this method will return null.
     *
     * @return array a String array.
     * @api
     */
    function getValueConstraints();

    /**
     * Gets the default value(s) of the property.
     *
     * These are the values that the property defined by this PropertyDefinition
     * will be assigned if it is automatically created (that is, if
     * ItemDefinition.isAutoCreated() returns true).
     * This method returns an array of values. If the property is multi-
     * valued, then this array represents the full set of values that the property
     * will be assigned upon being auto-created. Note that this could be the empty
     * array. If the property is single-valued, then the array returned will be
     * of size 1.
     *
     * If null is returned, then the property has no fixed default value. This
     * does not exclude the possibility that the property still assumes some
     * value automatically, but that value may be parametrized (for example, "the
     * current date") and hence not expressible as a single fixed value. In
     * particular, this must be the case if isAutoCreated returns true and this
     * method returns null.
     *
     * Note that to indicate a null value for this attribute in a node type
     * definition that is stored in content, the jcr:defaultValues property is
     * simply removed (since null values for properties are not allowed.
     *
     * In implementations that support node type registration, if this
     * PropertyDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate, then this method will return null.
     *
     * @return array An array of php values.
     * @api
     */
    function getDefaultValues();

    /**
     * Reports whether this property can have multiple values.
     *
     * <b>Note</b> that the isMultiple flag is special in that a given node
     * type may have two property definitions that are identical in every respect
     * except for the their isMultiple status. For example, a node type can specify
     * two string properties both called X, one of which is multi-valued and the other not.
     * An example of such a node type is nt:unstructured.
     *
     * In implementations that support node type registration, if this
     * PropertyDefinition object is actually a newly-created empty
     * PropertyDefinitionTemplate, then this method will return false.
     *
     * @return boolean True, if this property may have multiple values, else false.
     * @api
     */
    function isMultiple();

    /**
     * Returns the set of query comparison operators supported by this
     * property.
     *
     * This attribute only takes effect if the node type holding the property
     * definition has a queryable setting of true.
     *
     * JCR defines the comparison operators QueryObjectModelConstants::JCR_OPERATOR_*
     *
     *  An implementation may define additional comparison operators.
     *
     * Note that the set of operators that can appear in this attribute may be
     * limited by implementation-specific constraints that differ across
     * property types. For example, some implementations may permit property
     * definitions to provide JCR_OPERATOR_EQUAL_TO and
     * JCR_OPERATOR_NOT_EQUAL_TO as available operators for BINARY properties
     * while others may not.
     *
     * However, in all cases where a JCR-defined operator is potentially
     * available for a given property type, its behavior must conform to the
     * comparison semantics defined in the specification document (see 3.6.5
     * Comparison of Values).
     *
     * @return array List of query operators.
     * @api
     */
    function getAvailableQueryOperators();

    /**
     * Determines if this property is full-text searchable.
     *
     * Returns true if this property is full-text searchable,
     * meaning that its value is accessible through the full-text search
     * function within a query.
     *
     * This attribute only takes effect if the node type holding the
     * property definition has a queryable setting of true.
     *
     * @return boolean True, if this property is full-text searchable, else false.
     * @api
     */
    function isFullTextSearchable();

    /**
     * Report this property is orderable by a query.
     *
     * Returns true if this property is query orderable,
     * meaning that query results may be ordered by this property
     * using the order-by clause of a query.
     *
     * This attribute only takes effect if the node type holding the
     * property definition has a queryable setting of true.
     *
     * @return boolean True, if this property is query orderable, else false.
     * @api
     */
    function isQueryOrderable();
}
