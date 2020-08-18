<?php


/*
 * 外观模式
 *  外部与一个子系统的通信必须通过一个统一的外观对象进行, 为子系统中的一组接口提供一个一致的界面, 外观模式定义了一个高层接口， 这个接口使得
 *  这一系统更加容易使用
 *
 *  外观模式要求一个子系统的外部与其内部的通信通过一个统一的外观对象进行
 *
 * */

class Client
{
    public function main()
    {
        (new Facade)->operation();
    }
}

class Facade
{
    private $systemA;
    private $systemB;

    public function __construct()
    {
        $this->systemA = new SystemA;
        $this->systemB = new SystemB;
    }

    public function operation()
    {
        $this->systemA->operationA();
        $this->systemB->operationB();
    }
}

class SystemA
{
    public function operationA()
    {
        echo 'operationA<br/>';
    }
}

class SystemB
{
    public function operationB()
    {
        echo 'operationB<br/>';
    }
}

$client = new Client();
$client->main();
