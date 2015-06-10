<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Errors;

use Frametek\Collections\DataCollection;

/**
 * ErrorHandler
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class ErrorHandler extends ErrorCollection
{

    protected $values;

    public function __construct()
    {
        parent::__construct();
        $this->values = new DataCollection();
    }

    /**
     * Does the handler have an error for the given key ?
     *
     * @param string $key[optional]
     *            The optionnal error key
     *            
     * @return boolean If the handler contains errors
     */
    public function hasErrors($key = NULL)
    {
        if ($key) {
            return isset($this[$key]);
        } else {
            if (count($this)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Add a value to the error key
     *
     * @param string $key
     *            The error key
     * @param mixed $value
     *            The error value
     */
    public function addValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * Get the error value
     *
     * @param string $key
     *            The error key
     * @param mixed $default[optional]
     *            The default value used if there is no error value
     *            
     * @return mixed The key's value, or the default value
     */
    public function value($key, $default = '')
    {
        return $this->values->get($key, $default);
    }

    /**
     * Does the handler have an error value for the given key ?
     *
     * @param string $key
     *            The error key
     *            
     * @return boolean If the handler has an error value for the given key
     */
    public function hasValue($key)
    {
        return isset($this->values[$key]);
    }
}
