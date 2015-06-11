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
    protected $_config_path;

    public function __construct($config_path = '../app/config')
    {
        parent::__construct();
        $this->_config_path = rtrim($config_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        
        $this->loadAll();
    }

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
}
