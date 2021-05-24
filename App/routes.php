<?php

use \Core\Http\Request;

use \App\Models\User;

$router->get('/', function () {
  $user = new User();

  // CREATE
  $res = $user->insert([
    'email' => 'sample@mail.com',
    'password' => 'password'
  ]);

  dd($res);
});
