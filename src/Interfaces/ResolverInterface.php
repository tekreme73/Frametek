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
 * ResolverInterface
 *
 * This interface
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
interface ResolverInterface
{

    /**
     *
     * @param string $key            
     * @param array $args[optional]            
     */
    public function resolve($key, array $args = []);
}