<?php

namespace PHPCR;

/**
 * The property types supported by the JCR standard.
 *
 * - The <b>STRING</b> property type is used to store strings.
 * - <b>BINARY</b> properties are used to store binary data.
 * - The <b>LONG</b> property type is used to store integers.
 * - The <b>DECIMAL</b> property type is used to store precise decimal numbers.
 * - The <b>DOUBLE</b> property type is used to store floating point numbers.
 * - The <b>DATE</b> property type is used to store time and date information. See 4.2.6.1 Date in the specification.
 * - The <b>BOOLEAN</b> property type is used to store boolean values.
 * - A <b>NAME</b> is a pairing of a namespace and a local name. When read, the namespace is mapped to the current prefix.
 *   See 4.2.6.2 Name in the specification.
 * - A <b>PATH</b> property is an ordered list of path elements. A path element is a NAME with an optional index.
 *   When read, the NAMEs within the path are mapped to their current prefix. A path may be absolute or relative.
 *   See 4.2.6.3 Path in the specification.
 * - A <b>REFERENCE</b> property stores the identifier of a referenceable node (one having type mix:referenceable),
 *   which must exist within the same workspace or session as the REFERENCE property. A REFERENCE property enforces this
 *   referential integrity by preventing (in level 2 implementations) the removal of its target node.
 *   See 4.2.6.4 Reference in the specification.
 * - A <b>WEAKREFERENCE</b> property stores the identifier of a referenceable node (one having type mix:referenceable).
 * - A WEAKREFERENCE property does not enforce referential integrity. See 4.2.6.5 Weak Reference in the specification.
 * - A <b>URI</b> property is identical to STRING property except that it only accepts values that conform to the
 *   syntax of a URI-reference as defined in RFC 3986. See also 4.2.6.6 URI in the specification.
 * - <b>UNDEFINED</b> can be used within a property definition (see 4.7.5 Property Definitions) to specify that the
 *   property in question may be of any type. However, it cannot be the actual type of any property instance.
 *   For example it will never be returned by PropertyInterface::getType() and (in level 2 implementations) it cannot be assigned
 *   as the type when creating a new property.
 *
 * PHP Note on date formatting:
 *   Since there is no formatting for milliseconds in PHP we construct the date formatting by cutting the microseconds
 *   to 3 positions. Unfortunately this might cause an inaccuracy of one millisecond in the worst case.
 *
 * @license http://www.apache.org/licenses Apache License Version 2.0, January 2004
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @author Sebastian Kurfürst <sebastian@typo3.org>
 * @author Karsten Dambekalns <karsten@typo3.org>
 * @author David Buchmann <mail@davidbu.ch>
 *
 * @api
 */
final class PropertyType
{
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

    // @codeCoverageIgnoreStart
    /**
     * Make instantiation impossible...
     */
    private function __construct()
    {
    }
    // @codeCoverageIgnoreEnd

    /**
     * Returns the name of the specified type, as used in serialization.
     *
     * @param  integer $type type the property type
     * @return string  name of the specified type
     *
     * @throws \InvalidArgumentException if the given type is unknown.
     * @api
     */
    public static function nameFromValue($type)
    {
        switch (intval($type)) {
            case self::UNDEFINED :
                return self::TYPENAME_UNDEFINED;
            case self::STRING :
                return self::TYPENAME_STRING;
            case self::BINARY :
                return self::TYPENAME_BINARY;
            case self::BOOLEAN :
                return self::TYPENAME_BOOLEAN;
            case self::LONG :
                return self::TYPENAME_LONG;
            case self::DOUBLE :
                return self::TYPENAME_DOUBLE;
            case self::DECIMAL :
                return self::TYPENAME_DECIMAL;
            case self::DATE :
                return self::TYPENAME_DATE;
            case self::NAME :
                return self::TYPENAME_NAME;
            case self::PATH :
                return self::TYPENAME_PATH;
            case self::REFERENCE :
                return self::TYPENAME_REFERENCE;
            case self::WEAKREFERENCE :
                return self::TYPENAME_WEAKREFERENCE;
            case self::URI :
                return self::TYPENAME_URI;
            default:
                throw new \InvalidArgumentException('Unknown type (' . $type . ') given.');
        }
    }

