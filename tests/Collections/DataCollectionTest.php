<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */

use Frametek\Collections\DataCollection;

class DataCollectionTest extends PHPUnit_Framework_TestCase
{
    protected $collection;
    
    public function setUp()
    {
        $this->collection = new DataCollection();
    }
    
    public function test_defaultSeparator()
    {
        $this->assertEquals($this->collection->getSeparator(), '.');
    }
    
    public function test_unshift_shift()
    {
        $a = 55;
        $b = "fff";
        $c = false;
        $d = 0;
        
        $this->assertEmpty( $this->collection->all() );
        $size = $this->collection->count();

        /* UNSHIFT */
        $this->collection->unshift($a);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
        
        $this->collection->unshift($b);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
        
        $this->collection->unshift($c);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
        
        $this->collection->unshift($d);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
        
        /* SHIFT */
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $d );
        $size = $this->collection->count();
        
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $c );
        $size = $this->collection->count();
        
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $b );
        $size = $this->collection->count();
        
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $a );
    }
    
    public function test_push_pop()
    {
        $a = 44;
        $b = '4';
        $c = 26;
        $d = true;
    
        $this->assertEmpty( $this->collection->all() );
        $size = $this->collection->count();
    
        /* PUSH */
        $this->collection->push($a);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        $this->collection->push($b);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        $this->collection->push($c);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        $this->collection->push($d);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        /* POP */
        $tmp = $this->collection->pop();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $d );
        $size = $this->collection->count();
    
        $tmp = $this->collection->pop();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $c );
        $size = $this->collection->count();
    
        $tmp = $this->collection->pop();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $b );
        $size = $this->collection->count();
    
        $tmp = $this->collection->pop();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $a );
    }
    
    public function test_push_shift()
    {
        $a = 'g';
        $b = 666;
        $c = array( 'cake' => array( 'bob' ) );
        $d = 0;
    
        $this->assertEmpty( $this->collection->all() );
        $size = $this->collection->count();
    
        /* PUSH */
        $this->collection->push($a);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        $this->collection->push($b);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        $this->collection->push($c);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        $this->collection->push($d);
        $this->assertEquals( $this->collection->count(), $size + 1 );
        $size = $this->collection->count();
    
        /* SHIFT */
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $a );
        $size = $this->collection->count();
        
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $b );
        $size = $this->collection->count();
        
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $c );
        $size = $this->collection->count();
        
        $tmp = $this->collection->shift();
        $this->assertEquals( $this->collection->count(), $size - 1 );
        $this->assertEquals( $tmp, $d );
    }

    public function test_allAndSet()
    {
        $this->assertEmpty( $this->collection->all() );
        $this->collection->set( '123.456', 666 );
        $this->assertNotEmpty( $this->collection->all() );
        $this->assertCount( 1, $this->collection->get( '123' ) );
        
        $this->assertEquals(
            array( '456' => 666 ),
            $this->collection->get( '123' )
        );
        $this->assertEquals(
            666,
            $this->collection->get( '123.456' )
        );
    }
}
