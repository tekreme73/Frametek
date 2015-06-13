<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\App;
use Frametek\Http\UriHandler;
use Frametek\Core\Controller;
use Frametek\Collections\Singleton;

class AppTest extends PHPUnit_Framework_TestCase
{

    protected $app;

    public function setUp()
    {
        $this->app = new _FakeApp();
    }

    public function test_instance()
    {
        $this->assertInstanceOf('Frametek\App', $this->app);
    }

    public function test_appRun()
    {
        $this->assertTrue($this->app->run());
    }
}

class _FakeApp extends App
{

    public function getDefaultSingletons()
    {
        $default = parent::getDefaultSingletons();
        $default['config'] = new Singleton($default['config']->getClassName(), [
            "tests/_fake_app/config"
        ]);
        unset($default['http_session']);
        return $default;
    }

    public function getDefaultMiddlewares()
    {
        return array(
            '_FakeUriHandler'
        );
    }
}

class _FakeUriHandler extends UriHandler
{
    public function __construct()
    {
        parent::__construct('url', 'test', 'bob');
    }
    
    protected function useContainer(\Frametek\Interfaces\ResolverInterface $container)
    {
        parent::useContainer($container);
        $this->_http_get[$this->_main_get_parameter] = "test/bob/55";
    }
}
