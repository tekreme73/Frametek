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
 * AppInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface AppInterface extends Runnable
{

    /**
     *
     * @return \Frametek\Collections\ContainerResolverInterface
     */
    public function getContainer();

    /**
     *
     * @return array
     */
    public function getDefaultSingletons();

    /**
     *
     * @return array
     */
    public function getDefaultMiddlewares();

    /**
     *
     * @param \Frametek\Interfaces\MiddlewareInterface $middleware            
     */
    public function addMiddleware(\Frametek\Interfaces\MiddlewareInterface $middleware);

    /**
     *
     * @param string $key            
     * @param \Frametek\Interfaces\SingletonInterface $singleton            
     */
    public function addSingleton($key, \Frametek\Interfaces\SingletonInterface $singleton);
}