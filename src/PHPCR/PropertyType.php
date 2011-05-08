<?php
/**
 * Final class to define a property type.
 *
 * This file was ported from the Java JCR API to PHP by
 * Karsten Dambekalns <karsten@typo3.org> for the FLOW3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version. Alternatively, you may use the Simplified
 * BSD License.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with the script.
 * If not, see {@link http://www.gnu.org/licenses/lgpl.html}.
 *
 * The TYPO3 project - inspiring people to share!
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 *
 * @package phpcr
 */

namespace PHPCR;

/**
 * The property types supported by the JCR standard.
 *
 * The <b>STRING</b> property type is used to store strings.
 * <b>BINARY</b> properties are used to store binary data.
 * The <b>LONG</b> property type is used to store integers.
 * The <b>DECIMAL</b> property type is used to store precise decimal numbers.
 * The <b>DOUBLE</b> property type is used to store floating point numbers.
 * The <b>DATE</b> property type is used to store time and date information. See 4.2.6.1 Date in the specification.
 * The <b>BOOLEAN</b> property type is used to store boolean values.
 * A <b>NAME</b> is a pairing of a namespace and a local name. When read, the namespace is mapped to the current prefix.
 * See 4.2.6.2 Name in the specification.
 * A <b>PATH</b> property is an ordered list of path elements. A path element is a NAME with an optional index.
 * When read, the NAMEs within the path are mapped to their current prefix. A path may be absolute or relative.
 * See 4.2.6.3 Path in the specification.
 * A <b>REFERENCE</b> property stores the identifier of a referenceable node (one having type mix:referenceable),
 * which must exist within the same workspace or session as the REFERENCE property. A REFERENCE property enforces this
 * referential integrity by preventing (in level 2 implementations) the removal of its target node.
 * See 4.2.6.4 Reference in the specification.
 * A <b>WEAKREFERENCE</b> property stores the identifier of a referenceable node (one having type mix:referenceable).
 * A WEAKREFERENCE property does not enforce referential integrity. See 4.2.6.5 Weak Reference in the specification.
 * A <b>URI</b> property is identical to STRING property except that it only accepts values that conform to the
 * syntax of a URI-reference as defined in RFC 3986. See also 4.2.6.6 URI in the specification.
 * <b>UNDEFINED</b> can be used within a property definition (see 4.7.5 Property Definitions) to specify that the
 * property in question may be of any type. However, it cannot be the actual type of any property instance.
 * For example it will never be returned by Property.getType() and (in level 2 implementations) it cannot be assigned
 * as the type when creating a new property.
 *
 * @package phpcr
 * @api
 */
final class PropertyType {

    /**#@+
     * @var integer
     */

    /**
     * This constant can be used within a property definition to specify that
     * the property in question may be of any type.
     *
     * However, it cannot be the actual type of any property instance. For
     * example, it will never be returned by Property#getType and it cannot be
     * assigned as the type when creating a new property.
     */
    const UNDEFINED = 0;

    /**
     * The STRING property type is used to store strings.
     */
    const STRING = 1;

    /**
     * BINARY properties are used to store binary data.
     */
    const BINARY = 2;

    /**
     * The LONG property type is used to store integers.
     */
    const LONG = 3;

    /**
     * The DOUBLE property type is used to store floating point numbers.
     */
    const DOUBLE = 4;

    /**
     * The DATE property type is used to store time and date information.
     */
    const DATE = 5;

    /**
     * The BOOLEAN property type is used to store boolean values.
     */
    const BOOLEAN = 6;

    /**
     * A NAME is a pairing of a namespace and a local name. When read, the
     * namespace is mapped to the current prefix.
     */
    const NAME = 7;

    /**
     * A PATH property is an ordered list of path elements. A path element is a
     * NAME with an optional index. When read, the NAMEs within the path are
     * mapped to their current prefix. A path may be absolute or relative.
     */
    const PATH = 8;

    /**
     * A REFERENCE property stores the identifier of a referenceable node (one
     * having type mix:referenceable), which must exist within the same
     * workspace or session as the REFERENCE property. A REFERENCE property
     * enforces this referential integrity by preventing the removal of its
     * target node.
     */
    const REFERENCE = 9;

    /**
     * A WEAKREFERENCE property stores the identifier of a referenceable node
     * (one having type mix:referenceable). A WEAKREFERENCE property does not
     * enforce referential integrity.
     */
    const WEAKREFERENCE = 10;

    /**
     * A URI property is identical to STRING property except that it only
     * accepts values that conform to the syntax of a URI-reference as defined
     * in RFC 3986.
     */
    const URI = 11;

