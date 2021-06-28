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
 *  View
 */
if (!function_exists('view')) {
    function view(string $file, $params = [])
    {
        $path = app('path.views') . "/{$file}.view.php";
        $exists = file_exists($path);
        
        if (!$exists) {
            throw new \Exception(sprintf(
                'File: "%s" does not exists on Views folder.',
                $file,
            ));
        }

        extract($params);
        return require $path;
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
