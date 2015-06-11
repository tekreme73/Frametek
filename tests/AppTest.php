<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\App;

class AppTest extends PHPUnit_Framework_TestCase
{

    protected $app;

    public function setUp()
    {
        $this->app = new _FakeApp();
    }

    public function test_appRun()
    {
        $this->assertFalse($this->app->run());
    }
}

class _FakeApp extends App
{

    public function __construct()
    {
        parent::__construct();
        $this->_singletons['config']['args'] = [
            "tests/Persistent/config"
        ];
        unset($this->_singletons['http_session']);
    }
}
