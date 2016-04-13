<?php
/**
 * Copyright 2016-2020 Aji
 * That's a file upload and download Set,offer several methods above:
 *
 * ## getFileExt            : Get a file's extension name,like: .zip, .jpg
 * ## upload                : upload a file
 * ## uploads               : upload a set of file
 * ## download_location     : download file
 * ## download_header_pro   : ..
 * ## download_header_mid   : ..
 * ## download_header_smp   : ..
 *
 * In the php.ini , you must have some config above:
 * * file_uploads = On ;
 * * upload_max_filesize = 500M ;
 * * post_max_size = 500M ;        post limit
 * * max_execution_time = 1800 ;   Maximum execution time of each script, in seconds
 * * max_input_time = 1800 ;       Maximum amount of time each script may spend parsing request data
 * * memory_limit = 128M ;         Maximum amount of memory a script may consume (128MB)
 *
 * @package    keyCommon
 * @email      Adele513900383@gmail.com
 *
 * Version     : 1.2
 * DateTime    : 2015/9/01-21:00
 * Modified    : 2016/3/20-14:47
 *
 */
class UpDownFile
{
    /**
     * 如果上传失败，则判断失败的原因，返回专业的错误信息     *
     * $error 上传失败的序号
     */
    private function checkProErrorMsg($error) {
        $uploadError = array(
            '0' => '文件上传成功！',
            '1' => '文件超过php.ini允许的大小。',
            '2' => '文件超过表单允许的大小。',
            '3' => '文件只有部分被上传。',
            '4' => '没有文件被上传，请选择文件。',
            '6' => '找不到服务器临时目录。',
            '7' => '写文件到硬盘出错。',
            '8' => 'File upload stopped by extension。',
            '999' => 'Unknown Error'
        );
        return $uploadError[$error];
    }

    /**
     * 如果上传失败，返回普通错误
     */
    private function checkErrorMsg($error) {
        switch ($error) {
            case 1:
            case 2:
            case 3:
                $msg = '文件超过服务器限制大小，请重新选择';
                break;
            case 4:
                $msg = '没有文件被上传，请重新选择';
                break;
            case 6:
            case 7:
            case 8:
            case 999:
                $msg = '服务器错误，请重新选择';
                break;
            default:
                break;
        }
        return $msg;
    }

    /**
     * 检查该存放路径是否合法
     * $path 路径，一般为绝对路径
     */
    private function checkDir($path) {
        //检查是否存在路径
        if (@is_dir($path) === false) {
            mkdir($path, 0777, true);//true代表可创建多级目录;
            chmod($path, 0777);

            return "上传目录不存在，程序已试图创建";
        }
        //检查目录写权限
        if (@is_writable($path) === false) {
            chmod($path, 0777);

            return "上传目录没有写权限，程序已试图获取权限";
        }
        return '';
    }

    /**
     * 获取一个带后缀的文件名的后缀
     * $name,一个带后缀的文件名，例如：image.jpg
     */
    public function getFileExt($name) {
        //获得文件扩展名
        $temp_arr = explode(".", $name);
        $file_ext = end($temp_arr);
        $file_ext = strtolower($file_ext);
        return $file_ext;
//        $file_ext = array_pop($temp_arr);
//        $file_ext = trim($file_ext);
//        $file_ext = pathinfo($name,PATHINFO_EXTENSION),
    }

    /**
     * 检查上传的文件格式是否合法
     * $fileName     完整的文件名，如 image.jpg
     * $kind         需要检测的文件格式:all/image/img/flash/media/file，或者也可以是一个array('kind1','kind2);
     */
    private function checkAllowFile($fileName, $kind) {
        //定义允许上传的文件扩展名
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'img' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        //获得文件扩展名
        $file_ext = $this->getFileExt($fileName);

        if (is_array($kind)) {
            if (in_array($file_ext, $kind) === false) {
                return ("上传文件类型错误。\n只允许" . implode(",", $kind) . "格式。");
            }
        } else if ($kind == 'all' || !is_array($ext_arr[$kind])) {
            return false;
        } else if (in_array($file_ext, $ext_arr[$kind]) === false) {
            return ("上传文件类型错误。\n只允许" . implode(",", $ext_arr[$kind]) . "格式。");
        }
        return false;
    }

    /**
     * 输出信息，主要以数组的形式
     * $flag 成功标志，0 为false, 1 为true
     * $msg 成功或失败的信息
     * $newName 专为上传图片设置，当上传的图片被系统重命一个随机名，则返回该随机名
     */
    private function printMsg($flag, $msg = '', $proMsg = '', $newName = '') {
        $result = array(
            'success' => $flag,
            'msg' => $msg,
            'proMsg' => $proMsg,
            'newName' => $newName
        );
        return $result;
    }

