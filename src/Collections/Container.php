<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Collections;

use Frametek\Exception\Http\ClassIsNotInstantiableException;
use Frametek\Interfaces\BindInterface;
use Frametek\Interfaces\ResolverInterface;

/**
 * Container
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Container implements \ArrayAccess, BindInterface, ResolverInterface
{

    /**
     *
     * @var Frametek\Collections\DataCollection
     */
    protected $_bindings;

    /**
     *
     * @var Frametek\Collections\DataCollection
     */
    protected $_instances;

    /**
     */
    public function __construct()
    {
        $this->_bindings = new DataCollection();
        $this->_instances = new DataCollection();
        
        $this->_instances->setSeparator($this->_bindings->getSeparator());
    }

    /**
     * Get the recursive separator
     *
     * @return string The separator
     */
    public function getSeparator()
    {
        return $this->_bindings->getSeparator();
    }

    /**
     *
     * @param string $key            
     * @param mixed $object            
     *
     * @return mixed
     */
    protected function prepareObject($key, $object)
    {
        if ($this->isSingleton($key)) {
            $this->_instances[$key] = $object;
        }
        return $object;
    }

    /**
     *
     * @param array $class            
     * @param array $args[optional]            
     *
     * @throws ClassIsNotInstantiableException
     *
     * @return object
     */
    protected function buildObject(array $class, array $args = array())
    {
        $className = $class['value'];
        $reflector = new \ReflectionClass($className);
        
        if (! $reflector->isInstantiable()) {
            throw new ClassIsNotInstantiableException("Class [ $className ] is not a resolvable dependency.");
        }
        
        if ($reflector->getConstructor() !== NULL) {
            $constructor = $reflector->getConstructor();
            $dependencies = $constructor->getParameters();
            
            $args = $this->buildDependencies($args, $dependencies);
        }
        
        $object = $reflector->newInstanceArgs($args);
        
        return $object;
    }

    /**
     *
     * @param array $args            
     * @param array $dependencies            
     *
     * @return unknown
     */
    protected function buildDependencies(array $args, array $dependencies)
    {
        foreach ($dependencies as $dependency) {
            $class = $dependency->getClass();
            
            if (! $dependency->isOptional() && ! $dependency->isArray() && $class !== NULL) {
                if (get_class($this) === $class->name) {
                    array_unshift($args, $this);
                } else {
                    array_unshift($args, $this->resolve($class->name));
                }
            }
        }
        return $args;
    }

    /**
     * ******************************************************************************
     * Bind interface
     * *****************************************************************************
     */
    
    /**
     *
     * @param string $key            
     * @param mixed $value            
     * @param boolean $singleton[optional]            
     */
    public function bind($key, $value, $singleton = FALSE)
    {
        $this->_bindings[$key] = compact('value', 'singleton');
    }

    /**
     *
     * @param string $key            
     *
     * @return mixed|NULL
     */
    public function getBinding($key)
    {
        return $this->_bindings[$key];
    }

    /**
     *
     * @param string $key            
     * @param mixed $value            
     */
    public function singleton($key, $value)
    {
        $this->bind($key, $value, TRUE);
    }

    /**
     *
     * @param string $key            
     *
     * @return boolean
     */
    public function isSingleton($key)
    {
        $binding = $this->getBinding($key);
        
        if ($binding === NULL) {
            return FALSE;
        } else {
            return $binding['singleton'];
        }
    }

    /**
     *
     * @param string $key            
     *
     * @return boolean
     */
    public function singletonResolved($key)
    {
        return isset($this->_instances[$key]);
    }

    /**
     *
     * @param string $key            
     *
     * @return mixed|NULL
     */
    public function getSingletonInstance($key)
    {
        return $this->_instances[$key];
    }

    /**
     * ******************************************************************************
     * Resolver interface
     * *****************************************************************************
     */
    
    /**
     *
     * @param string $key            
     * @param array $args            
     *
     * @return NULL
     */
    public function resolve($key, array $args = array())
    {
        $class = $this->getBinding($key);
        
        if ($class === NULL) {
            $class = array(
                'value' => $key
            );
        }
        
        if ($this->isSingleton($key) && $this->singletonResolved($key)) {
            return $this->getSingletonInstance($key);
        } else {
            $object = $this->buildObject($class, $args);
            return $this->prepareObject($key, $object);
        }
    }

    /**
     * ******************************************************************************
     * ArrayAccess interface
     * *****************************************************************************
     */
    
    /**
     * Does the collection have a given key?
     *
     * @param string $key
     *            The data key
     *            
     * @return boolean If the collection have the given key
     */
    public function offsetExists($key)
    {
        return isset($this->_bindings[$key]);
    }

    /**
     * Get collection item for key
     *
     * @param string $key
     *            The data key
     *            
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
        return $this->resolve($key);
    }

    /**
     * Set collection item
     *
     * @param string $key
     *            The data key
     * @param mixed $value
     *            The data value
     */
    public function offsetSet($key, $value)
    {
        $this->bind($key, $value);
    }

    /**
     * Remove item from collection
     *
     * @param string $key
     *            The data key
     */
    public function offsetUnset($key)
    {
        unset($this->_bindings[$key]);
    }
}
