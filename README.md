<h1 align="center">
  <a href="https://github.com/zerexei/">
    PHP Core
  </a>
</h1>

<p align="center">
  Simple MVC framework
</p>

<p align="center">
  <a href="https://lbesson.mit-license.org/">
    <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="MIT license." />
  </a>
  <a href="https://github.com/zerexei/">
    <img src="https://img.shields.io/badge/Version-0.1.0-blue.svg" alt="Current package version." />
  </a>
  <a href="#">
    <img src="https://img.shields.io/badge/Pull_Request-YES-blue.svg" alt="Feel free to contribute." />
  </a>
</p>

## Setup

```php
// index.php
// no type coercion allowed
declare(strict_types=1);

// check if session started
if (session_status() === PHP_SESSION_NONE) {
    // start a session
    session_start();
}

use Zeretei\PHPCore\Application;
use Zeretei\PHPCore\Http\Request;

// import autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// get config
$config = require_once dirname(__DIR__) . '/config.php';

// create application instance
$app = new Application($config);

// load all routes
$app->get('router')->load('/path/to/routes');

// run application
$app->run(Request::uri(), Request::method());
```

## Application

```php
use \Zeretei\PHPCore\Application;

Application::get('config'); // app config
Application::get('router'); // router instance
Application::get('request'); // request instance
Application::get('session'); // session instance
Application::get('database'); // database instance
```

## Routing

```php
// routes.php
use \Zeretei\PHPCore\Http\Router;
use \App\Controller\UserController;

return function (Router $router) {
    $router->get('/path', fn () => 'Hello World!');
    $router->post('/login', [UserController::class, 'login']);
    $router->put();
    $router->patch();
    $router->delete();
}
```
