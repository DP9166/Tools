<?php


/*
 * 观察者接口类
 * */
interface Observer
{
    public function update($event_info = null);
}

/*
 * 观察者1
 * */
class Observer1 implements Observer
{
    public function update($event_info = null)
    {
        echo "观察者1 收到执行通知 执行完毕！\n";
    }
}

/*
 * 观察者2
 * */
class Observer2 implements Observer
{
    public function update($event_info = null)
    {
        echo "观察者2 收到执行通知 执行完毕！\n";
    }
}

/*
 * 事件
 * */
class Event
{
    // 用于观察者注册的数组
    protected $observers = [];

    // 增加观察者
    public function add(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    // 事件通知
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }

    // 触发事件
    public function trigger()
    {
        // 通知观察者
        $this->notify();
    }
}


// 创建一个事件
$event = new Event();
// 增加旁观者
$event->add(new Observer1());
$event->add(new Observer2());

$event->trigger();

//// 服务类 =>   实现事件都创建和触发, 不关心具体多少调用方需要见坚挺
//class DemoService
//{
//    public function demo()
//    {
//        // 创建一个事件
//        $event = new Event();
//
//        // 执行事件, 通知旁观者
//        $event->trigger();
//    }
//}
//
//class DoService
//{
//    public function do()
//    {
//        $event->add(new Observer1());
//        $event->add(new Observer2());
//    }
//}
