<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Http;

use Frametek\Collections\DataCollection;
use Frametek\Exception\Http\UndefinedHttpException;

/**
 * Cookie
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Cookie extends DataCollection
{

    /**
     *
     * @var integer
     */
    public static $_EXPIRE = 259200;

    /**
     *
     * @throws UndefinedHttpException
     */
    public function __construct()
    {
        parent::__construct();
        if (! isset($_COOKIE)) {
            throw new UndefinedHttpException("COOKIE");
        } else {
            $this->setAll($_COOKIE);
        }
    }

    /**
     * Set cookie item with expire
     *
     * @param string $key
     *            The cookie key
     * @param mixed $value
     *            The cookie value
     * @param integer $expire
     *            The cookie $expire
     *            
     * @return boolean Fail if an output has be done before this method call
     */
    public function setWithExpire($key, $value, $expire)
    {
        if (setcookie($key, $value, time() + $expire, '/', '', false, true)) {
            return true;
        }
        return false;
    }

    /**
     * ******************************************************************************
     * Collection interface
     * *****************************************************************************
     */
    /**
     * Set cookie item
     *
     * @param string $key
     *            The cookie key
     * @param mixed $value
     *            The cookie value
     */
    public function set($key, $value)
    {
        $this->setWithExpire($key, $value, static::$_EXPIRE);
    }

    /**
     * Remove item from cookies
     *
     * @param string $key
     *            The cookie key
     * @param boolean $all[optional]
     *            (unused) Specifie if all folders of the key path will be remove or not
     */
    public function remove($key, $all = FALSE)
    {
        $this->setWithExpire($key, $value, time() - 1);
    }
}