    /**
     * $name      上传文件的表单Name属性
     * $savePath  上传文件存放目录
     * $fileKind  上传文件的文件类型：all/image/media/flash/file/array，默认为 all （为空）
     * $newName   上传后文件的命名，如为空，则随机命名
     * $maxSize   上传文件的大小控制，默认为 10 M
     */
    public function upload($name, $savePath, $fileKind = 'all', $newName = '', $maxSize = '10485760') {
        //文件实体、文件名
        $uploadedFile = $_FILES[$name];
        $uploadedFileName = $uploadedFile['name'];

        //服务器上临时文件名
        $tmpName = $uploadedFile['tmp_name'];
        if (count($_FILES) == 0) {
            $msg = $this->checkErrorMsg(4);
            return $this->printMsg(0, $msg, '上传文件信息均为空');
        }

        // 上传文件是否出错
        if ($uploadedFile['error'] != 0) {
            $msg = $this->checkErrorMsg($uploadedFile['error']);
            $proMsg = $this->checkProErrorMsg($uploadedFile['error']);
            return $this->printMsg(0, $msg, $proMsg);
        }

        // 检测上传文件的大小是否超限制
        if ($maxSize == '' || $maxSize == null) $maxSize = '10485760';
        if ($uploadedFile['size'] > $maxSize) {
            $msg = $this->checkErrorMsg(1);
            return $this->printMsg(0, $msg, '超过代码设定的文件大小');
        }

        // 检测上传文件的类型是否正确
        if ($msg = $this->checkAllowFile($uploadedFileName, $fileKind)) {
            return $this->printMsg(0, $msg);
        }

        // 检测是否为 HTTP POST 上传的
        if (!is_uploaded_file($tmpName)) {
            return $this->printMsg(0, '上传失败，请重新上传', 'No with HTTP request');
        }

        // 上传的路径是否有错
        $proMsg = $this->checkDir($savePath);

        //文件重命名
        $n = $this->getFileExt($uploadedFileName);
        if (!$newName) {
//            $newName = date("YmdHis") . '_' . rand(10000, 99999) . "." . $n;
            $newName = md5(uniqid(microtime(true), true)) . '.' . $n;
        } else {
            $newName = $newName . '.' . $n;
        }

        //上传文件，注意，不管上传失败成功，须删除上传的缓冲文件
        $saveFile = $savePath . $newName;
        @ unlink($uploadedFile); // 删除临时文件

        if (!@move_uploaded_file($tmpName, $saveFile)) {
            return $this->printMsg(0, '文件上传失败', $proMsg);
        } else {
            return $this->printMsg(1, '操作成功', $proMsg, $newName);
        }
    }

    /**
     * $name      上传文件的表单Name属性
     * $savePath  上传文件存放目录
     * $fileKind  上传文件的文件类型：all/image/media/flash/file/array，默认为 all （为空）
     * $newName   上传后文件的命名，如为空，则随机命名
     * $maxSize   上传文件的大小控制，默认为 10 M
     */
    public function __uploads($name, $savePath, $fileKind = 'all', $newName = '', $maxSize = '10485760') {
        $files = array();
        foreach ($_FILES as $file) {
            if (is_array($file['name'])) {
                foreach ($file['name'] as $key => $val) {
                    $files[$key]['name'] = $file['name'][$key];
                    $files[$key]['type'] = $file['type'][$key];
                    $files[$key]['tmp_name'] = $file['tmp_name'][$key];
                    $files[$key]['error'] = $file['error'][$key];
                    $files[$key]['size'] = $file['size'][$key];

                    $_FILES[$key] = $files[$key];
                    print_r($this->upload($key, 'uploads/image/', image));
                }
            }
        }
    }

    /**这是一个有硬性规定需要  $name 上传文件 name 属性
     * $name      上传文件的表单Name属性
     * $savePath  上传文件存放目录
     * $fileKind  上传文件的文件类型：all/image/media/flash/file/array，默认为 all （为空）
     * $newName   上传后文件的命名，如为空，则随机命名
     * $maxSize   上传文件的大小控制，默认为 10 M
     */
    public function uploads($name, $savePath, $fileKind = 'all', $newName = '', $maxSize = '10485760') {
        $s_count = 0;
        $f_count = 0;
        $result = array(
            'success'=>1,
            'msg' => '上传成功',
            'proMsg' => ''
        );
        $file = $_FILES[$name];
        if (is_array($file['name'])) {
            foreach ($file['name'] as $key => $val) {
                $files[$key]['name'] = $file['name'][$key];
                $files[$key]['type'] = $file['type'][$key];
                $files[$key]['tmp_name'] = $file['tmp_name'][$key];
                $files[$key]['error'] = $file['error'][$key];
                $files[$key]['size'] = $file['size'][$key];

                $_FILES[$key] = $files[$key];

                $ary = $this->upload($key, $savePath, $fileKind);

                if($ary['success']){
                    $s_count++;
                }else{
                    $f_count++;
                    $result['proMsg'] .= $ary['msg'].'-'.$ary['proMsg'];
                }
            }
        }
        if($f_count > 0){
            $result['msg'] = '上传部分文件成功，不成功文件数量 ：'.$f_count;
        }
        return $result;
    }


    /**
     * Redirect 重定向文件下载
     * @param $file     下载的文件路径
     * @return bool
     */
    public function download_location($file) {
        if (file_exists($file)) {
            Header("Location:" . $file);
            return true;
        } else {
            return false;
        }
    }

    /**
     * header 函数下载
     * @param $filePath     下载文件路径
     * @return bool
     */
    public function download_header_pro($filePath) {
        if (file_exists($filePath)) {
            $file = fopen($filePath, "r");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header('Content-Disposition:inline;filename="' . basename($filePath) . '"');
            header("Content-Transfer-Encoding: binary");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: no-cache");
//            $file->save('php://output');
            fclose($file);
            return true;
        } else {
            return false;
        }
    }

    /**
     * header 函数下载
     * @param $file下载文件路径
     */
    public function downLoad_header_mid($file) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . basename($file)); //文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header("Content-Length: " . filesize($file)); //告诉浏览器，文件大小
        @ readfile($file);
    }

    /**
     * header 函数下载
     * @param $file下载文件路径
     */
    public function downLoad_header_smp($file) {
        if(file_exists($file)){
            header('content-disposition:attachment;filename=' . basename($file));
            header('content-length:' . filesize($file));
            readfile($file);
        }
    }
}
?>

