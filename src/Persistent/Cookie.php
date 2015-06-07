<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

use Frametek\Collections\Collection;

/**
 * Cookie
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
class Cookie extends Collection
{    
    public static $_EXPIRE = 259200;
    
    public function __construct()
    {
        if( !isset( $_COOKIE ) )
        {
        	throw new UndefinedCookieException();
        }
    }
    
    /**
     * Set cookie item with expire
     *
     * @param string   $key    The cookie key
     * @param mixed    $value  The cookie value
     * @param integer  $expire The cookie $expire
     * 
     * @return boolean Fail if an output has be done before this method call
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
     * Get all items in cookies by reference
     *
     * @return array    The cookies
     */
    public function &allByRef()
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
     * Remove item from cookies
     *
     * @param string    $key            The cookie key
     * @param boolean   $all[optional]  (unused) Specifie if all folders of the key path will be remove or not
     */
    public function remove( $key, $all = false )
    {
        $this->setWithExpire( $key, $value, time() - 1 );
    }
    
    /**
     * Set the data collection
     * 
     * @param array $datas  The datas to set to replace existing data collection
     */
    public function setAll( array $datas )
    {
        $_COOKIE = $datas;
    }
}
