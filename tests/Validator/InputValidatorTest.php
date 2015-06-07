<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */

use Frametek\Validator\InputValidator;
use Frametek\Errors\ErrorHandler;

class InputValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $validator;
    
    public function setUp()
    {
    	$this->validator = new InputValidator( new ErrorHandler() );
    }
    
    public function test_fails()
    {
        $this->assertFalse( $this->validator->fails() );
    }
    
    protected function check( array $valid_items, array $valid_rules, array $fail_items, array $fail_rules )
    {
        $this->validator->check($valid_items, $valid_rules);
        $this->assertFalse( $this->validator->fails() );
    
        $this->validator->check($fail_items, $fail_rules);
        $this->assertTrue( $this->validator->fails() );
    }
    
    public function test_checkRequired()
    {
        $this->check(
            [
                'bob'       => 100,
            ],
            [
                'bob'       => [
                    'required'   => true,
                ]
            ],
            [
                'bob'       => ''   //or NULL
            ],
            [
                'bob'       => [
                    'required'   => true,
                ]
            ]
        );
    }
    
    public function test_checkMinlength()
    {
        $this->check(
            [
                'bob'       => "12345",
            ],
            [
                'bob'       => [
                    'minlength'   => 3,
                ]
            ],
            [
                'bob'       => "12"
            ],
            [
                'bob'       => [
                    'minlength'   => 3,
                ]
            ]
        );
    }
    
    public function test_checkMaxlength()
    {
        $this->check(
            [
                'bob'       => "12345",
            ],
            [
                'bob'       => [
                    'maxlength'   => 6,
                ]
            ],
            [
                'bob'       => "12345"
            ],
            [
                'bob'       => [
                    'maxlength'   => 4,
                ]
            ]
        );
    }
    
    public function test_checkEmail()
    {
        $this->check(
            [
                'bob'       => "tekreme73@bob.com",
            ],
            [
                'bob'       => [
                    'email'   => true,
                ]
            ],
            [
                'bob'       => "bob.commms.sssd6/s"
            ],
            [
                'bob'       => [
                    'email'   => true,
                ]
            ]
        );
    }
    
    public function test_checkAlnum()
    {
        $this->check(
            [
                'bob'       => 'AbCd1zyZ9',
            ],
            [
                'bob'       => [
                    'alnum'   => true,
                ]
            ],
            [
                'bob'       => 'foo!#$bar',
            ],
            [
                'bob'       => [
                    'alnum'   => true,
                ]
            ]
        );
    }
    
    public function test_checkNum()
    {
        $this->check(
            [
                'bob'       => 50,
                'michel'    => "50"
            ],
            [
                'bob'       => [
                    'numeric'   => true,
                ],
                'michel'    => [
                    'numeric'   => true,
                ]
            ],
            [
                'bob'       => "abwabwa",
            ],
            [
                'bob'       => [
                    'numeric'   => true,
                ]
            ]
        );
    }
    
    public function test_checkMatch()
    {
        $this->check(
            [
                'bob'       => 50,
                'michel'    => 50
            ],
            [
                'bob'       => [
                    'numeric'   => true,
                ],
                'michel'    => [
                    'match'   => 'bob',
                ]
            ],
            [
                'bob'       => 50,
                'michel'    => "50"
            ],
            [
                'bob'       => [
                    'numeric'   => true,
                ],
                'michel'    => [
                    'match'   => 'bob',
                ]
            ]
        );
    }
    
    public function test_checkUrl()
    {
        $this->check(
            [
                'bob'       => "https://github.com/tekreme73",
            ],
            [
                'bob'       => [
                    'url'   => true,
                ]
            ],
            [
                'bob'       => "https://github.com/tekreme73/.greg33*er5g.#sdf kjj"
            ],
            [
                'bob'       => [
                    'url'   => true,
                ]
            ]
        );
    }
    
    public function test_preserve()
    {
        $value = 100;
        $this->validator->check(
            [
                'bob'       => $value,
            ],
            [
                'bob'       => [
                    'preserve'  => true,
                    'required'  => true,
                    'url'   => true,        //error
                ]
            ]
        );
        
        $this->assertTrue( $this->validator->fails() );
        $this->assertEquals(
            $value,
            $this->validator->errorHandler()->value( 'bob' )
        );
    }
    
    public function test_messages()
    {
        $this->validator->check(
            [
                'bob'       => 40,
            ],
            [
                'bob'       => [
                    'email'   => true,      //error
                ]
            ]
        );
    
        $this->assertTrue( $this->validator->fails() );
        $this->assertEquals(
            $this->validator->getMessage( 'email' ),
            $this->validator->errorHandler()->first( 'bob' )
        );
    }
}