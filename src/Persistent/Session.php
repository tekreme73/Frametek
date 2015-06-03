<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link      https://github.com/tekreme73/Frametek
 * @copyright Copyright (c) 2015 Rémi Rebillard
 * @license   https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

use Frametek\Interfaces\CollectionInterface;

/**
 * Session
 *
 * This class 
 *
 * @package Frametek
 * @author  Rémi Rebillard
 */
class Session implements CollectionInterface
{
	
	protected static $_SEP = '.';
	
    /**
     * Set session item
     *
     * Warn: Recursive function
     * 
     * @param string    $key   The session key
     * @param mixed     $value The session value
     * @param array     $in    The folder uses for the recursion
     */
    protected function setIn( $key, $value, &$in )
    {
        $keys = explode( static::$_SEP, $key, 2 );
        if( count( $keys ) > 0 ) {
            if( !isset( $in[ $keys[ 0 ] ] ) ) {
        	    if( count( $keys ) >= 2 ) {
                    $in[ $keys[ 0 ] ] = array();
        	    }
            }
            if( count( $keys ) >= 2 ) {
                $this->setIn( $keys[ 1 ], $value, $in[ $keys[ 0 ] ] );
            } else {
                $in[ $keys[ 0 ] ] = $value;
            }
        }
    }
    
    /**
     * Get session item for key
     *
     * Warn: Recursive function
     * 
     * @param string    $key    The session key
     * @param array     $in     The folder uses for the recursion
     *
     * @return mixed The key's value, or the default value
     */
    protected function getIn( $key, $in )
    {
        $keys = explode( static::$_SEP, $key, 2 );
        if( count( $keys ) <= 0 ) {
            return '';
        } else if( isset( $in[ $keys[ 0 ] ] ) ) {
            if( count( $keys ) >= 2 ) {
                return $this->getIn( $keys[ 1 ], $in[ $keys[ 0 ] ] );
            } else {
                return $in[ $keys[ 0 ] ];
            }
        } else {
            return '';
        }
    }
    
    /**
     * Does the session have a given key?
     *
     * Warn: Recursive function
     *
     * @param string    $key    The session key
     * @param array     $in     The folder uses for the recursion
     *
     * @return bool
     */
    protected function hasIn( $key, $in )
    {
        $keys = explode( static::$_SEP, $name, 2 );
        if( count( $keys ) <= 0 ) {
            return false;
        } else {
            if( !isset( $in[ $keys[ 0 ] ] ) ) {
                return false;
            } else {
                if( count( $keys ) >= 2 ) {
                    return true && $this->hasIn( $keys[ 1 ], $in[ $keys[ 0 ] ] );
                } else {
                    return true;
                }
            }
        }
    }
    
    /**
     * Remove item from session
     *
     * @param string    $key    The session key
     * @param array     $in     The folder uses for the recursion
     * @param bool      $all    Specifie if all folders of the key path will be remove or not
     */
    protected function removeIn( $key, &$in, $all = false )
    {
        $keys = explode( static::$_SEP, $key, 2 );
        if( count( $keys ) >= 0 ) {
            if( isset( $in[ $keys[ 0 ] ] ) ) {
                if( count( $keys ) >= 2 ) {
                    $this->removeIn( $keys[ 1 ], $in[ $keys[ 0 ] ], $all );
                    if( $all && empty( $in[ $keys[ 0 ] ] ) ) {
                        unset( $in[ $keys[ 0 ] ] );
                    }
                } else {
                    unset( $in[ $keys[ 0 ] ] );
                }
            }
        }
    }
    
    /**
     * Remove all items from session
     * 
     */
    public function reset()
    {
    	$_SESSION = array();
    }
    
    /********************************************************************************
     * Collection interface
     *******************************************************************************/
    
    /**
     * Get all items in session
     *
     * @return array    The source session
     */
    public function all()
    {
        return $_SESSION;
    }
    
    /**
     * Set session item
     *
     * @param string    $key    The session key
     * @param mixed     $value  The session value
     */
    public function set( $key, $value )
    {
    	$this->setIn( $key, $value, static::all() );
    }
    
    /**
     * Get session item for key
     *
     * @param string    $key        The session key
     * @param mixed     $default    The default value to return if session key does not exist
     *
     * @return mixed The key's value, or the default value
     */
    public function get( $key, $default = null )
    {
    	return ( $this->has( $key ) ) ? $this->getIn( $key, $this->all() ) : $default;
    }
    
    /**
     * Add item to session
     *
     * @param array $items Key-value array of data to append to the session
     */
    public function replace( array $items )
    {
        foreach ( $items as $key => $value ) {
            $this->set( $key, $value );
        }
    }
    
    /**
     * Does the session have a given key?
     *
     * @param string    $key    The session key
     *
     * @return bool
     */
    public function has( $key )
    {
    	return $this->hasIn( $name, $this->all() );
    }
    
    /**
     * Remove item from session
     *
     * @param string    $key    The session key
     * @param bool      $all    Specifie if all folders of the key path will be remove or not
     */
    public function remove( $key, $all = false )
    {
    	$this->removeIn( $key, $this->all(), $all );
    }
    
    /**
     * Remove all items from session with a list of exception
     * 
     * @param array $excepts The session's keys to prevent from remove
     */
    public function clear( array $excepts = [] )
    {
        $tmp = array();
        foreach( $excepts as $except ) {
            if( $this->has( $except ) ) {
                $tmp[ $except ] = $this->get( $except );
            }
        }
        $this->reset();
        foreach( $tmp as $key => $value ) {
            $this->put( $key, $value );
        }
    }
    
    
    /********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/
    
    /**
     * Does the session have a given key?
     *
     * @param string    $key    The session key
     *
     * @return bool
     */
    public function offsetExists( $key )
    {
        return $this->has( $key );
    }
    
    /**
     * Get session item for key
     *
     * @param string    $key    The session key
     *
     * @return mixed    The key's value, or the default value
     */
    public function offsetGet( $key )
    {
        return $this->get( $key );
    }
    
    /**
     * Set session item
     *
     * @param string    $key    The session key
     * @param mixed     $value  The session value
     */
    public function offsetSet( $key, $value )
    {
        $this->set( $key, $value );
    }
    
    /**
     * Remove item from session
     *
     * @param string    $key    The session key
     */
    public function offsetUnset( $key )
    {
        $this->remove( $key );
    }
    
    /**
     * Get number of items in session
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
     * Get session iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->all() );
    }
}