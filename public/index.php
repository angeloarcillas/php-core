<?php

/**
 * Register autoloader
 */
require_once __DIR__ . '/../vendor/autoload.php';

app()->bind('session', new \Session);
app()->bind('config', require_once 'path\to\config.php');
app()->bind('session', new \Session);
app()->bind('session', new \Session);
app()->bind('session', new \Session);

class A
{
    protected $data = [];

    public function __set($key, $value)
    {
       return $this->$key = $value;
    }
    public function __get($key)
    {
        return $this->$key;
    }
}

$a = new A();
$a->foo = "test";
$a->foo2 = "test";
$a->foo3 = "test";
echo $a->foo;
die(var_dump($a));

echo "Jello";

$errors = app('session')->get('errors');

// app('config');


function app($key = null)
{
    if (! is_null($key)) {
        $app = new \App();
        return $app->get($key);
    }

    return \App::instance();
}