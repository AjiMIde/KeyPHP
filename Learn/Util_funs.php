<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/18-10:03
 * Modified    : 2016/4/18-10:03
 * Description : 介绍几种常用的函数
 */

/**
 * # 传入参数的数量
 * # 传入参数的值（数组）
 * # 输入指定位置的参数
 */
include_once "../keyCommon/style.php";

function get() {
    print_r("<h4>Get the sum of params you pass with 'func_num_args': </h4>");
    print_r(func_num_args());


    print_r("<h4>The params you pass with 'func_get_args': </h4>");
    var_dump(func_get_args());

    print_r("<h4>The 3rd param is (with 'func_get_arg'): </h4>");
    print_r(func_get_arg(3));
}

get(1, 2, '3', true);


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
