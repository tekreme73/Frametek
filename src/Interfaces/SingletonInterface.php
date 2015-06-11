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

    public function singleton($key, $value);

    public function isSingleton($key);

    public function singletonResolved($key);

    public function getSingletonInstance($key);
}