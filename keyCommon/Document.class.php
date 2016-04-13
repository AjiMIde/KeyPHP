<?php

/**
 * Copyright 2016-2020 Aji
 * That's a Document Operation Set,offer several methods above:
 *
 * ## Get the list of specified type of files from document;
 * ## Get the list of sub directories from a directory path, not include files
 * ## Create a directory
 * ## Del the directory
 * ## Copy directory
 * ## Get the size of directory
 *
 * ## Zip operation :
 * > * Create zip
 * > * extract ip
 *
 * @package    keyCommon
 * @email      Adele513900383@gmail.com
 *
 * Version     : 1.4
 * DateTime    : 2015/10/15-17:50
 * Modified    : 2016/04/07-9:51
 */
class Document
{
    /**
     * @var string
     */
    const VERSION = "1.3";

    /**
     * @var string
     */
    const ERR_NO_SUCH_DIR = "Error: No Such Directory";

    /**
     * @var string
     */
    const ERR_CAN_NOT_OPEN_DIR = "Error: Can Not Open Directory";

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
     * @param string $type The file filter eg: all, img, flash, media, file(windows)
     * @return string $regex
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
     * Check the directory is valid
     *
     * @param $dir
     * @return bool:true|string:error msg
     */
    private function _checkDir($dir) {
        $suffix = substr($dir, strlen($dir) - 1);
        if ($suffix != "/") {
            $dir .= "/";
        }

        if (!$dir) {
            return self::ERR_INVALID_PATH;
        }

        if (@is_dir($dir) === false) {
            return self::ERR_NO_SUCH_DIR;
        }

        chmod($dir, 0777);
        if (@opendir($dir) === false) {
            @closedir($dir);
            return self::ERR_CAN_NOT_OPEN_DIR;
        }

        return true;
    }

    /**
     * gets instance of this class
     *
     * @return Docuemnt instance
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Document();
        }
        return self::$_instance;
    }

    /**
     * #Create a directory
     *
     * @param $dirPath The directory's path
     */
    public function createDir($dirPath) {
        if (@is_dir($dirPath) === false) {
            mkdir($dirPath, 0777, true);//true代表可创建多级目录;
            chmod($dirPath, 0777);
        }
    }

    private function _getSubFiles($dirPath, $regex, $deep, &$fileSize, &$fileName, &$fileTime, &$fileArr) {
        $dir = @opendir($dirPath);

        while (($file = @readdir($dir)) !== false) {
            $suffix = "." . pathinfo($file, PATHINFO_EXTENSION);

            if ($file != "." && $file != "..") {
                $path = $dirPath . '/' . $file;

                if (is_dir($path) && $deep) {

                    self::_getSubFiles($path . "/", $regex, $deep, $fileSize, $fileName, $fileTime, $fileArr);

                } elseif (preg_match($regex, $suffix, $matches)) {
                    $fileSize[] = round((filesize($path) / 1024), 2);//获取文件大小
                    $fileName[] = $path;//获取文件名称
                    $fileTime[] = date("Y-m-d H:i:s", filemtime($path));//获取文件最近修改日期
                    $fileArr[] = iconv("GB2312", "UTF-8", $file);
                }
            }
        }
        @closedir($dir);
    }

    /**
     * Get the sub file from the directory path
     *
     * @param string $dirPath The directory's path
     * @param string $fileType The file filter eg: all, img, flash, media, file(windows)
     * @param string $fileSort The type of files sort eg: name, size, time
     * @param int $sortType SORT_ASC/SORT_DESC
     * @param bool $deep Find in the sub directory or not
     *
     * @return array/string
     */
    public function getSubFiles($dirPath, $fileType = 'all', $fileSort = 'name', $sortType = SORT_ASC, $deep = false) {
        if (self::_checkDir($dirPath) !== TRUE) {
            return self::_checkDir($dirPath);
        }

        $regex = self::_getFileTypeRegex($fileType);

        $fileSize = array();
        $fileName = array();
        $fileTime = array();
        $fileArr = array();

        self::_getSubFiles($dirPath, $regex, $deep, $fileSize, $fileName, $fileTime, $fileArr);

        switch ($fileSort) {
            case 'name':
                array_multisort($fileName, $sortType, SORT_STRING, $fileArr);//按名字排序
                break;
            case 'time':
                array_multisort($fileTime, $sortType, SORT_STRING, $fileArr);//按时间排序
                break;
            case 'size':
                array_multisort($fileSize, $sortType, SORT_NUMERIC, $fileArr);//按大小排序
                break;
            default:
                array_multisort($fileName, $sortType, SORT_STRING, $fileArr);//按名字排序
                break;
        }
        return $fileArr;
    }

    private function _getSubDirs($dirPath, &$subDirs) {
        $dir = opendir($dirPath);
        while ($sub = readdir($dir)) {
            if ($sub != "." && $sub != "..") {
                if (is_dir($dirPath . $sub)) {
                    $subDirs[] = $sub;
                    self::_getSubDirs($dirPath . $sub . "/", $subDirs);
                }
            }
        }
    }

