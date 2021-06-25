<?php

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
