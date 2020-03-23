<?php declare(strict_types=1);


namespace Source\Middleware;


use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use ReallySimpleJWT\Token;
use Laminas\Diactoros\Response;


class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $response = new Response;

        if (Token::validate(getToken($request), JWT_SECRET)) {
            return $handler->handle($request);
        }

        $response->getBody()->write("Not valid token.");
        return $response->withStatus(400);
    }
}
