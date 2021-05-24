<?php

use \Core\Http\Request;

use \App\Models\User;

$router->get('/', function () {
  dd(request()->validate([
    'name' => 'email'
  ]), $_SESSION);
});

// TEST MODEL & DATABASE
// $router->get('/', function () {
//   $user = new User();

//   // // CREATE
//   // $res = $user->insert([
//   //   'email' => 'sample3@mail.com',
//   //   'password' => 'password3'
//   // ]);

//   // // UPDATE
//   // $res = $user->update(1,['email' => 'changed@mail.com']);

//   // // UPDATE - string id & more than 1 field
//   // $res = $user->update('1',[
//   //   'email' => 'string.changed@mail.com',
//   //   'password' => 'string changed password'
//   //   ]);

//   // // DELETE
//   // $res = $user->delete(1);

//   // // DELETE - string id
//   // $res = $user->delete('2');

//   // // SELECT
//   // $res = $user->select(4);

//   // // SELECT - string id
//   // $res = $user->select('5');

//   // // SELECT ALL
//   // $res = $user->selectAll();

//   // // SELECT ALL - specific column
//   // $res = $user->selectAll(columns: ['email']);

//   dd($res);
// });
