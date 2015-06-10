<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
use Frametek\Validator\ImageValidator;
use Frametek\Errors\ErrorHandler;
use Frametek\Http\File;

class ImageValidatorTest extends PHPUnit_Framework_TestCase
{

    protected $validator;

    protected $extensions = [
        'jpg',
        'jpeg',
        'png',
        'gif'
    ];

    public function setUp()
    {
        $this->validator = new ImageValidator(new ErrorHandler());
    }

    public function test_fails()
    {
        $this->assertFalse($this->validator->fails());
    }

    protected function check(array $valid_items, array $valid_rules, array $fail_items, array $fail_rules)
    {
        $this->validator->check($valid_items, $valid_rules);
        $this->assertFalse($this->validator->fails());
        
        $this->validator->check($fail_items, $fail_rules);
        $this->assertTrue($this->validator->fails());
    }

    protected function fileFaker($file_name, $size = 10, $error = File::VALID_ERROR, $tmp = 'nvm')
    {
        return [
            File::FILE_NAME => $file_name,
            File::TYPE => 'text/plain',
            File::TMP_NAME => $tmp,
            File::ERROR => $error,
            File::BYTE_SIZE => $size
        ];
    }

    public function test_checkExtensions()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg')
        ], [
            'bob' => [
                'extensions' => $this->extensions
            ]
        ], [
            'bob' => $this->fileFaker('bob.abc')
        ] // error here

        , [
            'bob' => [
                'extensions' => $this->extensions
            ]
        ]);
    }

    public function test_checkMaxsize()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg', 20)
        ], [
            'bob' => [
                'extensions' => $this->extensions,
                'maxsize' => 50
            ]
        ], [
            'bob' => $this->fileFaker('bob.jpg', 20)
        ] // error here

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'maxsize' => 15
            ]
        ]);
    }

    public function test_checkMinwidth()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'minwidth' => 30
            ]
        ], [
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'minwidth' => 100
            ]
        ] // error here

        );
    }

    public function test_checkMaxwidth()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'maxwidth' => 50
            ]
        ], [
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'maxwidth' => 30
            ]
        ] // error here

        );
    }

    public function test_checkMinheight()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'minheight' => 20
            ]
        ], [
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'minheight' => 60
            ]
        ] // error here

        );
    }

    public function test_checkMaxheight()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'maxheight' => 70
            ]
        ], [
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR, __DIR__ . '/image/redstone.jpg')
        ] // dimension => 48*48

        , [
            'bob' => [
                'extensions' => $this->extensions,
                'maxheight' => 25
            ]
        ] // error here

        );
    }

    public function test_checkErrors()
    {
        $this->check([
            'bob' => $this->fileFaker('bob.jpg', 20, File::VALID_ERROR)
        ], [
            'bob' => [
                'extensions' => $this->extensions
            ]
        ], [
            'bob' => $this->fileFaker('bob.jpg', 20, UPLOAD_ERR_PARTIAL)
        ] // error here

        , [
            'bob' => [
                'extensions' => $this->extensions
            ]
        ]);
    }

    public function test_messages()
    {
        $this->validator->check([
            'bob' => $this->fileFaker('bob.jpg', 20, UPLOAD_ERR_PARTIAL)
        ] // error here

        , [
            'bob' => [
                'extensions' => $this->extensions
            ]
        ]);
        
        $this->assertTrue($this->validator->fails());
        $this->assertEquals($this->validator->getErrorMessage(UPLOAD_ERR_PARTIAL), $this->validator->errorHandler()
            ->first('bob'));
    }
}
