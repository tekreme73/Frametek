<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */

use Frametek\Persistent\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $session;
    
    public function setUp()
    {
    	$this->session = new Session();
    	$this->session->set( "abc", 3 );
    }
    
    public function test_all()
    {
    	$this->assertNotEmpty(
    		$this->session->all()
    	);
    }
    
    public function test_has()
    {
        $this->assertTrue(
            $this->session->has( "abc" )
        );
    }
    
    public function test_hasnt()
    {
    	$this->assertFalse(
    		$this->session->has( "azzz" )
    	);
    }
    
    public function test_set()
    {
    	$this->session->set( "123456" , true );
    	$this->assertTrue( $this->session->has( "123456" ) );
    }
    
    public function test_get()
    {
    	$this->session->set( "abcde", 50 );
        $this->assertTrue( $this->session->get( "abc" ) === 3 );
        $this->assertTrue( $this->session->get( "abcde" ) === 50 );
    }
    
    public function test_replace()
    {
    	$this->session->replace([
    		"abc"     => 5,
    		"bob"     => "55"
    	]);
        $this->assertTrue( $this->session->get( "abc" ) === 5 );
        $this->assertCount( 2, $this->session->all() );
    }
    
    public function test_appendDifferentDepth()
    {
    	$this->session->set( "a.mm", 20 );
    	$this->session->set( "a.ddd.k", 50 );
        $this->assertCount( 2, $this->session->all() );
        $this->assertCount( 2, $this->session->get( "a" ) );
    }
    
    public function test_removePath()
    {
        $this->session->set( "gg.rr", true );
        $this->session->set( "gg.zzzzzzzz.dd", "20" );
        $this->assertCount( 2, $this->session->get( "gg" ) );
        $this->assertCount( 1, $this->session->get( "gg.zzzzzzzz" ) );
        $this->session->remove( "gg.zzzzzzzz.dd", false );
        $this->assertCount( 2, $this->session->get( "gg" ) );
        $this->assertCount( 0, $this->session->get( "gg.zzzzzzzz" ) );
    }
    
    public function test_removeAllPath()
    {
        $this->session->set( "gg.rr", true );
        $this->session->set( "gg.zzzzzzzz.dd", "20" );
        $this->assertCount( 2, $this->session->get( "gg" ) );
        $this->assertCount( 1, $this->session->get( "gg.zzzzzzzz" ) );
        $this->session->remove( "gg.zzzzzzzz.dd", true );
        $this->assertCount( 1, $this->session->get( "gg" ) );
        $this->assertNull( $this->session->get( "gg.zzzzzzzz" ) );
    }
}
