<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Core;

use Frametek\Interfaces\ContainerResolverInterface;
use Frametek\Core\Middleware;

/**
 * Controller
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Controller extends Middleware
{

    /**
     * ******************************************************************************
     * Middleware
     * *****************************************************************************
     */
    
    /**
     *
     * @param Frametek\Interfaces\ContainerResolverInterface $container            
     */
    protected function useContainer(ContainerResolverInterface $container)
    {
        // TODO
    }

    /**
     */
    public function call()
    {
        return FALSE;
    }
}