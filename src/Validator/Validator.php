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

/**
 * Validator
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
abstract class Validator
{

    public $_preserve_field = "preserve";

    public $_field_anchor = ":field";

    public $_satisfier_anchor = ":satisfier";

    public $_default_message = "";

    protected $errorHandler;

    protected $items;

    /**
     *
     * @param ErrorHandler $errorHandler            
     */
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
        $this->items = array();
        
        $this->_default_message = "Invalid value for $this->_field_anchor: $this->_satisfier_anchor";
    }

    abstract public function getRules();

    abstract public function getMessages();

    abstract protected function validate($field, $value, array $item_rules);

    /**
     * Check if items can be validate
     *
     * @param array $items
     *            List of items
     * @param array $rules
     *            List of rules
     *            
     * @return \Frametek\Validator\Validator The caller object
     */
    public function check(array $items, array $rules)
    {
        $this->items = $items;
        foreach ($items as $item => $value) {
            if (array_key_exists($item, $rules)) {
                $this->preserveItem($item, $value, $rules[$item]);
                $this->validate($item, $value, $rules[$item]);
            }
        }
        
        return $this;
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
    protected function preserveItem($field, $value, array &$item_rules)
    {
        if (! array_key_exists($this->_preserve_field, $item_rules)) {
            $preserve = false;
        } else {
            $preserve = $item_rules[$this->_preserve_field];
            unset($item_rules[$this->_preserve_field]);
        }
        
        if ($preserve) {
            $this->errorHandler->addValue($field, $value);
        }
    }

    /**
     * Validate the rule by calling the correct function
     *
     * @param mixed $caller
     *            The caller validator object
     * @param string $field
     *            The field name
     * @param mixed $value
     *            The field value
     * @param string $rule
     *            The rule name
     * @param mixed $satisfier
     *            The rule value
     */
    protected function validateRule($caller, $field, $value, $rule, $satisfier)
    {
        if (in_array($rule, $this->getRules())) {
            if (! call_user_func_array([
                $caller,
                $rule
            ], [
                $field,
                $value,
                $satisfier
            ])) {
                $this->ruleFailed($field, $rule, $satisfier);
            }
        }
    }

    /**
     * Add an error with the correct error message
     *
     * @param string $field
     *            The field name
     * @param string $rule
     *            The rule name
     * @param mixed $satisfier
     *            The rule value
     */
    protected function ruleFailed($field, $rule, $satisfier)
    {
        $this->errorHandler->add(str_replace([
            $this->_field_anchor,
            $this->_satisfier_anchor
        ], [
            $field,
            $satisfier
        ], $this->getMessage($rule, $this->_default_message)), $field);
    }

    /**
     * Get the error message for the rule
     *
     * @param string $rule
     *            The rule name
     * @param string $default[optional]
     *            The default message value
     *            
     * @return string The rule error message
     */
    public function getMessage($rule, $default = NULL)
    {
        $messages = $this->getMessages();
        if (isset($messages[$rule])) {
            return $messages[$rule];
        } else {
            return $default;
        }
    }

    /**
     * Detect if the validator has errors
     *
     * @return boolean If the validator has errors
     */
    public function fails()
    {
        return $this->errorHandler->hasErrors();
    }

    /**
     * Get the error handler
     *
     * @return ErrorHandler The error handler
     */
    public function errorHandler()
    {
        return $this->errorHandler;
    }
}
