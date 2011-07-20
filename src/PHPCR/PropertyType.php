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
 *   to 3 positions. Unfortunately this might cause an inacuracy of one millisecond in the worst case.
 *
 * @author Sebastian Kurfürst <sebastian@typo3.org>
 * @author Karsten Dambekalns <karsten@typo3.org>
 * @package phpcr
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

    /**
     * Make instantiation impossible...
     *
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * Returns the name of the specified type, as used in serialization.
     *
     * @param integer $type type the property type
     * @return string  name of the specified type
     *
     * @throws \InvalidArgumentException if the given type is unknown.
     * @api
     */
    static public function nameFromValue($type)
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
                throw new \InvalidArgumentException('Unknown type (' . $type . ') given.', 1257170231);
        }
    }

    /**
     * Returns the numeric constant value of the type with the specified name.
     *
     * @param string $name The name of the property type
     * @return int The numeric constant value
     *
     * @throws \InvalidArgumentException if the given name is unknown.
     * @api
     */
    static public function valueFromName($name)
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
                throw new \InvalidArgumentException('Unknown type name (' . $name . ') given.', 1257170232);
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
     * &nbsp;
     *
     * @param mixed $value The variable we need to know the type of
     * @param boolean $weak When a Node is given as $value this can be given as true to create a WEAKREFERENCE.
     * @return One of the self constants
     * @api
     */
    public static function determineType($value, $weak = false)
    {
        // name, path, reference, weak reference, uri are string, explicitly specify type if you need
        // decimal is handled as string, explicitly specify type if you need
        if (is_string($value)) {
            if (preg_match("/^(\d{4})-(\d{2})-(\d{2})T([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])/", $value, $matches)) {
                return self::DATE;
            }

            return self::STRING;
        } elseif (is_resource($value)) {
            return self::BINARY;
        } elseif (is_int($value)) {
            return self::LONG;
        } elseif (is_float($value)) {
            return self::DOUBLE;
        } elseif (is_bool($value)) {
            return self::BOOLEAN;
        } elseif (is_object($value)) {
            if ($value instanceof \DateTime) {
                return self::DATE;
            } elseif ($value instanceof \PHPCR\NodeInterface) {
                return ($weak) ?
                        self::WEAKREFERENCE :
                        self::REFERENCE;
            }
        }

        throw new \PHPCR\ValueFormatException('Can not determine type of property with value "'.var_export($value, true).'"');
    }

    /**
     * Attempt to convert $values into the proper format for $type.
     *
     * This is the other remaining part of ValueFactory functionality that is
     * still needed.
     *
     * Note that for converting to boolean, we follow the PHP convention of
     * treating any non-empty string as true, not just the word "true".
     *
     * @param mixed $values The value or value array to check and convert
     * @param int $type Target type to convert into. One of the type constants in \PHPCR\PropertyType
     * @return the value typecasted into the proper format (throws an exception if conversion is not possible)
     *
     * @throws \PHPCR\ValueFormatException is thrown if the specified value cannot be converted to the specified type.
     * @throws \PHPCR\RepositoryException if the specified Node is not referenceable, the current Session is no longer active, or another error occurs.
     * @throws \InvalidArgumentException if the specified DateTime value cannot be expressed in the ISO 8601-based format defined in the JCR 2.0 specification and the implementation does not support dates incompatible with that format.
     */
    public static function convertType($values, $type)
    {
        $ret = null;
        $isArray = is_array($values);
        if (!$isArray) {
            $values = array($values);
        } else {
            $ret = array();
        }
        switch($type) {
            case self::STRING:
                foreach ($values as $v) {
                    if ($v instanceof \DateTime) {
                        // Milliseconds formating is not possible in PHP so we
                        // construct it by cutting microseconds to 3 positions.
                        // This might not be as accurate as "real" rounded milliseconds.
                        $tmp = $v->format('Y-m-d\TH:i:s.');
                        $tmp .= substr($v->format('u'), 0, 3);
                        $tmp .= $v->format('P');
                        $ret[] = $tmp;
                    } elseif (is_resource($v)) {
                        $ret[] = stream_get_contents($v);
                        rewind($v);
                    } else {
                        settype($v, 'string');
                        $ret[] = $v;
                    }
                }
                break;
            case self::DECIMAL:
                $typename = 'string';
                break;
            case self::LONG:
                $typename = 'integer';
                break;
            case self::DOUBLE:
                $typename = 'double';
                break;
            case self::BOOLEAN:
                $typename = 'boolean'; //we follow php logic and are not binary compatible with jackrabbit. jcr is not specific about details of the conversion.
                break;
            case self::DATE:
                foreach ($values as $v) {
                    $datetime = false;
                    if ($v instanceof \DateTime) {
                        $datetime = $v;
                    } elseif (is_int($v)) {
                        $datetime = new \DateTime();
                        $datetime = $datetime->setTimestamp($v);
                    } elseif (is_string($v)) {
                        try {
                            $datetime = new \DateTime($v);
                        } catch (\Exception $e) {
                            $datetime = false;
                        }
                    }
                    if ($datetime === false) {
                        throw new \PHPCR\ValueFormatException('Can not convert "'.var_export($v, true).'" into a date');
                    }
                    $ret[] = $datetime;
                }
                break;
            case self::REFERENCE:
            case self::WEAKREFERENCE:
                foreach ($values as $v) {
                    if ($v instanceof \PHPCR\NodeInterface) {
                        // In Jackrabbit a new node cannot be referenced until it has been persisted
                        // See: https://issues.apache.org/jira/browse/JCR-1614
                        if ($v->isNew() || ! $v->isNodeType('mix:referenceable')) {
                            throw new \PHPCR\ValueFormatException('Node ' . $v->getPath() . ' is not referencable');
                        }
                        $ret[] = $v->getIdentifier();
                    } elseif (is_string($v) && ! empty($v)) {
                        //could check if string is valid uuid, but backend will do that
                        $ret[] = $v;
                    } else {
                        throw new \PHPCR\ValueFormatException("$v is not a unique id");
                    }
                }
                break;
            case self::BINARY:
                foreach ($values as $v) {
                    if (is_string($v)) {
                        $f = fopen('php://memory', 'rwb+');
                        fwrite($f, $v);
                        rewind($f);
                        $v = $f;
                    }

                    if (!is_resource($v)) {
                        throw new \PHPCR\ValueFormatException('Cannot convert value into a binary resource');
                    }

                    $ret[] = $v;
                }
            //FIXME: type PATH is missing. should automatically read property and node with getPath.
            default:
                //FIXME: handle other types somehow
                foreach ($values as $v) {
                    $ret[] = $v;
                }
                break;
            //TODO: more type checks or casts? name, path, uri, decimal. but the backend can handle the checks.
        }
        if (isset($typename)) {
            foreach ($values as $v) {
                if (! settype($v, $typename)) { //TODO: will this work for streams? or should we read them into string and then convert?
                    throw new \PHPCR\ValueFormatException;
                }
                $ret[] = $v;
            }
        }
        if (!$isArray) {
            $ret = $ret[0];
        }
        return $ret;
    }
}
