<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/26-19:13
 * Modified    : 2016/4/26-19:13
 * Description :
 */

/**
 * echo the info of "user dateTime modified Description"
 * @param string $Description     df: ...
 * @param string $user            df: Aji
 */
function udmd($Description = "...",$user = "Aji"){
    $trace = debug_backtrace();
    $file = $trace[0]['file'];

    $c_time = $file ? date("Y m d H:i",filectime($file)) : '...';
    $m_time = $file ? date("Y m d H:i",filemtime($file)) : '...';

    $string = "<div class='udmd'><div><span>User: </span>" . $user .
        "</div><div><span>DateTime: </span>" . $c_time .
        "</div><div><span>Modified: </span>" . $m_time .
        "</div><div><span>Description: </span>" . $Description ."</div></div>";

    print_r("<script>window.document.title='" . basename($file) ."'</script>");
    print_r($string);

}
function h3($content){
    print_r("<h3>".$content."</h3>");
}
function h4($content){
    print_r("<h4>".$content."</h4>");
}
function h6($content){
    print_r("<h6>".$content."</h6>");
}
function p($content){
    print_r("<p>".$content."</p>");
}
function code($content){
    print_r("<pre><code>$content</code></pre>");
}

function get_caller_info() {
    $c = '';
    $file = '';
    $func = '';
    $class = '';
    $trace = debug_backtrace();
    if (isset($trace[2])) {
        $file = $trace[1]['file'];
        $func = $trace[2]['function'];
        if ((substr($func, 0, 7) == 'include') || (substr($func, 0, 7) == 'require')) {
            $func = '';
        }
    } else if (isset($trace[1])) {
        $file = $trace[1]['file'];
        $func = '';
    }
    if (isset($trace[3]['class'])) {
        $class = $trace[3]['class'];
        $func = $trace[3]['function'];
        $file = $trace[2]['file'];
    } else if (isset($trace[2]['class'])) {
        $class = $trace[2]['class'];
        $func = $trace[2]['function'];
        $file = $trace[1]['file'];
    }
    if ($file != '') $file = basename($file);
    $c = $file . ": ";
    $c .= ($class != '') ? ":" . $class . "->" : "";
    $c .= ($func != '') ? $func . "(): " : "";
    return($c);
}
?>

<html>
<title>Instance</title>
<link rel="stylesheet" href="http://127.0.0.1:8090/highlight/styles/tomorrow.css">
<script type="text/javascript" src="http://127.0.0.1:8090/highlight/highlight.pack.js"></script>
<script type="text/javascript">
    hljs.initHighlightingOnLoad();
</script>
<head>
    <style>
        body {
            font-family: "Meiryo UI", "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "Microsoft YaHei UI", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif, \5FAE\8F6F\96C5\9ED1, \9ED1\4F53, \5b8b\4f53 !important;
            padding:30px 100px;
            color:#545454;
            line-height: 1.4;
        }

        h3 {
            font-weight: 500;
            margin-top: 40px;
            margin-bottom: 10px;
            font-size: 20px;
            color: #000;
            border-bottom: 1px solid #BBBBBB;
            padding: 6px 0;
        }
        h4{
            font-weight: 600;
            line-height: 1.1;
            margin-top: 60px;
            margin-bottom: 10px;
            font-size: 16px;
            color: #000;
            border-radius: 4px;
            padding: 8px;
            background: #EDEDED;
        }
        p{
            padding-left: 30px;
        }
        a{
            color:#83CBFF;
        }
        .udmd span{
            display: inline-block;
            width: 120px;
            color: #003d68;
            font-weight: 600;
        }
        .udmd div{
        }

        pre code{
            font-size: 14px;
            font-family: consolas;
            width: 400px;
            border-radius: 4px;
            border: 1px solid #d0d0d0;
            /*margin-top: 10px;*/
            /*margin-left: 10px;*/
        }

    </style>
</head>
</html>
