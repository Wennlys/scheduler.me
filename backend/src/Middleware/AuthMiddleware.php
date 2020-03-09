<?php


namespace Source\Middleware;


use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var Response
     */
    private Response $response;

    public function __construct() {
        $this->response = new Response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $auth = true;
        if ($auth === true) {
            return $handler->handle($request);
        }

        // if user does not have auth, possibly return a redirect response,
        // this will not continue to any further middleware and will never
        // reach your route callable
        $this->response->getBody()->write(json_encode("User not allowed!"));
        return $this->response->withAddedHeader('content-type', 'application/json')->withStatus(200);
    }
}
