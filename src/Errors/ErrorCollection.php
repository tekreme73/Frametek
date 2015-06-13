<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Errors;

use Frametek\Collections\RecursiveCollection;

/**
 * ErrorCollection
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
abstract class ErrorCollection extends RecursiveCollection
{

    protected $_errors;

    /**
     */
    public function __construct()
    {
        parent::__construct('.');
        $this->_errors = array();
    }

    /**
     * Add an error to the collection
     *
     * @param mixed $error
     *            The error to add
     * @param string $key[optional]
     *            The error key
     */
    public function add($error, $key = NULL)
    {
        if ($key) {
            $errorContainer = $this->get($key, new static());
            $errorContainer->push($error);
            $this[$key] = $errorContainer;
        } else {
            $this->push($error);
        }
    }

    /**
     * Get the first element at error item target by the key
     *
     * @param string $key
     *            The error key to use
     * @param mixed $default[optional]
     *            The default value used if there is no first error
     *            
     * @return mixed The first item in the errors
     */
    public function firstOf($key, $default = '')
    {
        $value = $this->get($key);
        if ($value) {
            return $value->first($default);
        } else {
            return $default;
        }
    }

    /**
     * ******************************************************************************
     * Collection interface
     * *****************************************************************************
     */
    
    /**
     * Get all items in errors
     *
     * @return array The source errors
     */
    public function all()
    {
        return $this->_errors;
    }

    /**
     * Get all items in errors by reference
     *
     * @return array The source errors
     */
    public function &allByRef()
    {
        return $this->_errors;
    }

    /**
     * Set the data errors
     *
     * @param array $datas
     *            The datas to set to replace existing data errors
     */
    public function setAll(array $datas)
    {
        $this->_errors = $datas;
    }
}
