<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

use Frametek\Collections\DataCollection;
use Frametek\Interfaces\PersistentInterface;

/**
 * Config
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Config extends DataCollection implements PersistentInterface
{

    /**
     *
     * @var string
     */
    protected $_template_path;

    /**
     *
     * @var string
     */
    protected $_config_path;

    /**
     *
     * @param string $config_path[optional]            
     *
     * @throws \RuntimeException
     */
    public function __construct($config_path = '../app/config')
    {
        parent::__construct();
        $this->_config_path = rtrim($config_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->_template_path = __DIR__ . DIRECTORY_SEPARATOR . "config_template" . DIRECTORY_SEPARATOR;
        
        if (is_dir($this->getPath()) && $this->generateDefault()) {
            $this->loadAll();
        } else {
            throw new \RuntimeException("Undefined directory $this->_config_path to load configurations!");
        }
    }

    /**
     * Load item from configs
     *
     * Warn: Recursive function
     *
     * @param \Directory $parentDirectory
     *            The parent directory
     */
    protected function load($parentDirectory)
    {
        while (false !== ($entry = $parentDirectory->read())) {
            if ($entry !== '.' && $entry !== '..') {
                if (is_dir($entry)) {
                    $tmpD = dir($entry);
                    $this->load($tmpD);
                    $tmpD->close();
                } else 
                    if (substr($entry, - strlen('.php')) === '.php') {
                        $this[substr($entry, 0, - strlen('.php'))] = include $this->getPath() . $entry;
                    }
            }
        }
    }

    /**
     * ******************************************************************************
     * Persistent interface
     * *****************************************************************************
     */
    
    /**
     *
     * @param boolean $force[optional]            
     *
     * @return boolean
     */
    public function generateDefault($force = FALSE)
    {
        $d = dir($this->_template_path);
        while (false !== ($entry = $d->read())) {
            if ($entry !== '.' && $entry !== '..') {
                if (substr($entry, - strlen('.php')) === '.php') {
                    if ($force || ! file_exists($this->getPath() . $entry)) {
                        $content = file_get_contents($this->_template_path . $entry);
                        $content = str_replace("':time'", time(), $content);
                        file_put_contents($this->getPath() . $entry, $content);
                    }
                }
            }
        }
        return TRUE;
    }

    /**
     *
     * @return string
     */
    public function getPath()
    {
        return $this->_config_path;
    }

    /**
     * Get configs item for key
     *
     * @param string $key
     *            The config key
     * @param mixed $default[optional]
     *            The default value to return if config key does not exist
     *            
     * @return mixed The key's value, or the default value
     */
    public function value($key, $default = NULL)
    {
        return $this->get($key, $default);
    }

    /**
     * Load all configuration files to be available
     */
    public function loadAll()
    {
        $this->setAll(array());
        $d = dir($this->getPath());
        $this->load($d);
        $d->close();
    }
}
