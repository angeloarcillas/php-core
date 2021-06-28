<?php

/**
 *  application helper
 */
if (!function_exists('app')) {
    function app(string $key = null)
    {
        if (is_null($key)) {
            return \Zeretei\PHPCore\Container::getInstance();
        }

        return \Zeretei\PHPCore\Container::get($key);
    }
}

/**
 *  Die and Dump
 */
if (!function_exists('dd')) {
    function dd(...$data)
    {
        die(var_dump(...$data));
    }
}

/**
 *  Die, Dump and debug - better format
 */
if (!function_exists('ddd')) {
    function ddd(...$data)
    {
        echo "<pre>";
        var_dump(...$data);
        echo "</pre>";
        exit;
    }
}
