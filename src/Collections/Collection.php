<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Collections;

use Frametek\Interfaces\CollectionInterface;

/**
 * Collection
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
abstract class Collection implements CollectionInterface
{	
	/**
	 * Set collection item by reference of the collection
	 * 
     * @param string   $key    The data key
     * @param mixed    $value  The data value
	 * @param array    $ref    The array to change
	 */
    private function setRef( $key, $value, array &$ref )
    {
    	$ref[ $key ] = $value;
    }
	
    /********************************************************************************
     * Collection interface
     *******************************************************************************/

    /**
     * Set collection item
     *
     * @param string    $key    The data key
     * @param mixed     $value  The data value
     */
    public function set( $key, $value )
    {
        $d = $this->all();
        $this->setRef( $key, $value, $d );
    }
	
    /**
     * Get collection item for key
     *
     * @param string    $key        The data key
     * @param mixed     $default    The default value to return if data key does not exist
     *
     * @return mixed The key's value, or the default value
     */
    public function get( $key, $default = null )
    {
        return ( $this->has( $key ) ) ? $this->all()[ $key ] : $default;
    }
    
    /**
     * Does the collection have a given key?
     *
     * @param string    $key    The data key
     *
     * @return bool
     */
    public function has( $key )
    {
        return isset( $this->all()[ $key ] );
    }
    
    /**
     * Add item to collection
     *
     * @param array $items Key-value array of data to append to the collection
     */
    public function replace( array $items )
    {
        foreach ( $items as $key => $value ) {
            $this->set( $key, $value );
        }
    }
    
    /**
     * Remove item from collection
     *
     * @param string    $key    The data key
     * @param bool      $all    Specifie if all folders of the key path will be remove or not
     */
    public function remove( $key, $all = false )
    {
    	if( $this->has( $key ) )
    	{
    		unset( $this->all()[ $key ] );
    	}
    }
    
    /**
     * Remove all items from collection with a list of exception
     *
     * @param array $excepts The collection's keys to prevent from remove
     */
    public function clear( array $excepts = [] )
    {
        $tmp = array();
        foreach( $excepts as $except ) {
            if( $this->has( $except ) ) {
                $tmp[ $except ] = $this->get( $except );
            }
        }
        $this->setAll( array() );
        foreach( $tmp as $key => $value ) {
            $this->set( $key, $value );
        }
    }
    
    /********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/
    
    /**
     * Does the collection have a given key?
     *
     * @param string    $key    The data key
     *
     * @return bool
     */
    public function offsetExists( $key )
    {
        return $this->has( $key );
    }
    
    /**
     * Get collection item for key
     *
     * @param string    $key    The data key
     *
     * @return mixed    The key's value, or the default value
     */
    public function offsetGet( $key )
    {
        return $this->get( $key );
    }
    
    /**
     * Set collection item
     *
     * @param string    $key    The data key
     * @param mixed     $value  The data value
     */
    public function offsetSet( $key, $value )
    {
        $this->set( $key, $value );
    }
    
    /**
     * Remove item from collection
     *
     * @param string    $key    The data key
     */
    public function offsetUnset( $key )
    {
        $this->remove( $key );
    }
    
    /**
     * Get number of items in collection
     *
     * @return int
     */
    public function count()
    {
        return count( $this->all() );
    }
    
    
    /********************************************************************************
     * IteratorAggregate interface
     *******************************************************************************/
    
    /**
     * Get collection iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->all() );
    }
}