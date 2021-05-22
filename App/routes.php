<?php

use Core\Http\Request;

$router->get('/', function () {
  request()->validate(["email" => 'email']);
  dd($_SESSION);
});
