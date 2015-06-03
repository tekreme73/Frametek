<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

use Frametek\Collections\RecursiveCollection;

/**
 * Config
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
class Config extends RecursiveCollection
{
    public static $_CONFIG_PATH = '../app/config';
    
    public static $_CONFIGS = array();

    /**
     * Get configs item for key
     *
     * @param string    $key        The config key
     * @param mixed     $default    The default value to return if config key does not exist
     *
     * @return mixed The key's value, or the default value
     */
    public static function value( $key, $default = null )
    {
        return (new static)->get( $key, $default );
    }
    
    /**
     * Load all configuration files to be available
     * 
     */
    public static function loadAll()
    {
    	$configs = new static;
    	$configs->setAll( array() );
        $d = dir( static::$_CONFIG_PATH );
        $configs->load( $d );
        $d->close();
    }
    
    /**
     * Load item from configs
     *
     * Warn: Recursive function
     * 
     * @param \Directory $parentDirectory
     */
    protected function load( $parentDirectory )
    {
        while( false !== ( $entry = $parentDirectory->read() ) ) {
            if( $entry !== '.' && $entry !== '..' )  {
                if( is_dir( $entry ) ) {
                    $tmpD = dir( $entry );
                    $this->load( $tmpD );
                    $tmpD->close();
                } else if( substr ( $entry, - strlen( '.php' ) ) === '.php' ) {
                    $this->set(
                    	substr ( $entry, 0, - strlen( '.php' ) ),
                    	include static::$_CONFIG_PATH . DIRECTORY_SEPARATOR . $entry
                    );
                }
            }
        }
    }
    
    /********************************************************************************
     * Collection interface
     *******************************************************************************/
    
    /**
     * Get all items in configs
     *
     * @return array    The source configs
     */
    public function all()
    {
        return static::$_CONFIGS;
    }
    
    /**
     * Set the data collection
     * 
     * @param array $datas  The datas to set to replace existing data collection
     */
    public function setAll( array $datas )
    {
        static::$_CONFIGS = $datas;
    }
}