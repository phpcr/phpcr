<?php
// $Id: Value.interface.php 717 2005-09-16 18:33:19Z tswicegood $

/**
 * This file contains {@link Value} which is part of the PHP Content Repository 
 * (phpCR), a derivative of the Java Content Repository JSR-170, and is
 * licensed under the Apache License, Version 2.0.
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
 */


/**
 * A generic holder for the value of a property. 
 *
 * A {@link Value} object can be used without knowing the actual property 
 * type (<i>STRING</i>, <i>DOUBLE</i>, <i>BINARY</i> etc.).
 *
 * Any implementation of this interface must adhere to the following behavior:
 * <ul>
 *    <li>
 *        A {@link Value} object can be read using type-specific 
 *       <i>get</i> methods. These methods are divided into two groups:
 *       <ul>
 *           <li>
 *               The non-stream <i>get</i> methods {@link getString()}, 
 *               {@link getDate()}, {@link getLong()}, {@link getDouble()} and 
 *               {@link getBoolean()}.
 *           </li>
 *           <li>
 *               {@link getStream()}
 *           </li>
 *       </ul>
 *    </li>
 *    <li>
 *        Once a {@link Value} object has been read once using 
 *        {@link getStream()}, all subsequent calls to {@link getStream()} will 
 *        return the same {@link Stream} object. This may mean, for example,
 *        that the stream returned is fully or partially consumed. In order to
 *        get a fresh stream the {@link Value} object must be reacquired via 
 *        {@link Property::getValue()} or {@link Property::getValues()}.
 *    </li>
 *    <li>
 *        Once a {@link Value} object has been read once using 
 *        {@link getStream()}, any subsequent call to any of the non-stream 
 *        <i>get</i> methods will throw an {@link IllegalStateException}.
 *        In order to successfully invoke a non-stream <i>get</i> method,
 *        the {@link Value} must be reacquired.
 *    </li>
 *    <li>
 *        Once a {@link Value} object has been read once using a non-stream get
 *        method, any subsequent call to {@link getStream()} will throw an 
 *        {@link IllegalStateException}. In order to successfully invoke 
 *        {@link getStream()}, the {@link Value} must be reacquired.
 *    </li>
 * </ul>
 *
 * Two {@link Value} instances, <i>v1</i> and <i>v2</i>, are 
 * considered equal if and only if:
 * <ul>
 *     <li><i>v1.getType() == v2.getType()</i>, and,</li>
 *     <li><i>v1.getString().equals(v2.getString())</i></li>
 * </ul>
 * Actually comparing two {@link Value} instances by converting them to string
 * form may not be practical in some cases (for example, if the values are very
 * large binaries). Consequently, the above is intended as a normative 
 * definition of {@link Value} equality but not as a procedural test of
 * equality. It is assumed that implementations will have efficient means of
 * determining equality that conform with the above definition.
 *
 * @package phpContentRepository
 */
interface phpCR_Value
{
	/**
	 * Returns a string representation of this value.
	 *
	 * @return string
	 *
	 * @throws {@link ValueFormatException}
	 *    If conversion to a string is not possible.
	 * @throws {@link IllegalStateException}
	 *    If {@link getStream()} has previously been called on this 
	 *    {@link Value} instance.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getString();
	
	
	/**
	 * Returns the stream resource of this value.
	 *
	 * <b>PHP Note</b>: As of PHP 5.0.x, there is no standard OO PHP stream
	 * interface, thus this method should be expected to return a valid file
	 * handle that can be utilized via fopen()/fread()/fclose().
	 *
	 * A default memory stream handler is available in {@link ValueStream}.
	 *
	 * @return resource
	 *     A valid PHP stream resource.
	 *
	 * @throws {@link IllegalStateException}
	 *    If non stream <i>get*()</i> has been previous called on this
	 *    {@link Value} object.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getStream();
	
	
	/**
	 * Returns the int representation of this value.
	 *
	 * This method should always return exactly what {@link getInt()} does.
	 * It has been left as a requirement to satisfy JCR compliance.
	 *
	 * @return int
	 * @see getInt()
	 */
	public function getLong();
	
	/**
	 * Returns the int representation of this value.
	 *
	 * @return int
	 *
	 * @throws {@link ValueFormatException}
	 *    If conversion to a int is not possible.
	 * @throws {@link IllegalStateException}
	 *    If {@link getStream()} has previously been called on this 
	 *    {@link Value} instance.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getInt();
	

	/**
	 * Returns the float/double representation of this value.
	 *
	 * This method should always return exactly what {@link getFloat()} does.
	 * It has been left as a requirement to satisfy JCR compliance.
	 *
	 * @see getFloat()
	 * @return float
	 */
	public function getDouble();
	
	/**
	 * Returns the float/double representation of this value.
	 *
	 * This method should always be an alias of {@link getFloat()}.
	 *
	 * @see getFloat()
	 * @return float
	 *
	 * @throws {@link ValueFormatException}
	 *    If conversion to a float is not possible.
	 * @throws {@link IllegalStateException}
	 *    If {@link getStream()} has previously been called on this 
	 *    {@link Value} instance.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getFloat();
	
	
	/**
	 * Returns the timestamp string of this value.
	 *
	 * <b>PHP Note</b>: PHP does not have a default Calendar object.  This 
	 * method has been adjusted to return a string representing a valid
	 * timestamp.
	 *
	 * Future version of phpCR may implement a simple date/time object to
	 * handle returning a mock of Java's Calendar object.
	 *
	 * Given the fluid nature of this method, it is advisable to throw a
	 * {@link ValidFormatException} on all {@link Value}s except those which
	 * must be returned as dates until a definitive return value is determined.
	 *
	 * @return string
	 *
	 * @throws {@link ValueFormatException}
	 *    If conversion to a timestamp/date is not possible.
	 * @throws {@link IllegalStateException}
	 *    If {@link getStream()} has previously been called on this 
	 *    {@link Value} instance.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getDate();
	
	
	/**
	 * Returns the boolean representation of this value.
	 *
	 * @return bool
	 *
	 * @throws {@link ValueFormatException}
	 *    If conversion to a boolean is not possible.
	 * @throws {@link IllegalStateException}
	 *    If {@link getStream()} has previously been called on this 
	 *    {@link Value} instance.
	 * @throws {@link RepositoryException}
	 *    If another error occurs.
	 */
	public function getBoolean();
	
	
	/**
	 * Returns the type of this Value.
	 * One of:
	 * <ul>
	 *    <li>{@link PropertyType::STRING}</li>
	 *    <li>{@link PropertyType::DATE}</li>
	 *    <li>{@link PropertyType::BINARY}</li>
	 *    <li>{@link PropertyType::DOUBLE}</li>
	 *    <li>{@link PropertyType::LONG}</li>
	 *    <li>{@link PropertyType::BOOLEAN}</li>
	 *    <li>{@link PropertyType::NAME}</li>
	 *    <li>{@link PropertyType::PATH}</li>
	 *    <li>{@link PropertyType::REFERENCE}</li>
	 * </ul>
	 *
	 * The type returned is that which was set at property creation.
	 *
	 * @see PropertyType
	 * @return int
	 */
	public function getType();

}

?>