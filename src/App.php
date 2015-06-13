<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek;

use Frametek\Collections\DataCollection;
use Frametek\Collections\Singleton;
use Frametek\Http\UriHandler;
use Frametek\Core\Controller;
use Frametek\Interfaces\AppInterface;
use Frametek\Interfaces\BindInterface;

/**
 * App
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class App implements AppInterface
{

    /**
     *
     * @var string
     */
    const VERSION = '0.1.4';

    /**
     *
     * @var \Frametek\Collections\Container
     */
    protected $_container;

    /**
     *
     * @var \Frametek\Collections\DataCollection
     */
    protected $_middlewares;

    /**
     *
     * @param mixed $container            
     * @param boolean $loadDefaultSingletons            
     * @param boolean $loadDefaultMiddlewares            
     *
     * @throws \Exception
     */
    public function __construct($container = [], $loadDefaultSingletons = TRUE, $loadDefaultMiddlewares = TRUE)
    {
        if (is_array($container)) {
            $container = new AppContainer($container);
        }
        if (! $container instanceof BindInterface) {
            throw new \Exception("Expected a BindInterface");
        }
        $this->_container = $container;
        $this->_middlewares = new DataCollection(array(
            $this
        ));
        
        if ($loadDefaultSingletons) {
            $this->loadDefaultSingletons();
        }
        if ($loadDefaultMiddlewares) {
            $this->loadDefaultMiddlewares();
        }
    }

    /**
     */
    protected function loadDefaultSingletons()
    {
        foreach ($this->getDefaultSingletons() as $key => $singleton) {
            $this->addSingleton($key, $singleton);
        }
    }

    /**
     */
    protected function loadDefaultMiddlewares()
    {
        foreach ($this->getDefaultMiddlewares() as $middleware_class) {
            $this->addMiddleware($this->_container->resolve($middleware_class));
        }
    }

    /**
     * ******************************************************************************
     * App interface
     * *****************************************************************************
     */
    
    /**
     *
     * @return \Frametek\Collections\ContainerResolverInterface
     */
    public function getContainer()
    {
        return $this->_container;
    }

    /**
     *
     * @return array
     */
    public function getDefaultSingletons()
    {
        return [
            'config' => new Singleton('Frametek\Persistent\Config'),
            'http_cookie' => new Singleton('Frametek\Http\Cookie'),
            'http_file' => new Singleton('Frametek\Http\File'),
            'http_get' => new Singleton('Frametek\Http\Get'),
            'http_post' => new Singleton('Frametek\Http\Post'),
            'http_session' => new Singleton('Frametek\Http\Session')
        ];
    }

    /**
     *
     * @return array
     */
    public function getDefaultMiddlewares()
    {
        return array(
            'Frametek\Http\UriHandler'
        );
    }

    /**
     *
     * @param \Frametek\Interfaces\MiddlewareInterface $middleware            
     *
     * @throws \RuntimeException
     */
    public function addMiddleware(\Frametek\Interfaces\MiddlewareInterface $middleware)
    {
        if ($this->_middlewares->contains($middleware)) {
            $middleware_class = get_class($middleware);
            throw new \RuntimeException("Circular Middleware setup detected. Tried to queue the same Middleware instance ($middleware_class) twice.");
        } else {
            $middleware->setApp($this);
            $middleware->setNext($this->_middlewares->first());
            $this->_middlewares->unshift($middleware);
        }
    }

    /**
     *
     * @param string $key            
     * @param \Frametek\Interfaces\SingletonInterface $singleton            
     */
    public function addSingleton($key, \Frametek\Interfaces\SingletonInterface $singleton)
    {
        $this->_container->singleton($key, $singleton->getClassName());
        $this->_container->resolve($key, $singleton->getArgs());
    }

    /**
     * ******************************************************************************
     * Runnable interface
     * *****************************************************************************
     */
    
    /**
     *
     * @return boolean
     */
    public function call()
    {
        return TRUE;
    }

    /**
     *
     * @return boolean
     */
    public function run()
    {
        try {
            return $this->_middlewares->first()->call();
        } catch (\RuntimeException $re) {
            var_dump($re->getMessage());
            die();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return FALSE;
    }
}
