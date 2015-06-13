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
 * UndefinedHttpException
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class UndefinedHttpException extends \Exception
{

    /**
     *
     * @param string $type_request[optional]            
     */
    public function __construct($type_request = "")
    {
        if (! empty($type_request)) {
            $msg = "HTTP " . mb_strtoupper($type_request) . " has to exist on the server to use this class!";
        } else {
            $msg = "HTTP Exception!";
        }
        parent::__construct($msg);
    }
}