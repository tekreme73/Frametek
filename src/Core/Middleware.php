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
use Frametek\Interfaces\Runnable;

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
     * @var Frametek\Interfaces\PersistentInterface
     */
    protected $_configs;

    /**
     *
     * @var Frametek\App
     */
    protected $_app;

    /**
     * (non-PHPdoc)
     * 
     * @see \Frametek\Interfaces\MiddlewareInterface::setApp()
     */
    public function setApp(App $app)
    {
        $this->_app = $app;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Frametek\Interfaces\MiddlewareInterface::getApp()
     */
    public function getApp()
    {
        return $this->_app;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Frametek\Interfaces\Runnable::run()
     */
    public function run()
    {
        if (! $this->_app) {
            throw \Exception("You have to define the application before call!");
        }
        $container = $this->_app->container();
        $this->_configs = $container->resolve('config');
        $this->useContainer($container);
        return $this->call();
    }

    /**
     *
     * @param Frametek\Interfaces\ContainerResolverInterface $container            
     */
    abstract protected function useContainer(ContainerResolverInterface $container);
}