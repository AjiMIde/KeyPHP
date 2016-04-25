<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/25-8:56
 * Modified    : 2016/4/25-8:56
 * Description :
 *
 * ## 输出一切与 服务器 和客户端有用的信息，包括 *服务器IP*、*当前脚本名称*、*服务器主机名*、*通信协议*、*请求方法*、*当前端口*等等。
 *
 */
function get() {
    print_r("<h3>当前服务器脚本</h3>");
    print_r($_SERVER['PHP_SELF'] . '<br>'); #当前正在执行脚本的文件名，与 document root相关。

    print_r("<h3>获取当前传递脚本的参数（需要运行在 cli 命令行）</h3>");
    print_r($_SERVER['argv'][0] . '<br>'); #传递给该脚本的参数。

    print_r("<h3>获取当前传递脚本的参数个数（需要运行在 cli 命令行）</h3>");
    print_r($_SERVER['argc'] . '<br>'); #包含传递给程序的命令行参数的个数（如果运行在命令行模式）。

    print_r("<h3> CGI规范的版本 </h3>");
    print_r($_SERVER['GATEWAY_INTERFACE'] . '<br>'); #服务器使用的 CGI 规范的版本。例如，“CGI/1.1”。

    print_r("<h3>当前主机名</h3>");
    print_r($_SERVER['SERVER_NAME'] . '<br>'); #当前运行脚本所在服务器主机的名称。

    print_r("<h3>当前服务器标识字串</h3>");
    print_r($_SERVER['SERVER_SOFTWARE'] . '<br>'); #服务器标识的字串，在响应请求时的头部中给出。

    print_r("<h3>当前通信协议和版本</h3>");
    print_r($_SERVER['SERVER_PROTOCOL'] . '<br>'); #请求页面时通信协议的名称和版本。例如，“HTTP/1.0”。

    print_r("<h3>访问页面时的请求方法</h3>");
    print_r($_SERVER['REQUEST_METHOD'] . '<br>'); #访问页面时的请求方法。例如：“GET”、“HEAD”，“POST”，“PUT”。

    print_r("<h3>查询(query)的字符串</h3>");
    print_r($_SERVER['QUERY_STRING'] . '<br>'); #查询(query)的字符串。

    print_r("<h3>当前运行脚本所在的文档根目录</h3>");
    print_r($_SERVER['DOCUMENT_ROOT'] . '<br>'); #当前运行脚本所在的文档根目录。在服务器配置文件中定义。

    print_r("<h3>当前请求的 Accept: 头部的内容</h3>");
    print_r($_SERVER['HTTP_ACCEPT'] . '<br>'); #当前请求的 Accept: 头部的内容。

    print_r("<h3>当前请求的 Accept-Charset: 头部的内容</h3>");
    print_r($_SERVER['HTTP_ACCEPT_CHARSET'] . '<br>'); #当前请求的 Accept-Charset: 头部的内容。例如：“iso-8859-1,*,utf-8”。

    print_r("<h3>当前请求的 Accept-Encoding</h3>");
    print_r($_SERVER['HTTP_ACCEPT_ENCODING'] . '<br>'); #当前请求的 Accept-Encoding: 头部的内容。例如：“gzip”。

    print_r("<h3>前请求的 Accept-Language</h3>");
    print_r($_SERVER['HTTP_ACCEPT_LANGUAGE'] . '<br>');#当前请求的 Accept-Language: 头部的内容。例如：“en”。

    print_r("<h3>当前请求的 Connection: 头部的内容</h3>");
    print_r($_SERVER['HTTP_CONNECTION'] . '<br>'); #当前请求的 Connection: 头部的内容。例如：“Keep-Alive”。

    print_r("<h3>当前请求的 Host</h3>");
    print_r($_SERVER['HTTP_HOST'] . '<br>'); #当前请求的 Host: 头部的内容。

    print_r("<h3>链接到当前页面的前一页面的 URL 地址</h3>");
    print_r($_SERVER['HTTP_REFERER'] . '<br>'); #链接到当前页面的前一页面的 URL 地址。

    print_r("<h3>当前请求的 User_Agent: 头部的内容</h3>");
    print_r($_SERVER['HTTP_USER_AGENT'] . '<br>'); #当前请求的 User_Agent: 头部的内容。

    print_r("<h3>如果通过https访问,则被设为一个非空的值(on)，否则返回off</h3>");
    print_r($_SERVER['HTTPS'] . '<br>'); # 如果通过https访问,则被设为一个非空的值(on)，否则返回off

    print_r("<h3>正在浏览当前页面用户的 IP 地址</h3>");
    print_r($_SERVER['REMOTE_ADDR'] . '<br>'); #正在浏览当前页面用户的 IP 地址。

    print_r("<h3>正在浏览当前页面用户的主机名</h3>");
    print_r($_SERVER['REMOTE_HOST'] . '<br>'); #。

    print_r("<h3>用户连接到服务器时所使用的端口</h3>");
    print_r($_SERVER['REMOTE_PORT'] . '<br>'); #用户连接到服务器时所使用的端口。

    print_r("<h3>当前执行脚本的绝对路径名</h3>");
    print_r($_SERVER['SCRIPT_FILENAME'] . '<br>'); #当前执行脚本的绝对路径名。

    print_r("<h3>管理员信息/h3>");
    print_r($_SERVER['SERVER_ADMIN'] . '<br>'); #管理员信息

    print_r("<h3>服务器所使用的端口</h3>");
    print_r($_SERVER['SERVER_PORT'] . '<br>'); #服务器所使用的端口

    print_r("<h3>服务器版本和虚拟主机名的字符串</h3>");
    print_r($_SERVER['SERVER_SIGNATURE'] . '<br>'); #包含服务器版本和虚拟主机名的字符串。

    print_r("<h3>当前脚本所在文件系统</h3>");
    print_r($_SERVER['PATH_TRANSLATED'] . '<br>'); #当前脚本所在文件系统（不是文档根目录）的基本路径。

    print_r("<h3>当前脚本的路径</h3>");
    print_r($_SERVER['SCRIPT_NAME'] . '<br>'); #包含当前脚本的路径。这在页面需要指向自己时非常有用。

    print_r("<h3>当前的 URI，即除出 http://1.1.1.1:801 以外的东西</h3>");
    print_r($_SERVER['REQUEST_URI'] . '<br>'); #访问此页面所需的 URI。例如，“/index.html”。

    print_r("<h3>用户输入的用户名（需运行在 Apache 模块方式下</h3>");
    print_r($_SERVER['PHP_AUTH_USER'] . '<br>'); #当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是用户输入的用户名。

    print_r("<h3>用户输入的密码（需运行在 Apache 模块方式下</h3>");
    print_r($_SERVER['PHP_AUTH_PW'] . '<br>'); #当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是用户输入的密码。

    print_r("<h3>用户使用的 Http 认证类型（需运行在 Apache 模块方式下</h3>");
    print_r($_SERVER['AUTH_TYPE'] . '<br>'); #当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是认证的类型。

    print_r("<h3>服务器地址</h3>");
    print_r($_SERVER['SERVER_ADDR'] . '<br>'); #当前服务器地址

    print_r("<h3 style='color:red'>除此之外，任何时候你都可以通过 <u>var_dump($_SERVER)</u>或<u>php_info()</u>来查看 $_SERVER 都有些什么参数及内容提供</h3>");
}

get();

?>

<html>
    <title>Array Instance</title>
    <head>
        <style>
            body{font-family: "Meiryo UI","Helvetica Neue",Helvetica,Arial, "Hiragino Sans GB","Hiragino Sans GB W3", "Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei", sans-serif, \5FAE\8F6F\96C5\9ED1,\9ED1\4F53,\5b8b\4f53 !important}
            h3{30px 0 1px 0}
        </style>
    </head>
</html>
