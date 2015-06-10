<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Exception;

/**
 * UndefinedHttpCookieException
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class UndefinedHttpCookieException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Http COOKIE need to exist on the server to use this class!");
    }
}
