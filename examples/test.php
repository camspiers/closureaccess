<?php

namespace Camspiers;

require __DIR__.'/../src/ClosureAccess.php';

class A {
    use ClosureAccess;
    public function hello($hello)
    {
        return $hello;
    }
}

function exec($hello, $world) {
    return sprintf('%s, %s!', $hello("Hello"), $world());
}

$obj = new A;

$obj->world = function () {
  return "world";
};

echo exec($obj->hello, $obj->world), PHP_EOL;
echo $obj->hello("Hello") . ', ' . $obj->world() . '!', PHP_EOL;

