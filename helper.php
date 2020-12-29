<?php
/**
 * TABLE OF CONTENTS
 * 1. Core
 * 2. String
 * 3. Number
 * 4. Array
 * 5. Https
 * 6. Forms
 * 7. Class
 * 8. Etc
 */


/***************************************************
 * CORE
 **************************************************/

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 */
if (! function_exists("view")) {
    function view(string $path, array $data = [])
    {
        extract($data);
        return require "App/Views/{$path}.view.php";
    }
}

/**
 * Return file from assets folder
 */
if (! function_exists("assets")) {
    function assets(string $path)
    {
        return 'App/Assets/'.e($path);
    }
}

/**
 * Redirect to new Page
 */
if (! function_exists('redirect')) {
    function redirect(string $to, int $status = 302, array $headers = [])
    {
        foreach ($headers as $header)
            header($header);

        header('location:/' . trim($to, "/"), true, $status);
    }
}

/**
 * Die  and dump
 */
if (! function_exists("dd")) {
    function dd(...$params)
    {
        die(var_dump($params));
    }
}

/***************************************************
 * STRING
 **************************************************/

/**
 * Encode string
 */
if (! function_exists("e")) {
    function e(string $string)
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}

/**
 * Reverse word
 */
if (! function_exists("rev")) {
    function rev(string $string)
    {
        return implode(' ', array_reverse(explode(' ', strrev($str)))) ;
    }
}

/**
 * String ends with ?
 *
 * @param string $str
 * @param string $end
 * @return bool
 */
if (! function_exists("ending")) {
    function ending($str, $end)
    {
        return $end == '' || substr_compare($str, $end, -strlen($end)) == 0;
    }
}

/***************************************************
 * NUMBER
 **************************************************/

/**
 * Reverse word
 */
if (! function_exists("toNegative")) {
    function toNegative(string $string)
    {
        return -abs($num);
    }
}

/***************************************************
 * ARRAY
 **************************************************/

/***************************************************
 * HTTP
 **************************************************/

 /**
 * Get all request
 *
 * @return array|string
 */
if (! function_exists("request")) {
    function request(?string $key = null)
    {
        // retienve $_REQUEST
        $request = \Http\Request::request();

        if (!$key)
            // return all request as object
            return (object) $request;

        if (array_key_exists($key, $request))
            // return request
            return $request[$key];

        error("Request key doesnt exist");
    }
}

/***************************************************
 * FORMS
 **************************************************/

 /**
 * Set csrf token
 */
if (! function_exists('csrf_token')) {
    function csrf_token()
    {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        $_SESSION["csrf_lifespan"] = time() + 3600;
        return $_SESSION["csrf_token"];
    }
}

/**
 * Create csrf field
 *
 * @return string
 */

if (! function_exists('csrf_field')) {
    function csrf_field()
    {
        return new HtmlString('<input type="hidden" name="_csrf" value="'. csrf_token() .'">');
    }
}

/**
 * Create method field
 *
 * @return string
 */
if (! function_exists('method_field')) {
    function method_field(string $method)
    {
        return new HtmlString('<input type="hidden" name="_method" value="'. $method .'">');
    }
}

 /***************************************************
 * CLASS
 **************************************************/

/**
 * Return class basename
 *
 * @return string
 */
if (! function_exists('class_basename')) {
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}

/***************************************************
 * ETC
 **************************************************/

/**
 * Throw new exception
 *
 * @param string $msg
 */
if (! function_exists("error")) {
    function error(string $msg)
    {
        throw new \Exception($msg);
    }
}

/**
 * Get/set/delete session
 *
 * @return mixed
 */
function session(string|array $x, bool $delete = false) {

    // session($key, true) | delete session
    if($delete)
    {
        unset($_SESSION[$x]);
        return;
    }
    // session([$key => $value]) | set session
    if(is_array($x)) {
        $key = array_keys($x)[0];
        $_SESSION[$key] = $x[$key];
        return;
    }

    // if key doesnt exist
    if(!isset($_SESSION[$x])) {
        return false;
    }

    // session($key) | get session
    return $_SESSION[$x];
}