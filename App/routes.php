<?php

use \Core\Http\Request;

use \App\Models\User;

$router->get('/', function () {
  $user = new User();

  // // CREATE
  // $res = $user->insert([
  //   'email' => 'sample@mail.com',
  //   'password' => 'password'
  // ]);

  // // UPDATE
  // $res = $user->update(1,['email' => 'changed@mail.com']);
  
  // // UPDATE - string id & more than 1 field
  // $res = $user->update('1',[
  //   'email' => 'string.changed@mail.com',
  //   'password' => 'string changed password'
  //   ]);

  // DELETE
  $res = $user->delete(1);

  dd($res);
});
