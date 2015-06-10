<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */

require_once '_FakeSession.php';

use Frametek\Http\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $session;
    
    public function setUp()
    {
    	$this->session = new _FakeSession();
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
    
    public function test_recursivePath()
    {
        $s = $this->session->getSeparator();
    	$this->session->set( "12".$s."3456" , true );
    	$this->assertTrue( $this->session->has( "12".$s."3456" ) );
    }
    
    public function test_changeRecursiveSeparator()
    {
        $this->session->setSeparator( '>' );
        $s = $this->session->getSeparator();
    	$this->session->set( "12".$s."3456" , true );
    	$this->assertTrue( $this->session->has( "12".$s."3456" ) );
    }
    
    public function test_replace()
    {
        $size = $this->session->count();
    	$this->session->replace([
    		"abc"     => 5,
    		"bob"     => "55"
    	]);
        $this->assertTrue( $this->session->get( "abc" ) === 5 );
        $this->assertTrue( $this->session->count() === $size + 1 );
    }
    
    public function test_appendDifferentDepth()
    {
        $s = $this->session->getSeparator();
    	$this->session->set( "a".$s."mm", 20 );
    	$this->session->set( "a".$s."ddd".$s."k", 50 );
        $this->assertCount( 2, $this->session->get( "a" ) );
    }
    
    public function test_removePath()
    {
        $s = $this->session->getSeparator();
        $this->session->set( "gg".$s."rr", true );
        $this->session->set( "gg".$s."zzzzzzzz".$s."dd", "20" );
        $this->assertCount( 2, $this->session->get( "gg" ) );
        $this->assertCount( 1, $this->session->get( "gg".$s."zzzzzzzz" ) );
        $this->session->remove( "gg".$s."zzzzzzzz".$s."dd", false );
        $this->assertCount( 2, $this->session->get( "gg" ) );
        $this->assertCount( 0, $this->session->get( "gg".$s."zzzzzzzz" ) );
    }
    
    public function test_removeAllPath()
    {
        $s = $this->session->getSeparator();
        $this->session->set( "gg".$s."rr", true );
        $this->session->set( "gg".$s."zzzzzzzz".$s."dd", "20" );
        $this->assertCount( 2, $this->session->get( "gg" ) );
        $this->assertCount( 1, $this->session->get( "gg".$s."zzzzzzzz" ) );
        $this->session->remove( "gg".$s."zzzzzzzz".$s."dd", true );
        $this->assertCount( 1, $this->session->get( "gg" ) );
        $this->assertNull( $this->session->get( "gg".$s."zzzzzzzz" ) );
    }
}
