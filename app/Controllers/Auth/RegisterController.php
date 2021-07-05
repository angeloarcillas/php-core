<?php

namespace App\Controllers\Auth;

use \Zeretei\PHPCore\Blueprint\Controller;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Show register form
     */
    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Register user
     */
    public function register()
    {
        $attributes = app('request')->validate([
            'username' => 'required|min:5|max:55',
            'email' => ['required', 'email'],
            'password' => ['min:8', 'confirm']
        ]);

        $user = new User();

        $attributes['password'] = password_hash($attributes['password'], PASSWORD_DEFAULT);

        if (!$user->insert($attributes)) {
            app('session')->setErrorFlash('register', 'Failed creating user.');
            return redirect()->back();
        }

        $user = $user->select($attributes['email'], 'email');

        app('session')->set('auth', $user->id);

        return redirect('/setup/posts');
    }
}
