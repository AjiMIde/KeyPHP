<?php

/**
 * User        : Aij
 * DateTime    : 2016/4/13-19:18
 * Modified    : 2016/4/13-19:18
 * Description :
 *
 * ## Create a new class in php , just like object-oriented program language
 * ## Inherit a class and use static/self::/$this
 *
 */
class Class_Ins
{
    const SIZE = 10;        //常量 constant value
    /**
     * @var int
     */
    public $value1 = 1;      //公共变量

    /**
     * @var int
     */
    private $value2 = 2;    //私有变量
    /**
     * @var int
     */
    protected $value3 = 3;  //保护变量

    /**
     * @var int
     */
    var $value4;            //据说是 php4 的产物

    /**
     * @var int
     */
    static $static_value;   //静态变量

    /**
     * Construct Function 这是 PHP4 的产物，已经报废
     * @param int $v1
     * @param int $v2
     * @param int $v3
     */
    function Class_Ins($v1, $v2, $v3 = 33) {
        $this->value1 = $v1;
        $this->value2 = $v2;
        $this->value3 = $v3;

        $this->value4 = self::SIZE;         //常量只能用 self:: 访问
        $this->value4 = self::$static_value;//静态变量也是只能用 self:: 访问
    }

    /**
     * Construct Function  两种构造函数的写法（只取一种）
     * @param int $v1
     * @param int $v2
     * @param int $v3
     */
    function __construct($v1, $v2, $v3 = 33) {
        $this->value1 = $v1;
        $this->value2 = $v2;
        $this->value3 = $v3;

        $this->value4 = self::SIZE;
    }

    /**
     * Static Function
     */
    static function getValue() {
        print_r(self::$value1 . "===" . self::$static_value);  //静态方法中也只能采用 self:: 访问变量等；
    }

    public function getValue_2(){
        print_r($this->value1 . "===" . $this->static_value);  //静态方法中也只能采用 self:: 访问变量等；
    }
}

/**
 * 继承的类
 */
class Class_Son extends Class_Ins
{
    /**
     * @var
     */
    public $value5;
    /**
     * @var
     */
    public $value6;

    /**
     * Construct function
     * @param int $v5
     * @param int $v6
     */
    function __construct($v5, $v6) {
        $this->value5 = $v5;
        $this->value6 = $v6;

        parent::__construct();      //继承时，需要调用父的构造函数
    }
}


/**
 * Author      : Aji
 * DateTime    : 2015-10-24
 * Description : 抽象类，只能使用抽象的方法；不能实例化，只能被继承，常作用于规范代码
 */
abstract class Abs_Class{
    abstract public function getV();
    abstract public function setV($val);
}

/**
 * 抽象类的继承、使用
 */
class Abs_Class_Ins extends Abs_Class{
    public $value = 1;
    function getV(){
        return $this->value;
    }
    function setV($val){
        $this->value = $val;
    }
}

/**
 * Author      : Aji
 * DateTime    : 2015/10/24
 * Modified    : 2015/10/24
 * Description : 一个工厂类，专门用来实例化其他类
 */
class Factory{
    /**
     * 静态方法，根据参数实例化类
     * @param $para
     * @return OperationAdd|OperationSub
     */
    public static function createObj($para){//静态方法只能通过实例调用过
        switch ($para){
            case '+':
                return new OperationAdd();
                break;
            case '-':
                return new OperationSub();
                break;
            default:
                break;
        }
    }
}
?>