    /**
     * Get the sub directories from the directory path , not include files
     *
     * @param $dirPath  String      The directory's path
     * @param $deep     Bool        Find in the sub directory or not
     * @return array|string
     */
    public function getSubDirs($dirPath, $deep = false) {
        if (self::_checkDir($dirPath) !== TRUE) {
            return self::_checkDir($dirPath);
        }

        self::_getSubDirs($dirPath, $subDirs);

        return $subDirs;
    }

    /**
     * Del the directory
     *
     * @param $dir      The directory's path
     * @return bool:true|string:error msg
     */
    public function delDir($dir) {
        $result = true;

        try {
            if (self::_checkDir($dir) !== TRUE) {
                throw new Exception(self::_checkDir($dir));
            }

            $dh = opendir($dir);

            while ($file = readdir($dh)) {
                if ($file != "." && $file != "..") {
                    $fullPath = $dir . "/" . $file;
                    if (!is_dir($fullPath)) {
                        unlink($fullPath);
                    } else {
                        self::delDir($fullPath);
                    }
                }
            }
            closedir($dh);

            if (!rmdir($dir)) {
                throw new Exception("Error: rmdir error");
            }
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    /**
     * Copy directory
     *
     * @param string $src source directory
     * @param string $dst destination directory
     * @return bool:true|string:error msg
     */
    public function recurse_copy($src, $dst) {
        $result = true;

        try {
            if ($src == "" || $dst == "") {
                throw new Exception(self::ERR_INVALID_PATH);
            }

            if (self::_checkDir($src) !== TRUE) {
                throw new Exception(self::_checkDir($src));
            }

            self::createDir($dst);

            $dir = opendir($src);

            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        self::recurse_copy($src . '/' . $file, $dst . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    /**
     * Get the size of directory using directory path
     *
     * @param string $dirPath The directory's path
     * @param string $size_unit The size unit eg: kb/mb/g   default:mb
     *
     * @return float
     */
    public function getDirSize($dirPath, $size_unit = "mb") {
        if (($msg = self::_checkDir($dirPath)) !== TRUE) {
            return $msg;
        }
        $size = self::_getDirSize($dirPath);

        switch ($size_unit) {
            case 'kb':
                echo 'size';
                $size = $size / 1024;
                break;
            case 'g':
                $size = $size / 1024 / 1024 / 1024;
                break;
            default:
                $size = $size / 1024 / 1024;
                break;
        }

        return $size;
    }

    private function _getDirSize($dirPath) {
        $dir = @opendir($dirPath);
        $size = '0';

        while (($file = @readdir($dir)) !== false) {
            if ($file != "." && $file != "..") {
                if (is_dir("$dirPath/$file")) {
                    $size += self::_getDirSize("$dirPath/$file");
                } else {
                    $size += filesize("$dirPath/$file");
                }
            }
        }
        @closedir($dir);
        return $size;
    }

    /**
     * Provide it to createZip
     *
     * @param $zip
     * @param $src
     */
    private function _addFileToZip($zip, $src, $subSrc = "") {
        $list = scandir($src);
        unset($list[0]);
        unset($list[1]);

        $file_list = array_values($list);

        for ($i = 0; $i < count($file_list); $i++) {
            $fileName = $src . $file_list[$i];
            if (file_exists($fileName)) {
                if (is_dir($fileName)) {
                    $zip->addEmptyDir($subSrc . $file_list[$i]);
                    self::_addFileToZip($zip, $fileName . '/', $subSrc . $file_list[$i] . '/');
                } else {
                    $zip->addFile($fileName, $subSrc . $file_list[$i]);
                }
            }
        }
    }

    /**
     * Create zip file
     *
     * @param string $zipName like: tmp/xx/xx/zip.zip Need the path
     * @param string $src The directory which we create zip from it like: tmp/xx/xx/
     * @return bool:true/string:msg
     */
    public function createZip($zipName, $src) {

        $result = true;

        try {
            if ($zipName == "" || $src == "") {
                throw new Exception(self::ERR_INVALID_PATH);
            }
            if (self::_checkDir($src) !== TRUE) {
                throw new Exception(self::_checkDir($src));
            }

            $zip = new ZipArchive();
            if ($zip->open($zipName, ZIPARCHIVE::OVERWRITE) !== TRUE) {
                if ($zip->open($zipName, ZIPARCHIVE::CREATE) !== TRUE) {
                    throw new Exception('Error:' . $zipName);
                    $zip->close();
                }
            }

            self::_addFileToZip($zip, $src);

            $zip->close();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    function addFileToZip($path, $zip) {
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                if (is_dir($path . "/" . $filename)) {
                    self::addFileToZip($path . "/" . $filename, $zip);
                } else {
                    $zip->addFile($path . "/" . $filename);
                }
            }
        }
        @closedir($path);
    }

}
