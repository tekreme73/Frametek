<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Http\Get;

/**
 * _FakeGet
 *
 * This class is only used for tests
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class _FakeGet extends Get
{

    public function __construct()
    {
        if (! parent::$_DATA) {
            parent::$_DATA = array();
        }
    }
}
