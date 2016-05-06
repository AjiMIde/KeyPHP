<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/26-19:13
 * Modified    : 2016/4/26-19:13
 * Description :
 */
function h3($content){
    print_r("<h3>".$content."</h3>");
}
function h4($content){
    print_r("<h4>".$content."</h4>");
}
function p($content){
    print_r("<p>".$content."</p>");
}
?>
<html>
<title>Instance</title>
<head>
    <style>
        body {
            font-family: "Meiryo UI", "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "Microsoft YaHei UI", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif, \5FAE\8F6F\96C5\9ED1, \9ED1\4F53, \5b8b\4f53 !important;
            padding:30px 100px;
            color:#005DEC;
        }

        h3 {
            font-weight: 500;
            line-height: 1.1;
            margin-top: 60px;
            margin-bottom: 10px;
            font-size: 24px;
            color:#000;
            border: 1px solid #8a8a8a;
            border-radius: 4px;
            padding: 14px;
            background: aliceblue;
        }
        h4{
            font-weight: 500;
            line-height: 1.1;
            margin-top: 60px;
            margin-bottom: 10px;
            font-size: 20px;
            color:#000;
            border-radius: 4px;
            padding: 8px;
            background: #EDEDED;
        }
        p{
            padding-left: 30px;
        }

    </style>
</head>
</html>
