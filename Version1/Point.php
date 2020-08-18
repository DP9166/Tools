<?php


class Point
{
    public $x;
    public $y;

    public function __construct($x = 0, $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }
}


class Circle
{
    public $radius;
    public $center;

    const PI = 3.14;

    public function __construct(Point $point, $radius = 1)
    {
        $this->center = $point;
        $this->radius = $radius;
    }

    // 打印圆点的坐标
    public function printCenter()
    {
        printf('center coordinate is (%d, %d)', $this->center->x, $this->center->y);
    }

    public function area()
    {
        return self::PI * pow($this->radius, 2);
    }
}

$reflectionClass = new reflectionClass(Circle::class);  // object(ReflectionClass)#1 (1) { ["name"]=> string(6) "Circle" }

$reflectionClass->getConstants();  // 返回一个由常量名称和值构成的关联数组 => array(1) { ["PI"]=> float(3.14) }

/*
 * 通过反射获取属性
 * array(2) { [0]=> object(ReflectionProperty)#2 (2) { ["name"]=> string(6) "radius" ["class"]=> string(6) "Circle" } [1]=> object(ReflectionProperty)#3 (2) { ["name"]=> string(6) "center" ["class"]=> string(6) "Circle" } }
 * */
$reflectionClass->getProperties();

/*
 * 反射类中定义的方法
 * array(3) { [0]=> object(ReflectionMethod)#4 (2) { ["name"]=> string(11) "__construct" ["class"]=> string(6) "Circle" } [1]=> object(ReflectionMethod)#5 (2) { ["name"]=> string(11) "printCenter" ["class"]=> string(6) "Circle" } [2]=> object(ReflectionMethod)#6 (2) { ["name"]=> string(4) "area" ["class"]=> string(6) "Circle" } }
 * */
$reflectionClass->getMethods();


function make($className)
{
    $reflectionClass = new ReflectionClass($className);

    $constructor = $reflectionClass->getConstructor();
    $parameters = $constructor->getParameters();
    $dependencies = getDependencies($parameters);

    return $reflectionClass->newInstanceArgs($dependencies);
}

function getDependencies($parameters)
{
    $dependencies = [];
    foreach ($parameters as $parameter) {
        $dependency = $parameter->getClass();

        if (is_null($dependency)) {
            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                $dependencies[] = '0';
            }
        } else {
            $dependencies[] = make($parameter->getClass()->name);
        }
    }
    return $dependencies;
}

$circle = make('Circle');
$area = $circle->area();

var_dump($area);

