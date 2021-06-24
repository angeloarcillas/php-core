<?php

class Request
{
    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function _set($key, $value)
    {
        $this[$key] = $value;
    }

    public function _get($key)
    {
        return $this[$key] ?? null;
    }
}
