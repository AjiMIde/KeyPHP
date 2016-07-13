<?php
/**
 * User        : Aij
 * DateTime    : 2016/4/21-13:35
 * Modified    : 2016/4/21-13:35
 * Description : 描述了数组的一些基本操作，如定义、使用、删除、增加、合并、获取等。。
 */
include_once '../keyCommon/style.php';

udmd('描述了数组的一些基本操作，如定义、使用、删除、增加、合并、获取等。。');

/**
 * Common Ary
 */
h4('定义数组');

$s='$aryMobile = array(
    "Apple",
    "XiaoMi",
    "HuaWei"
);';
code($s);
eval($s);

$s = '$aryComputer = array(
    "Lenovo",
    "AUSU",
    "Acer"
);';
code($s);
eval($s);


h4('Hash关联数组');
$s='$aryName1 = array(
    "firstName" => "aji",
    "secondName" => "key"
);';
code($s);
eval($s);


$s = '$aryName2 = array(
    "firstName" => "chen",
    "secondName" => "ji"
);';
code($s);
eval($s);


h4('多维数组，这个常用二维，一般三维都很少用了');
$s = '$aryTech = array(
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
);';
code($s);
eval($s);


h4("数组大小获取");
$s = 'count($aryComputer);';
code($s);
code(count($aryComputer));


h4("数组遍历 Array with 'foreach' :");
$s = 'foreach ($aryMobile as $val) {
    code("--$val--");
}';
code($s);
eval($s);

$s = 'foreach ($aryName1 as $key => $val) {
    code("--$key : $val--");
}';
code($s);
eval($s);


h4("使用 implode 直接分割得到数组的值");
$s = 'code(implode("-", $aryTech["php"]));';
code($s);
eval($s);


h4("使用 array_values 和 array_keys 得到数组的值或 key");
code('array_values($aryName2)');
var_dump(array_values($aryName2));
code('array_keys($aryName1)');
var_dump(array_keys($aryName1));


h4("Delete the child in Array with 'unset' :");

code('unset($aryMobile[2]);');
var_dump($aryName1);
unset($aryName1[1]);
var_dump($aryName1);


h4("合并数组Merge Array with: array_merge and array_merge_recursive:");
h6("使用 array_merge 过程中，如果有同 key ，则后一个数组的 key 值会覆盖前一个数组的 key 值，而使用 array_merge_recursive ，则会把相同 key 合并成一个子数组");
code('$aryMe = array_merge($aryMobile, $aryComputer);');
$aryMe = array_merge($aryMobile, $aryComputer);
var_dump($aryMe);

code('$aryMe2 = array_merge_recursive($aryName1,$aryName2);');
$aryMe2 = array_merge_recursive($aryName1,$aryName2);
var_dump($aryMe2);


h4("数组的连接Combine Array，连接数组 函数会得到一个新数组，它由一组提交的键和对应的值组成");
code('$aryCo = array_combine($aryMobile, $aryComputer);');
$aryCo = array_combine($aryMobile, $aryComputer);
var_dump($aryCo);


h4("数组截取，接合，替换");
code('array_slice($aryComputer,1,2);');
var_dump(array_slice($aryComputer,1,2));
var_dump($aryComputer);
code('array_slice($aryComputer,2,1,0);');
var_dump(array_slice($aryComputer,2,1,0));


/**
 * 数组排序
 */
h4("数组排序Sort Array");
$s = '
    $ary1 = array("D", "B", "A", "C", "E");
    $ary2 = array("c", "a", "b", "d", "e");
    array_multisort($ary1, SORT_ASC, SORT_STRING, $ary2);
    var_dump($ary1);
    var_dump($ary2);

    asort($ary1);
    arsort($ary1);

    ksort($ary1);
    krsort($ary1);
';
    code($s);
eval($s);


/**
 * 数组的交集
 */
h4("数组的交集： array_intersect : ");
$s = '
    $ary1 = array("a", "b", "c");
    $ary2 = array("a", "d", "e");
    $ary3 = array_intersect($ary1, $ary2); //---$ary3("a");
';
code($s);
eval($s);
var_dump($ary3);

$s = '
    $ary1 = array("a" => "aji", "b" => "bit", "c" => "can");
    $ary2 = array("a" => "aji", "d" => "bit", "e" => "can");
    $ary3 = array_intersect_assoc($ary1, $ary2);
';
code($s);
eval($s);
var_dump($ary3);



/**
 * 数组的差集
 */
h4("数组的差集: array_diff : ");
$s = '
    //array_diff(ary,ary-1,ary-2...)
    $ary1 = array("a", "b", "c");
    $ary2 = array("a", "d", "e");
    $ary3 = array_diff($ary1, $ary2); //---$ary3("b","c","d","e");
';
code($s);
eval($s);
var_dump($ary3);

$s = '
    // array_diff_assoc(ary,ary-1,ary-2,...)
    $ary1 = array("a" => "aji", "b" => "bit", "c" => "can");
    $ary2 = array("a" => "aji", "d" => "bit", "e" => "can");
    $ary3 = array_diff_assoc($ary1, $ary2); //---$ary3("b"=>"bit","c"-"can","d"=>"bit","e"=>"can");
';
code($s);
eval($s);
var_dump($ary3);


h4("Array 特别操作");
h6("Array 遍历性地修改整个数组的值，可使用 & 指针式地遍历修改");
$s = 'foreach($aryMobile as &$val){//在 $value 前加上指针标志符 & ,可以使用值指向内存地址，从而修改值
    $val .= \'-New\';
}';
code($s);
eval($s);
var_dump($aryMobile);

?>
