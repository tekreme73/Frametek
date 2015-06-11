<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Interfaces;

use Frametek\App;

/**
 * MiddlewareInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface MiddlewareInterface extends Runnable
{

    public function setApp(App $app);

    public function getApp();

    public function call();
}