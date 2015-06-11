<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Persistent\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{

    protected $configs;

    public function setUp()
    {
        $this->configs = new Config("tests/Persistent/config");
    }

    public function test_loadSuccess()
    {
        $this->assertNotEmpty($this->configs->all());
    }

    public function test_getConfig()
    {
        $this->assertNotEmpty($this->configs->value('app', []));
    }

    public function test_getPreciseConfig()
    {
        $this->assertEquals($this->configs->value('app.site.age'), 50);
    }
}
