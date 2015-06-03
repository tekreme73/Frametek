<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Collections;

/**
 * RecursiveCollection
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
abstract class RecursiveCollection extends Collection
{	
    protected static $_SEP = '.';

    /**
     * Set collection item
     *
     * Warn: Recursive function
     *
     * @param string    $key   The data key
     * @param mixed     $value The data value
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
     * Get collection item for key
     *
     * Warn: Recursive function
     *
     * @param string    $key    The data key
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
     * Does the collection have a given key?
     *
     * Warn: Recursive function
     *
     * @param string    $key    The data key
     * @param array     $in     The folder uses for the recursion
     *
     * @return bool
     */
    protected function hasIn( $key, $in )
    {
        $keys = explode( static::$_SEP, $key, 2 );
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
     * Remove item from collection
     *
     * Warn: Recursive function
     *
     * @param string    $key    The data key
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
        $this->setIn( $key, $value, $d );
        $this->setAll( $d );
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
        return ( $this->has( $key ) ) ? $this->getIn( $key, $this->all() ) : $default;
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
        return $this->hasIn( $key, $this->all() );
    }
    
    /**
     * Remove item from collection
     *
     * @param string    $key    The data key
     * @param bool      $all    Specifie if all folders of the key path will be remove or not
     */
    public function remove( $key, $all = false )
    {
    	$d = $this->all();
        $this->removeIn( $key, $d, $all );
        $this->setAll( $d );
    }
}