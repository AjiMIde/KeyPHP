<?php

/**
 * Copyright 2016-2020 Aji
 * That's a interface to get some information of a device(linux),offer several methods above:
 *
 *
 * ## Get the list of specified type of files from document;
 * ## Get the list of sub directories from a directory path, not include files
 * ## Create a directory
 * ## Del the directory
 * ## Copy directory
 * ## Get the size of directory
 *
 * ## Zip operation :
 * > * Create zip
 * > * extract ip
 *
 * @package    keyCommon
 * @email      Adele513900383@gmail.com
 *
 * Version     : 1.4
 * DateTime    : 2015/10/15-17:50
 * Modified    : 2016/04/07-9:51
 */
class DeviceState
{
    /**
     * @var string
     */
    const LINUX = "LINUX";

    /**
     * @var string
     */
    const WINNT = "WINNT";

    /**
     * @var string
     */
    const ERR_MSG = "Error: CANT GET NOTHING";

    /**
     * @var string
     */
    public $OS;

    /**
     * @var DeviceState
     */
    protected static $_instance;

    /**
     * Construct
     */
    public function __construct() {
        $this->OS = strtoupper(PHP_OS);

        /**
         * DIRECTORY_SEPARATOR php自带的一个内置常量，用来显示系统分隔符的命令。
         * 在windows下路径分隔符是\（当然/在部分系统上也是可以正常运行的
         * 在linux上路径的分隔符是/，DIRECTORY_SEPARATOR 这个常量存在的意义就是会根据不同的操作系统来显示不同的分隔符。
         */
        $this->Directory_separator = DIRECTORY_SEPARATOR;

        /**
         * PATH_SEPARATOR 是一个常量，在linux系统中是一个" : "号,Windows上是一个";"号。
         */
        $this->Path_separator = PATH_SEPARATOR;
    }

    /**
     * Get an instance of this class
     *
     * @return DeviceState instance
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new DeviceState();
        }
        return self::$_instance;
    }

    /**
     * Device information get
     *
     * @param  string $kind eg:'cpu','storage'
     * @return array
     */
    public function deviceInfoGet() {
        if ($this->OS != self::LINUX) {
            return "System is not linux";
        }

        $args = func_get_args();
        $array = array();

        if (in_array("storage", $args)) {
            $array['storage'] = $this->deviceStorageGet();
        }

        if (in_array("cpu", $args)) {
            $array['cpu'] = $this->deviceCpuGet();
        }

        return $array;
    }

    /**
     * Device storage get
     *
     * @return array
     */
    public function deviceStorageGet() {
        $fp = popen('df -h | grep -E "^(/)"', "r");
        $rs = "";
        while (!feof($fp)) {
            $rs .= fread($fp, 1024);
        }
        pclose($fp);

        $hdInfo = explode("\n", trim($rs));
        $hdInfoArr = array();

        foreach ($hdInfo as $key => $rawHdInfo) {
            $rawHdInfo = preg_replace("/\s{2,}/", " ", $rawHdInfo);
            $rawHdInfoArr = explode(" ", $rawHdInfo);

            $file_system = $rawHdInfoArr[0];
            $size = $rawHdInfoArr[1];
            $used = $rawHdInfoArr[2];
            $available = $rawHdInfoArr[3];
            $use_percent = $rawHdInfoArr[4];
            $mounted_on = $rawHdInfoArr[5];

            array_push($hdInfoArr, array(
                "file_system" => $file_system,
                "size" => $size,
                "used" => $used,
                "available" => $available,
                "use_percent" => $use_percent,
                "mounted_on" => $mounted_on
            ));
        }

        return $hdInfoArr;
    }

    /**
     * Device cpu get
     *
     * @return array
     */
    public function deviceCpuGet() {
        return array();
    }

    /**
     * Return the raw device information
     *
     * @param string $param 'a'|' ' 返回所有信息 's' 操作系统的名称 'n' 主机的名称 'r' 版本名 'v' 操作系统的版本号 'm' 核心类型
     * @return string
     */
    public function getRawDeviceInfo($param = "a") {
        return php_uname($param);
    }

    //=============
    /**
     * 获取当前磁盘所有分区信息（针对Linux)
     * 进而可求出分区的总大小，已用，剩余等信息
     *
     */
    function getOSDisk() {
        $pars = array_filter(explode("\n", `df -h`));
        var_dump($pars);
        print_r("<br>");
        foreach ($pars as $par) {
            if ($par{0} == '/') {//判断如果为分区的话
                $_tmp = array_values(array_filter(explode(' ', $par)));
                reset($_tmp);
                echo "分区挂载点：{$_tmp['5']}，" .
                    "总大小：{$_tmp['1']}" .
                    "已使用：{$_tmp['2']}({$_tmp['4']})<br/>";
            }
        }
    }
    //==========
}
