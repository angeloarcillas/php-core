<?php

use \Core\Http\Request;

use \App\Models\User;
$router->get('/', function () {
  $user = new User();
  dd($user->insert([
    'email' => 'sample@mail.com',
    'password' => 'password'
    ]));
});
