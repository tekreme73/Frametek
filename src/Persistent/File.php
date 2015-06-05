<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Persistent;

/**
 * File
 *
 * This class 
 *
 * @package		Frametek
 * @author		Rémi Rebillard
 */
class File
{

    /**
     * Upload a file to the destination on the server
     * 
     * @param array     $filename       A $_FILE item name
     * @param string    $destination    The destination file path
     * 
     * @return boolean true on success, exit() if not
     */
    public static function upload( $filename, $destination )
    {
        if( isset( $_FILES[ $filename ] ) )
        {
            $file = $_FILES[ $filename ];
            if( is_uploaded_file( $file['tmp_name'] ) )
            {
                try {
                    return move_uploaded_file( $file['tmp_name'], $destination );
                } catch( \Exception $e ) {
                    var_dump( $e->getMessage() );
                    exit();
                }
            }
        }
        return false;
    }
    
    /**
     * Remove a file
     * 
     * @param string    $file_path  The file path
     * 
     * @return boolean If it is a success or not
     */
    public static function remove( $file_path )
    {
        return unlink( $file_path );
    }
    
    /**
     * Remove a file on server
     * 
     * @param string    $file_path  The file path
     * 
     * @return boolean If it is a success or not ont server
     */
    public static function removeOnServer( $file_path )
    {
        return static::remove( $_SERVER['DOCUMENT_ROOT'] . $file_path );
    }
    
    /**
     * Detect if a file exists or not
     * 
     * @param string    $file_path  The file path
     * 
     * @return boolean if the file exists of not
     */
    public static function exists( $file_path )
    {
        return file_exists( $file_path );
    }
    
    /**
     * Detect if a file exists or not on the server
     *
     * @param string    $file_path  The file path
     *
     * @return boolean if the file exists of not on the server
     */
    public static function existsOnServer( $file_path )
    {
        return static::exists( $_SERVER['DOCUMENT_ROOT'] . $file_path );
    }
}
