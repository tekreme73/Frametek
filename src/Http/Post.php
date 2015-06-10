<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Http;

use Frametek\Collections\Collection;
use Frametek\Exception\UndefinedHttpPostException;

/**
 * Post
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Post extends Collection
{

    protected static $_DATA;

    public function __construct()
    {
        if (! isset($_POST)) {
            throw new UndefinedHttpPostException();
        } else {
            static::$_DATA = $_POST;
        }
    }

    /**
     * ******************************************************************************
     * Collection interface
     * *****************************************************************************
     */
    
    /**
     * Get all items in POST
     *
     * @return array The source POST
     */
    public function all()
    {
        return static::$_DATA;
    }

    /**
     * Get all items in POST by reference
     *
     * @return array The source POST
     */
    public function &allByRef()
    {
        return static::$_DATA;
    }

    /**
     * Set the POST data
     *
     * @param array $datas
     *            The datas to set to replace existing POST data
     */
    public function setAll(array $datas)
    {
        static::$_DATA = $datas;
    }
}
