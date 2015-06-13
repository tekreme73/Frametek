<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek;

use Frametek\Collections\Container;

/**
 * AppContainer
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class AppContainer extends Container
{

    /**
     *
     * @var array
     */
    protected $_options;

    /**
     *
     * @param array $user_options            
     */
    public function __construct(array $user_options = [])
    {
        parent::__construct();
        $this->_options = $user_options;
    }
}