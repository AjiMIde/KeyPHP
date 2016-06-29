<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/29-10:37
 * Modified    : 2016/4/29-10:37
 * Description :
 */
include_once '../keyCommon/style.php';

udmd('描述了 string 的一些基本操作，如义、使用、删除、增加、合并、获取等。。');

$str = "Hello World !";
print_r("<p>" . $str . "</p>");

print_r("<h3>计算字符串长度：</h3>");
print_r("<p>" . strlen($str) . "</p>");


print_r("<h3>使用 substr_replace(str,replacement,start[可正可负，但不大于strlen(str)],length) 替换字符串：</h3>");
print_r("<i><p>str_ireplace() 效果一样，只不过此函数不区分大小写</p></i>");
print_r("<p>" . substr_replace($str, "PHP", 6, 5) . "</p>");


print_r("<h3>使用str_replace(str1,str2,string)，替换字符串</h3>");
print_r("<p>" . str_replace("World", "Mysql", $str) . "</p>");


print_r("<h3>使用substr(string,start,length[默认是字符串结尾]) 截取字符串</h3>");
print_r("<p>" . substr($str, 6) . "</p>");


print_r("<h3>使用strtr(string,[from(str),to(str)])，strtr(string,[array( str => str)函数替换字符串中特定的字符</h3>");
print_r("<p>针对单个字符进行替换：" . strtr($str, 'World', 'China') . "</p>");
print_r("<p>针对整个数组：" . strtr($str, array("World" => "China")) . "</p>");


print_r("<h3>strstr(str,search[str|ASCII]) 搜索一个字符串在另一个字符串中的第一次出现， 并返回该匹配到的字符串及剩下的所有字符，如匹配不到，则返回 false</h3>");
print_r("<i><p>stristr(string,search)，效果一样，只不过此函数不区分大小写</p></i>");
print_r("<p>使用字符串" . strstr("Hello world!", "wor") . "</p>");
print_r("<p>使用ACSII" . strstr("Hello world!", 111) . "</p>");


print_r("<h3>使用strpos(string,find,start[可选]) 查找字符串在另一个字符串中最后一次出现的位置。 </h3>");
print_r("<i><p>strripos(string,find,start[可选])，效果一样，只不过此函数不区分大小写</p></i>");
print_r("<p>" . strpos("Hello world", "world") . "</p>");


print_r("<h3>strrchr(string,char[str|ASCII]) 查找字符串在另一个字符串中最后一次出现的位置，并返回从该位置到字符串结尾的所有字符。</h3>");
print_r("<p><i>与 strstr不同的是，此函数二进制安全</p></i>");
print_r("<p>" . strrchr("Hello world!", "world") . "</p>");
print_r("<p>" . strrchr("Hello world!", 111) . "</p>");


print_r("<h3>strpbrk(str,search) 函数在字符串中搜索指定字符中的任意一个,并返回所匹配到的字符及剩余字符：</h3>");
print_r("<p>" . strpbrk("Hello world!", "oe") . "</p>");


print_r("<h3>str_split(string,length[可选]) 函数把字符串分割到数组中。</h3>");
var_dump(str_split($str));


print_r("<h3>explode(separator,string,limit[可选，规定返回的数组元素的最大数目]) 把字符串按特定的字符分割到数组中</h3>");
var_dump(explode(" ", $str));


print_r("<h3>string strval(mixed var),把一个变量（或其他类型的如int/float/boolean/）变成 string 型</h3>");
$int = 19910626;
$int_str = strval($int);
var_dump($int);
var_dump($int_str);


print_r("<h3>strcmp(string1, string2) 函数比较两个字符串。注意，此函数对大小写敏感</h3>");
$str1 = 'ab';
$str2 = 'AB';
var_dump(strcmp($str1, $str2));


print_r("<h3>trim/rtrim/ltrim(string) php 去掉字符的空格：去掉首尾空格、去掉首空格、去掉尾空格</h3>");
print_r(trim($str));


print_r("<h3><i>preg_match(pattern(string),subject(string), [, &matches(array) [, flags(int|0) [, offset(int|0)]]])字符串的正则表达式查找</i></h3>");
$i = preg_match("/Hello/i", $str, $matches);
print_r("<p>" . $i . "</p>");
var_dump($matches);


print_r("<h3><i>preg_replace(pattern(mixed), replacement(mixed), subject(mixed) [, limit(int|-1) [, &count(int)]] )</i></h3>");
print_r("<i><p>limit默认为-1，表示无限替换，可自定义替换次数count则会返回替换的次数</p></i>");
$repStr = preg_replace("/Hello/i", "NiHao", $str);
print_r("<p>".$repStr."</p>");


print_r("<h3>iconv(code1（原来的编码）,code2（转换后的编码）,str) string 编码转换，常用在如读取windows文件时的操作，编码常见有：GBK|GB2312|latin1|UTF-8</h3>");
var_dump($str);
