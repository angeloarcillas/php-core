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
 * @param  string $path
 * @param  array  $data
 */
if (! function_exists("view")) {
    function view(string $path, array $data = [])
    {
        // array to variables
        extract($data);

        // append view file
        return require "App/Views/{$path}.view.php";
    }
}

/**
 * Return file from assets folder
 */
if (! function_exists("assets")) {
    function assets(string $path)
    {
        // base path of assets folder
        return 'App/Assets/'. e($path);
    }
}

/**
 * Redirect to new Page
 */
if (! function_exists('redirect')) {
    function redirect(?string $to = null, int $status = 302, array $headers = [])
    {
        if (!$to) {
            return new \Core\Http\Router();
        }

        // loop headers
        foreach ($headers as $header) {
            header($header);
        }

        // redirect
        header('location:/' .
            trim(str_replace('.', '/', e($to)), '/'),
            true,
            $status);

        exit;
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
 *
 * reverse each words
 */
if (! function_exists("rev")) {
    function rev(string $string)
    {
        return implode(' ', array_reverse(explode(' ', strrev($string)))) ;
    }
}

/**
 * String ends with ?
 * use str_ends_with() on php 8
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
 *  To negative real number
 *  int/float to negative real number
 */
if (! function_exists("toNegative")) {
    function toNegative(int $num)
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
        // create request instance
        $request = new \Core\Http\Request();

        // if key is null return Request::class
        if (!$key) {
            return $request;
        }

        // return request $attribute[$key]
        return $request->$key;
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
        // if no csrf token then create
       if (!isset($_SESSION['csrf_token'])) {
            // set csrf token
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

            // set csrf token lifespan
            $_SESSION["csrf_lifespan"] = time() + 3600;

            // return token
            return $_SESSION["csrf_token"];
        }

        // return token
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
        return '<input type="hidden" name="_csrf" value="'. csrf_token() .'">';
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
        return '<input type="hidden" name="_method" value="'. $method .'">';
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
function session(string|array $data, bool $delete = false) {

    // session($key, true) | delete session
    if($delete) {
        unset($_SESSION[$data]);
        return;
    }
    // session([$key => $value]) | set session
    if(is_array($data)) {
        // loop and set session
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }

        return;
    }

    // if key doesnt exist
    if(!isset($_SESSION[$data])) {
        return false;
    }

    // session($key) | get session
    return $_SESSION[$data];
}

/**
 * Same as @include
 *
 * Includes a component to html
 */
if (!function_exists('component')) {
    function component(string $path, array $data = [])
    {
        extract($data);
        return require_once 'App/Views/' . str_replace('.', '/', $path) . '.view.php';
    }
}

/**
 * Verify csrf token
 */
if (!function_exists('verifyCsrf')) {
    function verifyCsrf(string $hash)
    {
        if ($_SESSION['csrf_lifespan'] < time()
                || !hash_equals(session('csrf_token'), $hash)
            ) {
            session(['error' => 'csrf token didnt match.']);
            return redirect()->back();
        };

        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_lifespan']);
        return;
    }
}