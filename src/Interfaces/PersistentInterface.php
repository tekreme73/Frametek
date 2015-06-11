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
 * PersistentInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface PersistentInterface
{

    public function getPath();

    public function value($key, $default = NULL);

    public function loadAll();
}