<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use Laminas\Diactoros\Response;

use Source\Core\Connection;
use Source\Middleware\AuthMiddleware;
use Source\App\SessionStoreController;
use Source\App\FileStoreController;
use Source\App\AppointmentStoreController;
use Source\App\UserIndexController;
use Source\App\UserShowController;
use Source\App\UserStoreController;
use Source\App\UserUpdateController;
use Source\App\UserDestroyController;
use Source\App\TestController;
use Source\App\UserIndexProviderController;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new ResponseFactory();

$container = new League\Container\Container;


$container->add(UserIndexController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(UserIndexProviderController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(UserShowController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(UserStoreController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(UserUpdateController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(UserDestroyController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(SessionStoreController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(FileStoreController::class)
    ->addArgument(Connection::getInstance())
    ->addArgument(Response::class);

$container->add(AppointmentStoreController::class)
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
    $route->map('GET', '/', 'Source\App\UserIndexController::index');
    $route->map('GET', '/find', 'Source\App\UserShowController::show');
    $route->map('POST', '/', 'Source\App\UserStoreController::store');
    $route->map('PUT', '/', 'Source\App\UserUpdateController::update')
        ->middleware(new AuthMiddleware(new Response));
    $route->map('DELETE', '/', 'Source\App\UserDestroyController::destroy');
});

$router->map('GET', '/providers', 'Source\App\UserIndexProviderController::index');

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

