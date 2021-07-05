<?php

/**
 *  application helper
 */
if (!function_exists('app')) {
    function app(string $key = null)
    {
        $app =  \Zeretei\PHPCore\Application::getInstance();
        return is_null($key) ? $app : $app->get($key);
    }
}

/**
 *  Request instance
 */
if (!function_exists('request')) {
    function request(string $key = null)
    {
        return is_null($key) ? app('request') : app('request')->$key;
    }
}

/**
 *  Redirect
 */
if (!function_exists('redirect')) {
    function redirect(string $path = null, int $status = 302)
    {
        if (is_null($path)) return app('router');

        if (headers_sent() === false) {
            $realSubPath = str_replace('.', '/', e($path));
            $realPath = '/' . trim($realSubPath, '/');
            header("location:{$realPath}", true, $status);
            exit;
        }

        return false;
    }
}

/**
 *  encode
 */
if (!function_exists('e')) {
    function e(string $str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }
}

/**
 *  Convert path to system path
 */
if (!function_exists('sys_path')) {
    function sys_path(string $file, string $path)
    {
        $file = str_replace('.', '/', $file);
        $realPath = str_replace('{file}', $file, $path);
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $realPath);
    }
}

/**
 *  View
 */
if (!function_exists('view')) {
    function view(string $file, $params = [])
    {
        $path = app('path.views') . '/{file}.view.php';
        $realPath = sys_path($file, $path);
        $exists = file_exists($realPath);

        if (!$exists) {
            throw new \Exception(
                sprintf('File: "%s" does not exists on Views folder.', $realPath)
            );
        }

        extract($params);

        return require $realPath;
    }
}

/**
 * View includes folder
 */
if (!function_exists('includes')) {
    function includes($file)
    {
        $path = app('path.views') . "/includes/{file}.view.php";
        $path =  sys_path($file, $path);
        return require_once $path;
    }
}
