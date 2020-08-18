<?php


phpinfo();


/*
 * 依赖注入：   不是由自己内部new 对象或者实例， 通过构造函数， 或者方法传入的都属于依赖注入(DI)
 *
 * 控制反转：    由外部负责依赖需求的行为，称为依赖反转
 *                  $user = User(new DatabaseLog());
 *                  $user->login();
 * */

// 定义写日志的接口规范
interface Log
{
    public function write();
}

// 文件记录日志
class FileLog implements Log
{
    public function write()
    {
        echo 'file log write...';
    }
}

class DatabaseLog implements Log
{
    public function write()
    {
        echo 'database log write';
    }
}

class user
{
    protected $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function login()
    {
        echo 'login success<br/>';
        $this->log->write();
    }
}

/*
 * Ioc 核心思想
 *  1. Ioc 维护binding 数组记录方法传入的键值对
 *          user    =>  User
 *          log     =>  FileLog
 *  2. 在ioc->make('user')都时候, 通过反射拿到User 都构造函数
 *          此时会发现 User都构造函数是log , 而log 是FileLog
 *  3. 反射机制创建 $filelog = new FileLog();
 *  4. 通过 newInstanceArgs 然后去创建new User($filelog)
 *
 * */

class Ioc
{
    public $binding = [];

    public function bind($abstract, $concrete)
    {
        $this->binding[$abstract]['concrete'] = function ($ioc) use ($concrete) {
            return $ioc->build($concrete);
        };
    }

    public function make($abstract)
    {
        $concrete = $this->binding[$abstract]['concrete'];
        return $concrete($this);
    }

    public function build($concrete)
    {
        $reflector = new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return $reflector->newInstance();
        } else {
            $dependencies  = $constructor->getParameters();
            $instances = $this->getDependencies($dependencies);
            return $reflector->newInstanceArgs($instances);
        }
    }

    protected function getDependencies($paramters)
    {
        $dependencies = [];

        foreach ($paramters as $paramter) {
            $dependencies[] = $this->make($paramter->getClass()->name);
        }
        return $dependencies;
    }
}


class UserFacade
{
    protected static $ioc;

    public static function setFacadeIoc($ioc)
    {
        static::$ioc = $ioc;
    }

    protected static function getFacadeAccessor()
    {
        return 'user';
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::$ioc->make(static::getFacadeAccessor());
        return $instance->$method(...$args);
    }
}

$ioc = new Ioc();
$ioc->bind('Log', 'filelog');
$ioc->bind('user', 'User');

UserFacade::setFacadeIoc($ioc);

UserFacade::login();

//$user = $ioc->make('user');
//$user->login();

//function make($concrete)
//{
//    $reflector = new ReflectionClass($concrete);
//    $constructor = $reflector->getConstructor();
//
//    if (is_null($constructor)) {
//        return $reflector->newInstance();
//    } else {
//        $dependencies = $constructor->getParameters();
//
//        $instance = getDependencies($dependencies);
//        return $reflector->newInstanceArgs($instance);
//    }
//}
//
//function getDependencies($paramters)
//{
//    $dependencies = [];
//
//    foreach ($paramters as $paramter) {
//        $dependencies[] = make($paramter->getClass()->name);
//    }
//    return $dependencies;
//}

//$user = make('User');
//$user->login();