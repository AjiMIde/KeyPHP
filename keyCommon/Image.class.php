<?php
/**
 * Copyright 2016-2020 Aji
 * That's a interface to get some information of a device(linux),offer several methods above:
 *
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
 * Version     : 1.0
 * DateTime    : 2016/7/6-10:26
 * Modified    : 2016/7/6-10:26
 */
class Image
{
    /**
     * @var string
     */
    const ERROR_IMAGE= "Error image path or file";

    /**
     * @var DeviceState
     */
    protected static $_instance;

    /**
     * Construct
     */
    public function __construct() {

    }

    /**
     * Get an instance of this class
     *
     * @return DeviceState instance
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new DeviceState();
        }
        return self::$_instance;
    }

    /**
     * jpg/jpeg/gif/png/...   to   png
     *
     * @param string $in_file           欲转换的旧文件
     * @param string $out_fileName      输出的文件名
     * @param string $out_filePath      输出的文件夹路径（如无，则采用欲转换的旧文件的路径)
     * @param bool|false $del_old       是否删除旧文件（默认否）
     * @return bool|string              true|错误信息
     */
    public function toPng($in_file, $out_fileName = "output",$out_filePath = "",$del_old = false){
        try{
            //判断旧文件是否正确
            if (@is_file($in_file) === false) {
                return self::ERROR_IMAGE;
            }
            chmod($in_file, 0777);

            //将旧文件输出成字符串流
            $imageString = imagecreatefromstring(file_get_contents($in_file));
            if($imageString == false){
                return self::ERROR_IMAGE;
            }

            //获取输出的文件夹路径（如无则采用旧文件的路径）
            if($out_filePath == ""){
                $out_filePath = dirname($in_file).'/';
            }

            //转换输出
            if(imagepng($imageString, $out_filePath.$out_fileName.".png") === false){
                return self::ERROR_IMAGE;
            }

            //是否删除旧文件
            if($del_old){
                @unlink($in_file);
            }

        }catch (Exception $e){
            return $e->getMessage();
        }

        return true;
    }

    /**
     * jpg/jpeg/gif/png/...   to   jpg
     *
     * @param string $in_file           欲转换的旧文件
     * @param string $out_fileName      输出的文件名
     * @param int $out_quality          输出的 jpg 质量，默认80
     * @param string $out_filePath      输出的文件夹路径（如无，则采用欲转换的旧文件的路径)
     * @param bool|false $del_old       是否删除旧文件（默认否）
     * @return bool|string              true|错误信息
     */
    public function pngToJpg($in_file, $out_fileName = "output",$out_quality = 80, $out_filePath = "",$del_old = false){
        try{
            //判断旧文件是否正确
            if (@is_file($in_file) === false) {
                return self::ERROR_IMAGE;
            }
            chmod($in_file, 0777);

            //获取输出的文件夹路径（如无则采用旧文件的路径）
            if($out_filePath == ""){
                $out_filePath = dirname($in_file).'/';
            }

            //将旧文件输出成字符串流，并将png中透明色改为白色
            $image = imagecreatefrompng($in_file);
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagealphablending($bg, TRUE);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);

            //转换输出
            if(imagejpeg($bg, $out_filePath . $out_fileName.".jpg", $out_quality) === false){
                return self::ERROR_IMAGE;
            }
            //释放
            imagedestroy($bg);

            //是否删除旧文件
            if($del_old){
                @unlink($in_file);
            }

        }catch (Exception $e){
            return $e->getMessage();
        }

        return true;
    }
}