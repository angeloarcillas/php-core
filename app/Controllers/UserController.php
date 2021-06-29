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
        return view('welcome', compact('users'));
    }

    public function show($id, $name)
    {
        $user = new User();
        dd($id, $name);
    }
    
    public function create()
    {
        return view('users/create');
    }
    
    public function store()
    {
        $user = new User();
        $user = $user->insert(request()->all());
        dd($user);
    }
    
    public function test(string $b = null)
    {
        return $b;
    }
}
