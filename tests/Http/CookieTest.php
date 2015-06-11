<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Http\Cookie;

class CookieTest extends PHPUnit_Framework_TestCase
{

    protected $http_cookies;

    public function setUp()
    {
        $this->http_cookies = new Cookie();
    }

    public function test_all()
    {
        $this->assertEmpty($this->http_cookies->all());
    }

    public function test_hasnt()
    {
        $this->assertFalse($this->http_cookies->has("azzz"));
    }
    
    /*
     * UNABLE TO TEST BECAUSE OF THE COOKIES LIMITATION
     * setcookie doesn't works when an output is done before
     * public function test_get()
     * {
     * $this->cookies->set( "abcde", 50 );
     * $this->assertTrue($this->cookies->get( "abcde" ) == 50 );
     * }
     */
}
