<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Core;

use Frametek\App;
use Frametek\Interfaces\MiddlewareInterface;
use Frametek\Interfaces\PersistentInterface;
use Frametek\Interfaces\ContainerResolverInterface;

/**
 * Middleware
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
abstract class Middleware implements MiddlewareInterface
{

    /**
     *
     * @var \Frametek\Interfaces\PersistentInterface
     */
    protected $_configs;

    /**
     *
     * @var \Frametek\Interfaces\AppInterface
     */
    protected $_app;

    /**
     *
     * @var \Frametek\Interfaces\MiddlewareInterface
     */
    protected $_next;

    abstract protected function useContainer(\Frametek\Interfaces\ResolverInterface $container);

    /**
     * ******************************************************************************
     * Middleware interface
     * *****************************************************************************
     */
    
    /**
     *
     * @param \Frametek\Interfaces\AppInterface $app            
     */
    public function setApp(\Frametek\Interfaces\AppInterface $app)
    {
        $this->_app = $app;
    }

    /**
     *
     * @return \Frametek\Interfaces\AppInterface
     */
    public function getApp()
    {
        return $this->_app;
    }

    /**
     *
     * @param \Frametek\Interfaces\Runnable $next            
     */
    public function setNext(\Frametek\Interfaces\Runnable $next)
    {
        $this->_next = $next;
    }

    /**
     *
     * @return \Frametek\Interfaces\MiddlewareInterface
     */
    public function getNext()
    {
        return $this->_next;
    }

    /**
     *
     * @return boolean
     */
    public function hasNext()
    {
        return ($this->getNext() instanceof \Frametek\Interfaces\Runnable);
    }

    /**
     * ******************************************************************************
     * Runnable interface
     * *****************************************************************************
     */
    
    /**
     *
     * @throws \RuntimeException
     *
     * @return boolean
     */
    public function call()
    {
        if (! $this->_app) {
            throw \RuntimeException("You have to define the application before call!");
        }
        $container = $this->_app->getContainer();
        $this->_configs = $container->resolve('config');
        $this->useContainer($container);
        try
        {
            if ($this->run()) {
                if ($this->hasNext()) {
                    return $this->getNext()->call();
                } else {
                    return TRUE;
                }
            }
        } catch( \RunetimeException $e )
        {
            throw $e;
        } catch( \Exception $e )
        {
            throw $e;
        }
        return FALSE;
    }
}