<?php
// $Id: Property.interface.php 399 2005-08-13 19:38:08Z tswicegood $

/**
 * This file contains {@link Property} which is part of the PHP Content Repository
 * (phpCR), a derivative of the Java Content Repository JSR-170,  and is 
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
 * A {@link Property} object represents the smallest granularity of content
 * storage.
 *
 * A {@link Property} must have one and only one parent {@link Node}. A 
 * {@link Property}does not have children. When we say that {@link Node} A "has" {@link Property}B 
 * it means that B  is a child of A.
 *
 * A {@link Property} consists of a name and a value. See {@link Value}.
 *
 * @see Value, Node
 *
 * @package phpContentRepository
 */
interface phpCR_Property extends phpCR_Item {

	/**
	 * Sets the value of this {@link Property} to $value.
	 *
	 * If this {@link Property}'s {@link PropertyType} is not constrained by 
	 * the {@link NodeType} of its parent {@link Node}, then the
	 * {@link PropertyType} is changed to that of the supplied 
	 * $value. 
	 *
	 * If the {@link PropertyType} is constrained, then a best-effort conversion 
	 * is attempted. If conversion fails, a {@link ValueFormatException} is 
	 * thrown immediately (not on {@link save()}).
	 *
	 * The change will be persisted (if valid) on {@link save()}
	 *
	 * <b>PHP Note</b>: As PHP does not have method overloading, we can not
	 * have multiple definitions of this method, thus setValue() has to account
	 * for the following types: {@link Value} object, array of {@link Value}s
	 * string, boolean, int (Java long), float (Java double).  While the actual
	 * implementation is left up to programmer/designer, the best practice might
	 * be to implement some sort of switch statement to hand $value
	 * off to another method based on it's type.
	 *
	 * @param mixed
	 *   The new value to set the {@link Property} to.
	 * @throws {@link ValueFormatException}
	 *   If the type or format of the specified value is incompatible with the 
	 *   type of this {@link Property}.
	 * @throws {@link RepositoryException}
	 *   If another error occurs.
	 */
	public function setValue($value);
	
	
	/**
	 * Returns the value of this {@link Property}.
	 *
	 * Returns the value of the {@link Property} as a generic {@link Value} 
	 * object or NULL if the {@link Property} has no value.
	 *
	 * @return object
	 *
	 * @throws {@link ValueFormatException}
	 *    If the property is multi-valued.
	 * @throws {@link RepositoryException}
	 *   If an error occurs.
	 */
	public function getValue();
	
	
	/**
	 * Returns an array of all the values of this {@link Property}. Used to 
	 * access multi-value properties.
	 *
	 * @return array
	 *   An array of {@link Value}s.
	 * @throws {@link RepositoryException}
	 *   If an error occurs.
	 */
	public function getValues();
	
	
	/**
	 * Returns a string representation of the value of this
	 * {@link Property}. 
	 *
	 * A shortcut for Property->getValue()->getString().
	 *
	 * If this Property is multi-valued, this method returns the first value.
	 *
	 * @see Value
	 * @return string
	 *   A string representation of the value of this {@link Property}.
	 */
	public function getString();
	
	
	/**
	 * Returns a float (Java double) representation of
	 * the value of this {@link Property}.
	 *
	 * A shortcut for Property->getValue()->getFloat(). 
	 *
	 * If this Property is multi-valued, this method returns the first value.
	 *
	 * <b>PHP Note</b>: This method is unique from JCR and is added do to PHP's
	 * naming of the float type.  
	 *
	 * This method should return the same as {@link getDouble()}.
	 *
	 * @see Value, Value::getFloat(), getDouble()
	 * @return float
	 *   A float representation of the value of this {@link Property}.
	 */
	public function getFloat();
	
	
	/**
	 * An alias to {@link getFloat()} in order to provide the necessary functions
	 * to meet JCR standards.
	 *
	 * A shortcut for Property->getValue()->getDouble(). 
	 *
	 * This method should return the same as {@link getFloat()}.
	 *
	 * @see getFloat(), Value::getDouble()
	 * @return float
	 */
	public function getDouble();
	
	
	/**
	 * Returns a stream representation of the value of this {@link Property}. 
	 *
	 * A shortcut for Property->getValue()->getStream(). 
	 *
	 * If this Property is multi-valued, this method returns the first value.
	 *
	 * <b>PHP Note</b>: PHP handles streams slightly differently and provides
	 * no superclass such as InputStream providing a uniform method
	 * for implementing streams.  As such, it is up the developer to determine 
	 * whether to return a resource that "exhibits streamable behavior" or an
	 * object that handles the streaming for them.  See
	 * {@link http://us2.php.net/manual/en/ref.stream.php Stream Functions} for
	 * a full explanation of PHP's stream capabilities.
	 *
	 * @see Value, Value::getStream()
	 * @return object|reference
	 *   A stream representation of the value of this {@link Property}.
	 */
	public function getStream();
	
	
	/**
	 * Returns a {@link Calendar} representation of the value of this 
	 * {@link Property}.
	 *
	 * A shortcut for Property->getValue()->getDate().
	 *
	 * If this {@link Property} is multi-valued, this method returns the first 
	 * value.
	 *
	 * <b>PHP Note</b>: PHP does not provide a specific Calendar class, so
	 * the actual implementation is left up to the user.  One option is to
	 * utilize Harry Fuecks' 
	 * {@link http://pear.php.net/package/Calendar Calendar} PEAR package.
	 *
	 * @see Value, Value::getDate()
	 * @return object 
	 *   A date representation of the value of this {@link Property}.
	 */
	public function getDate();
	
	
	/**
	 * Returns a boolean representation of the value of this
	 * {@link Property}.
	 *
	 * A shortcut for Property->getValue()->getBoolean().
	 *
	 * If this Property is multi-valued, this method returns the first value.
	 *
	 * @see Value::getBoolean()
	 * @return bool
	 *   A boolean representation of the value of this {@link Property}.
	 */
	public function getBoolean();
	
	
	/**
	 * Returns an integer representation of the value of this
	 * {@link Property}.
	 *
	 * A shortcut for Property->getValue()->getInt().
	 *
	 * If this Property is multi-valued, this method returns the first value.
	 *
	 * @see Value::getLong()
	 * @return int
	 *   An integer representation of the value of this {@link Property}.
	 */
	public function getInt();
	
	
	/**
	 * An alias to {@link getInt()} in order to provide the necessary functions
	 * to meet the JCR standard.
	 *
	 * A shortcut for Property->getValue()->getLong().
	 *
	 * If this Property is multi-valued, this method returns the first value.
	 *
	 * @see Value::getLong()
	 * @return int
	 *   An integer representation of the value of this {@link Property}.
	 */
	public function getLong();
	
	
	/**
	 * Returns the length of the value of this {@link Property}.
	 *
	 * Level 1 and 2:
	 *
	 * Returns the length of the value of this {@link Property} in bytes if the 
	 * value is a {@link PropertyType::_BINARY}, otherwise it returns the number
	 * of characters needed to display the value (for strings this is the string
	 * length, for numeric types it is the number of characters needed to
	 * display the number). Returns -1 if the implementation cannot determine
	 * the length. Returns 0 if the {@link Property}has no value.
	 *
	 * @return int
	 */
	public function getLength();
	
	
	/**
	 * Returns the definition of this {@link Property}. 
	 *
	 * This method is actually a shortcut to searching through this 
	 * {@link Property}'s parent's {@link NodeType} (and its supertypes) for the
	 * {@link Property} definition applicable to this {@link Property}.
	 *
	 * @see NodeType::getPropertyDefinitions()
	 *
	 * @return object
	 *	A {@link PropertyDef} object
	 *
     * @throws {@link RepositoryException}
	 *    If an error occurs.	 
	 */
	public function getDefinition();
	
	
    /**
     * Returns the type of this <i>Property</i>. One of:
     * <ul>
     *    <li>{@link PropertyType::$STRING}</li>
     *    <li>{@link PropertyType::$BINARY}</li>
     *    <li>{@link PropertyType::$DATE}</li>
     *    <li>{@link PropertyType::$DOUBLE}</li>
     *    <li>{@link PropertyType::$LONG}</li>
     *    <li>{@link PropertyType::$BOOLEAN}</li>
     *    <li>{@link PropertyType::$NAME}</li>
     *    <li>{@link PropertyType::$PATH}</li>
     *    <li>{@link PropertyType::$REFERENCE}</li>
     * </ul>
	 *
     * The type returned is that which was set at property creation. Note that for some property <i>p</i>,
     * the type returned by <i>p.getType()</i> may differ from the type returned by
     * <i>p.getDefinition.getRequiredType()</i> only in the case where the latter returns <i>UNDEFINED</i>.
     * The type of a property instance is never <i>UNDEFINED</i> (it must always have some actual type).
     *
     * @return int
	 *
     * @throws {@link RepositoryException}
	 *    If an error occurs
     */
    public function getType();
}

?>