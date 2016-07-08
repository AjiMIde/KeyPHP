<?php
/**
 * User        : Aij
 * DateTime    : 2016/7/08-13:35
 * Modified    : 2016/7/08-13:54
 * Description : MySql的连接、关闭、数据库的操作，表的CURD操作
 */
include_once '../keyCommon/style.php';

udmd('MySql的连接、关闭、数据库的操作，表的CURD操作');


class mysql {

    public $con;

    public function __construct(){
        $this->con = mysqli_connect('127.0.0.1','root','123456','wp_db','3307','');

    }

    public function openCon(){
        if (!$this->con) {
            die('Could not connect: ' . mysqli_errno());
        }
        var_dump($this->con);
    }

    public function closeCon(){
        mysqli_close($this->con);
    }

    public function createDB(){
        if (mysqli_query("CREATE DATABASE my_db", $this->con)) {
            echo "Database created";
        } else {
            echo "Error creating database: " . mysqli_error();
        }
    }

    public function createTB(){
        mysqli_select_db("my_db", $this->con);
        $sql = "CREATE TABLE Persons " +
            "( personID int NOT NULL AUTO_INCREMENT, FirstName varchar(15), LastName varchar(15), Age int )";

        var_dump(mysqli_query($sql,$this->con));
    }
}

?>
