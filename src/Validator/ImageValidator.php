<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Validator;

use Frametek\Errors\ErrorHandler;
use Frametek\Http\File;

/**
 * ImageValidator
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class ImageValidator extends Validator
{

    /**
     *
     * @var string
     */
    public $_extension_field = 'extensions';

    /**
     *
     * @var string
     */
    public $_extension_first_error = "You have to validate the image extension in first place!";

    /**
     *
     * @var Frametek\Http\File
     */
    protected $_http_files;

    public function __construct(ErrorHandler $errorHandler)
    {
        parent::__construct($errorHandler);
        $this->_http_files = new File();
    }

    /**
     * Get the error message from the file error code
     *
     * @param integer $error
     *            The error code
     * @param string $default[optional]
     *            The default message if no error message can be found
     *            
     * @return string The error message
     */
    public function getErrorMessage($error, $default = NULL)
    {
        $messages = $this->_http_files->getErrorMessages();
        if (isset($messages[$error])) {
            return $messages[$error];
        } else {
            if (is_null($default)) {
                return "Erreur indéfinie !";
            } else {
                return $default;
            }
        }
    }

    /**
     * Get a list of messages for each rules.
     * This while be fires when a rule check failed
     *
     * @return array list of messages for each rules
     */
    public function getRules()
    {
        return [
            'extensions',
            'maxsize',
            'minwidth',
            'maxwidth',
            'minheight',
            'maxheight'
        ];
    }

    /**
     * Get a list of messages for each rules.
     * This while be fires when a rule check failed
     *
     * @return array list of messages for each rules
     */
    public function getMessages()
    {
        return [
            'extensions' => "Les extensions autorisées sont : :satisfier",
            'maxsize' => "L'image :field ne doit pas faire plus de :satisfier otets",
            'minwidth' => "La largeur minimum de l'image :field est de :satisfier pixels",
            'maxwidth' => "La largeur maximum de l'image :field est de :satisfier pixels",
            'minheight' => "La hauteur minimum de l'image :field est de :satisfier pixels",
            'maxheight' => "La hauteur maximum de l'image :field est de :satisfier pixels"
        ];
    }

    /**
     * Preserve the field value there is the preserve rule
     *
     * @param string $field
     *            The field name
     * @param mixed $value
     *            The field value
     * @param array $item_rules
     *            List of rules
     */
    protected function validate($field, $value, array $item_rules)
    {
        if ($value[File::ERROR] === File::VALID_ERROR) {
            if (! array_key_exists($this->_extension_field, $item_rules)) {
                $this->errorHandler()->add($this->_extension_first_error, $field);
            } else {
                if ($this->extensions($field, $value, $item_rules[$this->_extension_field])) {
                    unset($item_rules[$this->_extension_field]);
                    foreach ($item_rules as $rule => $satisfier) {
                        $this->validateRule($this, $field, $value, $rule, $satisfier);
                    }
                } else {
                    $this->ruleFailed($field, $this->_extension_field, implode(", ", $item_rules[$this->_extension_field]));
                }
            }
        } else {
            $this->errorHandler()->add($this->getErrorMessage($value[File::ERROR]), $field);
        }
    }

    protected function getDimension($image)
    {
        return getimagesize($image[File::TMP_NAME]);
    }

    protected function extensions($field, $value, $satisfier)
    {
        $ext = strtolower(substr(strrchr($value[File::FILE_NAME], '.'), 1)); // "png" for example
        return in_array($ext, $satisfier);
    }

    protected function maxsize($field, $value, $satisfier)
    {
        return $value[File::BYTE_SIZE] <= $satisfier;
    }

    protected function minwidth($field, $value, $satisfier)
    {
        $dim = $this->getDimension($value);
        return $dim[0] >= $satisfier;
    }

    protected function maxwidth($field, $value, $satisfier)
    {
        $dim = $this->getDimension($value);
        return $dim[0] <= $satisfier;
    }

    protected function minheight($field, $value, $satisfier)
    {
        $dim = $this->getDimension($value);
        return $dim[1] >= $satisfier;
    }

    protected function maxheight($field, $value, $satisfier)
    {
        $dim = $this->getDimension($value);
        return $dim[1] <= $satisfier;
    }
}
