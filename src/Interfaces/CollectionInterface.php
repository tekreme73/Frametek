<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link      https://github.com/tekreme73/Frametek
 * @copyright Copyright (c) 2015 Rémi Rebillard
 * @license   https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Interfaces;

/**
 * Collection Interface
 *
 * @package Frametek
 * @author  Rémi Rebillard
 */
interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{	
    public function all();
    
    public function set( $key, $value );
    
    public function get( $key, $default = null );
    
    public function replace( array $items );
    
    public function has( $key );
    
    public function remove( $key, $all = false );
    
    public function clear( array $excepts = [] );
    
    public function setAll( array $datas );
}