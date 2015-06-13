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
 * MiddlewareInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface MiddlewareInterface extends Runnable
{

    /**
     *
     * @param \Frametek\Interfaces\AppInterface $app            
     */
    public function setApp(\Frametek\Interfaces\AppInterface $app);

    /**
     */
    public function getApp();

    /**
     *
     * @param \Frametek\Interfaces\Runnable $next            
     */
    public function setNext(\Frametek\Interfaces\Runnable $next);

    /**
     */
    public function getNext();

    /**
     */
    public function hasNext();
}
