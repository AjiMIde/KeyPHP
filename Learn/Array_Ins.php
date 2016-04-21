<html>
    <title>Array Instance</title>
    <head>
        <style>
            body{font-family: "Meiryo UI","Helvetica Neue",Helvetica,Arial, "Hiragino Sans GB","Hiragino Sans GB W3", "Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei", sans-serif, \5FAE\8F6F\96C5\9ED1,\9ED1\4F53,\5b8b\4f53 !important}
            h3{30px 0 1px 0}

        </style>
    </head>
</html>
<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/21-13:35
 * Modified    : 2016/4/21-13:35
 * Description : 描述了数组的一些基本操作，如定义、使用、删除、增加、合并、获取等。。
 */

/**
 * Common Ary
 */
$aryMobile = array(
    "Apple",
    "XiaoMi",
    "HuaWei"
);

$aryComputer = array(
    "Lenovo",
    "AUSU",
    "Acer"
);

/*
 * Hash关联数组
 */
$aryName1 = array(
    "firstName" => "aji",
    "secondName" => "key"
);

$aryName2 = array(
    "firstName" => "chen",
    "secondName" => "ji"
);

/**
 * 多维数组，这个常用二维，一般三维都很少用了
 */
$aryTech = array(
    "php" => array(
        "smart",
        "speed",
        "mysql"
    ),
    "ext" => array(
        "panel",
        "grid",
        "form"
    )
);

/**
 * 数组大小获取
 */
print_r("<h3>Count of Array1 with 'count()' :</h3>");
print_r(count($aryComputer));


/**
 * 数组遍历
 */
print_r("<h3>遍历 Array with 'foreach' :</h3>");
foreach ($aryMobile as $val) {
    print_r("<p>$val</p>");
}

foreach ($aryName1 as $key => $val) {
    print_r("<p>$key : $val</p>");
}

print_r("<h3>使用 implode 直接分割得到数组的值</h3>");
print_r("<p>".implode('-', $aryTech['php'])."</p>");

print_r("<h3>使用 array_values 和 array_keys 得到数组的值或 key </h3>");
var_dump(array_values($aryName2));
var_dump(array_keys($aryName1));


/**
 * 删除数组的 value
 */
print_r("<h3>Delete the child in Array with 'unset' :</h3>");

$aryMobile[3] = "MeiZu";
var_dump($aryMobile);

unset($aryMobile[2]);
var_dump($aryMobile);


/**
 * 合并数组
 */
print_r("<h3>Merge Array with: array_merge and array_merge_recursive:</h3>");
print_r("<h6>使用 array_merge 过程中，如果有同 key ，则后一个数组的 key 值会覆盖前一个数组的 key 值，而使用 array_merge_recursive ，则会把相同 key 合并成一个子数组</h6>");
$aryMe = array_merge($aryMobile, $aryComputer);
var_dump($aryMe);

$aryMe2 = array_merge_recursive($aryName1,$aryName2);
var_dump($aryMe2);


/**
 * 数组的连接
 * 连接数组 函数会得到一个新数组，它由一组提交的键和对应的值组成
 */
print_r("<h3>Combine Array</h3>");
$aryCo = array_combine($aryMobile, $aryComputer);
var_dump($aryCo);


/**
 * 数组截取，接合，替换
 */
print_r("<h3>数组截取，接合，替换</h3>");
var_dump(array_slice($aryComputer,1,2));
var_dump($aryComputer);

var_dump(array_slice($aryComputer,2,1,0));


/**
 * 数组排序
 */
print_r("<h3>Sort Array</h3>");
    $ary1 = array('D', 'B', 'A', 'C', 'E');
    $ary2 = array('c', 'a', 'b', 'd', 'e');
    array_multisort($ary1, SORT_ASC, SORT_STRING, $ary2);
    var_dump($ary1);
    var_dump($ary2);

    asort($ary1);
    arsort($ary1);

    ksort($ary1);
    krsort($ary1);


/**
 * 数组的交集
 */
print_r("<h3>数组的交集： array_intersect : </h3>");
    $ary1 = array('a', 'b', 'c');
    $ary2 = array('a', 'd', 'e');
    $ary3 = array_intersect($ary1, $ary2); //---$ary3('a');
var_dump($ary3);

    $ary1 = array('a' => 'aji', 'b' => 'bit', 'c' => 'can');
    $ary2 = array('a' => 'aji', 'd' => 'bit', 'e' => 'can');
    $ary3 = array_intersect_assoc($ary1, $ary2);
var_dump($ary3);



/**
 * 数组的差集
 */
print_r("<h3>数组的差集: array_diff : </h3>");
    //array_diff(ary,ary-1,ary-2...)
    $ary1 = array('a', 'b', 'c');
    $ary2 = array('a', 'd', 'e');
    $ary3 = array_diff($ary1, $ary2); //---$ary3('b','c,'d,'e');
var_dump($ary3);

    // array_diff_assoc(ary,ary-1,ary-2,...)
    $ary1 = array('a' => 'aji', 'b' => 'bit', 'c' => 'can');
    $ary2 = array('a' => 'aji', 'd' => 'bit', 'e' => 'can');
    $ary3 = array_diff_assoc($ary1, $ary2); //---$ary3('b'=>'bit','c'-'can','d'=>'bit','e'=>'can');
var_dump($ary3);


print_r("<h2>Array 特别操作</h2>");
print_r("<h5>Array 遍历性地修改整个数组的值，可使用 & 指针式地遍历修改</h5>");
foreach($aryMobile as &$val){//在 $value 前加上指针标志符 & ,可以使用值指向内存地址，从而修改值
    $val .= '-New';
}
var_dump($aryMobile);

?>
