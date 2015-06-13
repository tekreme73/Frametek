<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Exception\Collections;

/**
 * ClassIsNotInstantiableException
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class ClassIsNotInstantiableException extends \Exception
{

    /**
     *
     * @param string $className[optional]            
     */
    public function __construct($className = "")
    {
        parent::__construct("Class [ $className ] is not a resolvable dependency.");
    }
}