    /**
     * The DECIMAL property type is used to store precise decimal numbers.
     */
    const DECIMAL = 12;

    /**#@-*/

    /**#@+
     * @var string
     */
    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_UNDEFINED = 'undefined';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_STRING = 'String';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_BINARY = 'Binary';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_LONG = 'Long';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_DOUBLE = 'Double';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_DATE = 'Date';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_BOOLEAN = 'Boolean';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_NAME = 'Name';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_PATH = 'Path';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_REFERENCE = 'Reference';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_WEAKREFERENCE = 'WeakReference';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_URI= 'URI';

    /**
     * String constant for type name as used in serialization.
     */
    const TYPENAME_DECIMAL = 'Decimal';

    /**#@-*/

    /**
     * Make instantiation impossible...
     *
     * @return void
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     */
    private function __construct() {}

    /**
     * Returns the name of the specified type, as used in serialization.
     *
     * @param integer $type type the property type
     * @return string  name of the specified type
     *
     * @author Sebastian Kurfürst <sebastian@typo3.org>
     * @author Karsten Dambekalns <karsten@typo3.org>
     *
     * @throws \InvalidArgumentException if the given type is unknown.
     * @api
     */
    static public function nameFromValue($type) {
        switch (intval($type)) {
            case self::UNDEFINED :
                return self::TYPENAME_UNDEFINED;
                break;
            case self::STRING :
                return self::TYPENAME_STRING;
                break;
            case self::BINARY :
                return self::TYPENAME_BINARY;
                break;
            case self::BOOLEAN :
                return self::TYPENAME_BOOLEAN;
                break;
            case self::LONG :
                return self::TYPENAME_LONG;
                break;
            case self::DOUBLE :
                return self::TYPENAME_DOUBLE;
                break;
            case self::DECIMAL :
                return self::TYPENAME_DECIMAL;
                break;
            case self::DATE :
                return self::TYPENAME_DATE;
                break;
            case self::NAME :
                return self::TYPENAME_NAME;
                break;
            case self::PATH :
                return self::TYPENAME_PATH;
                break;
            case self::REFERENCE :
                return self::TYPENAME_REFERENCE;
                break;
            case self::WEAKREFERENCE :
                return self::TYPENAME_WEAKREFERENCE;
                break;
            case self::URI :
                return self::TYPENAME_URI;
                break;
            default:
                throw new \InvalidArgumentException('Unknown type (' . $type . ') given.', 1257170231);
        }
    }

    /**
     * Returns the numeric constant value of the type with the specified name.
     *
     * @param string $name The name of the property type
     * @return int The numeric constant value
     *
     * @author Sebastian Kurfürst <sebastian@typo3.org>
     * @author Karsten Dambekalns <karsten@typo3.org>
     *
     * @throws \InvalidArgumentException if the given name is unknown.
     * @api
     */
    static public function valueFromName($name) {
        switch (strtolower($name)) {
            case 'undefined':
                return self::UNDEFINED;
                break;
            case 'string':
                return self::STRING;
                break;
            case 'binary':
                return self::BINARY;
                break;
            case 'long':
                return self::LONG;
                break;
            case 'double':
                return self::DOUBLE;
                break;
            case 'date':
                return self::DATE;
                break;
            case 'boolean':
                return self::BOOLEAN;
                break;
            case 'name':
                return self::NAME;
                break;
            case 'path':
                return self::PATH;
                break;
            case 'reference':
                return self::REFERENCE;
                break;
            case 'weakreference':
                return self::WEAKREFERENCE;
                break;
            case 'uri':
                return self::URI;
                break;
            case 'decimal':
                return self::DECIMAL;
                break;
            default:
                throw new \InvalidArgumentException('Unknown type name (' . $name . ') given.', 1257170232);
        }
    }

    /**
     * Returns the numeric constant value of the type for the given PHP type
     * name as returned by gettype().
     *
     * <b>Note:</b> this is an addition not defined in JSR-283.
     *
     * @param string $type
     * @return integer
     *
     * @author Karsten Dambekalns <karsten@typo3.org>
     * @api
     */
    static public function valueFromType($type) {
        switch (strtolower($type)) {
            case 'string':
                return self::STRING;
                break;
            case 'bool':
            case 'boolean':
                return self::BOOLEAN;
                break;
            case 'int':
            case 'integer':
                return self::LONG;
                break;
            case 'float':
            case 'double':
                return self::DOUBLE;
                break;
            case 'datetime':
                return self::DATE;
                break;
            default:
                return self::UNDEFINED;
        }
    }
}
