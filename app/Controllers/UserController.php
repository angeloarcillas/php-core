<?php

namespace App\Controllers;

use Zeretei\PHPCore\Blueprint\Controller;

class UserController extends Controller
{

    public function __invoke()
    {
        echo  "asd";
    }
    public function index()
    {
        echo "Index";
    }
}
