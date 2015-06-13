<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Interfaces;

/**
 * SingletonInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface SingletonInterface
{

    /**
     *
     * @return string
     */
    public function getClassName();

    /**
     *
     * @return array
     */
    public function getArgs();
}