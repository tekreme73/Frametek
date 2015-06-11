<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Http\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{

    protected $http_session;

    public function setUp()
    {
        $this->http_session = new _FakeSession();
        $this->http_session->set("abc", 3);
    }

    public function test_all()
    {
        $this->assertNotEmpty($this->http_session->all());
    }

    public function test_has()
    {
        $this->assertTrue($this->http_session->has("abc"));
    }

    public function test_hasnt()
    {
        $this->assertFalse($this->http_session->has("azzz"));
    }

    public function test_set()
    {
        $this->http_session->set("123456", true);
        $this->assertTrue($this->http_session->has("123456"));
    }

    public function test_get()
    {
        $this->http_session->set("abcde", 50);
        $this->assertTrue($this->http_session->get("abc") === 3);
        $this->assertTrue($this->http_session->get("abcde") === 50);
    }

    public function test_recursivePath()
    {
        $s = $this->http_session->getSeparator();
        $this->http_session->set("12" . $s . "3456", true);
        $this->assertTrue($this->http_session->has("12" . $s . "3456"));
    }

    public function test_changeRecursiveSeparator()
    {
        $this->http_session->setSeparator('>');
        $s = $this->http_session->getSeparator();
        $this->http_session->set("12" . $s . "3456", true);
        $this->assertTrue($this->http_session->has("12" . $s . "3456"));
    }

    public function test_replace()
    {
        $size = $this->http_session->count();
        $this->http_session->replace([
            "abc" => 5,
            "bob" => "55"
        ]);
        $this->assertTrue($this->http_session->get("abc") === 5);
        $this->assertTrue($this->http_session->count() === $size + 1);
    }

    public function test_appendDifferentDepth()
    {
        $s = $this->http_session->getSeparator();
        $this->http_session->set("a" . $s . "mm", 20);
        $this->http_session->set("a" . $s . "ddd" . $s . "k", 50);
        $this->assertCount(2, $this->http_session->get("a"));
    }

    public function test_removePath()
    {
        $s = $this->http_session->getSeparator();
        $this->http_session->set("gg" . $s . "rr", true);
        $this->http_session->set("gg" . $s . "zzzzzzzz" . $s . "dd", "20");
        $this->assertCount(2, $this->http_session->get("gg"));
        $this->assertCount(1, $this->http_session->get("gg" . $s . "zzzzzzzz"));
        $this->http_session->remove("gg" . $s . "zzzzzzzz" . $s . "dd", false);
        $this->assertCount(2, $this->http_session->get("gg"));
        $this->assertCount(0, $this->http_session->get("gg" . $s . "zzzzzzzz"));
    }

    public function test_removeAllPath()
    {
        $s = $this->http_session->getSeparator();
        $this->http_session->set("gg" . $s . "rr", true);
        $this->http_session->set("gg" . $s . "zzzzzzzz" . $s . "dd", "20");
        $this->assertCount(2, $this->http_session->get("gg"));
        $this->assertCount(1, $this->http_session->get("gg" . $s . "zzzzzzzz"));
        $this->http_session->remove("gg" . $s . "zzzzzzzz" . $s . "dd", true);
        $this->assertCount(1, $this->http_session->get("gg"));
        $this->assertNull($this->http_session->get("gg" . $s . "zzzzzzzz"));
    }
}

class _FakeSession extends Session
{

    public function __construct()
    {
        $this->setSeparator('.');
        if (! $this->all()) {
            $this->setAll([]);
        }
    }
}
