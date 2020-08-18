<?php

//namespace App\Http\Libs;

header("content-type:text/html;charset=utf-8");

class DB
{
    private $dblink;
    private static $instance;
//
     private $config = [
            'host' => '127.0.0.1',
            'user' => 'root',
            'pwd' => '123456',
            'name' => 'qinggan'
        ];

//    private $config = [
//        'host' => '47.104.10.44',
//        'user' => 'root',
//        'pwd' => 'Dp199166@@@',
//        'name' => 'youmai'
//    ];


    private function __construct()
    {
        $obj = $this->dblink = new mysqli(
            $this->config["host"],
            $this->config["user"],
            $this->config["pwd"],
            $this->config["name"]
        );
        if ($obj->connect_error) {
            die('connect to db0 failed');
        }
        $this->dblink->query("set names utf8");
    }

    public static function getinstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function exec_db($sql)
    {
        $rs = $this->dblink->query($sql) or die($this->dolog($this->dblink->error, $sql));
        return $rs;
    }

    public function exec_db_insertid($sql)
    {
        $rs = $this->dblink->query($sql) or die($this->dolog($this->dblink->error, $sql));
        return $this->dblink->insert_id;
    }

    public function getonerecord($sql)
    {
        $result = $this->dblink->query($sql) or die($this->dolog($this->dblink->error, $sql));
        $data = $result->fetch_all(MYSQLI_ASSOC);
        mysqli_free_result($result);
        return (empty($data)) ? [] : $data[0];
    }

    public function getallrecord($sql)
    {
        $result = $this->dblink->query($sql) or die($this->dolog($this->dblink->error, $sql));
        $data = $result->fetch_all(MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $data;
    }

    public function close()
    {
        if ($this->dblink) {
            mysqli_close($this->dblink);
        }
    }

    private function __clone()
    {
    }

    public function __destruct()
    {
        $this->close();
    }

    private function dolog($msg='',$datas=''){

        var_dump($msg);
        die();
//        $time = date('Y-m-d',time());
//        $filename = dirname(__DIR__). '/./../../storage/logs/queue/'.$time.'.log';
//        if(is_array($datas)){
//            file_put_contents($filename, "[{$time}]\n"."{$msg}\n".var_export($datas,true)."\n\n", FILE_APPEND);
//        }else{
//            file_put_contents($filename, "[$time]\n"."{$msg}\n".$datas."\n\n", FILE_APPEND);
//        }
    }

}