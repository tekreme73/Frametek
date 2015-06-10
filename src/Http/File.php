<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Http;

use Frametek\Collections\Collection;
use Frametek\Exception\UndefinedFilesException;

/**
 * File
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class File extends Collection
{
    const FILE_NAME = 'name';
    const TYPE      = 'type';
    const TMP_NAME  = 'tmp_name';
    const ERROR     = 'error';
    const BYTE_SIZE = 'size';
    
    const VALID_ERROR   = UPLOAD_ERR_OK;
    
    protected static $_DATA;

    public function __construct()
    {
        if (! isset($_FILES)) {
            throw new UndefinedFilesException();
        } else {
            static::$_DATA = $_FILES;
        }
    }
    
    /**
     * 
     * @return array
     */
    public static function getErrorMessages()
    {
        return array(
            UPLOAD_ERR_INI_SIZE     => "La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini.",
            UPLOAD_ERR_FORM_SIZE    => "La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.",
            UPLOAD_ERR_PARTIAL      => "Le fichier n'a été que partiellement téléchargé.",
            UPLOAD_ERR_NO_FILE      => "Aucun fichier n'a été téléchargé.",
            UPLOAD_ERR_NO_TMP_DIR   => "Un dossier temporaire est manquant.",
            UPLOAD_ERR_CANT_WRITE   => "Échec de l'écriture du fichier sur le disque.",
            UPLOAD_ERR_EXTENSION    => "Une extension PHP a arrêté l'envoi de fichier.",
        );
    }
    
    /**
     * Upload a file to the destination on the server
     *
     * @param array $filename
     *            A $_FILE item name
     * @param string $destination
     *            The destination file path
     *            
     * @return boolean true on success, exit() if not
     */
    public static function upload($filename, $destination)
    {
        if ( isset( static::$_DATA[ $filename ] ) )
        {
            $file = static::$_DATA[ $filename ];
            if (is_uploaded_file($file[TMP_NAME]))
            {
                try
                {
                    return move_uploaded_file($file[TMP_NAME], $destination);
                } catch (\Exception $e)
                {
                    var_dump($e->getMessage());
                    exit();
                }
            }
        }
        return false;
    }

    /**
     * Delete a file
     *
     * @param string $file_path
     *            The file path
     *            
     * @return boolean If it is a success or not
     */
    public static function delete($file_path)
    {
        return unlink($file_path);
    }

    /**
     * Delete a file on server
     *
     * @param string $file_path
     *            The file path
     *            
     * @return boolean If it is a success or not
     */
    public static function deleteOnServer($file_path)
    {
        return static::delete($_SERVER['DOCUMENT_ROOT'] . $file_path);
    }

    /**
     * Detect if a file exists or not
     *
     * @param string $file_path
     *            The file path
     *            
     * @return boolean if the file exists of not
     */
    public static function exists($file_path)
    {
        return file_exists($file_path);
    }

    /**
     * Detect if a file exists or not on the server
     *
     * @param string $file_path
     *            The file path
     *            
     * @return boolean if the file exists of not on the server
     */
    public static function existsOnServer($file_path)
    {
        return static::exists($_SERVER['DOCUMENT_ROOT'] . $file_path);
    }
    
    /**
     * ******************************************************************************
     * Collection interface
     * *****************************************************************************
     */
    
    /**
     * Get all items in cookies
     *
     * @return array The cookies
     */
    public function all()
    {
        return static::$_DATA;
    }
    
    /**
     * Get all items in cookies by reference
     *
     * @return array The cookies
     */
    public function &allByRef()
    {
        return static::$_DATA;
    }

    /**
     * Set the data collection
     *
     * @param array $datas
     *            The datas to set to replace existing data collection
     */
    public function setAll(array $datas)
    {
        static::$_DATA = $datas;
    }
}
