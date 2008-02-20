<?php
declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

require_once('PHPUnit/Framework.php');


define('BASE_CHAR', '\X0041-\X005A|\X0061-\X007A|\X00C0-\X00D6|\X00D8-\X00F6|\X00F8-\X00FF|\X0100-\X0131|\X0134-\X013E|
        \X0141-\X0148|\X014A-\X017E|\X0180-\X01C3|\X01CD-\X01F0|\X01F4-\X01F5|\X01FA-\X0217|\X0250-\X02A8|
        \X02BB-\X02C1|\X0386|\X0388-\X038A|\X038C|\X038E-\X03A1|\X03A3-\X03CE|\X03D0-\X03D6|\X03DA|\X03DC|
        \X03DE|\X03E0|\X03E2-\X03F3|\X0401-\X040C|\X040E-\X044F|\X0451-\X045C|\X045E-\X0481|\X0490-\X04C4|
        \X04C7-\X04C8|\X04CB-\X04CC|\X04D0-\X04EB|\X04EE-\X04F5|\X04F8-\X04F9|\X0531-\X0556|\X0559|
        \X0561-\X0586|\X05D0-\X05EA|\X05F0-\X05F2|\X0621-\X063A|\X0641-\X064A|\X0671-\X06B7|\X06BA-\X06BE|
        \X06C0-\X06CE|\X06D0-\X06D3|\X06D5|\X06E5-\X06E6|\X0905-\X0939|\X093D|\X0958-\X0961|\X0985-\X098C|
        \X098F-\X0990|\X0993-\X09A8|\X09AA-\X09B0|\X09B2|\X09B6-\X09B9|\X09DC-\X09DD|\X09DF-\X09E1|
        \X09F0-\X09F1|\X0A05-\X0A0A|\X0A0F-\X0A10|\X0A13-\X0A28|\X0A2A-\X0A30|\X0A32-\X0A33|\X0A35-\X0A36|
        \X0A38-\X0A39|\X0A59-\X0A5C|\X0A5E|\X0A72-\X0A74|\X0A85-\X0A8B|\X0A8D|\X0A8F-\X0A91|\X0A93-\X0AA8|
        \X0AAA-\X0AB0|\X0AB2-\X0AB3|\X0AB5-\X0AB9|\X0ABD|\X0AE0|\X0B05-\X0B0C|\X0B0F-\X0B10|\X0B13-\X0B28|
        \X0B2A-\X0B30|\X0B32-\X0B33|\X0B36-\X0B39|\X0B3D|\X0B5C-\X0B5D|\X0B5F-\X0B61|\X0B85-\X0B8A|
        \X0B8E-\X0B90|\X0B92-\X0B95|\X0B99-\X0B9A|\X0B9C|\X0B9E-\X0B9F|\X0BA3-\X0BA4|\X0BA8-\X0BAA|
        \X0BAE-\X0BB5|\X0BB7-\X0BB9|\X0C05-\X0C0C|\X0C0E-\X0C10|\X0C12-\X0C28|\X0C2A-\X0C33|\X0C35-\X0C39|
        \X0C60-\X0C61|\X0C85-\X0C8C|\X0C8E-\X0C90|\X0C92-\X0CA8|\X0CAA-\X0CB3|\X0CB5-\X0CB9|\X0CDE|
        \X0CE0-\X0CE1|\X0D05-\X0D0C|\X0D0E-\X0D10|\X0D12-\X0D28|\X0D2A-\X0D39|\X0D60-\X0D61|\X0E01-\X0E2E|
        \X0E30|\X0E32-\X0E33|\X0E40-\X0E45|\X0E81-\X0E82|\X0E84|\X0E87-\X0E88|\X0E8A|\X0E8D|\X0E94-\X0E97|
        \X0E99-\X0E9F|\X0EA1-\X0EA3|\X0EA5|\X0EA7|\X0EAA-\X0EAB|\X0EAD-\X0EAE|\X0EB0|\X0EB2-\X0EB3|\X0EBD|
        \X0EC0-\X0EC4|\X0F40-\X0F47|\X0F49-\X0F69|\X10A0-\X10C5|\X10D0-\X10F6|\X1100|\X1102-\X1103|
        \X1105-\X1107|\X1109|\X110B-\X110C|\X110E-\X1112|\X113C|\X113E|\X1140|\X114C|\X114E|\X1150|
        \X1154-\X1155|\X1159|\X115F-\X1161|\X1163|\X1165|\X1167|\X1169|\X116D-\X116E|\X1172-\X1173|\X1175|
        \X119E|\X11A8|\X11AB|\X11AE-\X11AF|\X11B7-\X11B8|\X11BA|\X11BC-\X11C2|\X11EB|\X11F0|\X11F9|
        \X1E00-\X1E9B|\X1EA0-\X1EF9|\X1F00-\X1F15|\X1F18-\X1F1D|\X1F20-\X1F45|\X1F48-\X1F4D|\X1F50-\X1F57|
        \X1F59|\X1F5B|\X1F5D|\X1F5F-\X1F7D|\X1F80-\X1FB4|\X1FB6-\X1FBC|\X1FBE|\X1FC2-\X1FC4|\X1FC6-\X1FCC|
        \X1FD0-\X1FD3|\X1FD6-\X1FDB|\X1FE0-\X1FEC|\X1FF2-\X1FF4|\X1FF6-\X1FFC|\X2126|\X212A-\X212B|\X212E|
        \X2180-\X2182|\X3041-\X3094|\X30A1-\X30FA|\X3105-\X312C|\XAC00-\XD7A3');

define('IDEOGRAPHIC',  '\X4E00-\X9FA5|\X3007|\X3021-\X3029');

define('COMBINING_CHAR', '\X0300-\X0345|\X0360-\X0361|\X0483-\X0486|\X0591-\X05A1|\X05A3-\X05B9|\X05BB-\X05BD|\X05BF|
        \X05C1-\X05C2|\X05C4|\X064B-\X0652|\X0670|\X06D6-\X06DC|\X06DD-\X06DF|\X06E0-\X06E4|\X06E7-\X06E8|
        \X06EA-\X06ED|\X0901-\X0903|\X093C|\X093E-\X094C|\X094D|\X0951-\X0954|\X0962-\X0963|\X0981-\X0983|
        \X09BC|\X09BE|\X09BF|\X09C0-\X09C4|\X09C7-\X09C8|\X09CB-\X09CD|\X09D7|\X09E2-\X09E3|\X0A02|\X0A3C|
        \X0A3E|\X0A3F|\X0A40-\X0A42|\X0A47-\X0A48|\X0A4B-\X0A4D|\X0A70-\X0A71|\X0A81-\X0A83|\X0ABC|
        \X0ABE-\X0AC5|\X0AC7-\X0AC9|\X0ACB-\X0ACD|\X0B01-\X0B03|\X0B3C|\X0B3E-\X0B43|\X0B47-\X0B48|
        \X0B4B-\X0B4D|\X0B56-\X0B57|\X0B82-\X0B83|\X0BBE-\X0BC2|\X0BC6-\X0BC8|\X0BCA-\X0BCD|\X0BD7|
        \X0C01-\X0C03|\X0C3E-\X0C44|\X0C46-\X0C48|\X0C4A-\X0C4D|\X0C55-\X0C56|\X0C82-\X0C83|\X0CBE-\X0CC4|
        \X0CC6-\X0CC8|\X0CCA-\X0CCD|\X0CD5-\X0CD6|\X0D02-\X0D03|\X0D3E-\X0D43|\X0D46-\X0D48|\X0D4A-\X0D4D|
        \X0D57|\X0E31|\X0E34-\X0E3A|\X0E47-\X0E4E|\X0EB1|\X0EB4-\X0EB9|\X0EBB-\X0EBC|\X0EC8-\X0ECD|
        \X0F18-\X0F19|\X0F35|\X0F37|\X0F39|\X0F3E|\X0F3F|\X0F71-\X0F84|\X0F86-\X0F8B|\X0F90-\X0F95|\X0F97|
        \X0F99-\X0FAD|\X0FB1-\X0FB7|\X0FB9|\X20D0-\X20DC|\X20E1|\X302A-\X302F|\X3099|\X309A');

define('DIGIT', '\X0030-\X0039|\X0660-\X0669|\X06F0-\X06F9|\X0966-\X096F|\X09E6-\X09EF|\X0A66-\X0A6F|\X0AE6-\X0AEF|
        \X0B66-\X0B6F|\X0BE7-\X0BEF|\X0C66-\X0C6F|\X0CE6-\X0CEF|\X0D66-\X0D6F|\X0E50-\X0E59|\X0ED0-\X0ED9|
        \X0F20-\X0F29');

define('EXTENDER', '\X00B7|\X02D0|\X02D1|\X0387|\X0640|\X0E46|\X0EC6|\X3005|\X3031-\X3035|\X309D-\X309E|\X30FC-\X30FE');

    /*
    name's prefix must be a valid xml name:
    http://www.w3.org/TR/REC-xml-names
    [4] 	NCName 	 ::= 	(Letter | '_') (NCNameChar)*	  // An XML Name, minus the ":"
    [5] 	NCNameChar 	::= 	Letter | Digit | '.' | '-' | '_' | CombiningChar | Extender
    [84]   	Letter	   ::=   	BaseChar | Ideographic
    */

define('LETTER', BASE_CHAR . "|" . IDEOGRAPHIC);

define('NC_NAME', "[" . LETTER . "|_]" . "[" .  LETTER . "|" . DIGIT . "|.|\\-|_|" . COMBINING_CHAR . "|" . EXTENDER . "]*");

define('SIMPLENAME_CHAR', "[^/:\\[\\]\\*'\"\\s]");

define('PATTERNSTRING_NAME', "((" . NC_NAME . "):)?" . // prefix
        SIMPLENAME_CHAR . "([" . SIMPLENAME_CHAR . "| ]*" . SIMPLENAME_CHAR . ")?");

define('PATTERN_NAME', '#'.PATTERNSTRING_NAME.'#');

define('PATTERNSTRING_PATH_ELEMENT', PATTERNSTRING_NAME . "(\\[[1-9]\\d*\\])?");

define('PATTERNSTRING_PATH_WITHOUT_LAST_SLASH', "(\\./|\\.\\./|/)?" .
        "(" . PATTERNSTRING_PATH_ELEMENT . "/)*" .
        PATTERNSTRING_PATH_ELEMENT);

define('PATTERNSTRING_PATH', PATTERNSTRING_PATH_WITHOUT_LAST_SLASH . "/?");

define('PATTERN_PATH', '#'.PATTERNSTRING_PATH.'#');

define('PATTERNSTRING_DATE', "[0-9][0-9][0-9][0-9]-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]||2[0-9]|3[01])" .
        "T([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9].[0-9][0-9][0-9]" .
        "(Z|[+-]([0-1][0-9]|2[0-3]):[0-5][0-9])");

define('PATTERN_DATE', '#'.PATTERNSTRING_DATE.'#');

/**
 * This class provides various utility methods that are used by the property
 * test cases.
 *
 * @package		phpCR
 * @version 	$Id$
 * @author		Ronny Unger <ru@php-workx.de>
 * @author		Karsten Dambekalns <karsten@typo3.org>
 * @copyright	Copyright belongs to the respective authors
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
abstract class phpCR_PropertyUtil {

    /**
     * Traverses a tree below a given node searching for a property with a given
     * type
     *
     * @param session	Session		the session
     * @param node 		Node		the node to start traverse
     * @param type 		integer		the property type to search for
     * @return the property found or null if no property is found
     */
    public static function searchProp($session, $node, $type) {

        $prop = null;
        $propType = T3_phpCRJackrabbit_PropertyType::UNDEFINED;
        if ($prop == null) {
            for ($props = $node->getProperties(); $props->hasNext(); ) {
                $property = $props->nextProperty();
                $propType = $property->getType();
                if ($propType == $type) {
                    $prop = $property;
                    break;
                }
            }
        }
        if ($prop == null) {
            for ($nodes = $node->getNodes(); $nodes->hasNext(); ) {
                $n = $nodes->nextNode();
                $prop = T3_phpCRJackrabbit_PropertyUtil::searchProp($session, $n, $type);
                if ($prop != null) {
                    break;
                }
            }
        }
        return $prop;
    }

    /**
     * Returns the value of a property. If <code>prop</code> is multi valued
     * this method returns the first value.
     *
     * @param prop the property from which to return the value.
     * @return the value of the property.
     */
    public static function getValue($prop) {
        $val;
        if ($prop->getDefinition()->isMultiple()) {
            $vals = (array)$prop->getValues();
            if (count($vals) > 0) {
                $val = $vals[0];
            } else {
                $val = null;
            }
        } else {
            $val = $prop->getValue();
        }
        return $val;
    }

    /**
     * checks if the given name follows the NAME syntax rules and if a present
     * prefix is mapped to a registered namespace
     *
     * @param name the string to test
     */
    public static function checkNameFormat($name, $session) {
        if ($name == null || strlen($name) == 0) {
            return false;
        } else {
            $nsr = $session->getWorkspace()->getNamespaceRegistry();
            $prefixOk = true;

            // validate namespace prefixes if present
            $split = explode(':', $name);
            if (count($split) > 1) {
                $prefix = $split[0];
                try {
                    $nsr->getURI($prefix);
                } catch (phpCR_NamespaceException $e) {
                    $prefixOk = false;
                }
            }

            // validate name element
            $matches = preg_match(PATTERN_NAME, $name);

            return $matches && $prefixOk;
        }
    }

    /**
     * Checks if the given path follows the path syntax rules.
     *
     * @param jcrPath the string to test
     */
    public static function checkPathFormat($jcrPath, $session) {
        if ($jcrPath == null || strlen($jcrPath) == 0) {
            return false;
        } else if ($jcrPath == "/") {
            return true;
        } else {
            $nsr = $session->getWorkspace()->getNamespaceRegistry();
            $match = false;
            $prefixOk = true;
            // split path into path elements and validate each of them
            $elems = (array)split("/", $jcrPath, -1);
            for ($i = (strpos($jcrPath, "/")===0 ? 1 : 0); $i < count($elems); $i++) {
                // validate path element
                $elem = $elems[$i];
                $match = preg_match(PATTERN_PATH, $elem);
                if (!(bool)$match) {
                    break;
                }

                // validate namespace prefixes if present
                $split = (array)split($elem, ":");
                if (count($split) > 1) {
                    $prefix = $split[0];
                    try {
                        $nsr->getURI($prefix);
                    } catch (phpCR_NamespaceException $e) {
                        $prefixOk = false;
                        break;
                    }
                }
            }
            return $match && $prefixOk;
        }
    }

    /**
     * Checks if the String is a valid date in string format.
     *
     * @param str the string to test.
     * @return <code>true</code> if <code>str</code> is a valid date format.
     */
    public static function isDateFormat($str) {
        return (bool)preg_match(PATTERN_DATE, $str);
    }

    /**
     * Counts the number of bytes of a Binary value.
     *
     * @param val the binary value.
     * @return the number of bytes or -1 in case of any exception
     */
    public static function countBytes($val) {
        $length = 0;
        $in = null;
        try {
            $in = $val->getStream();
            $bin = new BufferedInputStream($in);
            while ($bin->read() != -1) {
                $length++;
            }
            $bin->close();
        } catch (Exception $e) {
            $length = -1;
        }

        if ($in != null) {
            $in->close();
        }

        return $length;
    }

    /**
     * Helper method to test the type received with Value.getType() and
     * Property.getType() .
     */
    public static function checkGetType($prop, $propType) {
        $val = self::getValue($prop);
        $samePropType = ($val->getType() == $propType);
        $requiredType = $prop->getDefinition()->getRequiredType();
        if ($requiredType != phpCR_PropertyType::UNDEFINED) {
            $samePropType = ($val->getType() == $requiredType);
        }
        return $samePropType;
    }

    /**
     * Helper method to compare the equality of two values for equality with the
     * fulfilling of the equality conditions. These conditions for the values
     * are to have the same type and the same string representation.
     *
     * @param val1 first value
     * @param val2 second value
     * @return true if the equals method is equivalent to the normative
     *         definition of value equality, false in the other case.
     */
    public static function equalValues($val1, $val2) {

        $isEqual = ($val1 == $val2 ? true : false);
        $conditions = false;
        try {
            $conditions = ($val1->getType() == $val2->getType()) && ($val1->getString() == $val2->getString() ? true : false);
        } catch (phpCR_ValueFormatException $e) {
            return false;
        }
        return ($isEqual == $conditions);
    }

    /**
     * Helper method to assure that no property with a null value exist.
     *
     * @param node the node to start the search from.
     * @return <code>true</code> if a null value property is found;
     *         <code>false</code> in the other case.
     */
    public static function nullValues($node) {
        $nullValue = false;
        for ($props = $node->getProperties(); $props->hasNext(); ) {
            $property = $props->nextProperty();
            if (!$property->getDefinition()->isMultiple()) {
                $nullValue = ($property->getValue() == null);
                if ($nullValue) {
                    break;
                }
            }
        }

        if (!$nullValue) {
            for ($nodes = $node->getNodes(); $nodes->hasNext(); ) {
                $n = $nodes->nextNode();
                $nullValue = $this->nullValues($n);
            }
        }
        return $nullValue;
    }

    /**
     * Helper method to find a multivalue property. If a type is given,
     * the helper method tries to find a multivalue property of a given type.
     *
     * @param node the node to start the search from.
     * @param type the property type.
     * @return a multivalue property or null if not found any.
     */
    public static function searchMultivalProp($node, $type=null) {
        $multiVal = null;
        for ($props = $node->getProperties(); $props->hasNext(); ) {
            $property = $props->nextProperty();

            if ($type != null) {
            	if ($property->getDefinition()->isMultiple() && $property->getType() == $type) {
	                $multiVal = $property;
	                break;
	            }
            } else {
            	if ($property->getDefinition()->isMultiple()) {
	                $multiVal = $property;
	                break;
	            }
            }
        }

        if ($multiVal == null) {
            for ($nodes = $node->getNodes(); $nodes->hasNext(); ) {
                $n = $nodes->nextNode();
                $multiVal = $this->searchMultivalProp($n, $type);
                if ($multiVal != null) {
                    break;
                }
            }
        }
        return $multiVal;
    }
}
?>