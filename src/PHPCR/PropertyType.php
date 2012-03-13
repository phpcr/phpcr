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

    // @codeCoverageIgnoreStart
    /**
     * Make instantiation impossible...
     *
     * @return void
     */
    private function __construct()
    {
    }
    // @codeCoverageIgnoreEnd

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
                throw new \InvalidArgumentException('Unknown type (' . $type . ') given.');
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
     * @param mixed $value The variable we need to know the type of
     * @param boolean $weak When a Node is given as $value this can be given as true to create a WEAKREFERENCE.
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

        // avoid stumbling over objects with var_export
        if (is_object($value)) {
            throw new \PHPCR\ValueFormatException('The class of the value object is not understood by PHPCR: '.get_class($value));
        }
        throw new \PHPCR\ValueFormatException('Can not determine type of property with value "'.var_export($value, true).'"');
    }

    /**
     * Attempt to convert $values into the proper format for $type.
     *
     * This is the other remaining part of ValueFactory functionality that is
     * still needed.
     *
     * If a $srctype is specified, the conversion also checks whether the
     * conversion is allowed according to the property type conversion of the
     * jcr specification (link below). This might be needed because NAME and
     * other properties have quite restricted conversion matrix but in php will
     * be modelled as string.
     *
     * Note that for converting to boolean, we follow the PHP convention of
     * treating any non-empty string as true, not just the word "true".
     *
     * Table based on <a href="http://www.day.com/specs/jcr/2.0/3_Repository_Model.html#3.6.4%20Property%20Type%20Conversion">JCR spec</a>
     *
        <TABLE>
        <TR><TD><BR></TD><TD>STRING (1)</TD><TD>BINARY (2)</TD><TD>LONG (3)</TD><TD>DOUBLE (4)</TD><TD>DATE (5)</TD><TD>BOOLEAN (6)</TD><TD>NAME(7)</TD><TD>PATH (8)</TD><TD>REFERENCE (9/10)</TD><TD>URI (11)</TD><TD>DECIMAL (12)</TD></TR>
        <TR><TD>STRING</TD><TD>x</TD><TD>Utf-8 encoded</TD><TD>cast to int</TD><TD>cast to float</TD><TD>SYYYY-MM-DDThh:Mm:ss.sssTZD</TD><TD><I>'' is false, else true</I></TD><TD>if valid name, name</TD><TD>if valid path, as name</TD><TD>check valid uuid</TD><TD>RFC 3986</TD><TD>string</TD></TR>
        <TR><TD>BINARY</TD><TD>Utf-8</TD><TD>x</TD><TD COLSPAN="9" BGCOLOR="#E6E6E6">Converted to string and then interpreted as above</TD></TR>
        <TR><TD>LONG</TD><TD>cast to string</TD><TD>String, then Utf-8</TD><TD>x</TD><TD>cast to float</TD><TD>Unix Time</TD><TD><I>0 false else true</I></TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>cast to string</TD></TR>
        <TR><TD>DOUBLE</TD><TD>cast to string</TD><TD>String, then Utf-8</TD><TD>cast to int</TD><TD>x</TD><TD>Unix Time</TD><TD><I>0.0 is false, else true</I></TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>cast to string</TD></TR>
        <TR><TD>DATE</TD><TD>SYYYY-MM-DDThh:<BR>Mm:ss.sssTZD</TD><TD>String, then Utf-8</TD><TD>Unix timestamp</TD><TD>Unix timestamp</TD><TD>x</TD>
        <TD><I>true</I></TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>Unix timestamp</TD></TR>
        <TR><TD>BOOLEAN</TD><TD>cast to string</TD><TD>String, then Utf-8</TD><TD>0/1</TD><TD>0.0/1.0</TD><TD>ValueFormatException</TD><TD>x</TD><TD>'0'/'1'</TD>
        <TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD></TR>
        <TR><TD>NAME</TD><TD>Qualified form</TD><TD>String, then Utf-8</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>x</TD><TD>noop (relative path)</TD><TD>ValueFormatException</TD><TD>„./“ and qualified name. % encode illegal characters</TD><TD>ValueFormatException</TD></TR>
        <TR><TD>PATH</TD><TD>Standard form</TD><TD>String, then Utf-8</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>if relative path lenght 1 noop / otherwise ValueFormatException</TD><TD>x</TD><TD>ValueFormatException</TD><TD>„./“ if not starting with /. % encode illegal characters</TD><TD>ValueFormatException</TD></TR>
        <TR><TD>REFERENCE</TD><TD>noop</TD><TD>String, then Utf-8</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>x</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD></TR>
        <TR><TD>URI</TD><TD>noop</TD><TD>String, then Utf-8</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD>
        <TD>ValueFormatException</TD><TD>single name: decode %, remove ./  else ValueFormatException</TD><TD>Decode %, remove leading ./ . if not star w. name, / or ./ then ValueFormatException</TD><TD>ValueFormatException</TD><TD>x</TD><TD>ValueFormatException</TD></TR>
        <TR><TD>DECIMAL</TD><TD>noop</TD><TD>Utf-8 encoded</TD><TD>cast to int</TD><TD>cast to float</TD><TD>Unix Time</TD><TD><I>0 false else true</I></TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>ValueFormatException</TD><TD>x</TD></TR>
        </TABLE>
     *
     * @param mixed $values The value or value array to check and convert
     * @param int $type Target type to convert into. One of the type constants in \PHPCR\PropertyType
     * @param int $srctype Source type to convert from, if not specified this is automatically determined, which will miss the string based types that are not strings (DECIMAL, NAME, PATH, URI)
     *
     * @return mixed the value typecasted into the proper format (throws an exception if conversion is not possible)
     *
     * @throws \PHPCR\ValueFormatException is thrown if the specified value cannot be converted to the specified type
     * @throws \PHPCR\RepositoryException if the specified Node is not referenceable, the current Session is no longer active, or another error occurs.
     * @throws \InvalidArgumentException if the specified DateTime value cannot be expressed in the ISO 8601-based format defined in the JCR 2.0 specification and the implementation does not support dates incompatible with that format.
     *
     * @see http://www.day.com/specs/jcr/2.0/3_Repository_Model.html#3.6.4%20Property%20Type%20Conversion
     */
    public static function convertType($value, $type, $srctype = self::UNDEFINED)
    {
        if (is_array($value)) {
            $ret = array();
            foreach($value as $v) {
                $ret[] = self::convertType($v, $type, $srctype);
            }
            return $ret;
        }

        if (self::UNDEFINED == $srctype) {
            $srctype = self::determineType($value);
        }

        // except on noop, stream needs to be read into string first
        if (self::BINARY == $srctype && self::BINARY != $type && is_resource($value)) {
            $t = stream_get_contents($value);
            rewind($value);
            $value = $t;
            $srctype = self::STRING;
        } elseif ((self::REFERENCE == $srctype ||
            self::WEAKREFERENCE == $srctype )
                && $value instanceof NodeInterface) {
            // In Jackrabbit a new node cannot be referenced until it has been persisted
            // See: https://issues.apache.org/jira/browse/JCR-1614
            if ($value->isNew()) {
                throw new \PHPCR\ValueFormatException('Node ' . $value->getPath() . ' must be persisted before being referenceable');
            }
            if (! $value->isNodeType('mix:referenceable')) {
                throw new \PHPCR\ValueFormatException('Node ' . $value->getPath() . ' is not referenceable');
            }
            $value = $value->getIdentifier();
        }

        switch ($type) {
            case self::STRING:
                switch ($srctype) {
                    case self::DATE:
                        if (! $value instanceof \DateTime) {
                            throw new RepositoryException('something weird');
                        }
                        // Milliseconds formating is not possible in PHP so we
                        // construct it by cutting microseconds to 3 positions.
                        // This might not be as accurate as "real" rounded milliseconds.
                        return $value->format('Y-m-d\TH:i:s.') .
                            substr($value->format('u'), 0, 3) .
                            $value->format('P');
                    case self::NAME:
                    case self::PATH:
                        // TODO: The name/path is converted to qualified form according to the current local namespace mapping (see §3.2.5.2 Qualified Form).
                         return $value;
                    default:
                        if (is_object($value)) {
                            throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to STRING');
                        } elseif (is_resource($value)) {
                            throw new \PHPCR\ValueFormatException('Inconsistency: Non-binary property should not have resource stream value');
                        }
                        // TODO: how can we provide ValueFormatException on failure? invalid casting leads to 'catchable fatal error' instead of exception
                        return (string) $value;
                }

            case self::BINARY:
                if (is_resource($value)) {
                    return $value;
                }
                if (! is_string($value)) {
                    $value = self::convertType($value, self::STRING, $srctype);
                }
                $f = fopen('php://memory', 'rwb+');
                fwrite($f, $value);
                rewind($f);
                return $f;

            case self::LONG:
                switch ($srctype) {
                    case self::STRING:
                    case self::LONG:
                    case self::DOUBLE:
                    case self::BOOLEAN:
                    case self::DECIMAL:
                        return (integer) $value;
                    case self::DATE:
                        if (! $value instanceof \DateTime) {
                            throw new RepositoryException('something weird');
                        }
                        return $value->getTimestamp();
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a LONG');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to a LONG');

            case self::DOUBLE:
                switch ($srctype) {
                    case self::STRING:
                    case self::LONG:
                    case self::DOUBLE:
                    case self::BOOLEAN:
                    case self::DECIMAL:
                        return (double) $value;
                    case self::DATE:
                        if (! $value instanceof \DateTime) {
                            throw new RepositoryException('something weird');
                        }
                        return (double) $value->getTimestamp();
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a DOUBLE');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to a DOUBLE');

            case self::DATE:
                switch ($srctype) {
                    case self::STRING:
                    case self::DATE:
                        if ($value instanceof \DateTime) {
                            return $value;
                        }
                        try {
                            return new \DateTime($value);
                        } catch (\Exception $e) {
                            throw new \PHPCR\ValueFormatException("String '$value' is not a valid date", null, $e);
                        }
                    case self::LONG:
                    case self::DOUBLE:
                    case self::DECIMAL:
                        $datetime = new \DateTime();
                        $datetime = $datetime->setTimestamp($value);
                        return $datetime;
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a DATE');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to DATE');

            case self::BOOLEAN:
                switch ($srctype) {
                    case self::STRING:
                    case self::LONG:
                    case self::DOUBLE:
                    case self::BOOLEAN:
                        return (boolean) $value;
                    case self::DATE:
                        return (boolean) $value->getTimestamp();
                    case self::DECIMAL:
                        return (boolean) ((double) $value); // '0' is false too
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a BOOLEAN');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to a BOOLEAN');

            case self::NAME:
                switch ($srctype) {
                    case self::STRING:
                    case self::PATH:
                    case self::NAME:
                        // TODO: check if valid
                        return $value;
                    case self::URI:
                        // TODO: check if valid, remove leading ./, decode
                        return $value;
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a NAME');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to NAME');

            case self::PATH:
                switch ($srctype) {
                    case self::STRING:
                        // TODO: check if valid
                        return $value;
                    case self::NAME:
                    case self::PATH:
                        return $value;
                    case self::URI:
                        // TODO: check if valid, remove leading ./, decode
                        return $value;
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a PATH');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to PATH');

            case self::REFERENCE:
            case self::WEAKREFERENCE:
                switch ($srctype) {
                    case self::STRING:
                    case self::REFERENCE:
                    case self::WEAKREFERENCE:
                        if (empty($value)) {
                            //TODO check if string is valid uuid
                            throw new \PHPCR\ValueFormatException('Value '.var_export($value, true).' is not a valid unique id');
                        }
                        return $value;
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a unique id');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to unique id');

            case self::URI:
                switch ($srctype) {
                    case self::STRING:
                        // TODO: check if valid
                        return $value;
                    case self::NAME:
                        return '../'.rawurlencode($value);
                    case self::PATH:
                        if (strlen($value) > 0
                            && '/' != $value[0]
                            && '.' != $value[0]
                        ) {
                            $value = './'.$value;
                        }
                        return str_replace('%2F', '/', rawurlencode($value));
                    case self::URI:
                        return $value;
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a URI');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to URI');

            case self::DECIMAL:
                switch ($srctype) {
                    case self::STRING:
                        // TODO: validate
                        return $value;
                    case self::LONG:
                    case self::DOUBLE:
                    case self::BOOLEAN:
                    case self::DECIMAL:
                        return (string) $value;
                    case self::DATE:
                        return (string) $value->getTimestamp();
                }
                if (is_object($value)) {
                    throw new \PHPCR\ValueFormatException('Can not convert object of class '.get_class($value).' to a DECIMAL');
                }
                throw new \PHPCR\ValueFormatException('Can not convert '.var_export($value, true).' to a DECIMAL');

            default:
                throw new \PHPCR\ValueFormatException("Unexpected target type $type in conversion");
        }

    }
}
