<?php declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';


use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;

use Source\Middleware\AuthMiddleware;
use Source\Core\DIContainer;
use Source\App\UserController;
use League\Container\Container;
use Source\Models\UserDAO;
use Source\Models\User;
use Source\Core\Connection;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new ResponseFactory();

$strategy = (new League\Route\Strategy\JsonStrategy($responseFactory))
    ->addDefaultResponseHeader('content-type', 'scheduler/json');
$router   = (new League\Route\Router)->setStrategy($strategy);

/**
 * DEPENDENCY INJECTION CONTAINERS
 */
DIContainer::register('UserController', function () {
//    $instance = Connection::getInstance();
//    $conn = $instance->getConnection();
//    $userDao = new UserDAO();
//    $response = new Response();

    $var = 7;
    return new UserController($var);
});

$router->group('/users', function (RouteGroup $route) {
    $route->map('GET', '/', UserController::class);
    $route->map('GET', '/find', 'Source\App\UserController::show');
    $route->map('POST', '/', 'Source\App\UserController::store');
    $route->map('DELETE', '/', 'Source\App\UserController::destroy');

    $route
        ->map('PUT', '/', 'Source\App\UserController::update')
        ->middleware(new AuthMiddleware);
});

$router->group('/sessions', function (RouteGroup $route) {
    $route->map('POST', '/', 'Source\App\SessionController::store');
});

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
