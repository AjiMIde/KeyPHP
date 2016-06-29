<?php

/**
 * Copyright 2016-2020 Aji
 * That's a Http/Https Operation Set,offer several methods above:
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
 * DateTime    : 2016/03/05
 * Modified    : 2016/06/16
 */
class HttpR
{
    /**
     * @var string
     */
    const VERSION = "1.0";

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
    const USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36";

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
     * Check the directory is valid
     *
     * @param  string $dir
     * @return bool|string  true/error msg
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
     * Private method: make an array to string like: key=value&key=value
     * @param $array
     * @return string
     */
    private function _post_string_to_array($array){
        $string = "";
        foreach ($array as $key => $value) {
            $string .= "$key=$value&";
        }
        $string = substr($string, 0, strlen($string) - 1);

        return $string;
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
     * Use Curl to send Http Request(post)
     *
     * @param string $remote_server
     * @param array $post_array
     * @param int $timeout
     * @return string
     */
    function http_curl($remote_server, $post_array, $timeout = 20) {

        $post_string = self::_post_string_to_array($post_array);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST,count($post_array)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded。
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //执行 curl 对象，发送请求
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Use Curl to send http Request(get)
     *
     * @param string $remote_server
     * @param int $timeout
     */
    function http_curl_get($remote_server, $timeout = 20){
        $ch = curl_init($remote_server) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        return curl_exec($ch) ;
    }

    /**
     * Use Curl to set cookie
     * 
     * @param string $remote_server
     * @param string $cookie
     * @return bool 
     */
    function http_curl_cookie($remote_server,$cookie){
        $header[]= 'Accept: image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, text/html, * '. '/* ';
        $header[]= 'Accept-Language: zh-cn ';
        $header[]= self::USER_AGENT;
        $header[]= 'Host: '.$remote_server;
        $header[]= 'Connection: Keep-Alive ';
        $header[]= 'Cookie: '.$cookie;

        return curl_setopt($curlHandel,CURLOPT_HTTPHEADER,$header);  
    }





    /**
     * Use stream context to send Http Request(post)
     *
     * @param string $remote_server
     * @param array $post_array
     * @param int $timeout
     * @return string
     */
    function http_streamContext($remote_server, $post_array, $timeout = 20) {

        $post_string = self::_post_string_to_array($post_array);

        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded' .
                    '\r\n' . 'User-Agent : ' . self::USER_AGENT .
                    '\r\n' . 'Content-length:' . strlen($post_string) + 8,
                'content' => $post_string
            )
        );
        $stream_context = stream_context_create($context);
        $data = file_get_contents($remote_server, false, $stream_context);

        return $data;
    }

    /**
     * socket 模拟 post数据
     *
     * @param string $host eg: www.v.com | 1.1.1.1
     * @param string $port eg: 8082 | ""
     * @param string $host_path eg: KeyPHP/index.php?action=do
     * @param string $post_str eg: value1=1&value2=2
     * @param int $timeout eg: 60
     */
    function http_socket($remote_server, $port, $host_path, $post_array, $timeout = 20){
        $post_string = self::_post_string_to_array($post_array);

        if ($port == "") {
            $port = "-1";
        }
        $host_path = "/" . $host_path;
        $content_length = strlen($post_string);

        //创建socket连接
        $fp = fsockopen($remote_server, $port, $errNo, $errStr, $timeout) or exit ($errStr . "=>" . $errNo);
        //构造post请求的头
        $header = "POST " . $host_path . " HTTP/1.1\r\n";
        $header .= "Host:" . $remote_server . "\r\n";
        $header .= "Referer:$host_path\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . $content_length . "\r\n";
        $header .= "Connection: Close\r\n\r\n";
        //添加post的字符串
        $header .= $post_string . "\r\n";

        //发送post的数据
        fputs($fp, $header);
        while (!feof($fp)) {
            $line = fgets($fp, 1024); //去除请求包的头只显示页面的返回数据
            print_r($line);
        }
        return(file_get_contents($fp));

        fclose($fp);
    }

    /**
     * Curl 发送 Http 请求
     * **这个认证是一个升级版（还没有经过测试），该认证可识别 https/http 等协议去发送 http 请求
     *
     * @param string $remote_server 远程服务器地址
     * @param string $post_string 需要附加的参数
     * @param int $timeout 超时时间，默认 30s
     * @param string $CA_cert 证书，证书链接，通常为"***\ca_cert.pem""
     */
    function http_curl2($remote_server, $post_string, $timeout = 30, $CA_cert = "") {
        $SSL = substr($remote_server, 0, 8) == "https://" ? true : false;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $remote_server);

        //当需要进行一些 SSL 证书认证时，根据条件的多少执行不同的认证级别
        if ($SSL && $CA_cert) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
            curl_setopt($ch, CURLOPT_CAINFO, $CA_cert);       // CA根证书（用来验证的网站证书是否是CA颁布）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);      // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        } else if ($SSL && !$CA_cert) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);      // 检查证书中是否设置域名
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);      // 检查证书中是否设置域名
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                   //获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_USERAGENT, "From eky CURL Example beta");//在HTTP请求中包含一个”user-agent”头的字符串
        curl_setopt($ch, CURLOPT_POST, true);                             //设置为 post
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));           //解决 post 数据过长的问题

        //执行 curl 对象，发送请求
        $data = curl_exec($ch);

        //查看报错信息
        if (curl_error($ch)) {
            curl_close($ch);
            return curl_error($ch);
        } else {
            curl_close($ch);
            return $data;
        }
    }


    /**
     * 使用 file_get_contents 在 https 协议下正常使用
     *
     * 1，第一种情况只用在 密钥协议 或 链接证书 没有通过认证，一般会用在该 https url 是我们生成的或临时创建出来的给用户使用
     *
     * 2，第二种情况可用在该 证书 已经被下载到服务器上。
     *
     * 详情参考 [php.net](http://php.net/manual/en/migration56.openssl.php)
     */
    function https_file_get_contents() {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $arrContextOptions_need = array(
            "ssl" => array(
                "cafile" => "/path/to/bundle/ca-bundle.crt",
                "verify_peer" => true,
                "verify_peer_name" => true,
            ),
        );

        $response = file_get_contents("https://baidu.com", false, stream_context_create($arrContextOptions));
        echo $response;
    }

    /**
     *
     * @param string $remote_server 远程服务器地址
     * @param string $file 需要附加的文件路径
     */
    function request_upload_by_curl($remote_server, $file) {
        $post_data = array(
            'name' => 'aji',
            'file' => '@' . $file
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        //启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        $info = curl_exec($ch);
        curl_close($ch);

        print_r($info);
    }
}
