<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Http;

use Frametek\Interfaces\ContainerResolverInterface;
use Frametek\Core\Middleware;

/**
 * UriHandler
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class UriHandler extends Middleware
{

    /**
     *
     * @var Frametek\Http\Get
     */
    protected $_http_get;

    /**
     *
     * @var string
     */
    protected $_main_get_parameter;

    /**
     *
     * @var array
     */
    protected $_params;

    /**
     *
     * @var string
     */
    protected $_controller;

    /**
     *
     * @var string
     */
    protected $_method;

    public function __construct($main_parameter = 'url', $default_controller = 'home', $default_method = 'index')
    {
        $this->_main_get_parameter = $main_parameter;
        $this->_controller = $default_controller;
        $this->_method = $default_method;
        
        $this->_params = array();
    }

    /**
     *
     * @throws MissingMainGetParameterException
     * @return multitype:
     */
    protected function parse()
    {
        if (isset($this->_http_get[$this->_main_get_parameter])) {
            $explode = explode('/', filter_var(rtrim($this->_http_get[$this->_main_get_parameter], '/'), FILTER_SANITIZE_URL));
            return $explode;
        } else {
            throw new MissingMainGetParameterException($this->_main_get_parameter);
        }
    }

    /**
     * ******************************************************************************
     * Middleware
     * *****************************************************************************
     */
    
    /**
     *
     * @param Frametek\Interfaces\ContainerResolverInterface $container            
     */
    protected function useContainer(ContainerResolverInterface $container)
    {
        $this->_http_get = $container->resolve('http_get');
    }

    /**
     */
    public function call()
    {
        /* $uri = $this->parse(); */
        return FALSE;
    }
}