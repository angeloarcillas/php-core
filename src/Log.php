<?php

namespace Zeretei\PHPCore;

use DateTime;
use Zeretei\PHPCore\Http\Request;

class Log
{
    public static function set($error)
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $route = Request::uri();
        $method = Request::method();

        $start = "=============================================================\n";
        $end = "\n=============================================================\n";
        $message = $start . sprintf('%s - [%s] %s  %s', $date, $method, $route . PHP_EOL, $error) . $end;

        $file = Application::get('path.app') . "/logs/log.txt";
        file_put_contents($file, $message, FILE_APPEND);
    }
}
