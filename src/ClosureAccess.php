<?php

namespace Camspiers;

use ReflectionMethod;

/**
 * @package Camspiers
 */
trait ClosureAccess
{
    /**
     * @var array
     */
    protected $closureMethods = [];

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (isset($this->$name)) {
            $func = $this->$name;
            switch (count($args)) {
                case 0: return $func();
                case 1: return $func($args[0]);
                case 2: return $func($args[0], $args[1]);
                case 3: return $func($args[0], $args[1], $args[2]);
                case 4: return $func($args[0], $args[1], $args[2], $args[3]);
                case 5: return $func($args[0], $args[1], $args[2], $args[3], $args[4]);
                default: return call_user_func_array($func, $args);
            }
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value instanceof \Closure ? $value->bindTo($this, $this) : $value;
    }

    /**
     * @param $name
     * @throws \InvalidArgumentException
     * @return callable
     */
    public function __get($name)
    {
        if (isset($this->closureMethods[$name])) {
            return $this->closureMethods[$name];
        } elseif (method_exists($this, $name)) {
            $reflectionMethod = new ReflectionMethod($this, $name);
            
            if (!$reflectionMethod->isPublic()) {
                throw new \InvalidArgumentException(sprintf(
                    "Method %s::%s is not public and can't be accessed through ClosureAccess",
                    __CLASS__,
                    $name
                ));
            }
            
            return $this->closureMethods[$name] = $reflectionMethod->getClosure($this);
        }
    }
}