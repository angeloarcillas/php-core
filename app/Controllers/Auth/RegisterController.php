<?php

namespace App\Controllers\Auth;

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
        $request->validate([
            'username' => 'required|min:5|max:25',
            'email' => ['required', 'email'],
            'password' => ['confirm']
        ]);
        dd('a');
    }
}
