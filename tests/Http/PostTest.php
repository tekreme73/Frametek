<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Http\Post;

class PostTest extends PHPUnit_Framework_TestCase
{

    protected $http_post;

    public function setUp()
    {
        $this->http_post = new Post();
    }

    public function test_all()
    {
        $this->assertEmpty($this->http_post->all());
    }

    public function test_hasnt()
    {
        $this->assertFalse($this->http_post->has("azzz"));
    }

    public function test_setAll()
    {
        $this->http_post->setAll(array(
            'name' => 'bob'
        ));
        $this->assertEquals(array(
            'name' => 'bob'
        ), $this->http_post->all());
    }

    public function test_has()
    {
        $this->http_post->setAll(array(
            'name' => 'bob'
        ));
        $this->assertTrue(isset($this->http_post['name']));
    }

    public function test_set()
    {
        $this->http_post->set('bob', 42);
        $this->assertTrue(isset($this->http_post['bob']));
    }

    public function test_get()
    {
        $this->http_post->setAll(array(
            'name' => 'bob'
        ));
        $this->assertEquals('bob', $this->http_post['name']);
    }
}
