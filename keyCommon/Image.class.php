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
     * @param string $in_file           ��ת���ľ��ļ�
     * @param string $out_fileName      ������ļ���
     * @param string $out_filePath      ������ļ���·�������ޣ��������ת���ľ��ļ���·��)
     * @param bool|false $del_old       �Ƿ�ɾ�����ļ���Ĭ�Ϸ�
     * @return bool|string              true|������Ϣ
     */
    public function toPng($in_file, $out_fileName = "output",$out_filePath = "",$del_old = false){
        try{
            //�жϾ��ļ��Ƿ���ȷ
            if (@is_file($in_file) === false) {
                return self::ERROR_IMAGE;
            }
            chmod($in_file, 0777);

            //�����ļ�������ַ�����
            $imageString = imagecreatefromstring(file_get_contents($in_file));
            if($imageString == false){
                return self::ERROR_IMAGE;
            }

            //��ȡ������ļ���·������������þ��ļ���·����
            if($out_filePath == ""){
                $out_filePath = dirname($in_file).'/';
            }

            //ת�����
            if(imagepng($imageString, $out_filePath.$out_fileName.".png") === false){
                return self::ERROR_IMAGE;
            }

            //�Ƿ�ɾ�����ļ�
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
     * @param string $in_file           ��ת���ľ��ļ�
     * @param string $out_fileName      ������ļ���
     * @param int $out_quality          ����� jpg ������Ĭ��80
     * @param string $out_filePath      ������ļ���·�������ޣ��������ת���ľ��ļ���·��)
     * @param bool|false $del_old       �Ƿ�ɾ�����ļ���Ĭ�Ϸ�
     * @return bool|string              true|������Ϣ
     */
    public function pngToJpg($in_file, $out_fileName = "output",$out_quality = 80, $out_filePath = "",$del_old = false){
        try{
            //�жϾ��ļ��Ƿ���ȷ
            if (@is_file($in_file) === false) {
                return self::ERROR_IMAGE;
            }
            chmod($in_file, 0777);

            //��ȡ������ļ���·������������þ��ļ���·����
            if($out_filePath == ""){
                $out_filePath = dirname($in_file).'/';
            }

            //�����ļ�������ַ�����������png��͸��ɫ��Ϊ��ɫ
            $image = imagecreatefrompng($in_file);
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagealphablending($bg, TRUE);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);

            //ת�����
            if(imagejpeg($bg, $out_filePath . $out_fileName.".jpg", $out_quality) === false){
                return self::ERROR_IMAGE;
            }
            //�ͷ�
            imagedestroy($bg);

            //�Ƿ�ɾ�����ļ�
            if($del_old){
                @unlink($in_file);
            }

        }catch (Exception $e){
            return $e->getMessage();
        }

        return true;
    }
}