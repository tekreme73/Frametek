<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

use Frametek\Interfaces\CollectionInterface;

/**
 * Cookie
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
class Cookie implements CollectionInterface
{
    
    public static $_EXPIRE = 259200;
    
    /**
     * Set cookie item with expire
     *
     * @param string   $key    The cookie key
     * @param mixed    $value  The cookie value
     * @param int      $expire The cookie $expire
     * 
     * @return bool    Fail if an output has be done before this method call
     */
    public function setWithExpire( $key, $value, $expire )
    {
        if( setcookie( $key, $value, time() + $expire, '/', '', false, true ) )
        {
            return true;
        }
        return false;
    }
    
    /********************************************************************************
     * Collection interface
     *******************************************************************************/
    
    /**
     * Get all items in cookies
     *
     * @return array    The cookies
     */
    public function all()
    {
        return $_COOKIE;
    }
    
    /**
     * Set cookie item
     *
     * @param string    $key    The cookie key
     * @param mixed     $value  The cookie value
     */
    public function set( $key, $value )
    {
        $this->setWithExpire( $key, $value, static::$_EXPIRE );
    }
    
    /**
     * Get cookie item for key
     *
     * @param string    $key        The cookie key
     * @param mixed     $default    The default value to return if cookie key does not exist
     *
     * @return mixed The key's value, or the default value
     */
    public function get( $key, $default = null )
    {
        return ( $this->has( $key ) ) ? $this->all()[ $key ] : $default;
    }
    
    /**
     * Add item to cookies
     *
     * @param array $items Key-value array of data to append to the cookies
     */
    public function replace( array $items )
    {
        foreach ( $items as $key => $value ) {
            $this->set( $key, $value );
        }
    }
    
    /**
     * Does the cookies have a given key?
     *
     * @param string    $key    The cookie key
     *
     * @return bool
     */
    public function has( $key )
    {
        return isset( $this->all()[ $key ] );
    }
    
    /**
     * Remove item from cookies
     *
     * @param string    $key    The cookie key
     * @param bool      $all    Specifie if all folders of the key path will be remove or not
     */
    public function remove( $key, $all = false )
    {
        $this->setWithExpire( $key, $value, time() - 1 );
    }
    
    /**
     * Remove all items from cookies with a list of exception
     *
     * @param array $excepts The cookies' keys to prevent from remove
     */
    public function clear( array $excepts = [] )
    {
        $_COOKIE = array();
    }
    
    
    /********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/
    
    /**
     * Does the cookies have a given key?
     *
     * @param string    $key    The cookie key
     *
     * @return bool
     */
    public function offsetExists( $key )
    {
        return $this->has( $key );
    }
    
    /**
     * Get cookie item for key
     *
     * @param string    $key    The cookie key
     *
     * @return mixed    The key's value, or the default value
     */
    public function offsetGet( $key )
    {
        return $this->get( $key );
    }
    
    /**
     * Set cookie item
     *
     * @param string    $key    The cookie key
     * @param mixed     $value  The cookie value
     */
    public function offsetSet( $key, $value )
    {
        $this->set( $key, $value );
    }
    
    /**
     * Remove item from cookies
     *
     * @param string    $key    The cookie key
     */
    public function offsetUnset( $key )
    {
        $this->remove( $key );
    }
    
    /**
     * Get number of items in cookies
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
     * Get cookies iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->all() );
    }
}