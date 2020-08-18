<?php


/*
 * 装饰模式
 *  装饰模式能够实现动态为对象添加功能， 是从一个对象外部来给对象添加功能
 *
 *  通常有两种方式给一个类或对象增加行为
 *      1. 继承机制：  通过继承一个现有类使得子类在拥有自身方法的同时还拥有父类的方法
 *      2. 组合机制：  将一个类的对象嵌入另一个对象中， 由另一个对象来决定是否调用嵌入对象的行为以便扩展自己的行为
 *
 *
 *  定义：
 *      动态的给一个对象增加一些额外的职责，
 *
 * */


abstract class Component
{
    abstract public function operation();
}

class ConcreteComponent extends Component
{
    public function operation()
    {
        echo __CLASS__ . '|' . __METHOD__ . "\r\n";
    }
}

abstract class Decorator extends Component
{
    /*
     * 持有Component的对象
     * */
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    abstract public function operation();
}

class ConcreDecoratorA extends Decorator
{
    public function beforeOperation()
    {
        echo __CLASS__ . '|' . __METHOD__ . "\r\n";
    }

    public function afterOperation()
    {
        echo __CLASS__ . '|' . __METHOD__ . "\r\n";
    }

    public function operation()
    {
        $this->beforeOperation();
        $this->component->operation();
        $this->afterOperation();
    }
}

class ConcreDecoratorB extends Decorator
{
    public function beforeOperation()
    {
        echo __CLASS__ . '|' . __METHOD__ . "\r\n";
    }

    public function afterOperation()
    {
        echo __CLASS__ . '|' . __METHOD__ . "\r\n";
    }

    public function operation()
    {
        $this->beforeOperation();
        $this->component->operation();
        $this->afterOperation();
    }
}


class Client
{
    public function main()
    {
        $component = new ConcreteComponent();
        $decoratorA = new ConcreDecoratorA($component);
//        $decoratorB = new ConcreDecoratorB($component);
        $decoratorA->operation();
    }
}


$client = new Client();
$client->main();





