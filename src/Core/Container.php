<?php

namespace Budgetwise\Core;


use LogicException;

class Container
{
    protected array $bindings = [];

    public function bind($key, $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * @throws LogicException
     */
    public function resolve($key)
    {
        if (! array_key_exists($key, $this->bindings)) {
            throw new LogicException("No matching binding found for key {$key}");
        }

        $resolver = $this->bindings[$key];
        return call_user_func($resolver);
    }
}