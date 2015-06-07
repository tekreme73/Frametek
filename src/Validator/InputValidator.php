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
 * InputValidator
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
class InputValidator extends Validator
{
    
    public function __construct( ErrorHandler $errorHandler )
    {
        parent::__construct( $errorHandler );
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
            'required',
            'minlength',
            'maxlength',
            'email',
            'alnum',
            'numeric',
            'match',
            'url'
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
    		'required'	=> "Le champs :field est requis",
    		'minlength'	=> "Le champs :field doit contenir au minimum :satisfier caractères",
    		'maxlength'	=> "Le champs :field doit contenir au maximun :satisfier caractères",
    		'email'		=> "L'adresse mail est invalide",
    		'alnum'		=> "Le champs :field doit contenir des caractères alphanumériques",
    		'numeric'	=> "Le champs :field doit contenir des caractères numériques",
    		'match'		=> "Le champs :field doit correspondre au champs :satisfier",
    		'url'       => "Ce :field ne semble pas valide ( ex: http://www.siteweb.com )",
    	];
    }
    
    /**
     * Preserve the field value there is the preserve rule
     * 
     * @param string    $field      The field name
     * @param mixed     $value      The field value
     * @param array     $item_rules List of rules
     */
    protected function validate( $field, $value, array $item_rules )
    {
        if( !array_key_exists( 'required',  $item_rules ) )
        {
            $item_rules[ 'required' ] = false;
        }
        
        if( $item_rules[ 'required' ] || $this->required( $field, $value, $item_rules[ 'required' ] ) )
        {
            foreach( $item_rules as $rule => $satisfier )
            {
                $this->validateRule( $this, $field, $value, $rule, $satisfier );
            }
        }
    }
    
    protected function required( $field, $value, $satisfier )
    {
        $v = trim( $value );
        return !empty( $v );
    }
    
    protected function minlength( $field, $value, $satisfier )
    {
        return strlen( trim( $value ) ) >= $satisfier;
    }
    
    protected function maxlength( $field, $value, $satisfier )
    {
        return strlen( trim( $value ) ) <= $satisfier;
    }
    
    protected function email( $field, $value, $satisfier )
    {
        return filter_var( trim( $value ), FILTER_VALIDATE_EMAIL );
    }
    
    protected function alnum( $field, $value, $satisfier )
    {
        return ctype_alnum( trim( $value ) );
    }
    
    protected function numeric( $field, $value, $satisfier )
    {
        return is_numeric( trim( $value ) );
    }
    
    protected function match( $field, $value, $satisfier )
    {
        return $value === $this->items[ $satisfier ];
    }
    
    protected function url( $field, $value, $satisfier )
    {
        return filter_var( trim( $value ), FILTER_VALIDATE_URL );
    }
}