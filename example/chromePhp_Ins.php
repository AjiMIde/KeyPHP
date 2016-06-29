<?php
/**
 * User        : Aij
 * DateTime    : 2016/06/29-13:34
 * Modified    : 2016/06/29-14:34
 * Description :
 */

include_once "../Library/ChromePhp/ChromePhp.php";
include_once '../keyCommon/style.php';


udmd('Chrome PHP 是借用 chrome 插件来调试 PHP 的一个插件，主要支持如 chrome 中常见的:warn,error,log,group,table 等。支持输出 PHP 变量与数组等。
<br>项目地址：<a>https://craig.is/writing/chrome-logger</a>
<br>Github: <a>https://github.com/ccampbell/chromephp/blob/master/README.md</a>');

h3('打开“开发者工具即可看到相关的效果');

$v1 = "i am v1:string";
ChromePhp::log($v1);


$v2 = array('php','java','python');
ChromePhp::error($v2);


ChromePhp::group('I am Group:');
ChromePhp::warn('php');
ChromePhp::warn('java');
ChromePhp::warn('python');
ChromePhp::groupEnd();
