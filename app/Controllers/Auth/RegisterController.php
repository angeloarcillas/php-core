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
        
    }    
}
