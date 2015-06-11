<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek;

use Frametek\Interfaces\Runnable;
use Frametek\Interfaces\ContainerResolverInterface;

/**
 * App
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class App implements Runnable
{

    /**
     *
     * @var string
     */
    const VERSION = '0.1.4';

    /**
     *
     * @var \Frametek\Collections\ContainerResolverInterface
     */
    protected $_container;

    /**
     *
     * @var array
     */
    protected $_singletons = [
        'config' => [
            'class' => 'Frametek\Persistent\Config',
            'args' => []
        ],
        'http_cookie' => [
            'class' => 'Frametek\Http\Cookie',
            'args' => []
        ],
        'http_file' => [
            'class' => 'Frametek\Http\File',
            'args' => []
        ],
        'http_get' => [
            'class' => 'Frametek\Http\Get',
            'args' => []
        ],
        'http_post' => [
            'class' => 'Frametek\Http\Post',
            'args' => []
        ],
        'http_session' => [
            'class' => 'Frametek\Http\Session',
            'args' => []
        ]
    ];

    /**
     *
     * @var array
     */
    protected $_middlewares = [
        'controller' => [
            'class' => 'Frametek\Core\Controller',
            'args' => []
        ],
        'uri_handler' => [
            'class' => 'Frametek\Http\UriHandler',
            'args' => []
        ]
    ];

    /**
     *
     * @param unknown $container            
     * @throws \Exception
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new AppContainer($container);
        }
        if (! $container instanceof ContainerResolverInterface) {
            throw new \Exception("Expected a ContainerResolverInterface");
        }
        $this->_container = $container;
    }

    /**
     *
     * @return \Frametek\Collections\ContainerResolverInterface
     */
    public function container()
    {
        return $this->_container;
    }

    /**
     */
    protected function loadSingletons()
    {
        foreach ($this->_singletons as $key => $singleton) {
            $this->_container->singleton($key, $singleton['class']);
            $this->_container->resolve($key, $singleton['args']);
        }
    }

    /**
     *
     * @return boolean
     */
    protected function loadMiddlewares()
    {
        $failure = FALSE;
        foreach ($this->_middlewares as $key => $middleware) {
            $key = 'middleware' . $this->_container->getSeparator() . $key;
            
            $this->_container->singleton($key, $middleware['class']);
            $object = $this->_container->resolve($key, $middleware['args']);
            
            $object->setApp($this);
            $failure = $failure || $object->run();
        }
        return $failure;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Frametek\Interfaces\Runnable::run()
     */
    public function run()
    {
        $this->loadSingletons();
        return $this->loadMiddlewares();
    }
}