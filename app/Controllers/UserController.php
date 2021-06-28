<?php

namespace App\Controllers;

use App\Models\User;
use Zeretei\PHPCore\Blueprint\Controller;

class UserController extends Controller
{

    public function __invoke()
    {
        echo  "asd";
    }
    public static function index()
    {
        $r = app('request')->all();
        dd($r);
    }

    public function show($id, $name)
    {
        dd($id, $name);
    }
}
