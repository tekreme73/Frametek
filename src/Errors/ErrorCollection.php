<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Errors;

use Frametek\Collections\RecursiveCollection;

/**
 * ErrorCollection
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
abstract class ErrorCollection extends RecursiveCollection
{
    protected $errors;
    
    public function __construct()
    {
        parent::__construct( '.' );
        $this->errors = array();
    }
    
    /**
     * Add an error to the collection
     * 
     * @param mixed     $error  The error to add
     * @param string    $key    The optionnal error key
     */
    public function add( $error, $key = null )
    {
        if( $key )
        {
            $errorContainer = $this->get( $key, new static() );
            $errorContainer->push( $error );
            $this->set( $key, $errorContainer );
        }
        else
        {
            $this->push( $error );
        }
    }
    
    /***
     * Get the first element at error item target by the key
     * 
     * @param string    $key        The error key to use
     * @param mixed     $default    The default value used if there is no first error
     * 
     * @return mixed The first item in the errors
     */
    public function first( $key, $default = '' )
    {
        $first = $this->allByKey( $key )->shift();
        if( !$first ) {
            $first = $default;
        } else {
            $this->allByKey( $key )->unshift( $first );
        }
        return $first;
    }
    
    
    /**
     * Get all items in errors by key
     * 
     * @param string    $key The error key to use
     * 
     * @return array    All items in errors by keys, if undefined key : all()
     */
    protected function allByKey( $key, $default = NULL )
    {
        if( is_null( $default ) )
        {
            $default = $this->all();
        }
        return $this->get( $key, $default );
    }
    
    /********************************************************************************
     * Collection interface
     *******************************************************************************/
    
    /**
     * Get all items in errors
     *
     * @return array    The source errors
     */
    public function all()
    {
        return $this->errors;
    }
    
    /**
     * Get all items in errors by reference
     *
     * @return array    The source errors
     */
    public function &allByRef()
    {
        return $this->errors;
    }
    
    /**
     * Set the data errors
     *
     * @param array $datas  The datas to set to replace existing data errors
     */
    public function setAll( array $datas )
    {
        $this->errors = $datas;
    }
}
