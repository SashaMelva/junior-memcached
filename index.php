<?php
$memcached = new Memcached();
$memcached->addServer('jm-memcached1', 11211);
$memcached->addServer('jm-memcached2', 11211);
$memcached->addServer('jm-memcached3', 11211);
print_r($memcached->getResultMessage());
print_r('<hr />');

$num = getNum($_SERVER['REQUEST_URI']);
$var_key = $memcached->get("{$num}");

if (!empty($var_key)) {
    //Если объект закэширован, выводим его значение
    echo $var_key;
} else {
    //Если в кэше нет объекта с ключом our_var, создадим его
    //Объект our_var будет храниться 5 минут и не будет сжат
    $fib = fib($num);
    $memcached->set("{$num}", $fib, 300);
    //Выведем закэшированные данные
    echo $fib;
}

function fib(int $a): int
{

    if ($a === 0) {
        return 0;
    }

    if ($a === 1) {
        return 1;
    }

    $result = fib($a - 1) + fib($a - 2);
    return $result;
}

function getNum($url)
{
    $num = explode('=', $url);
    return $num[1];
}