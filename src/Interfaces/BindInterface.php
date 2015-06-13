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
 * BindInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface BindInterface
{

    /**
     *
     * @param string $key            
     * @param mixed $value            
     * @param boolean $singleton[optional]            
     */
    public function bind($key, $value, $singleton = FALSE);

    /**
     *
     * @param string $key            
     */
    public function getBinding($key);

    /**
     *
     * @param string $key            
     * @param mixed $value            
     */
    public function singleton($key, $value);

    /**
     *
     * @param string $key            
     */
    public function isSingleton($key);

    /**
     *
     * @param string $key            
     */
    public function singletonResolved($key);

    /**
     *
     * @param string $key            
     */
    public function getSingletonInstance($key);
}