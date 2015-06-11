<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Collections\Container;

class ContainerTest extends PHPUnit_Framework_TestCase
{

    protected $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function test_containerIsContainer()
    {
        $this->assertInstanceOf('Frametek\Collections\Container', $this->container);
    }

    public function test_bindingObjectWorks()
    {
        $this->container->bind('foo', 'Bar');
        
        $this->assertEquals('Bar', $this->container->getBinding('foo')['value']);
    }

    public function test_returnNullWhenBindingNotFound()
    {
        $binding = $this->container->getBinding('bar');
        
        $this->assertNull($binding);
    }

    public function test_resolveClassReturnsObject()
    {
        $object = $this->container->resolve('Bar');
        
        $this->assertInstanceOf('Bar', $object);
    }

    public function test_arrayAccessWorkAsIntended()
    {
        $this->container['qux'] = 'Bar';
        
        $object = $this->container['qux'];
        
        $this->assertInstanceOf('Bar', $object);
    }

    public function test_singleton()
    {
        $this->container->singleton('abc', 'Foo');
        
        $object = $this->container->resolve('abc');
        
        $this->assertInstanceOf('Foo', $object);
    }
}

class Foo
{
}

class Bar
{

    public function __construct(Foo $foo)
    {}
}