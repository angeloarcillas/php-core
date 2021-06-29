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

    public function show($id)
    {
        $user = new User();
        $user = $user->select($id);
        return view('users/show', compact('user'));
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

    public function edit($id)
    {
        $user = new User();
        $user = $user->select($id);
        return view('users/edit', compact('user'));
    }
    
    public function update($id)
    {
        $user = new User();
        $user = $user->update($id, request()->all());
        return redirect('php-core/users');
    }
}
