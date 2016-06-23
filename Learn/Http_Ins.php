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
    request_by_streamContext($server, $post);

    request_by_socket($_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'], "KeyPHP/Learn/Http_Ins.php?action=accept", $post);

    request_upload_by_curl($server, "E:/BaiduYB/EclipseWorkSapce/KeyPHP/resources/uploads/a.jpg");
}







