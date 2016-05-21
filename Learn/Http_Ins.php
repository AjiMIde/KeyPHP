<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/19-9:18
 * Modified    : 2016/4/19-9:18
 * Description : 实现使用 Curl,stream,socket,curl upload file 等方式构建 Http post/get 请求获取远程数据
 */

$ary = array(
    'name' => 'aji',
    'sex' => 'man',
    'age' => 27
);

$post = "";
foreach ($ary as $key => $value) {
    $post .= "$key=$value&";
}
$post = substr($post, 0, strlen($post) - 1);

$server = "http://" . $_SERVER['HTTP_HOST'] . "/KeyPHP/Learn/Http_Ins.php?action=accept";


$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

if ($action == "accept") {

    var_dump($_REQUEST);

    var_dump($_FILES);

} else {
    request_by_curl($server, $post);

    request_by_streamContext($server, $post);

    request_by_socket($_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'], "KeyPHP/Learn/Http_Ins.php?action=accept", $post);

    request_upload_by_curl($server, "E:/BaiduYB/EclipseWorkSapce/KeyPHP/resources/uploads/a.jpg");
}


/**
 * Curl 发送 Http 请求
 *
 * @param string $remote_server 远程服务器地址
 * @param string $post_string 需要附加的参数
 */
function request_by_curl($remote_server, $post_string) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Aji's CURL Example beta");

    //执行 curl 对象，发送请求
    $data = curl_exec($ch);

    curl_close($ch);
    print_r($data);
}


/**
 * stream context 发送请求
 *
 * @param string $remote_server 远程服务器地址
 * @param string $post_string 需要附加的参数
 */
function request_by_streamContext($remote_server, $post_string) {
    $context = array(//构建post参数
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded' .
                '\r\n' . 'User-Agent : Jimmy\'s POST Example beta' .
                '\r\n' . 'Content-length:' . strlen($post_string) + 8,
            'content' => $post_string
        )
    );
    $stream_context = stream_context_create($context);//根据需要 post 的参数，构造 stream 上下文
    $data = file_get_contents($remote_server, false, $stream_context);//发送请求，并获取数据
    print_r($data);
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
function request_by_socket($host, $port, $host_path, $post_str, $timeout = 60) {
    if ($port == "") {
        $port = "-1";
    }
    $host_path = "/" . $host_path;
    $content_length = strlen($post_str);

    //创建socket连接
    $fp = fsockopen($host, $port, $errNo, $errStr, $timeout) or exit ($errStr . "=>" . $errNo);
    //构造post请求的头
    $header = "POST " . $host_path . " HTTP/1.1\r\n";
    $header .= "Host:" . $host . "\r\n";
    $header .= "Referer:$host_path\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . $content_length . "\r\n";
    $header .= "Connection: Close\r\n\r\n";
    //添加post的字符串
    $header .= $post_str . "\r\n";

    //发送post的数据
    fputs($fp, $header);
    while (!feof($fp)) {
        $line = fgets($fp, 1024); //去除请求包的头只显示页面的返回数据
        print_r($line);
    }
    print_r(file_get_contents($fp));

    fclose($fp);
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
 * Curl 发送 Http 请求
 * **这个认证是一个升级版（还没有经过测试），该认证可识别 https/http 等协议去发送 http 请求
 *
 * @param string $remote_server 远程服务器地址
 * @param string $post_string 需要附加的参数
 * @param int $timeout 超时时间，默认 30s
 * @param string $CA_cert 证书，证书链接，通常为"***\ca_cert.pem""
 */
function http_curl($remote_server, $post_string, $timeout = 30, $CA_cert = "") {
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
        print_r(curl_error($ch));
    } else {
        print_r($data);
    }
    curl_close($ch);
}