    /**
     * Returns the numeric constant value of the type with the specified name.
     *
     * This method is case-insensitive
     *
     * @param string $name The name of the property type
     *
     * @return int The numeric constant value
     *
     * @throws \InvalidArgumentException if the given name is unknown.
     *
     * @api
     */
    public static function valueFromName($name)
    {
        switch (strtolower($name)) {
            case 'undefined':
                return self::UNDEFINED;
            case 'string':
                return self::STRING;
            case 'binary':
                return self::BINARY;
            case 'long':
                return self::LONG;
            case 'double':
                return self::DOUBLE;
            case 'date':
                return self::DATE;
            case 'boolean':
                return self::BOOLEAN;
            case 'name':
                return self::NAME;
            case 'path':
                return self::PATH;
            case 'reference':
                return self::REFERENCE;
            case 'weakreference':
                return self::WEAKREFERENCE;
            case 'uri':
                return self::URI;
            case 'decimal':
                return self::DECIMAL;
            default:
                throw new \InvalidArgumentException('Unknown type name (' . $name . ') given.');
        }
    }

    /**
     * Determine PropertyType from on variable type.
     *
     * This is most of the remainder of ValueFactory that is still needed.
     *
     * - if the given $value is a Node object, type will be REFERENCE, unless
     *    $weak is set to true which results in WEAKREFERENCE
     * - if the given $value is a DateTime object, the type will be DATE.
     *
     * Note that string is converted to date exactly if it matches the jcr
     * formatting spec for dates (sYYYY-MM-DDThh:mm:ss.sssTZD) according to
     * http://www.day.com/specs/jcr/2.0/3_Repository_Model.html#3.6.4.3%20From%20DATE%20To
     *
     * @param mixed   $value The variable we need to know the type of
     * @param boolean $weak  When a Node is given as $value this can be given as true to create a WEAKREFERENCE.
     *
     * @return int One of the type constants
     *
     * @throws ValueFormatException if the type can not be determined
     *
     * @api
     */
    public static function determineType($value, $weak = false)
    {
        // name, path, reference, weak reference, uri are string, explicitly specify type if you need
        // decimal is handled as string, explicitly specify type if you need
        if (is_string($value)) {
            // check if this is a jcr formatted date: sYYYY-MM-DDThh:mm:ss.sssTZD
            if (preg_match("/^(\\+|-)?(\\d{4})-(\\d{2})-(\\d{2})T([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])(\\.[0-9][0-9][0-9])?.*/", $value, $matches)) {
                try {
                    new \DateTime($value);

                    return self::DATE;
                } catch (\Exception $e) {
                    // ignore, fall through to the string if its not valid
                }
            }

            return self::STRING;
        }
        if (is_resource($value)) {
            return self::BINARY;
        }
        if (is_int($value)) {
            return self::LONG;
        }
        if (is_float($value)) {
            return self::DOUBLE;
        }
        if (is_bool($value)) {
            return self::BOOLEAN;
        }
        if (is_object($value)) {
            if ($value instanceof \DateTime) {
                return self::DATE;
            }
            if ($value instanceof NodeInterface) {
                return ($weak) ? self::WEAKREFERENCE : self::REFERENCE;
            }
            if ($value instanceof PropertyInterface) {
                return $value->getType();
            }
            throw new ValueFormatException('Object values must implement PHPCR\NodeInterface, PHPCR\PropertyInterface or be \DateTime, supplied argument is of class: '.get_class($value));
        }

        throw new ValueFormatException('Can not determine type of property with value "'.var_export($value, true).'"');
    }
}
