<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */

use Frametek\Persistent\Cookie;

class CookieTest extends PHPUnit_Framework_TestCase
{
    protected $cookies;
    
    public function setUp()
    {
    	$this->cookies = new Cookie();
    }
    
    public function test_all()
    {
    	$this->assertEmpty(
    		$this->cookies->all()
    	);
    }
    
    public function test_hasnt()
    {
    	$this->assertFalse(
    		$this->cookies->has( "azzz" )
    	);
    }
    
    /* UNABLE TO TEST BECAUSE OF THE COOKIES LIMITATION
     * setcookie doesn't works when an output is done before
    public function test_get()
    {
    	$this->cookies->set( "abcde", 50 );
        $this->assertTrue($this->cookies->get( "abcde" ) == 50 );
    }
    */
}