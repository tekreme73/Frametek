<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Interfaces;

/**
 * Collection Interface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{

    /**
     */
    public function all();

    /**
     */
    public function &allByRef();

    /**
     *
     * @param string $key            
     * @param mixed $value            
     */
    public function set($key, $value);

    /**
     *
     * @param string $key            
     * @param mixed $default[optional]            
     */
    public function get($key, $default = NULL);

    /**
     *
     * @param mixed $value            
     */
    public function push($value);

    /**
     */
    public function pop();

    /**
     */
    public function shift();

    /**
     *
     * @param mixed $value            
     */
    public function unshift($value);

    /**
     *
     * @param mixed $default[optional]            
     */
    public function first($default = NULL);

    /**
     *
     * @param array $items            
     */
    public function replace(array $items);

    /**
     *
     * @param string $key            
     */
    public function has($key);

    /**
     *
     * @param mixed $value            
     * @param boolean $strict[optional]            
     */
    public function contains($value, $strict = TRUE);

    /**
     *
     * @param string $key            
     * @param boolean $all[optional]            
     */
    public function remove($key, $all = FALSE);

    /**
     *
     * @param array $excepts[optional]            
     */
    public function clear(array $excepts = []);

    /**
     *
     * @param array $datas            
     */
    public function setAll(array $datas);
}
