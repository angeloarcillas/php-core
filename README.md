# php-core

> PHP MVC starter-template

## Setup
```
1. setup routes on App\routes.php
2. create a controller file on App\Controllers
3. create a model file on App\Models
4. setup app & database config on config.php
5. create a view file on App\Views
```

## Setting routes

- Syntax: $router->$method($url, $controller)

```php
// routes.php

// set host url
$router->host = "my-host";

// GET REQUEST - using function
$router->get("/users", function() {
  return view('index');
});

// POST REQUEST - using controller with method store
$router->post("/users", "UserController@store");

// PUT REQUEST
$router->put("/users", "UserController@update");

// DELETE REQUEST - using controller with __invoke method
$router->delete("/users/1", "UserController");
```

## Querying To Database

```php
use \App\Models\User;

$user = new User();

// CREATE
$user->insert([
    'email' => 'sample@mail.com',
    'password' => 'password'
]);

// UPDATE
$user->update(1,['email' => 'changed@mail.com']);

// UPDATE - string id & more than 1 field
$user->update('sample@mail.com',[
    'email' => 'string.changed@mail.com',
    'password' => 'string changed password'
]);

// DELETE
$user->delete(1);

// DELETE - string id
$user->delete('sample@mail.com');

// SELECT
$user->select(4);

// SELECT - string id
$user->select('sample@mail.com');

// SELECT ALL
$user->selectAll();

// SELECT ALL - specific column
$user->selectAll(columns: ['email']);
});
```

## Using request validator
```php
$attributes = request()->validate([
  'email' => 'required|min:3|max:55',
  'password' => ['required', 'confirm', 'min:8', 'max:255']
])

```
