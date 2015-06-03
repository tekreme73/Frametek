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

    public static function upload( $file, $destination )
    {
        try {
            return move_uploaded_file( $file['tmp_name'], $destination );
        } catch( \Exception $e ) {
            var_dump( $e );
            exit();
        }
    }
    
    public static function exists( $file_path )
    {
        return file_exists( $file_path );
    }
    
    public static function existsOnServer( $file_path )
    {
        return static::exists( $_SERVER['DOCUMENT_ROOT'] . $file_path );
    }
}