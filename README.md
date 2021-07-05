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
// enable strict type
declare(strict_types=1);

// start a session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Zeretei\PHPCore\Application;
use Zeretei\PHPCore\Http\Request;

// import autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// set config
$config = require_once dirname(__DIR__) . '/config.php';

// create an application instance
$app = new Application($config);

// setup paths
$app->bind('path.app', $app->ROOT_DIR . 'app');
$app->bind('path.views', $app->ROOT_DIR . 'app/Views');
$app->bind('path.routes', $app->ROOT_DIR . 'app/routes.php');
$app->bind('path.databases', $app->ROOT_DIR . 'app/Databases');

// run application
$app->run(Request::uri(), Request::method());
```

## Application

```php
use \Zeretei\PHPCore\Application;

Application::get('config'); // app config
Application::get('router'); // router instance
Application::get('request'); // request instance
Application::get('response'); // response instance
Application::get('database'); // database instance
Application::get('session'); // session instance
```

## Routing

```php
// routes.php
use \Zeretei\PHPCore\Http\Router;
use \App\Controller\UserController;

return function (Router $router) {
    // set router host
    $router->setHost('simplewebsite');
    // get request
    $router->get('/path', fn () => 'Hello World!');
    // post request
    $router->post('/login', [UserController::class, 'login']);
    // put request
    $router->put();
    // patch request
    $router->patch();
    // delete request
    $router->delete();
}
```

## Database

```php
// execute a sql statement
Application::get('database')->query($sql, $params);
// execute an update sql statement
Application::get('database')->update($sql, $params);
// execute an delete sql statement
Application::get('database')->delete($sql, $params);
// execute a select sql statement
Application::get('database')->fetch($sql, $params);
// execute a select all sql statement
Application::get('database')->fetchAll($sql, $params);
```

## Model

```php
class User extends Model {}

$user = new User();

$user->insert($params)
$user->update($id, $params)
$user->delete($id, $key)
$user->select($id, $key)
$user->all()
```

# Controller

```php
class UserController extends Controller {

    public __construct() {
        // register a middleware
        $this->registerMiddleware(new AuthMiddleware(['delete']));
    }

}
```

## Middlewares

```php
class AuthMiddleware extends Middleware {
    // execute a middleware
    public function execute($action) {
        if (Application::isGuest()) {
            throw new \Exception("403 - Unauthorized");
        }
    }
}
```
