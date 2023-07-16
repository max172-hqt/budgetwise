<?php

namespace Budgetwise\Core;


use LogicException;


class Container
{
    protected array $bindings = [];
    protected array $singletons = [];

    public function bind($key, $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function singleton($key, $resolver): void
    {
        $this->singletons[$key] = call_user_func($resolver);
    }

    /**
     * @throws LogicException
     */
    public function resolve($key)
    {
        if (!array_key_exists($key, $this->bindings)
            && !array_key_exists($key, $this->singletons)
        ) {
            throw new LogicException("No matching binding found for key {$key}");
        }

        if (array_key_exists($key, $this->singletons)) {
            return $this->singletons[$key];
        }

        $resolver = $this->bindings[$key];
        return call_user_func($resolver);
    }
}