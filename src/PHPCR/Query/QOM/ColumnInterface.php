<?php

namespace PHPCR\Query\QOM;

/**
 * Defines a column to include in the tabular view of query results.
 *
 * If property is not specified, a column is included for each single-valued
 * non-residual property of the node type specified by the nodeType attribute
 * of selector.
 *
 * If property is specified, columnName is required and used to name the column
 * in the tabular results. If property is not specified, columnName must not be
 * specified, and the included columns will be named "selector.propertyName".
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @api
 */
interface ColumnInterface
{
    /**
     * Gets the name of the selector.
     *
     * @return string the selector name
     *
     * @api
     */
    public function getSelectorName();

    /**
     * Gets the name of the property.
     *
     * @return string|null the property name, or null to include a column for
     *      each single-value non-residual property of the selector's node type
     *
     * @api
     */
    public function getPropertyName();

    /**
     * Gets the column name.
     *
     * @return string|null the column name; must be null if getPropertyName is
     *      null and contain the name for this column otherwise.
     *
     * @api
     */
    public function getColumnName();
}
