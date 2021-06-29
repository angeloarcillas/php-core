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
    public function index()
    {
        $user = new User();
        $users = $user->selectAll();
        return view('welcome', compact('users'));
    }

    public function show($id, $name)
    {
        dd($id, $name);
    }

    public function test(string $b = null)
    {
        return $b;
    }
}
