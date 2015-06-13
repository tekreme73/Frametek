<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Collections;

use Frametek\Interfaces\SingletonInterface;

/**
 * Singleton
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Singleton implements SingletonInterface
{

    /**
     *
     * @var string
     */
    protected $_classname;

    /**
     *
     * @var array
     */
    protected $_args;

    /**
     *
     * @param string $classname            
     * @param array $args[optional]            
     */
    public function __construct($classname, array $args = [])
    {
        $this->_classname = $classname;
        $this->_args = $args;
    }

    /**
     * ******************************************************************************
     * Singleton interface
     * *****************************************************************************
     */
    
    /**
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->_classname;
    }

    /**
     *
     * @return array
     */
    public function getArgs()
    {
        return $this->_args;
    }
}