<?php

namespace App\Controllers\Auth;

use App\Models\User;
use \Zeretei\PHPCore\Blueprint\Controller;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register()
    {
        $request = app('request');
        $attributes = $request->validate([
            'username' => 'required|min:5|max:55',
            'email' => ['required', 'email'],
            'password' => ['min:8', 'confirm']
        ]);

        $user = new User();

        // hash password
        $attributes['password'] = password_hash($attributes['password'], PASSWORD_DEFAULT);

        if (!$user->insert($attributes)) {
            app('session')->setFlash('register', 'Failed creating user.');
            return redirect()->back();
        }
        return redirect('/php-core/users');
    }
}
