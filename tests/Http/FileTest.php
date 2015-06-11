<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Http\File;

class FileTest extends PHPUnit_Framework_TestCase
{

    protected $http_files;

    public function setUp()
    {
        $this->http_files = new File();
    }

    public function test_exists()
    {
        $this->assertTrue($this->http_files->exists("tests/phpunit_command.info"));
        $this->assertFalse($this->http_files->exists("tests/bob.txt"));
    }
}
