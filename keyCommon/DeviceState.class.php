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
    public function deviceInfoGet(){
        if($this->OS != self::LINUX){
            return "System is not linux";
        }

        $args = func_get_args();
        $array = array();

        if(in_array("storage",$args)){
            $array['storage'] = $this->deviceStorageGet();
        }

        if(in_array("cpu",$args)){
            $array['cpu'] = $this->deviceCpuGet();
        }

        return $array;
    }

    /**
     * Device storage get
     *
     * @return array
     */
    public function deviceStorageGet(){
        $fp = popen('df -h | grep -E "^(/)"',"r");
        $rs = "";
        while(!feof($fp)){
            $rs .= fread($fp,1024);
        }
        pclose($fp);

        $hdInfo = explode("\n", trim($rs));
        $hdInfoArr = array();

        foreach ($hdInfo as $key => $rawHdInfo) {
            $rawHdInfo = preg_replace("/\s{2,}/", " ", $rawHdInfo);  //把多个空格换成 “ ”
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
    public function deviceCpuGet(){
        return array();
    }

}
