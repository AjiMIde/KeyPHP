<?php

/**
 * Copyright 2016-2020 Aji
 * That's a Document Operation Set,offer several methods above:
 *
 * ## createFile with the 'file path' param
 * ## getContent with the 'file path' param
 * ## writeContent into a file
 *
 * @package    keyCommon
 * @email      Adele513900383@gmail.com
 *
 * Version     : 1.6
 * DateTime    : 2016/05/04
 * Modified    : 2016/05/05
 */
class File
{
    /**
     * @var string
     */
    const VERSION = "1.0";

    /**
     * @var string
     */
    const ERR_NO_SUCH_FILE = "Error: No Such File";

    /**
     * @var string
     */
    const ERR_CAN_NOT_OPEN_FILE = "Error: Can Not Open FILE";

    /**
     * @var string
     */
    const ERR_INVALID_PATH = "Error: Invalid Path";

    /**
     * @var Object
     */
    private static $_instance;

    /**
     * Construct
     */
    public function __construct() {
    }

    /**
     * Get the file type regex
     *
     * @param  string $type The file filter eg: all, img, flash, media, file(windows)
     * @return string
     */
    private function _getFileTypeRegex($type = 'all') {
        switch ($type) {
            case 'image':
                $regex = "/\.(gif|jpeg|jpg|png|bmp)$/i";
                break;
            case 'img':
                $regex = "/\.(gif|jpeg|jpg|png|bmp)$/i";
                break;
            case 'flash':
                $regex = "/\.(swf|flv)$/i";
                break;
            case 'media':
                $regex = "/\.(swf|flv|map|wav|wma|wmv|mid|avi|mpg|asf|rm|rmvb)$/i";
                break;
            case 'file':
                $regex = "/\.(doc|docx|xls|xlsx|ppt|htm|html|txt|zip|rar|gz|bz2)$/i";
                break;
            case 'all':
                $regex = "/.*/i";
                break;
            default:
                $regex = "/.*/i";
                break;
        }
        return $regex;
    }

    /**
     * Check the file is valid
     *
     * @param  string $file
     * @return bool|string true/error msg
     */
    private function _checkFile($file) {
        if (@is_file($file) === false) {
            return self::ERR_NO_SUCH_FILE;
        }

        chmod($file, 0777);
        if (@fopen($file, "r") === false) {
            @fclose($file);
            return self::ERR_CAN_NOT_OPEN_FILE;
        }

        return true;
    }

    /**
     * gets instance of this class
     *
     * @return Document|Object
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Document();
        }
        return self::$_instance;
    }

    /**
     * @param $file
     * @return bool|string
     */
    public function getContent($file) {
        if (($result = self::_checkFile($file)) !== TURE) {
            return $result;
        }

        return readfile($file);             //1，使用readfile 输出

        return file_get_contents($file);    //2，使用 file_get_contents 输出

        $myfile = @fopen($file, "r");
        $content = "";
        while (!feof($myfile)) {
            $content .= fgets($myfile);
        }
        fclose($myfile);

        return $content;                    //3，使用 流 feof 获取输出
    }

    /**
     * Create a file
     *
     * @param string $filePath The file's path
     */
    public function createFile($filePath) {
        if (@is_file($filePath) === false) {
            $myfile = fopen($filePath, "w"); //if it can't open ,it will be created
            chmod($filePath, 0777);
            fclose($myfile);
        }
    }


    /**
     * Write content to file
     *
     * @param string $file
     * @param string $content
     */
    public function writeContent($file,$content = ""){
        if (($result = self::_checkFile($file)) !== TURE) {
            return $result;
        }
        $fp = fopen($file, "w+");//the value of mode is: r r+ w w+ a a+ x

        if ($fp == true) {
            fwrite($fp, $content);
        }
        fclose($fp);
    }
}
