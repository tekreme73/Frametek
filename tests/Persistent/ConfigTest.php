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
    public function setUp()
    {
    	Config::$_CONFIG_PATH = "tests/Persistent/config";
        Config::loadAll();
    }
    
    public function test_loadSuccess()
    {
    	$configs = new Config();
    	$this->assertNotEmpty(
    		$configs->all()
    	);
    }
    
    public function test_getConfig()
    {
    	$this->assertNotEmpty(
    		Config::value( 'app', [] )
    	);
    }
    
    public function test_getPreciseConfig()
    {
        $this->assertEquals(
        	Config::value( 'app.site.age' ),
        	50
        );
    }
}