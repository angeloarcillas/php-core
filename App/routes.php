<?php
// TODO: Create a separate git branch for other none related component

// set host url
$router->host = 'php-core';

// add valid method
$router->addSupportedMethod('PATCH');

// set route
$router->get('/', function () {
  return view('welcome');
});
