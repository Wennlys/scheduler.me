<?php 
declare(strict_types=1);

namespace Source\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $expiration = getPayload($request)["exp"];
        if ($expiration > time()) {
            return $handler->handle($request);
        }

        $this->response->getBody()->write(json_encode("Not valid token."));
        return $this->response->withStatus(400);
    }
}
