<?php
/**
 * User        : Aij
 * DateTime    : 2016/5/05-10:35
 * Modified    : 2016/5/05-11:05
 * Description : 描述了变量的定义、修改、判断、置空、转换类型、判断类型等。
 */

include_once '../keyCommon/style.php' ;

udmd('描述了变量的定义、修改、判断、置空、转换类型、判断类型等');

print_r("<h3>定义：PHP 与 Ruby、JavaScript 一样属于 弱类型的松散型语言，可定义变量为任何类型：</h3>");

$v1 = 5;
$v2 = 6.00;
$v3 = "7";

var_dump($v1);
var_dump($v2);
var_dump($v3);


print_r("<h3>转换变量：可通过一些运算来改变变量类型：</h3>");
$v1 = 0.00 + $v1;
var_dump($v1);

$v2 = "" . $v2;
var_dump($v2);

$v3 = 0 + $v3;
var_dump($v3);


print_r("<h3>转换变量：一般通过强制类型转换改变变量类型：(int)(double)(string)(object)</h3>");
var_dump((int)$v1);
var_dump((double)$v2);
var_dump((string)$v3);


print_r("<h3>转换变量：一般还通过特定的函数改变变量类型：strval()/intval()/doubleval()/floatval()</h3>");
var_dump(doubleval($v1));
var_dump(strval($v2));
var_dump(intval($v3));


print_r("<h3>获取变量的类型： gettype()</h3>");
var_dump(gettype($v1));
var_dump(gettype($v2));
var_dump(gettype($v3));


print_r("<h3>判断变量：通过特定的函数判断变量的类型：is_array/is_float/is_string/is_int</h3>");
var_dump(is_array($v1));
var_dump(is_int($v1));
var_dump(is_double($v1));


print_r("<h3>判断变量是否存在：isset()/empty() ；置空变量:unset() </h3>");
var_dump(isset($v1));

unset($v1);

var_dump(empty($v1));


?>
