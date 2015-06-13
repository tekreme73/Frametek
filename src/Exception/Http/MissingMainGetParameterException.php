<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Exception\Http;

/**
 * MissingMainGetParameterException
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class MissingMainGetParameterException extends \RuntimeException
{

    /**
     *
     * @param unknown $main_parameter            
     */
    public function __construct($main_parameter)
    {
        parent::__construct("The url must contains the HTTP GET parameter: '$main_parameter' for routing!");
    }
}
