<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
require_once '_FakeGet.php';

use Frametek\Http\Get;

class GetTest extends PHPUnit_Framework_TestCase
{

    protected $get;

    public function setUp()
    {
        $this->get = new _FakeGet();
    }

    public function test_all()
    {
        $this->assertEmpty( $this->get->all() );
    }

    public function test_hasnt()
    {
        $this->assertFalse($this->get->has("azzz"));
    }
    
    public function test_setAll()
    {
        $this->get->setAll(
            array(
                'name'   => 'bob'
            )
        );
        $this->assertEquals( array( 'name'   => 'bob' ), $this->get->all() );
    }
    
    public function test_has()
    {
        $this->get->setAll(
            array(
                'name'   => 'bob'
            )
        );
        $this->assertTrue( isset( $this->get[ 'name' ] ) );
    }
    
    public function test_set()
    {
        $this->get->set('bob', 42);
        $this->assertTrue( isset( $this->get[ 'bob' ] ) );
    }
    
    public function test_get()
    {
        $this->get->setAll(
            array(
                'name'   => 'bob'
            )
        );
        $this->assertEquals( 'bob', $this->get[ 'name' ] );
    }
}
