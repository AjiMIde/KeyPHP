<?php
include_once "../keyCommon/Document.class.php";
include_once '../keyCommon/style.php';

$instance = new Document();

$dir = "../resources/uploads/";

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

print_r("<h3>使用 getcwd()/dirname()/basename()/ 获取相关路径：</h3>");
print_r("<p>".getcwd()."</p>");
print_r("<p>".dirname(__FILE__)."</p>");
print_r("<p>".basename(dirname(dirname(__FILE__)))."</p>");



if ($action == 'createZip') {
    print_r("<h4>Create zip</h4>");
    $result = $instance->createZip("$dir/aji.zip", "$dir");
    var_dump($result);


} elseif ($action == 'del') {
    print_r("<h4>Del Dir</h4>");
    $result = $instance->delDir($dir);
    var_dump($result);


} elseif ($action == 'copy') {
    print_r("<h4>Recurse copy</h4>");
    $result = $instance->recurse_copy($dir, $dir . 'copy/');
    var_dump($result);


} else {
    print_r("<h4>Get Sub Files Name And Deep </h4>");
    $result = $instance->getSubFiles($dir, 'img', 'name', SORT_ASC, true);
    var_dump($result);

    print_r("<h4>Get Sub Files Name SORT_DESC</h4>");
    $result = $instance->getSubFiles($dir, 'img', 'name', SORT_DESC);
    var_dump($result);

    print_r("<h4>Get sub Files Name</h4>");
    $result = $instance->getSubDirs($dir);
    var_dump($result);
}









