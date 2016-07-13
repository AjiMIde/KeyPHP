<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/26
 * Modified    : 2016/4/26
 * Description : 描述了时间 Date 的一些基本操作，如获取、计算、格式
 */

include_once '../keyCommon/style.php';

udmd('描述了时间 Date 的一些基本操作，如获取、计算、格式');


h4("输出各种格式的 dateTime ");
p(date('Y/m/d'));
p(date("Y.m.d"));
p(date("Y-m-d"));


h4("使用 时间戳：timestamp ，是在当前的时间上再加上一些日子？用法如下：mktime(hour,minute,second,month,day,year,is_dst)");
$timeStamp = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
p("Tomorrow is:" . date("Y/m/d", $timeStamp));


$timeStamp = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
print_r("<p>Yesterday is:" . date("Y/m/d", $timeStamp));


h4("利用时间戳指定一个特定日子并生成时间对象，如下：");
p(date("Y-m-d", strtotime('2015-04-26')));
p(date("Y-m-d", strtotime('15-04-26')));
p(date("Y-m-d", strtotime('April 26 2015')));


h4("利用时间戳指定一个特定日子并进行计算，如下：");
p(date("Y-m-d", strtotime('2015-04-26') + (60 * 60 * 24)));
p(date("Y-m-d", strtotime('15-04-26 13:00:00 +1 day')));


h4("时间戳可以传入任意参数，如下：");
p(date("Y-m-d", strtotime("now")));
p(date("Y-m-d", strtotime("3 October 2005")));
p(date("Y-m-d", strtotime("+5 hours")));
p(date("Y-m-d", strtotime("+1 week")));
p(date("Y-m-d", strtotime("+1 week 3 days 7 hours 5 seconds")));
p(date("Y-m-d", strtotime("next Monday")));
p(date("Y-m-d", strtotime("last Sunday")));


h4("strtotime() 函数将任何英文文本的日期时间描述解析为 Unix 时间。（自 January 1 1970 00:00:00 GMT 起的秒数）");
p("今天的Unix时间戳-秒：" . strtotime(date("Y-m-d")));
p("今天的Unix时间戳-年：" . (strtotime(date("Y-m-d")) / 60 / 60 / 24 / 365));


h4("利用 strtotime() 函数计算两天的间隔：与去年2015-04-26 的天数间隔");
p(round(abs(strtotime(date("Y-m-d")) - strtotime("2015-04-26")) / 60 / 60 / 24, 0));


?>

<html>
<title>Array Instance</title>
<head>
    <style>
        body {
            font-family: "Meiryo UI", "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "Microsoft YaHei UI", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif, \5FAE\8F6F\96C5\9ED1, \9ED1\4F53, \5b8b\4f53 !important
        }

        h3 {
            30px 0 1px 0
        }

    </style>
</head>
</html>
