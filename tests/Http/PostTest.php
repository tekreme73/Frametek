<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
require_once '_FakePost.php';

class PostTest extends PHPUnit_Framework_TestCase
{

    protected $post;

    public function setUp()
    {
        $this->post = new _FakePost();
    }

    public function test_all()
    {
        $this->assertEmpty( $this->post->all() );
    }

    public function test_hasnt()
    {
        $this->assertFalse($this->post->has("azzz"));
    }
    
    public function test_setAll()
    {
        $this->post->setAll(
            array(
                'name'   => 'bob'
            )
        );
        $this->assertEquals( array( 'name'   => 'bob' ), $this->post->all() );
    }
    
    public function test_has()
    {
        $this->post->setAll(
            array(
                'name'   => 'bob'
            )
        );
        $this->assertTrue( isset( $this->post[ 'name' ] ) );
    }
    
    public function test_set()
    {
        $this->post->set('bob', 42);
        $this->assertTrue( isset( $this->post[ 'bob' ] ) );
    }
    
    public function test_get()
    {
        $this->post->setAll(
            array(
                'name'   => 'bob'
            )
        );
        $this->assertEquals( 'bob', $this->post[ 'name' ] );
    }
}
