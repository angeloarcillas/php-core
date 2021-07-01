<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Zeretei\PHPCore\Blueprint\Controller;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login()
    {
        $request = app('request');
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = new User();

        $user = $user->select($attributes['email'], 'email');

        if (!$user || !password_verify($attributes['password'], $user->password)) {
            app('session')->setErrorFlash('user', 'Username or password did not match.');
            return redirect()->back();
        }

        app('session')->set('auth', $user->id);

        return redirect('/php-core/users');
    }
}
