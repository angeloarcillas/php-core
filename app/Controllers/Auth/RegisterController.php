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
            'username' => 'required|min:5|max:55',
            'email' => ['required', 'email'],
            'password' => ['min:8', 'confirm']
        ]);
        
        
    }
}
