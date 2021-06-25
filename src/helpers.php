<?php

/**
 *  Die and Dump
 */
if (function_exists('dd')) {
    function dd(...$data)
    {
        die(var_dump(...$data));
    }
}
