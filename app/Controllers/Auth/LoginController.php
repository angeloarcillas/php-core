<?php

namespace App\Controllers\Auth;

use Zeretei\PHPCore\Blueprint\Controller;

use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Login user
     */
    public function login()
    {
        $attributes = app('request')->validate([
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

        return redirect('/setup/posts');
    }
}
