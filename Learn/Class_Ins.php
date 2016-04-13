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
    const SIZE = 10;        //���� constant value
    /**
     * @var int
     */
    public $value1 = 1;      //��������

    /**
     * @var int
     */
    private $value2 = 2;    //˽�б���
    /**
     * @var int
     */
    protected $value3 = 3;  //��������

    /**
     * @var int
     */
    var $value4;            //��˵�� php4 �Ĳ���

    /**
     * @var int
     */
    static $static_value;   //��̬����

    /**
     * Construct Function
     * @param int $v1
     * @param int $v2
     * @param int $v3
     */
    function Class_Ins($v1, $v2, $v3 = 33) {
        $this->value1 = $v1;
        $this->value2 = $v2;
        $this->value3 = $v3;

        $this->value4 = self::SIZE;         //����ֻ���� self:: ����
        $this->value4 = self::$static_value;//��̬����Ҳ��ֻ���� self:: ����
    }

    /**
     * Construct Function  ���ֹ��캯����д����ֻȡһ�֣�
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
        print_r(self::$value1 . "===" . self::$static_value);  //��̬������Ҳֻ�ܲ��� self:: ���ʱ����ȣ�
    }

    public function getValue_2(){
        print_r($this->value1 . "===" . $this->static_value);  //��̬������Ҳֻ�ܲ��� self:: ���ʱ����ȣ�
    }
}

/**
 * �̳е���
 */
class Class_son extends Class_Ins
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

        parent::__construct();      //�̳�ʱ����Ҫ���ø��Ĺ��캯��
    }
}
