<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Errors\ErrorHandler;

class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{

    protected $handler;

    public function setUp()
    {
        $this->handler = new ErrorHandler();
    }

    public function test_instanceOfErrorCollection()
    {
        $this->assertInstanceOf("Frametek\Errors\ErrorCollection", $this->handler);
    }

    public function test_addError()
    {
        $this->assertEmpty($this->handler->all());
        $this->handler->add("Bob a été méchant");
        $this->assertTrue($this->handler->hasErrors());
        $this->assertFalse($this->handler->hasErrors('bob'));
    }

    public function test_addValue()
    {
        $this->assertEmpty($this->handler->all());
        $this->handler->addValue('booob', 654);
        $this->assertTrue($this->handler->hasValue('booob'));
        $this->assertFalse($this->handler->hasValue('michel'));
    }

    public function test_firstError()
    {
        $this->assertEmpty($this->handler->all());
        
        $first = 'Il a vraiment été méchant!';
        $this->handler->add('Il a vraiment été méchant!', 'bob.bobby.g');
        $this->handler->add('Très très méchant!!', 'bob.bobby.g');
        $this->assertTrue($this->handler->hasErrors('bob.bobby.g'));
        
        $this->assertEquals($first, $this->handler->firstOf('bob.bobby.g'));
    }
}
