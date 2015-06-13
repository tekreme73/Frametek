<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Http;

use Frametek\Exception\Http\MissingMainGetParameterException;
use Frametek\Interfaces\PersistentInterface;
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
     * @var integer
     */
    const CONTROLLER_FIELD = 0;

    /**
     *
     * @var integer
     */
    const METHOD_FIELD = 1;

    /**
     *
     * @var \Frametek\Http\Get
     */
    protected $_http_get;

    /**
     *
     * @var \Frametek\Http\File
     */
    protected $_files;

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
     * @var \Frametek\Core\Controller | string
     */
    protected $_controller;

    /**
     *
     * @var string
     */
    protected $_method;

    /**
     *
     * @param string $main_parameter[optional]            
     * @param string $default_controller[optional]            
     * @param string $default_method[optional]            
     *
     */
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
     *
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
     *
     * @return boolean
     */
    public function run()
    {
        try {
            $uri = $this->parse();
            
            $c_ext = ucfirst($this->_configs->value('controller.extension', ''));
            $c_path = rtrim(rtrim($this->_configs->value('app.path') . $this->_configs->value('controller.path'), '/'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            
            if ($this->_files->exists($c_path . $uri[static::CONTROLLER_FIELD] . $c_ext . '.php')) {
                $this->_controller = $uri[static::CONTROLLER_FIELD];
                unset($uri[0]);
            } else {
                if (isset($uri[static::CONTROLLER_FIELD])) {
                    return \Exception("Undefined route!");
                }
            }
            
            $c = $this->_controller . $c_ext;
            require_once $c_path . $c . '.php';
            
            $this->_controller = new $c();
            
            if (isset($uri[static::METHOD_FIELD])) {
                if (method_exists($this->_controller, $uri[static::METHOD_FIELD])) {
                    $this->_method = $uri[static::METHOD_FIELD];
                    unset($uri[static::METHOD_FIELD]);
                }
            }
            
            if ($uri) {
                $this->_params = array_values($uri);
            }
            
            return call_user_func_array([
                $this->_controller,
                $this->_method
            ], $this->_params);
        } catch (MissingMainGetParameterException $e) {
            var_dump($e->getMessage());
        } catch (\Exception $e) {
            var_dump($e);
        }
        return FALSE;
    }

    /**
     * ******************************************************************************
     * Middleware
     * *****************************************************************************
     */
    
    /**
     *
     * @param \Frametek\Interfaces\ResolverInterface $container            
     */
    protected function useContainer(\Frametek\Interfaces\ResolverInterface $container)
    {
        $this->_http_get = $container->resolve('http_get');
        $this->_files = $container->resolve('http_file');
    }
}