<?php

namespace App\Controllers;

use \App\Middlewares\AuthMiddleware;
use \App\Models\User;
use \Zeretei\PHPCore\Blueprint\Controller;

/**
 * TODO: Add error handling & refactor
 */
class UserController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['edit']));
    }

    public function __invoke()
    {
        return  "__invoked";
    }

    public function index()
    {
        $user = new User();
        $users = $user->all();
        return view('users/index', compact('users'));
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
        return redirect('php-core/users');
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

    public function destroy($id)
    {
        $user = new User();
        $user = $user->delete($id);
        return redirect('php-core/users');
    }
}
