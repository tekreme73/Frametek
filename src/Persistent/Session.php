<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link      https://github.com/tekreme73/Frametek
 * @copyright Copyright (c) 2015 Rémi Rebillard
 * @license   https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

use Frametek\Collections\RecursiveCollection;

/**
 * Session
 *
 * This class 
 *
 * @package Frametek
 * @author  Rémi Rebillard
 */
class Session extends RecursiveCollection
{
    protected static $_DATA;
	
    protected static $_SEP = '.';
    
    public function __construct()
    {
    	if( isset( $_SESSION ) )
    	{
            static::$_DATA = $_SESSION;
    	} else {
            static::$_DATA = array();
    	}
    }
           
    /********************************************************************************
     * Collection interface
     *******************************************************************************/
    
    /**
     * Get all items in session
     *
     * @return array    The source session
     */
    public function all()
    {
        return static::$_DATA;
    }
    
    /**
     * Set the data collection
     * 
     * @param array $datas  The datas to set to replace existing data collection
     */
    public function setAll( array $datas )
    {
        static::$_DATA = $datas;
    }
}
