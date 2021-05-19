<?php

use Core\Http\Request;

$router->get('/', function () {
  $x = new Request();
  dd($x->all());
});
