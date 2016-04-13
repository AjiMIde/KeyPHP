<?php
include_once "../keyCommon/Document.class.php";

$instance = new Document();

$dir = "../resources/uploads/";

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

if ($action == 'createZip') {
    print_r("========<b>Create zip</b>==========<br/>");
    $result = $instance->createZip("$dir/aji.zip", "$dir");
    var_dump($result);


} elseif ($action == 'del') {
    print_r("========<b>Del Dir</b>==========");
    $result = $instance->delDir($dir);
    var_dump($result);


} elseif ($action == 'copy') {
    print_r("========<b>Recurse copy</b>==========");
    $result = $instance->recurse_copy($dir, $dir . 'copy/');
    var_dump($result);


} else {
    print_r("========<b>Get Sub Files Name And Deep </b>==========");
    $result = $instance->getSubFiles($dir, 'img', 'name', SORT_ASC, true);
    var_dump($result);

    print_r("========<b>Get Sub Files Name SORT_DESC</b>==========");
    $result = $instance->getSubFiles($dir, 'img', 'name', SORT_DESC);
    var_dump($result);

    print_r("========<b>Get sub Files Name</b>==========");
    $result = $instance->getSubDirs($dir);
    var_dump($result);
}









