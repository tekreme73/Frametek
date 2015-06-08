<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Collections;

use Frametek\Collections\RecursiveCollection;

/**
 * DataCollection
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class DataCollection extends RecursiveCollection
{

    protected $datas;

    public function __construct()
    {
        parent::__construct('.');
        $this->datas = array();
    }

    /**
     * ******************************************************************************
     * Collection interface
     * *****************************************************************************
     */
    
    /**
     * Get all items in datas
     *
     * @return array The source datas
     */
    public function all()
    {
        return $this->datas;
    }

    /**
     * Get all items in datas by reference
     *
     * @return array The source datas
     */
    public function &allByRef()
    {
        return $this->datas;
    }

    /**
     * Set the datas
     *
     * @param array $datas
     *            The datas to set to replace existing datas
     */
    public function setAll(array $datas)
    {
        $this->datas = $datas;
    }
}
