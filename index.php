<?php
session_start();
$memcached = new Memcached();
$memcached->addServer('jm-memcached1', 11211);
$memcached->addServer('jm-memcached2', 11211);
$memcached->addServer('jm-memcached3', 11211);


$num = getNum($_SERVER['REQUEST_URI']);
$user = session_id();

var_dump(session_id(), session_id());
$var_key = $memcached->get("{$num}-{$user}");


if (!empty($var_key)) {
    //Если объект закэширован, выводим его значение
    echo $var_key;
} else {
    var_dump('recalculate value');
    //Если в кэше нет объекта с ключом our_var, создадим его
    //Объект our_var будет храниться 5 минут и не будет сжат
    $fib = fib($num);
    $memcached->set("{$num}-{$user}", $fib, 300);
    //Выведем закэшированные данные
    echo $fib;
}

function fib(int $a)
{
    static $catch = [];

    if(!empty($catch[$a])) {
        return $catch[$a];
    }

    if ($a === 0) {
        return $catch[$a] = 0;
    }

    if ($a === 1) {
        return $catch[$a] = 1;
    }

    $catch[$a] = fib($a - 1) + fib($a - 2);
    return  $catch[$a];
}

function getNum($url)
{
    $data = explode('=', $url);
    $num = explode('&', $data[1]);
    return $num[0];
}

function getUser($url) {
    $user = explode('=', $url);
    return $user[2];
}