<?php

interface Milldeware {
    public static function handle(Closure $next);
}

class VerfiyCsrfToken implements Milldeware
{
    public static function handle(Closure $next)
    {
        echo '验证 csrf Token <br/>';
        $next();
    }
}

class VerfiyAuth implements Milldeware
{
    public static function handle(Closure $next)
    {
        echo '验证是否登录';
        $next();
    }
}

class SetCookie implements Milldeware
{
    public static function handle(Closure $next)
    {
        $next();
        echo '设置cookie信息！';
    }
}

$handle = function () {
    echo "当前要执行的程序";
};

$pipe_arr = [
    'VerfiyCsrfToken',
    'VerfiyAuth',
    'Setcookie'
];


$callback = array_reduce($pipe_arr, function ($stack, $pipe) {
    return function () use ($stack, $pipe) {
        return $pipe::handle($stack);
    };
}, $handle);


call_user_func($callback);

//function call_middleware()
//{
//    setcookie::handle(function () {
//        VerfiyAuth::handle(function () {
//            $handle = function () {
//                echo '当前要执行都程序';
//            };
//            VerfiyCsrfToken::handle($handle);
//        });
//    });
//}
//call_middleware();