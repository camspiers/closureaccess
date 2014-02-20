<?php

namespace Camspiers;

use ReflectionMethod;

/**
 * Class ClosureAccess
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
        if (isset($this->$name) && $this->$name instanceof \Closure) {
            return call_user_func_array($this->$name, $args);
        }
    }

    /**
     * @param $name
     * @throws \InvalidArgumentException
     * @return callable
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            if (empty($this->closureMethods[$name])) {
                if (!(new ReflectionMethod($this, $name))->isPublic()) {
                    throw new \InvalidArgumentException(sprintf(
                        "Method %s::%s is not public and can't be accessed though ClosureAccess",
                        __CLASS__,
                        $name
                    ));
                }
                
                $this->closureMethods[$name] = function () use ($name) {
                    return call_user_func_array([$this, $name], func_get_args());
                };
            }
            
            return $this->closureMethods[$name];
        }
    }
}