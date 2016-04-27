<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/18-10:03
 * Modified    : 2016/4/18-10:03
 * Description : 介绍几种常用的函数
 */
include_once '../keyCommon/style.php';

/**
 * # 传入参数的数量
 * # 传入参数的值（数组）
 * # 输入指定位置的参数
 */
class Class_Get
{
    var $val1 = 1;
    var $val2 = 1;
    function get() {
        print_r('<h3>函数调用信息的基本获取与操作:</h3>');

        print_r("<h4>Get some msg of 'class','function','method'</h4>");

        print_r("<p>Current Class: " . __CLASS__ . "</p>");
        print_r("<p>Current Function: " . __FUNCTION__ . "</p>");
        print_r("<p>Current Method: " . __METHOD__ . "</p>");

        print_r("<h4>以下获取也是同上面一样的获取，不过需要运行在类中：</h4>");

        print_r("<p>Current Class (with get): " . get_class() . "</p>");
        print_r("<p>Current Class' Methods: </p>");
        var_dump(get_class_methods(__CLASS__));

        print_r("<p>Current Class Vars (with get): </p>");
        var_dump(get_class_vars(__CLASS__));


        print_r("<h4>Get the sum of params you pass with 'func_num_args': </h4>");
        print_r(func_num_args());


        print_r("<h4>The params you pass with 'func_get_args': </h4>");
        var_dump(func_get_args());

        print_r("<h4>The 3rd param is (with 'func_get_arg'): </h4>");
        print_r(func_get_arg(3));
    }
}

$Class_Get = new Class_Get();
$Class_Get->get(1, 2, '3', true);


function parse_ini() {
    print_r("<h4>Read the ini file with 'parse_ini_file'</h4>");

    $path = "../resources/uploads/setting.ini";

    var_dump(parse_ini_file($path));
    var_dump(parse_ini_file($path, true));

    $myfile = fopen($path, "r") or die("Unable to open file!");
    // 输出单行直到 end-of-file
    while (!feof($myfile)) {
        $str = fgets($myfile);

        print_r($str . '<br>');
    }
    fclose($myfile);
}

parse_ini();


print_r("<h3>随机函数的使用：</h3>");
function getRand() {
    for ($i = 0; $i < 5; $i++) {
        print_r("<p>" . rand(10, 30) . "</p>");
    }

    for ($i = 0; $i < 5; $i++) {
        print_r("<p>" . mt_rand(1, 5) . "</p>");
    }

    $arr = array("wx", "sms", "rw");
    for ($i = 0; $i < 5; $i++) {
        $j = mt_rand(0, 2);
        print_r("<p>" . $arr[$j] . "</p>");
    }
}

getRand();
