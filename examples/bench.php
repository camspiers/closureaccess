<?php

require __DIR__ . '/../vendor/autoload.php';

class A
{
    use Camspiers\ClosureAccess;

    public function mul($a, $b)
    {
        return $a * $b;
    }
}

const TIMES = 1000000;

function test1Baseline()
{
    $obj = new A;
    for ($i = 0; $i < TIMES; $i++) {
        assert($obj->mul(10, 10) === 100);
    }
}

function test1ClosureAccess()
{
    $obj = new A;
    for ($i = 0; $i < TIMES; $i++) {
        $fn = $obj->mul;
        assert($fn(10, 10) === 100);
    }
}

bench\invoke('test1Baseline');
bench\invoke('test1ClosureAccess');

echo 'Testing public method access as property', PHP_EOL;
foreach (bench\formatTimes(bench\collector()) as $time) {
    echo $time, PHP_EOL;
}


function test2Baseline()
{
    $obj = new A;
    for ($i = 0; $i < TIMES; $i++) {
        assert($obj->mul(10, 10) === 100);
    }
}

function test2ClosureAccess()
{
    $obj = new A;
    $obj->mul1 = function ($a, $b) {
        return $a * $b;
    };
    for ($i = 0; $i < TIMES; $i++) {
        assert($obj->mul1(10, 10) === 100);
    }
}

bench\invoke('test2Baseline');
bench\invoke('test2ClosureAccess');

echo 'Testing set property call as public method', PHP_EOL;
foreach (bench\formatTimes(bench\collector()) as $time) {
    echo $time, PHP_EOL;
}