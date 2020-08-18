<?php


/*
 * 观察者模式
 *  1. 定义对象间的一种一对多依赖关系, 使得每当一个对象状态发生改变时, 其相关依赖对象皆
 *      得到通知并自动更新
 *
 * */


// 抽象目标类
abstract class Subject
{
    protected $stateNow;
    protected $observers = [];

    public function attach(Observer $observer)
    {
        array_push($this->observers, $observer);
    }

    public function detach(Observer $ob)
    {
        $pos = 0;

        foreach ($this->observers as $viewer) {
            if ($viewer == $ob) {
                array_splice($this->observers, $pos, 1);
            }
            $pos++;
        }
    }

    public function notify()
    {
        foreach ($this->observers as $viewer) {
            $viewer->update($this);
        }
    }
}

// 具体目标类
class ConcreteSubject extends Subject
{
    public function setState($state)
    {
        $this->stateNow = $state;
        $this->notify();
    }

    public function getstate()
    {
        return $this->stateNow;
    }
}

// 抽象观察者
abstract class Observer
{
    abstract public function update(Subject $subject);
}

// 具体观察者
class ConcreteObserverDT extends Observer
{
    private $currentState;

    public function update(Subject $subject)
    {
        $this->currentState = $subject->getState();

        echo '<div style="font-size:10px;">'. $this->currentState .'</div>';
    }
}

class ConcreteObserverPhone extends Observer
{
    private $currentState;

    public function update(Subject $subject)
    {
        $this->currentState = $subject->getState();
        echo '<div style="font-size:20px;">'. $this->currentState .'</div>';
    }
}

// 使用观察者模式
class Client
{
    public function __construct()
    {
        $sub = new ConcreteSubject();

        $objDT = new ConcreteObserverDT();
        $obPhone = new ConcreteObserverPhone();

        $sub->attach($objDT);
        $sub->attach($obPhone);

        $sub->setState('Hello world');
        $sub->notify();
    }
}

$worker = new Client();