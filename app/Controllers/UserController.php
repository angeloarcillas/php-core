<?php

namespace App\Controllers;

use Zeretei\PHPCore\Blueprint\Controller;

class UserController extends Controller
{

    public function __invoke()
    {
        echo  "asd";
    }
    public static function index()
    {
        echo "Index";
    }

    public function show($id, $name)
    {
        dd($id, $name);
    }
}
