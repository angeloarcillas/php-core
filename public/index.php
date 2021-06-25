<?php

use Zeretei\PHPCore\Request;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/helpers.php';

$method = Request::method();
$uri = Request::uri();
dd($uri);
