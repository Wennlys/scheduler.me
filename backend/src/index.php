<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use Laminas\Diactoros\Response;

use Source\Middlewares\AuthMiddleware;
use Source\App\UserController;
use Source\Core\Connection;
use Source\App\SessionController;
use Source\App\FileController;
use Source\App\AppointmentController;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new ResponseFactory();

$container = new League\Container\Container;

$container->add(UserController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(SessionController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(FileController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(AppointmentController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(AuthMiddleware::class)
    ->addArgument(Response::class);

$container->add(Connection::class);
$container->add(Response::class);

$strategy = (new League\Route\Strategy\JsonStrategy($responseFactory))
    ->addDefaultResponseHeader('content-type', 'scheduler/json')
    ->setContainer($container);

$router = (new League\Route\Router())->setStrategy($strategy);

$router->group('/users', function (RouteGroup $route) {
    $route->map('GET', '/', 'Source\App\UserController::index');
    $route->map('GET', '/find', 'Source\App\UserController::show');
    $route->map('POST', '/', 'Source\App\UserController::store');
    $route->map('DELETE', '/', 'Source\App\UserController::destroy');
    $route->map('PUT', '/', 'Source\App\UserController::update')
        ->middleware(new AuthMiddleware(new Response));
});

$router->map('POST', '/sessions', 'Source\App\SessionController::store');

$router->group('/appointments', function (RouteGroup $route){
    $route->map('POST', '/', 'Source\App\AppointmentController::store')
        ->middleware(new AuthMiddleware(new Response));
});

$router->group('/files', function (RouteGroup $route) {
    $route->map('POST', '/', 'Source\App\FileController::store')
        ->middleware(new AuthMiddleware(new Response));
});

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);

