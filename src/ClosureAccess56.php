<?php

namespace Camspiers;

trait ClosureAccess56
{
    use ClosureAccess;

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (isset($this->$name)) {
            $func = $this->$name;
            return $func(...$args);
        }
    }
}